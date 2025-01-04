<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail precisa ser válido.',
            'email.exists' => 'Não encontramos nenhum cadastro com esse e-mail.',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return back()->with('status', 'Enviamos as instruções para recuperação da senha no e-mail informado');
                break;
            case 'passwords.throttled':
                return back()->withErrors(['email' => 'Você excedeu o número de tentativas. Tente novamente mais tarde.']);
                break;
            default:
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => $status]);
        }
    }
}
