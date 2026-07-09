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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no', 30);
            $table->string('customer_name', 100);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name', 100);
            $table->integer('quantity')->default(1);
            $table->decimal('product_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('grand_total_amount', 10, 2);
            $table->string('payment_method', 30)->default('Cash');
            $table->string('status', 30)->default('Paid');
            $table->date('receipt_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
