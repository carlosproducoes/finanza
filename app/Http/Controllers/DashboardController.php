<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\FinancialAccount;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index ()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalEntryTransactions = Transaction::where('company_id', '=', session('company_id'))
                                                ->where('movement_type', '=', 'entry')
                                                ->whereMonth('date', $currentMonth)
                                                ->whereYear('date', $currentYear)
                                                ->sum('amount');

        $totalExitTransactions = Transaction::where('company_id', '=', session('company_id'))
                                                ->where('movement_type', '=', 'exit')
                                                ->whereMonth('date', $currentMonth)
                                                ->whereYear('date', $currentYear)
                                                ->sum('amount');

        $balance = BankAccount::where('company_id', '=', session('company_id'))
                                ->sum('balance');

        $totalEntryFinancialAccounts = FinancialAccount::where('company_id', '=', session('company_id'))
                                                        ->where('movement_type', '=', 'entry')
                                                        ->where('status', '!=', 'paid')
                                                        ->whereMonth('due_date', $currentMonth)
                                                        ->whereYear('due_date', $currentYear)
                                                        ->sum('projected_amount');

        $totalExitFinancialAccounts = FinancialAccount::where('company_id', '=', session('company_id'))
                                                        ->where('movement_type', '=', 'exit')
                                                        ->where('status', '!=', 'paid')
                                                        ->whereMonth('due_date', $currentMonth)
                                                        ->whereYear('due_date', $currentYear)
                                                        ->sum('projected_amount');
        
        return view('dashboard', [
            'totalEntryTransactions' => $totalEntryTransactions,
            'totalExitTransactions' => $totalExitTransactions,
            'balance' => $balance,
            'totalEntryFinancialAccounts' => $totalEntryFinancialAccounts,
            'totalExitFinancialAccounts' => $totalExitFinancialAccounts
        ]);
    }
}