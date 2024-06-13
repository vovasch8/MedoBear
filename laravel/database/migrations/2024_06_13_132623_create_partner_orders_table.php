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
        Schema::create('partner_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id');
            $table->integer('order_id');
            $table->string('link');
            $table->integer('price')->default(0);
            $table->integer('payments')->default(0);
            $table->boolean('paid_out')->default(false);
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
        Schema::dropIfExists('partner_orders');
    }
};
