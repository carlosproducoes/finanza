<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    public function scopeCompanyId ($query)
    {
        return $query->where('company_id', session('company_id'));
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }

    public function transactions ()
    {
        return $this->hasMany(Transaction::class);
    }
}
