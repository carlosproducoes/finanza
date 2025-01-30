<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FinancialAccount;
use Illuminate\Http\Request;

class FinancialAccountController extends Controller
{
    public function index ()
    {
        $financialAccounts = FinancialAccount::where('company_id', '=', session('company_id'))->get();
        
        return view('financial-accounts.index', [
            'financialAccounts' => $financialAccounts
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

        $description = $request->description;

        if (empty($description)) {
            $description = Category::find($request->category_id)->name;
        }

        FinancialAccount::create([
            'description' => $description,
            'due_date' => $request->due_date,
            'projected_amount' => $request->projected_amount,
            'movement_type' => $request->movement_type,
            'category_id' => $request->category_id,
            'company_id' => session('company_id')
        ]);

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

        $description = $request->description;

        if (empty($description)) {
            $description = Category::find($request->category_id)->name;
        }

        $financialAccount->description = $description;
        $financialAccount->due_date = $request->due_date;
        $financialAccount->projected_amount = $request->projected_amount;
        $financialAccount->category_id = $request->category_id;

        $financialAccount->save();

        return redirect()->route('financial-accounts.index');
    }

    public function destroy (FinancialAccount $financialAccount)
    {
        $financialAccount->delete();

        return redirect()->route('financial-accounts.index');
    }
}
