<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTFingerprint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_fingerprint', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fingerprint_code')->unsigned();
            $table->string('browser');
            $table->string('browser_version');
            $table->string('OS');
            $table->string('resolution');
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
        Schema::dropIfExists('t_fingerprint');
    }
}
