<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAccountStatus extends Model
{
    use HasFactory;

    public function financialAccounts ()
    {
        return $this->hasMany(FinancialAccount::class);
    }
}
