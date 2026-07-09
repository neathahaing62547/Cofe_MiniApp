<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('product', function (Blueprint $table) {
    $table->id('product_id');

    $table->unsignedBigInteger('category_id');

    $table->string('product_name', 100);

    $table->decimal('price', 10, 2);

    $table->integer('stock_quantity');

    $table->text('description')->nullable();

    $table->string('image', 255)->nullable();

    $table->timestamps();
});

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
