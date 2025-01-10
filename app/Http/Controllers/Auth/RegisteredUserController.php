<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'type_of_use' => 'required|in:personal,business',
            'company_name' => [
                'required_if:type_of_use,business',
                'max:255'
            ],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string válida.',
            'name.max' => 'O nome não pode ultrapassar 255 caracteres.',
            
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser uma string válida.',
            'email.email' => 'O e-mail precisa ser válido.',
            'email.unique' => 'Este e-mail já está registrado.',
            'email.max' => 'O e-mail não pode ultrapassar 255 caracteres.',
            
            'type_of_use.required' => 'Selecione uma das opções',
            'type_of_use.in' => 'Valor selecionado inválido',

            'company_name.required_if' => 'O nome da empresa é obrigatório',
            'company_name.max' => 'O nome da empresa deve ter até 255 caracteres',

            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha precisa ter no mínimo 8 caracteres.', // Ajuste conforme a configuração de "password" padrão
        ]);

        $companyName = !empty($request->company_name) ? $request->company_name : $request->name;

        $company = Company::create([
            'name' => $companyName
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::first()->id,
            'company_id' => $company->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        session(['company_id' => Auth::user()->company_id]);

        return redirect(route('dashboard', absolute: false));
    }
}
