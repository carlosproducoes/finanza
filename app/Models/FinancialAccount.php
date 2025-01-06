<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
{
    use HasFactory;

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
