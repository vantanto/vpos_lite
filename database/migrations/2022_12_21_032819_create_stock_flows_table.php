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
        Schema::create('stock_flows', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->enum('type', ['in', 'out']);
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->foreignId('order_detail_id')->nullable()->constrained('order_details');
            $table->foreignId('purchase_id')->nullable()->constrained('purchases');
            $table->foreignId('purchase_detail_id')->nullable()->constrained('purchase_details');
            $table->integer('quantity_in')->default(0);
            $table->integer('quantity_total_in')->default(0);
            $table->integer('quantity_out')->default(0);
            $table->integer('quantity_total_out')->default(0);
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
        Schema::dropIfExists('stock_flows');
    }
};
