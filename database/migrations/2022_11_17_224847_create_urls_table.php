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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();

            /**
             * The reasons why I use indexes instead of foreign keys is because the DB is meant to store, and retrieve the data
             * The logic of how data should be handled is something that has to be done within the application layer.
             * This give also much power to handle things front line prior to asking the DB to do anything.
             */

            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('destination')->index();
            $table->string('slug', 5)->unique();
            $table->integer('views')->unsigned()->default(0);
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
        Schema::dropIfExists('urls');
    }
};
