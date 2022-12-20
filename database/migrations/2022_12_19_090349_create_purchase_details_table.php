<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('unit_id')->constrained('units');
            $table->integer('quantity');
            $table->integer('quantity_total');
            $table->decimal('price', 20, 2);
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('subtotal', 20, 2)->default(0);
            $table->decimal('subtotal_discount', 20, 2)->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_details');
    }
};
