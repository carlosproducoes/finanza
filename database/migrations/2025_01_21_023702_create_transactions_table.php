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
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable(false);
            $table->date('date')->nullable(false);
            $table->enum('movement_type', ['entry', 'exit'])->nullable(false);
            $table->integer('reference_id')->nullable();
            $table->string('reference_type')->nullable();
            $table->foreignId('category_id')->nullable(false)->constrained();
            $table->foreignId('bank_account_id')->nullable(false)->constrained();
            $table->foreignId('company_id')->nullable(false)->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
