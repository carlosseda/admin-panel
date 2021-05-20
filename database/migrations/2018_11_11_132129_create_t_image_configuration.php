<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTImageConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_image_configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity', 255);
            $table->string('disk', 255);
            $table->string('directory', 255);
            $table->string('type', 255);
            $table->string('content', 255);
            $table->string('grid', 255);
            $table->string('content_accepted', 255);
            $table->string('extension_conversion');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('quality');
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
        Schema::dropIfExists('t_image_configuration');
    }
}
