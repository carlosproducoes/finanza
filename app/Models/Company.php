<?php

namespace App\Models;

use Database\Seeders\FinancialAccountSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users ()
    {
        return $this->hasMany(User::class);
    }

    public function bankAccounts ()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function categories ()
    {
        return $this->hasMany(Category::class);
    }

    public function financialAccounts ()
    {
        return $this->hasMany(FinancialAccountSeeder::class);
    }

    public function transactions ()
    {
        return $this->hasMany(Transaction::class);
    }
}
