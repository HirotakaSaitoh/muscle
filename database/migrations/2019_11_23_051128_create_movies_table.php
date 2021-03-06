<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();//投稿したユーザーのID）[i:ユーザーの投稿動画を検索する]
            $table->string('movie_url')->nullable; //動画URL
            $table->string('item_movie'); //動画の名前
            $table->string('user_comment',200)->nullable;// 投稿者コメント
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
        Schema::dropIfExists('movies');
    }
}
