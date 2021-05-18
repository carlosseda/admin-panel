<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTImageResized extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_image_resized', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable(true);
            $table->text('alt')->nullable(true);
            $table->string('path', 255);
            $table->string('entity',64);
            $table->integer('entity_id')->unsigned()->index();
            $table->string('language',64);
            $table->string('filename',255);
            $table->string('content',64);
            $table->string('mime_type',64);
            $table->string('grid',11)->nullable(true);
            $table->integer('size')->nullable(true);
            $table->smallInteger('width')->nullable(true);
            $table->smallInteger('height')->nullable(true);
            $table->integer('quality')->nullable(true);
            $table->integer('runtime')->nullable(true);
            $table->integer('image_configuration_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('t_image');
    }
}
