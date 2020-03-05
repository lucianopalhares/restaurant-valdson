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
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->unsignedBigInteger('payment_way_id');
            $table->foreign('payment_way_id')->references('id')->on('payment_ways'); 
            $table->decimal('total', 12,2);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->string('coupon_code')->nullable();
            $table->string('coupon_value')->nullable();
            $table->decimal('total_final', 12,2);
            $table->integer('status')->nullable()->default(0);//0:cancelada,1:ativa,2:solicitacao de cancelamento
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
