<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }

    public function financialAccounts ()
    {
        return $this->hasMany(FinancialAccount::class);
    }
}
