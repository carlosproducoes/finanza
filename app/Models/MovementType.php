<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementType extends Model
{
    use HasFactory;

    public function categories ()
    {
        return $this->hasMany(Category::class);
    }

    public function financialAccounts ()
    {
        return $this->hasMany(FinancialAccount::class);
    }

    public function Transactions ()
    {
        return $this->hasMany(Transaction::class);
    }
}
