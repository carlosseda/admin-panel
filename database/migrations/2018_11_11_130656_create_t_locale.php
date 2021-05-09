<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLocale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_locale', function (Blueprint $table) {
            $table->increments('id');
            $table->string('language');
            $table->string('rel_parent', 255);
            $table->string('rel_anchor', 255);
            $table->string('tag', 255);
            $table->integer('key')->nullable(true)->index();
            $table->text('value')->nullable(true);
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
        Schema::dropIfExists('t_locale');
    }
}
