<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
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

    public function category ()
    {
        $this->belongsTo(Category::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }

    public function financialAccountStatus ()
    {
        return $this->belongsTo(FinancialAccountStatus::class);
    }
}
