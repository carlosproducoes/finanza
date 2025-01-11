<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\MovementType;
use App\Models\Transaction;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use Exception;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct ()
    {
        $this->transactionService = new TransactionService();
    }

    public function index ()
    {
        $transactions = Transaction::companyId()
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(50);

        return view('transactions.index', compact('transactions'));
    }

    public function create ()
    {
        $movementTypes = MovementType::all();
        $bankAccounts = BankAccount::companyId()->get();

        return view('transactions.create')
                    ->with([
                        'movementTypes' => $movementTypes,
                        'bankAccounts' => $bankAccounts,
                    ]);
    }

    public function store (Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
            'date' => 'required|date',
            'amount' => 'required|regex:/^\d{1,3}(\.\d{3})*(,\d{2})?$/',
            'movement_type' => 'required|integer|exists:movement_types,id',
            'bank_account' => 'required|integer|exists:bank_accounts,id'
        ], [
            'description.required' => 'A descrição é obrigatória',
            'description.string' => 'A descrição deve ser um texto',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',

            'date.required' => 'A data é obrigatória',
            'date.date' => 'A data informada não é válida',

            'amount.required' => 'O valor é obrigatório',
            'amount.regex' => 'O formato do valor não é válido',

            'movement_type.required' => 'O tipo de movimentação é obrigatório',
            'movement_type.integer' => 'O tipo de movimentação não é válida',
            'movement_type.exists' => 'O tipo de movimentação selecionado não existe',

            'bank_account.required' => 'A conta bancária é obrigatória',
            'bank_account.integer' => 'A conta bancária selecionada não é válida',
            'bank_account.exists' => 'A conta bancária selecionada não existe'
        ]);

        $data = $request->only(['description', 'date', 'amount', 'movement_type', 'bank_account']);

        try {
            $this->transactionService->storeTransaction($data);

            return redirect()
                    ->route('transaction.index')
                    ->with(['success' => 'Transação adicionada com sucesso']);
        } catch (Exception $exception) {
            return redirect()
                    ->back()
                    ->withErrors(['error' => $exception->getMessage()])
                    ->withInput();
        }
    }
}
