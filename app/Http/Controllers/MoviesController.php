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


class MoviesController extends Controller
{
    
    //コンストラクタ（このクラスが呼ばれたら最初に処理をする） ******************************************************************
    public function __construct()  
    { 
    $this->middleware('auth');
    }
    
    
    
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
        $uploads = Movie::orderBy('created_at', 'desc')->first();   
        $myData = Auth::user();
        $userQuery = User::query(); //
        $userQuery->where('id',$uploads->user_id);//whereでuser tableのidとmovie tableのidが一致しているのを呼び出し、userQueryにぶち込んでいる。
        $user = $userQuery->first();
        $uploads->user_name = $user->name;   //ここのuser_name(変数)はblade.phpへ渡す時の変数と同じ変数名にす
        
        //movieCommentをぶっ飛ばす処理（同期処理ですみませんでした、Vue頑張ります；；）
        $movieComment = Movie::leftJoin("moviecomments","movie_id","=", "movies.id")->where( 'movie_id',$uploads->id)->get();
        $commentUser = User::leftJoin("moviecomments","user_id","=", "users.id")->where( 'movie_id',$uploads->id)->get();
        
        $iineCount = Mgood::where("movie_id", $uploads->id)->where("delete_flag", 0)->count();
        
        //今見てる人がイイねをしてるのかどうかを判断する
        //条件文（表示切替ボタンの切り替えと表示件数が＋１に出来るかー１に出来るか切り替え）
 
