9<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTGooglebot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_googlebot', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->integer('sitemap_id')->unsigned()->nullable();
            $table->integer('complete');
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
        Schema::dropIfExists('t_googlebot');
    }
}
