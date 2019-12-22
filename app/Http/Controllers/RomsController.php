<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Movie;  
use Validator;  
use Auth;
use App\User;
use App\Mgood;
use App\Moviecomment;


class RomsController extends Controller
{
    

    //accountページの動画を順番に表示(後はwhereのidを自動でクリックしたアイコンのidにする→12/3済)******************************************
    public function index($user_name)
    { 

        //$query = Movie::table("movies")->leftJoin("users","users.id", "=", "movies.user_id")->get();
        //$query = Movie::leftJoin("users","users.id", "=", "movies.user_id")->get();//←これだけのときにできた
        
        $myData = Auth::user();//myaccountかどうかの分岐に使用
        
        
        $query = User::leftJoin("movies","user_id","=", "users.id")->where('name', $user_name)->get();   //joinさせてからwhereで条件を絞る$user_nameはURLと同じものを取得している
        //$query2 = User::leftJoin("movies","user_id","=", "users.id")->where('name', $user_name)->first(); 
        $query2 = User::where('name', $user_name)->first(); 
        //dd($query); //For checking(デバック方法)
        
        //複数の場合は検索で複数のデータを取ってくる
        //動画のデータ群と紐づいたユーザーのデータをPHPの処理で一つのデータにまとめる
        //取ってきたい動画の数と条件を指定してここに書く
        //ログインしたアカウントの最新動画順を全部表示させる
        
        return view('accounts', ['query' => $query, 'query2' => $query2, 'myData' => $myData]);
    }
    
    
    
    //topページの動画を最新順に表示(いいねをしたユーザーidがmgoodsテーブルにいるとエラーになる)******************************************** 
    public function top()
    { 
        if(Auth::check()){ //ログイン確認
            $check = 0;//ログインしていれば０
            $myData = Auth::user();
            
            
        }else{
            $check = 1; //ログインしていなければ１
            $myData = 0;
        }
        
        $uploads = Movie::orderBy('created_at', 'desc')->first();   
        $userQuery = User::query(); //
        $userQuery->where('id',$uploads->user_id);//whereでuser tableのidとmovie tableのidが一致しているのを呼び出し、userQueryにぶち込んでいる。
        $user = $userQuery->first();
        $uploads->user_name = $user->name;   //ここのuser_name(変数)はblade.phpへ渡す時の変数と同じ変数名にす
        
        //movieCommentをぶっ飛ばす処理（同期処理ですみませんでした、Vue頑張ります；；）
        $movieComment = Movie::leftJoin("moviecomments","movie_id","=", "movies.id")->where( 'movie_id',$uploads->id)->get();
        $commentUser = User::leftJoin("moviecomments","user_id","=", "users.id")->where( 'movie_id',$uploads->id)->get();
        
        $iineCount = Mgood::where("movie_id", $uploads->id)->where("delete_flag", 0)->count();
        
        
        //今見てる人がイイねをしてるのかどうかを判断する
        //条件文（表示切替　ボタンの切り替えと表示件数が＋１に出来るかー１に出来るか切り替え）
        
        
     
            return view('top', ['uploads' => $uploads, 'myData' => $myData,'movieComment' => $movieComment,'commentUser' => $commentUser, 'iineCount'=>$iineCount,'check'=>$check]);   
    }

 
    //動画をclickして拡大表示させる(movie.blade.php)***************************************************
    public function movie($movie_item_name){
        //public function movie(Movie $m_name){
        //public function movie($m_name){
        //$m_name= new Movie;
        //  $m_name = Movie::select('item_movie')->first(); 
        //$m_name = Movie::find('item_movie');
        $myData = Auth::user();

        
        // ->limit(5)->get(); 5件とれる  limit() 件数を指定して取れる
        $m_name = Movie::where('item_movie', $movie_item_name)->get();   //whereで条件を絞る$movie_item_nameはURLと同じものを取得している

        
        
            return view('movies', [
            'm_name' => $m_name, 'myData' => $myData
        ]);
        
    }
   //test用
    public function test(){
   $name = Mgood::where('movie_id', 3)->get(['user_id']);
      return view('test',['name'=>$name]);
    }
}
