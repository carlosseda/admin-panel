<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTrackingScroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tracking_scroll', function (Blueprint $table) {
            $table->id();
            $table->double('difference_in_y', 8, 2);
            $table->double('current_y_position', 8, 2);
            $table->string("origin");
            $table->string("route");
            $table->string("move");
            $table->string("entity");
            $table->integer('fingerprint_code')->unsigned()->nullable();
            $table->string("retention")->nullable();
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
        Schema::dropIfExists('t_tracking_scroll');
    }
}
