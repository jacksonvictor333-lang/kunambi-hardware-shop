<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->enum('type', [
                'stock_in',
                'stock_out',
                'adjustment',
            ]);

            $table->integer('quantity');

            $table->integer('quantity_before');

            $table->integer('quantity_after');

            $table->string('reference')->nullable();

            $table->text('reason')->nullable();

            $table->decimal('unit_cost', 15, 2)
                ->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
