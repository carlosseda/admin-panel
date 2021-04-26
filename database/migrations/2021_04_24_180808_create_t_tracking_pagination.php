<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTrackingPagination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tracking_pagination', function (Blueprint $table) {
            $table->id();
            $table->string("origin");
            $table->string("route");
            $table->string("move");
            $table->string("entity");
            $table->string("page");
            $table->integer('fingerprint_code')->unsigned()->nullable();
            $table->index('fingerprint_code');	
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
        Schema::dropIfExists('t_tracking_pagination');
    }
}
