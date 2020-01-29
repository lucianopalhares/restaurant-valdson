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
            $table->string('address');
            $table->string('number',10)->nullable();
            $table->string('district',50);
            $table->enum('state',['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO']);
            $table->string('city',100);
            $table->string('opening_hours_start',10)->nullable();
            $table->string('opening_hours_end',10)->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('whatsapp')->nullable();
            $table->string('logo');
            $table->string('cnpj')->nullable();
            $table->string('insc_est')->nullable();
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
