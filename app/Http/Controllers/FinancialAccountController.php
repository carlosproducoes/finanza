<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\FinancialAccount;
use Carbon\Carbon;
use App\Services\FinancialAccountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialAccountController extends Controller
{
    public function index (Request $request)
    {
        $date = Carbon::now()->format('m-Y');

        if (isset($request->date) && preg_match('/^\d{2}-\d{4}/', $request->date)) {
            $date = $request->date;
        }

        [$month, $year] = explode('-', $date);

        $financialAccounts = DB::table('financial_accounts as fa')
                                ->leftJoin('installments as i', 'fa.id', '=', 'i.financial_account_id')
                                ->join('categories as c', 'fa.category_id', '=', 'c.id')
                                ->where('fa.company_id', session('company_id'))
                                ->whereYear('fa.due_date', $year)
                                ->whereMonth('fa.due_date', $month)
                                ->whereNull('i.id')
                                ->whereNull('fa.deleted_at')
                                ->select(
                                    'fa.id',
                                    'fa.description',
                                    'fa.due_date',
                                    'fa.payment_date',
                                    'fa.projected_amount',
                                    'fa.paid_amount',
                                    'fa.movement_type',
                                    'fa.total_installments',
                                    'fa.status',
                                    'c.name as category',
                                    'fa.company_id',
                                    'fa.created_at',
                                    'fa.updated_at',
                                    'fa.deleted_at',
                                    DB::raw('"financial_account" as type')
                                )
                                ->unionAll(
                                    DB::table('installments as i')
                                        ->join('financial_accounts as fa', 'i.financial_account_id', '=', 'fa.id')
                                        ->join('categories as c', 'fa.category_id', '=', 'c.id')
                                        ->where('i.company_id', session('company_id'))
                                        ->whereYear('i.due_date', $year)
                                        ->whereMonth('i.due_date', $month)
                                        ->whereNull('i.deleted_at')
                                        ->select(
                                            'i.id',
                                            DB::raw('CONCAT(fa.description, " (", i.number, "/", fa.total_installments, ")")'),
                                            'i.due_date',
                                            'i.payment_date',
                                            'i.projected_amount',
                                            'i.paid_amount',
                                            'fa.movement_type',
                                            'fa.total_installments',
                                            'i.status',
                                            'c.name as category',
                                            'i.company_id',
                                            'i.created_at',
                                            'i.updated_at',
                                            'i.deleted_at',
                                            DB::raw('"installment" as type')
                                        )
                                )
                                ->orderBy('due_date')
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
            'is_installment' => 'in:on',
            'number_installments' => 'required_if:is_installment,on|integer|min:1'
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

            'is_installment.in' => 'Erro ao definir as parcelas',

            'number_installments.required_if' => 'O número de parcelas é obrigatório',
            'number_installments.integer' => 'Número de parcelas inválido',
            'number_installments.min' => 'O número de parcelas deve ser no mínimo 1'
        ]);

        $data = $request->only([
            'description',
            'due_date',
            'projected_amount',
            'movement_type',
            'category_id',
            'number_installments'
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
