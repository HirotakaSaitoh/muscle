<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('movie_id')->index();//投稿したユーザーのID）[i:ユーザーの投稿動画を検索する]
            $table->integer('user_id');// user_id（投げ銭したユーザーのID）
            $table->boolean('delete_flag');// いいね取り消し時のカウント
            $table->timestamps(); //投稿タイミング
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mgoods');
    }
}
