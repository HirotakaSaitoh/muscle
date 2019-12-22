<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviecommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moviecomments', function (Blueprint $table) {
            $table->increments('id');  //コメントを特定するID
            $table->integer('movie_id')->unique(); //コメント対象の動画
            $table->integer('user_id'); //コメントしたユーザーのID
            $table->text('movie_comment',200)->nullable();  //コメント内容
            $table->double('comment_time',8,3); //動画に対するコメント投稿時間,全8桁、少数点以下3桁
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
        Schema::dropIfExists('moviecomments');
    }
}
