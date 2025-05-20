<?php

namespace App\Services;

use App\Models\Category;
use App\Models\FinancialAccount;
use App\Models\Installment;
use Illuminate\Support\Facades\DB;

class InstallmentService
{
    public static function storeInstallment (Array $data)
    {

        Installment::create([
            'number' => $data['number'],
            'due_date' => $data['due_date'],
            'projected_amount' => $data['projected_amount'],
            'status' => 'pending',
            'financial_account_id' => $data['financial_account_id'],
            'company_id' => session('company_id')
        ]);
    }

    public static function updateInstallment (Array $data, Installment $installment)
    {

        $installment->due_date = $data['due_date'];
        $installment->projected_amount = $data['projected_amount'];

        $installment->save();
    }

    public static function processInstallment (Array $data, Installment $installment)
    {
        DB::transaction(function () use ($data, $installment) {
            $installment->payment_date = $data['payment_date'];
            $installment->paid_amount = $data['paid_amount'];
            $installment->status = 'paid';
            $installment->save();

            $transactionData = [
                'description' => $installment->financialAccount->description . " ({$installment->number}/{$installment->financialAccount->total_installments})",
                'amount' => $installment->paid_amount,
                'date' => $installment->payment_date,
                'movement_type' => $installment->financialAccount->movement_type,
                'category_id' => $installment->financialAccount->category_id,
                'bank_account' => $data['bank_account']
            ];

            TransactionService::storeTransaction($transactionData);
        });
    }

    public static function destroyInstallment (Installment $installment)
    {
        $financialAccountId = $installment->financial_account_id;

        $installment->delete();

        $installments = Installment::where('company_id', session('company_id'))
                                    ->where('financial_account_id', '=', $financialAccountId)
                                    ->get();

        $i = 1;
        foreach ($installments as $installment) {
            $installment->number = $i;
            $installment->save();
            
            $i++;
        }

        $financialAccount = FinancialAccount::find($financialAccountId);
        $financialAccount->total_installments = count($installments);

        $financialAccount->save();
    }
}