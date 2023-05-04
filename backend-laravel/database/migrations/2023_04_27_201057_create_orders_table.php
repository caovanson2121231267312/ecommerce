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
            $table->string('name')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('ship')->default(0);
            $table->text('note')->nullable();
            $table->integer('price')->default(0);
            $table->integer('sale_price')->default(0);

            $table->bigInteger('payment_id')->unsigned()->index();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
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
