<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\MovementType;
use App\Models\Transaction;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use Carbon\Carbon;
use Exception;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct ()
    {
        $this->transactionService = new TransactionService();
    }

    public function index (Request $request)
    {
        $movementTypes = MovementType::all();
        $bankAccounts = BankAccount::companyId()->get();
        $query = Transaction::companyId();

        $filters = session('transactions_filters', []);

        if (!is_array($filters)) {
            $filters = [];
        }

        if ($request->has('remove_filter') && !empty($request->remove_filter)) {
            unset($filters[$request->remove_filter]);
        }

        if ($request->has('search')) {
            if (!empty($request->input('search'))) {
                $filters['search'] = [
                    'name' => 'Busca',
                    'value' => $request->input('search'),
                    'input' => $request->input('search')
                ];
            } else {
                unset($filters['search']);
            }
        }

        if ($request->has('start_date')) {
            if (!empty($request->input('start_date'))) {
                $startDate = Carbon::createFromFormat('d/m/Y', $request->input('start_date'))->format('Y-m-d');
                $filters['start_date'] = [
                    'name' => 'Data início',
                    'value' => $request->start_date,
                    'input' => $startDate
                ];
            } else {
                unset($filters['start_date']);
            }
        }

        if ($request->has('end_date')) {
            if (!empty($request->input('end_date'))) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->input('end_date'))->format('Y-m-d');
                $filters['end_date'] = [
                    'name' => 'Data fim',
                    'value' => $request->end_date,
                    'input' => $endDate
                ];
            } else {
                unset($filters['end_date']);
            }
        }

        if ($request->has('movement_type')) {
            if (!empty($request->input('movement_type'))) {
                $filters['movement_type'] = [
                    'name' => 'Tipo',
                    'value' => $movementTypes->find($request->movement_type)->name == 'entry' ? 'Entrada' : 'Saída',
                    'input' => $request->movement_type
                ];
            } else {
                unset($filters['movement_type']);
            }
        }

        if ($request->has('bank_account')) {
            if (!empty($request->input('bank_account'))) {
                $filters['bank_account'] = [
                    'name' => 'Conta',
                    'value' => $bankAccounts->find($request->bank_account)->name,
                    'input' => $request->bank_account
                ];
            } else {
                unset($filters['bank_account']);
            }
        }

        if (array_key_exists('search', $filters) && !empty($filters['search'])) {
            $query->where('description', 'LIKE', "%{$filters['search']['input']}%");
        }

        if (array_key_exists('start_date', $filters) && !empty($filters['start_date'])) {
            $query->where('date', '>=', $filters['start_date']['input']);
        }

        if (array_key_exists('end_date', $filters) && !empty($filters['end_date'])) {
            $query->where('date', '<=', $filters['end_date']['input']);
        }

        if (array_key_exists('movement_type', $filters) && !empty($filters['movement_type'])) {
            $query->where('movement_type_id', '=', $filters['movement_type']['input']);
        }

        if (array_key_exists('bank_account', $filters) && !empty($filters['bank_account'])) {
            $query->where('bank_account_id', '=', $filters['bank_account']['input']);
        }

        $query->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(50);

        $transactions = $query->get();

        session(['transactions_filters' => $filters]);

        return view('transactions.index')
                    ->with([
                        'transactions' => $transactions,
                        'movementTypes' => $movementTypes,
                        'bankAccounts' => $bankAccounts,
                        'filters' => $filters,
                    ]);
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
