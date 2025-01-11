<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\MovementType;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function storeTransaction (array $data)
    {
        DB::transaction(function () use ($data) {
            
            $movementType = MovementType::find($data['movement_type']);
            $bankAccount = BankAccount::find($data['bank_account']);

            $amount = (float) str_replace(',', '.', str_replace('.', '', $data['amount']));

            if ($movementType->name == 'exit' && $bankAccount->balance < $amount) {
                throw new Exception('O valor é maior do que o saldo da conta');
            }

            switch ($movementType->name) {
                case 'exit':
                    $bankAccount->balance -= $amount;
                    break;
                case 'entry':
                    $bankAccount->balance += $amount;
                    break;
            }

            $bankAccount->save();
            
            $transaction = new Transaction();
            $transaction->description = $data['description'];
            $transaction->date = Carbon::createFRomFormat('d/m/Y', $data['date'])->format('Y-m-d');
            $transaction->amount = $amount;
            $transaction->current_balance = $bankAccount->balance;
            $transaction->movement_type_id = $movementType->id;
            $transaction->bank_account_id = $bankAccount->id;
            $transaction->company_id = session('company_id');
            $transaction->save();

        });
    }
}