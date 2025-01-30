<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index ()
    {
        $transactions = Transaction::where('company_id', '=', session('company_id'))->get();
        
        return view('transactions.index', [
            'transactions' => $transactions
        ]);
    }

    public function create (String $movementType)
    {
        if (!in_array($movementType, ['entry', 'exit'])) {
            return redirect()->route('transactions.index');
        }

       $categories = Category::where('company_id', '=', session('company_id'))->where('movement_type', '=', $movementType)->get();
       $bankAccounts = BankAccount::where('company_id', '=', session('company_id'))->get();

        return view('transactions.create', [
            'categories' => $categories,
            'bankAccounts' => $bankAccounts,
            'movementType' => $movementType
        ]);
    }

    public function store (Request $request)
    {
        if (empty($request->movement_type) || !in_array($request->movement_type, ['entry', 'exit'])) {
            return redirect()->route('financial-accounts.index');
        }

        $request->validate([
            'description' => 'max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id,company_id,' . session('company_id') . ',movement_type,' . $request->movement_type,
            'bank_account' => 'required|exists:bank_accounts,id,company_id,' . session('company_id'),
        ], [
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',

            'amount.required' => 'O valor é obrigatório',
            'amount.numeric' => 'Valor inválido',

            'date.required' => 'A data é obrigatória',
            'date.date' => 'Data inválida',

            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'Categoria inválida',

            'bank_account.required' => 'A conta é obrigatória',
            'bank_account,exists' => 'Conta inválida'
        ]);

        DB::transaction(function () use ($request) {
            $description = $request->description;

            if (empty($description)) {
                $description = Category::find($request->category_id)->name;
            }

            Transaction::create([
                'description' => $description,
                'amount' => $request->amount,
                'date' => $request->date,
                'movement_type' => $request->movement_type,
                'category_id' => $request->category_id,
                'bank_account_id' => $request->bank_account,
                'company_id' => session('company_id')
            ]);

            $bankAccount = BankAccount::find($request->bank_account);

            if ($request->movement_type == 'entry') {
                $bankAccount->increment('balance', $request->amount);
            } else if ($request->movement_type == 'exit') {
                $bankAccount->decrement('balance', abs($request->amount));
            }

            $bankAccount->save();
        });

        return redirect()->route('transactions.index');
    }

    public function edit (Transaction $transaction)
    {
        if ($transaction->company_id != session('company_id')) {
            return redirect()->route('transactions.index');
        }

        $categories = Category::where('company_id', '=', session('company_id'))->where('movement_type', '=', $transaction->movement_type)->get();
        $bankAccounts = BankAccount::where('company_id', '=', session('company_id'))->get();

        return view('transactions.edit', [
            'transaction' => $transaction,
            'categories' => $categories,
            'bankAccounts' => $bankAccounts,
        ]);
    }

    public function update (Request $request, Transaction $transaction)
    {
        if ($transaction->company_id != session('company_id')) {
            return redirect()->route('transactions.index');
        }

        $request->validate([
            'description' => 'max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id,company_id,' . session('company_id') . ',movement_type,' . $transaction->movement_type,
            'bank_account' => 'required|exists:bank_accounts,id,company_id,' . session('company_id'),
        ], [
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',

            'amount.required' => 'O valor é obrigatório',
            'amount.numeric' => 'Valor inválido',

            'date.required' => 'A data é obrigatória',
            'date.date' => 'Data inválida',

            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'Categoria inválida',

            'bank_account.required' => 'A conta é obrigatória',
            'bank_account,exists' => 'Conta inválida'
        ]);

        DB::transaction(function () use ($request, $transaction) {
        
            $description = $request->description;

            if (empty($description)) {
                $description = Category::find($request->category_id)->name;
            }

            $transaction->description = $description;

            $bankAccount = BankAccount::find($transaction->bank_account_id);

            if ($transaction->bank_account_id != $request->bank_account) {
                $newBankAccount = BankAccount::find($request->bank_account);

                if ($transaction->movement_type == 'entry') {
                    $bankAccount->decrement('balance', abs($transaction->amount));
                    $newBankAccount->increment('balance', $request->amount);
                } else if ($transaction->movement_type == 'exit') {
                    $bankAccount->increment('balance', $transaction->amount);
                    $newBankAccount->decrement('balance', abs($request->amount));
                }

                $newBankAccount->save();
            } else {
                $difference = (float) $transaction->amount - $request->amount;

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

            $transaction->amount = $request->amount;
            $transaction->date = $request->date;
            $transaction->category_id = $request->category_id;
            $transaction->bank_account_id = $request->bank_account;

            $transaction->save();

        });

        return redirect()->route('transactions.index');
    }

    public function destroy (Transaction $transaction)
    {
        if ($transaction->company_id != session('company_id')) {
            return redirect()->route('transactions.index');
        }

        $bankAccount = BankAccount::find($transaction->bank_account_id);
        
        if ($transaction->movement_type == 'entry') {
            $bankAccount->decrement('balance', abs($transaction->amount));
        } else if ($transaction->movement_type == 'exit') {
            $bankAccount->increment('balance', $transaction->amount);
        }

        $bankAccount->save();
        $transaction->delete();

        return redirect()->route('transactions.index');
    }
}