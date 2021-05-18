<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTLocaleRedirect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_locale_redirect', function (Blueprint $table) {
            $table->increments('id');
            $table->string('language',64);
            $table->string('group', 255);
            $table->string('key', 255);
            $table->string('subdomain', 255)->nullable(true);
            $table->string('old_url', 255)->nullable(true)->index();
            $table->integer('locale_seo_id')->unsigned()->index()->nullable(true);
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
        Schema::dropIfExists('t_locale_redirect');
    }
}