        if(!isset($commentUser[0]))
        {$chk=0;
        }else{ 
        $chk=1;
        }

     
            return view('top', ['uploads' => $uploads, 'myData' => $myData,'movieComment' => $movieComment,'commentUser' => $commentUser, 'iineCount'=>$iineCount,'chk'=>$chk]);   
    }

    
    //topページコメント追加(非同期処理)********************************************************* 
    public function comment_store(Request $request){

        $movieComment = new Moviecomment; 
        $movieComment -> movie_id = $request->movie_id; 
        $movieComment -> user_id = $request->user_id;
        $movieComment -> movie_comment = $request->movie_comment;
        $movieComment -> comment_time = $request->comment_time;
        $movieComment -> save();//databaseにコメント情報を登録したい
     
    }

    
    
    
    
    
    //topページコメント削除(非同期処理)********************************************************* 
    public function comment_delete(Request $request){
        
        $commentDelete = Moviecomment::findOrFail($request->id);
        $commentDelete->delete();
    
    }
    
     
 
    //topページいいね機能(非同期処理)*********************************************************************
    public function favorite(Request $request){ //DBの受け渡し
        $GU = Mgood::where('user_id', $request->user_id)
        ->where('movie_id', $request->movie_id)
        ->first();
      
        if($GU==""){       //mgoodsにdelete_flagが入っていない場合、値を入れる
            $mgoods = new Mgood; 
            $mgoods -> delete_flag = $request->delete_flag;  //falseだとbooleanに０が入る
            $mgoods -> movie_id = $request->movie_id; 
            $mgoods -> user_id = $request->user_id;
            $mgoods -> save();//databaseにコメント情報を登録したい
        
        }else{           //mgoodsにdelete_flagが入っていない場合、値を入れ替える
            $GU->delete_flag = $request->delete_flag;
            $GU->save();
        }

        //2回目以降、mgoodsのdelete_flagカラムを確認し、切り替える
        //return "ABC";     
    
        //いいね数を表示させるための変数(工事中)
        // $count_favorite_users = $mgoods->user_id()->count();
        // return view('top',['count_favorite_users'=>$count_favorite_users,]);
        
    }
    
    

        
    //動画追加画面表示************************************************************************************* 
    public function upload2()
    {
        //phpinfo();
        return view('uploads2');
    }
       
        
   //動画追加******************************************************************
    public function store2(Request $request)     
    {
    
        //バリデーション
        $validator = Validator::make($request->all(), [
            'item_movie'   => 'required | mimes:mp4,qt,x-ms-wmv,mpeg,x-msvideo', //動画であること
            'user_comment' => 'required | max:200',
        ]);
    
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/upload2')
                ->withInput()
                ->withErrors($validator);
        }

        //file 取得     
        $file = $request->file('item_movie');     
          
        //file が空かチェック     
        if( !empty($file) )
        {  

        //ファイル名をランダム化
        $filename = str_random(10);
          
        //ファイル名を取得         
        $move = $file->move('../upload/m/',$filename.".mp4"); //public/upload/...  public/upload/mフォルダに入る
                  
        }else{         
            $filename = "";     
        }
    
        //data登録
        $uploads = new Movie;
        //$uploads = Movie::where('id',Auth::user()->id)->find($request->id);   検索
        $user = Auth::user();
        $uploads->user_id   = $user->id;
        $uploads->movie_url = 'test'; //$request->'movie_url';
        $uploads->user_comment = $request->user_comment;
        $uploads->item_movie = $filename;
        //$uploads->code = $filename;
        $uploads->save();
        return redirect('/upload2');
        //後で、topに戻す！！！！！！！！！！！！！！！！！！！！！！！！！！！！！
    }      
        
  
    //管理画面に移動 ************************************************************
    public function management()
    {
        //アカウント認証実装(web.phpにて)
        
        //アカウント整合未実装
    
        //アカウントに情報を渡す
        $mane = Auth::user();

     return view('managements',[ 'mane' => $mane]);
    }
    
    
    //管理画面で情報更新(工事中→12/03済 念のため前のコード消してない)*******************************************************
    public function user_update(Request $request){//
        //データ更新    
      
        //バリデーション
        $validator = Validator::make($request->all(), [
    
            'user_image'   => 'Image', //画像であること
            'name'  => 'required | max:20',
            'email' => 'required |email| max:100', //メアドであること
        ]);
     
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/management')
                ->withInput()
                ->withErrors($validator);
        }
        
        //file 取得     
        $file = $request->file('user_image');
       //$request = \Image::make($request)->resize(200, null)->save(public_path() . '/image/' .'resize-noimage.png');
        
        //$file = $image->getClientOriginalName();
        //幅300に合わせる
        //$image = \Image::make($file)
          
        //file が空かチェック     
        if( !empty($file) )
        {  
        //
        
        //$filedelete = Storage::allfiles($request->id); ~~~~~~~~~~今までの画像を消す処理をしたい~~~~~~~~~~
        //Storage::delete($filedelete);
        
       //ファイル名を取得         
        $filename = $file->getClientOriginalName(); 
          
        //ファイルを移動         
        $move = $file->move('../upload/image/',$filename); //public/upload/...  public/upload/imageフォルダに入る
                  
        }else{         
            $filename = "";     
        }


        $mane = User::find($request->id);   
        $mane->name = $request->name;   
        $mane->introduce = $request->introduce;   
        $mane->email = $request->email;  
        $mane->user_image = $filename;
        $mane->save();   
        return redirect('/management');//～～～～～～～～/user/{user_name}に遷移したいけどまだやり方わからず～～～～～～～～～～
    
        
    }
    
    //パスワード変更画面への移動****************************************************
     public function managementPW()
    {
        //アカウント認証実装(web.phpにて)
        //アカウント整合未実装
    
        //アカウントに情報を渡す
        $myData = Auth::user();

     return view('managementPWs',[ 'myData' => $myData]);
    }
    
    //パスワード変更画面で情報更新*************PWの暗号化を戻したり暗号化したりの処理が不明、現在のPWと入力されたPWの一致を確認して新しいPW��変更する******************************************
    public function PW_update(Request $request){

        
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
    
    //ログアウト処理
     public function getLogout(){
     return Auth::logout();
      
    }
    
    
}