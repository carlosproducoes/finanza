<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'number',
        'due_date',
        'projected_amount',
        'status',
        'financial_account_id',
        'company_id'
    ];

    public function financialAccount ()
    {
        return $this->belongsTo(FinancialAccount::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
