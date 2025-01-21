<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    public function bankAccount ()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
