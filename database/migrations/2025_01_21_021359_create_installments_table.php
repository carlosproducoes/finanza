<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->nullable(false);
            $table->date('due_date')->nullable(false);
            $table->date('payment_date')->nullable();
            $table->decimal('projected_amount', 10, 2)->nullable(false);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->nullable(false)->default('pending');
            $table->foreignId('financial_account_id')->nullable(false)->constrained();
            $table->foreignId('company_id')->nullable(false)->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
