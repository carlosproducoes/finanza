<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'description',
        'due_date',
        'projected_amount',
        'movement_type',
        'category_id',
        'company_id'
    ];

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    public function company ()
    {
        return $this->belongsTo(Company::class);
    }
}
