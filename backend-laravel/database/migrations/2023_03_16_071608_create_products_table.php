<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('name')->nullable()->index();
            $table->string('slug')->index()->unique();
            $table->text('description')->nullable();
            $table->integer('view')->default(0);
            $table->integer('like')->default(0);
            $table->integer('status')->default(0);
            $table->integer('quantity')->default(0);
            $table->json('images')->default(DB::raw("('{}')"));
            $table->longText('content');
            $table->integer('price')->default(0);
            $table->float('sale')->default(0);
            $table->date('time_sale')->nullable();
            $table->text('note')->nullable();
            $table->boolean('hot')->default(0);
            $table->text('payload')->nullable();

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->bigInteger('brand_id')->unsigned()->index();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
