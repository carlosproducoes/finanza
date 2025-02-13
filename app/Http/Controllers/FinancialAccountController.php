<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\FinancialAccount;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Services\FinancialAccountService;
use Illuminate\Http\Request;

class FinancialAccountController extends Controller
{
    public function index (Request $request)
    {
        $date = Carbon::now()->format('m-Y');

        if (isset($request->date) && preg_match('/^\d{2}-\d{4}/', $request->date)) {
            $date = $request->date;
        }

        [$month, $year] = explode('-', $date);

        $financialAccounts = FinancialAccount::where('company_id', '=', session('company_id'))
                                                ->whereMonth('due_date', $month)
                                                ->whereYear('due_date', $year)
                                                ->get();
        
        return view('financial-accounts.index', [
            'financialAccounts' => $financialAccounts,
            'date' => $date
        ]);
    }

    public function create (String $movementType)
    {
        if (!in_array($movementType, ['entry', 'exit'])) {
            return redirect()->route('financial-accounts.index');
        }
        
        $categories = Category::where('company_id', '=', session('company_id'))->where('movement_type', '=', $movementType)->get();

        return view('financial-accounts.create', [
            'categories' => $categories,
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
            'due_date' => 'required|date',
            'projected_amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id,company_id,' . session('company_id') . ',movement_type,' . $request->movement_type,
        ], [
            'description.required' => 'A descrição é obrigatória',
            'description.string' => 'Descrição inválida',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',

            'due_date.required' => 'A data de vencimento é obrigatória',
            'due_date.date' => 'Data de vencimento inválida',

            'projected_amount.required' => 'O valor projetado é obrigatório',
            'projected_amount.numeric' => 'Valor projetado inválido',

            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'Categoria inválida',
        ]);

        $data = $request->only([
            'description',
            'due_date',
            'projected_amount',
            'movement_type',
            'category_id'
        ]);

        FinancialAccountService::storeFinancialAccount($data);

        return redirect()->route('financial-accounts.index');
    }

    public function edit (FinancialAccount $financialAccount)
    {
        if ($financialAccount->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $categories = Category::where('company_id', '=', session('company_id'))->where('movement_type', '=', $financialAccount->movement_type)->get();

        return view('financial-accounts.edit', [
            'financialAccount' => $financialAccount,
            'categories' => $categories
        ]);
    }

    public function update (Request $request, FinancialAccount $financialAccount)
    {
        if ($financialAccount->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $request->validate([
            'description' => 'max:255',
            'due_date' => 'required|date',
            'projected_amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id,company_id,' . session('company_id') . ',movement_type,' . $financialAccount->movement_type,
        ], [
            'description.required' => 'A descrição é obrigatória',
            'description.string' => 'Descrição inválida',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',

            'due_date.required' => 'A data de vencimento é obrigatória',
            'due_date.date' => 'Data de vencimento inválida',

            'projected_amount.required' => 'O valor projetado é obrigatório',
            'projected_amount.numeric' => 'Valor projetado inválido',

            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'Categoria inválida',
        ]);

        $data = $request->only([
            'description',
            'due_date',
            'projected_amount',
            'category_id'
        ]);

        FinancialAccountService::updateFinancialAccount($data, $financialAccount);

        return redirect()->route('financial-accounts.index');
    }

    public function pay (FinancialAccount $financialAccount)
    {
        if ($financialAccount->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }

        $bankAccounts = BankAccount::where('company_id', '=', session('company_id'))->get();

        return view('financial-accounts.pay', [
            'financialAccount' => $financialAccount,
            'bankAccounts' => $bankAccounts
        ]);
    }

    public function process (Request $request, FinancialAccount $financialAccount)
    {
        if ($financialAccount->company_id != session('company_id')) {
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

        FinancialAccountService::processFinancialAccount($data, $financialAccount);

        return redirect()->route('financial-accounts.index');
    }

    public function destroy (FinancialAccount $financialAccount)
    {
        if ($financialAccount->company_id != session('company_id')) {
            return redirect()->route('financial-accounts.index');
        }
        
        FinancialAccountService::destroyFinancialAccount($financialAccount);

        return redirect()->route('financial-accounts.index');
    }
}
