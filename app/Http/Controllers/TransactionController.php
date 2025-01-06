<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $companyId;

    public function __construct ()
    {
        $this->companyId = auth()->user()->company->id;
    }

    public function index ()
    {
        $transactions = Transaction::where('company_id', $this->companyId)
            ->paginate(50);

        return view('transactions.index', compact('transactions'));
    }
}
