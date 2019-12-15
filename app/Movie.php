<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //動画の処理をまとめる
    //関数をつくる
    //例えば、このユーザーの動画をとる関数
    
    
    
  //belongsTo設定
//   public function belongToUser()
//   {
//   return $this->belongsTo('App\User');
//   }
  
  //いいねの数を表示させる関数
  public function favorite_users(){
            return $this->belongsToMany(User::class,'favorite','movie_id','user_id')->withTimestamps();
    }
  
  
}



