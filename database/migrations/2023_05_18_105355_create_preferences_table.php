<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('date_id');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('feed_news_id');

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('author_id')->references('id')->on('author') ;
            $table->foreign('country_id')->references('id')->on('country') ;
            $table->foreign('date_id')->references('id')->on('date') ;
            $table->foreign('source_id')->references('id')->on('source') ;
            $table->boolean('feedable');
            $table->foreign('feed_news_id')->references('id')->on('feed_news') ;
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
        Schema::dropIfExists('preferences');
    }
}
