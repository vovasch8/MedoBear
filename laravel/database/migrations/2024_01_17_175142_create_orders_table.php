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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("pip");
            $table->string('phone');
            $table->string('type_poshta');
            $table->string("ukr_city")->default(null);
            $table->string("ukr_post_office")->default(null);
            $table->string("nova_city")->default(null);
            $table->string("nova_warehouse")->default(null);
            $table->boolean("courier")->default(false);
            $table->string("street")->default(null);
            $table->string("house")->default(null);
            $table->string("room")->default(null);
            $table->string("price");
            $table->string("promocode")->default(null);
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
};
