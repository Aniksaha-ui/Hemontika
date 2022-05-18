<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('order_user_id');
           $table->String("generate_ordertitle");

         $table->foreign('order_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        $table->unsignedBigInteger('order_cart_id');
        $table->foreign('order_cart_id')->references('id')->on('carts')->onDelete('cascade')->onUpdate('cascade');
        
        $table->String("order_status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
