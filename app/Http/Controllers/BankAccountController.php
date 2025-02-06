<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index ()
    {
        $bankAccounts = BankAccount::where('company_id', '=', session('company_id'))->get();

        return view('bank-accounts.index', [
            'bankAccounts' => $bankAccounts
        ]);
    }

    public function create ()
    {
        return view('bank-accounts.create');
    }

    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric'
        ], [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',

            'balance.required' => 'O saldo é obrigatório',
            'balance.numeric' => 'Saldo inválido'
        ]);

        BankAccount::create([
            'company_id' => session('company_id'),
            'name' => $request->name,
            'balance' => $request->balance
        ]);

        return redirect()->route('bank-accounts.index');
    }

    public function edit (BankAccount $bankAccount)
    {
        if ($bankAccount->company_id != session('company_id')) {
            return redirect()->route('bank-accounts.index');
        }

        return view('bank-accounts.edit', [
            'bankAccount' => $bankAccount
        ]);
    }

    public function update (Request $request, BankAccount $bankAccount)
    {
        if ($bankAccount->company_id != session('company_id')) {
            return redirect()->route('bank-accounts.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric'
        ], [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',

            'balance.required' => 'O saldo é obrigatório',
            'balance.numeric' => 'Saldo inválido'
        ]);

        $bankAccount->name = $request->name;
        $bankAccount->balance = $request->balance;
        $bankAccount->save();

        return redirect()->route('bank-accounts.index');
    }

    public function destroy (BankAccount $bankAccount)
    {
        if ($bankAccount->company_id != session('company_id')) {
            return redirect()->route('bank-accounts.index');
        }

        $bankAccount->delete();

        return redirect()->route('bank-accounts.index');
    }
}
