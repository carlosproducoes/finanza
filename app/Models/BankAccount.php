<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'company_id'
    ];

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}