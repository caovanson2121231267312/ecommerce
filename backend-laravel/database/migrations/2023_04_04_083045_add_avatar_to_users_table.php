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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->text('note')->nullable();
            $table->integer('login_failed')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('gender')->nullable();
            $table->date('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('phone_number');
            $table->dropColumn('note');
            $table->dropColumn('login_failed');
            $table->dropColumn('status');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
        });
    }
};