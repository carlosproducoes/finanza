<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    public static function storeTransaction (Array $data)
    {
        DB::transaction(function () use ($data) {

            $description = $data['description'];

            if (empty($description)) {
                $description = Category::find($data['category_id'])->name;
            }

            Transaction::create([
                'description' => $description,
                'amount' => $data['amount'],
                'date' => $data['date'],
                'movement_type' => $data['movement_type'],
                'category_id' => $data['category_id'],
                'bank_account_id' => $data['bank_account'],
                'company_id' => session('company_id')
            ]);

            $bankAccount = BankAccount::find($data['bank_account']);

            if ($data['movement_type'] == 'entry') {
                $bankAccount->increment('balance', $data['amount']);
            } else if ($data['movement_type'] == 'exit') {
                $bankAccount->decrement('balance', abs($data['amount']));
            }

            $bankAccount->save();

        });
    }

    public static function updateTransaction (Array $data, Transaction $transaction)
    {
        DB::transaction(function () use ($data, $transaction) {
        
            $description = $data['description'];

            if (empty($description)) {
                $description = Category::find($data['category_id'])->name;
            }

            $transaction->description = $description;

            $bankAccount = BankAccount::find($transaction->bank_account_id);

            if ($transaction->bank_account_id != $data['bank_account']) {
                $newBankAccount = BankAccount::find($data['bank_account']);

                if ($transaction->movement_type == 'entry') {
                    $bankAccount->decrement('balance', abs($transaction->amount));
                    $newBankAccount->increment('balance', $data['amount']);
                } else if ($transaction->movement_type == 'exit') {
                    $bankAccount->increment('balance', $transaction->amount);
                    $newBankAccount->decrement('balance', abs($data['amount']));
                }

                $newBankAccount->save();
            } else {
                $difference = (float) $transaction->amount - $data['amount'];

                if ($difference < 0) {
                    if ($transaction->movement_type == 'entry') {
                        $bankAccount->increment('balance', abs($difference));
                    } else if ($transaction->movement_type == 'exit') {
                        $bankAccount->decrement('balance', abs($difference));
                    }
                } else if ($difference > 0) {
                    if ($transaction->movement_type == 'entry') {
                        $bankAccount->decrement('balance', $difference);
                    } else if ($transaction->movement_type == 'exit') {
                        $bankAccount->increment('balance', $difference);
                    }
                }
            }

            $bankAccount->save();

            $transaction->amount = $data['amount'];
            $transaction->date = $data['date'];
            $transaction->category_id = $data['category_id'];
            $transaction->bank_account_id = $data['bank_account'];

            $transaction->save();

        });
    }

    public static function destroyTransaction (Transaction $transaction)
    {
        $bankAccount = BankAccount::find($transaction->bank_account_id);
        
        if ($transaction->movement_type == 'entry') {
            $bankAccount->decrement('balance', abs($transaction->amount));
        } else if ($transaction->movement_type == 'exit') {
            $bankAccount->increment('balance', $transaction->amount);
        }

        $bankAccount->save();
        $transaction->delete();
    }

}