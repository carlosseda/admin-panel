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
            $table->string('path', 255)->nullable(true);
            $table->string('entity',64)->nullable(true);
            $table->integer('entity_id')->unsigned()->index()->nullable(true);
            $table->string('language',64)->nullable(true);
            $table->string('filename',255)->nullable(true);
            $table->string('content',64)->nullable(true);
            $table->string('mime_type',64)->nullable(true);
            $table->string('grid',11)->nullable(true);
            $table->integer('size')->nullable(true);
            $table->smallInteger('width')->nullable(true);
            $table->smallInteger('height')->nullable(true);
            $table->integer('quality')->nullable(true);
            $table->integer('runtime')->nullable(true);
            $table->integer('image_original_id')->unsigned()->nullable(true);
            $table->integer('temporal_id')->unsigned()->index()->nullable(true);
            $table->integer('image_configuration_id')->unsigned()->nullable(true);
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
