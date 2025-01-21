<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable(false);
            $table->date('due_date')->nullable(false);
            $table->date('payment_date')->nullable();
            $table->decimal('projected_amount', 10, 2)->nullable(false);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->enum('movement_type', ['entry', 'exit'])->nullable(false);
            $table->enum('status', ['pending', 'paid', 'overdue'])->nullable(false)->default('pending');
            $table->foreignId('category_id')->nullable(false)->constrained();
            $table->foreignId('company_id')->nullable(false)->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_accounts');
    }
};
