<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sku')->unique();

            $table->string('unit')->default('pcs');

            $table->decimal('buying_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);

            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('minimum_stock')->default(5);

            $table->text('description')->nullable();

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
