<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function financialAccount ()
    {
        return $this->belongsTo(FinancialAccount::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
