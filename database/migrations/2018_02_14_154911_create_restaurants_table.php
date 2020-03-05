<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('slug',100)->unique();
            $table->string('address');
            $table->string('number',10)->nullable();
            $table->string('district',50);
            $table->string('state',20);
            $table->string('city',100);
            $table->string('opening_hours_start',10)->nullable();
            $table->string('opening_hours_end',10)->nullable();
            $table->string('delivery_time',10)->nullable();
            $table->string('value_min',10)->nullable();
            $table->string('tax',10)->nullable();
            $table->unsignedBigInteger('payment_way_id')->nullable();
            $table->foreign('payment_way_id')->references('id')->on('payment_ways'); 
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('logo');
            $table->string('logo_path');
            $table->string('cnpj')->nullable();
            $table->string('insc_est')->nullable();
            $table->text('info')->nullable();
            $table->text('about_us')->nullable();
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
        Schema::dropIfExists('restaurants');
    }
}
