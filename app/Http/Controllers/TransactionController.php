<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Transaction;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index (Request $request)
    {
        $date = Carbon::now()->format('m-Y');

        if (isset($request->date)) {
            $date = $request->date;
        }

        [$month, $year] = explode('-', $date);

        $transactions = Transaction::where('company_id', '=', session('company_id'))
                                    ->whereMonth('date', $month)
                                    ->whereYear('date', $year)
                                    ->get();
        
        return view('transactions.index', [
            'transactions' => $transactions,
            'date' => $date
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

        $data = $request->only([
            'description',
            'amount',
            'date',
            'movement_type',
            'category_id',
            'bank_account'
        ]);

        TransactionService::storeTransaction($data);

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

        $data = $request->only([
            'description',
            'amount',
            'date',
            'category_id',
            'bank_account'
        ]);

        TransactionService::updateTransaction($data, $transaction);

        return redirect()->route('transactions.index');
    }

    public function destroy (Transaction $transaction)
    {
        if ($transaction->company_id != session('company_id')) {
            return redirect()->route('transactions.index');
        }

        TransactionService::destroyTransaction($transaction);

        return redirect()->route('transactions.index');
    }
}