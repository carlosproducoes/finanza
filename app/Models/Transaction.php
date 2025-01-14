<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function scopeCompanyId ($query)
    {
        return $query->where('company_id', session('company_id'));
    }

    public function movementType ()
    {
        return $this->belongsTo(MovementType::class);
    }

    public function bankAccount ()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function financialAccount ()
    {
        return $this->belongsTo(FinancialAccount::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
