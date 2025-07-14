<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Installment;
use App\Models\Category;
use App\Services\InstallmentService;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    private InstallmentService $installmentService;

    public function __construct (InstallmentService $installmentService)
    {
        $this->installmentService = $installmentService;
    }

    public function edit (Installment $installment)
    {
        if ($installment->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $categories = Category::where('company_id', '=', session('company_id'))->where('movement_type', '=', $installment->financialAccount->movement_type)->get();

        return view('installments.edit', [
            'installment' => $installment,
            'categories' => $categories
        ]);
    }

    public function update (Request $request, Installment $installment)
    {
        if ($installment->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $request->validate([
            'due_date' => 'required|date',
            'projected_amount' => 'required|numeric'
        ], [
            'due_date.required' => 'A data de vencimento é obrigatória',
            'due_date.date' => 'Data de vencimento inválida',

            'projected_amount.required' => 'O valor projetado é obrigatório',
            'projected_amount.numeric' => 'Valor projetado inválido',
        ]);

        $data = $request->only([
            'due_date',
            'projected_amount'
        ]);

        $this->installmentService->updateInstallment($data, $installment);

        return redirect()->route('financial-accounts.index');
    }

    public function pay (Installment $installment)
    {
        if ($installment->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $bankAccounts = BankAccount::where('company_id', '=', session('company_id'))->get();

        return view('installments.pay', [
            'installment' => $installment,
            'bankAccounts' => $bankAccounts
        ]);
    }

    public function process (Request $request, Installment $installment)
    {
        if ($installment->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $request->validate([
            'payment_date' => 'required|date',
            'paid_amount' => 'required|numeric',
            'bank_account' => 'required|exists:bank_accounts,id,company_id,' . session('company_id'),
        ], [
            'payment_date.required' => 'A data do pagamento é obrigatória',
            'payment_date.date' => 'Data do pagamento inválida',

            'paid_amount.required' => 'O valor pago é obrigatório',
            'paid_amount.numeric' => 'Valor pago inválido',

            'bank_account.required' => 'A conta é obrigatória',
            'bank_account.exists' => 'Conta inválida'
        ]);

        $data = $request->only([
            'payment_date',
            'paid_amount',
            'bank_account'
        ]);

        $this->installmentService->processInstallment($data, $installment);

        return redirect()->route('financial-accounts.index');
    }

    public function destroy (Installment $installment)
    {
        if ($installment->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }
        
        $this->installmentService->destroyInstallment($installment);

        return redirect()->route('financial-accounts.index');
    }
}
