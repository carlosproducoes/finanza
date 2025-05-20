<?php

namespace App\Services;

use App\Models\Category;
use App\Models\FinancialAccount;
use App\Services\InstallmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialAccountService
{
    public static function storeFinancialAccount (Array $data)
    {
        $description = $data['description'];

        if (empty($description)) {
            $description = Category::find($data['category_id'])->name;
        }

        $financialAccount = FinancialAccount::create([
            'description' => $description,
            'due_date' => $data['due_date'],
            'projected_amount' => $data['projected_amount'],
            'movement_type' => $data['movement_type'],
            'total_installments' => $data['number_installments'],
            'status' => 'pending',
            'category_id' => $data['category_id'],
            'company_id' => session('company_id')
        ]);

        if (!empty($data['number_installments'])) {
            $numberInstallments = $data['number_installments'];
            $projectedAmount = $data['projected_amount'] / $numberInstallments;
            $dueDate = Carbon::createFromFormat('Y-m-d', $data['due_date']);

            for ($i = 1; $i <= $numberInstallments; $i++) {
                InstallmentService::storeInstallment([
                    'number' => $i,
                    'due_date' => $dueDate->format('Y-m-d'),
                    'projected_amount' => $projectedAmount,
                    'status' => 'pending',
                    'financial_account_id' => $financialAccount->id,
                    'company_id' => session('company_id')
                ]);

                $dueDate->addMonth();
            }
        }
    }

    public static function updateFinancialAccount (Array $data, FinancialAccount $financialAccount)
    {
        $description = $data['description'];

        if (empty($description)) {
            $description = Category::find($data['category_id'])->name;
        }

        $financialAccount->description = $description;
        $financialAccount->due_date = $data['due_date'];
        $financialAccount->projected_amount = $data['projected_amount'];
        $financialAccount->category_id = $data['category_id'];

        $financialAccount->save();
    }

    public static function processFinancialAccount (Array $data, FinancialAccount $financialAccount)
    {
        DB::transaction(function () use ($data, $financialAccount) {
            $financialAccount->payment_date = $data['payment_date'];
            $financialAccount->paid_amount = $data['paid_amount'];
            $financialAccount->status = 'paid';
            $financialAccount->save();

            $transactionData = [
                'description' => $financialAccount->description,
                'amount' => $financialAccount->paid_amount,
                'date' => $financialAccount->payment_date,
                'movement_type' => $financialAccount->movement_type,
                'category_id' => $financialAccount->category_id,
                'bank_account' => $data['bank_account']
            ];

            TransactionService::storeTransaction($transactionData);
        });
    }

    public static function destroyFinancialAccount (FinancialAccount $financialAccount)
    {
        $financialAccount->delete();
    }
}