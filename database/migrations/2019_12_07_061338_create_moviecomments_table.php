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
            $table->datetime('comment_time'); //投稿日時
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
