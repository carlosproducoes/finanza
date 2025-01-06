<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->decimal('current_balance', 10, 2);
            $table->foreignId('movement_type_id')->constrained();
            $table->foreignId('bank_account_id')->constrained();            
            $table->foreignId('company_id')->constrained();
            $table->foreignId('financial_account_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
