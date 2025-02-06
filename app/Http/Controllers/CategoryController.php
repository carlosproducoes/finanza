<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index ()
    {
        $categories = Category::where('company_id', '=', session('company_id'))->get();

        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create ()
    {
        return view('categories.create');
    }

    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'movement_type' => 'required|in:entry,exit'
        ], [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',

            'movement_type.required' => 'O tipo é obrigatório',
            'movement_type.in' => 'Tipo inválido'
        ]);

        Category::create([
            'company_id' => session('company_id'),
            'name' => $request->name,
            'movement_type' => $request->movement_type
        ]);

        return redirect()->route('categories.index');
    }

    public function edit (Category $category)
    {
        if ($category->company_id != session('company_id')) {
            return redirect()->route('categories.index');
        }

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    public function update (Request $request, Category $category)
    {
        if ($category->company_id != session('company_id')) {
            return redirect()->route('categories.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'Nome inválido',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
        ]);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories.index');
    }

    public function destroy (Category $category)
    {
        if ($category->company_id != session('company_id')) {
            return redirect()->route('categories.index');
        }
        
        $category->delete();

        return redirect()->route('categories.index');
    }
}
