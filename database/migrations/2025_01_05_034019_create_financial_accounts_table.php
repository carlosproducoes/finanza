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
            $table->text('description');
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->decimal('projected_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->foreignId('financial_account_status_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('movement_type_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts_payable_receivable');
    }
};
