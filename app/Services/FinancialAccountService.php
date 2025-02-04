<?php

namespace App\Services;

use App\Models\Category;
use App\Models\FinancialAccount;
use Illuminate\Support\Facades\DB;

class FinancialAccountService
{
    public static function storeFinancialAccount (Array $data)
    {
        $description = $data['description'];

        if (empty($description)) {
            $description = Category::find($data['category_id'])->name;
        }

        FinancialAccount::create([
            'description' => $description,
            'due_date' => $data['due_date'],
            'projected_amount' => $data['projected_amount'],
            'movement_type' => $data['movement_type'],
            'category_id' => $data['category_id'],
            'company_id' => session('company_id')
        ]);
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