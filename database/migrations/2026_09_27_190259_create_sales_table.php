<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Customer will be connected later
            $table->unsignedBigInteger('customer_id')
                ->nullable();

            $table->string('invoice_number')
                ->unique();

            $table->decimal('subtotal', 15, 2)
                ->default(0);

            $table->decimal('discount', 15, 2)
                ->default(0);

            $table->decimal('total', 15, 2)
                ->default(0);

            $table->decimal('paid_amount', 15, 2)
                ->default(0);

            $table->decimal('balance', 15, 2)
                ->default(0);

            $table->enum('payment_method', [
                'cash',
                'mobile_money',
                'card',
                'bank',
                'credit',
            ])->default('cash');

            $table->enum('status', [
                'completed',
                'pending',
                'cancelled',
            ])->default('completed');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('invoice_number');
            $table->index('payment_method');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
