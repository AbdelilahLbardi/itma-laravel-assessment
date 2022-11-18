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
        /*
         * As per the requirements, should create a new REST endpoint to accept unauthenticated POST requests
         * which requires making user_id optional
         */
        Schema::table('urls', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urls', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable(false)->change();
        });
    }
};
