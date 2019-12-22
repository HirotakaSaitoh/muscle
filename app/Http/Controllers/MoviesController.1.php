<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
        return view('accounts', [      
        'query' => $query,
        'query2' => $query2,
        'myData' => $myData
          ]);
    }
    
    
    
    //topページの動画を最新順に表示(工事終了12/7)******************************************** 
    public function top()
    { 
        $uploads = Movie::orderBy('created_at', 'desc')->first();   
        $myData = Auth::user();
        
        $userQuery = User::query(); //
        $userQuery->where('id',$uploads->user_id);//whereでuser tableのidとmovie tableのidが一致しているのを呼び出し、userQueryにぶち込んでいる。
        $user = $userQuery->first();
        $uploads->user_name = $user->name;   //ここのuser_name(変数)はblade.phpへ渡す時の変数と同じ変数名にする
        //$uploads = Movie::where('id',Auth::user()->id)->find($request->id);   検索ここにかく
        //複数の場合は検索で複数のデータを取ってくる
        //動画のデータ群と紐づいたユーザーのデータをPHPの処理で一つのデータにまとめる
        //取ってきたい動画の数と条件を指定してここに書く
        
        //moviesのIDとmoviecommentのmovie_idと一致させる
        //$movieComment = Moviecomment::leftJoin("movies","id","=", "moviecomments.movie_id")->where('movie_id', $uploads->id)->get();
        $movieComment = Movie::leftJoin("moviecomments","movie_id","=", "movies.id")->where( 'movie_id',$uploads->id)->get();
       
       //        $query = User::leftJoin("movies","user_id","=", "users.id")->where('name', $user_name)->get();   //joinさせてからwhereで条件を絞る$user_nameはURLと同じものを取得している
        //$query2 = User::leftJoin("movies","user_id","=", "users.id")->where('name', $user_name)->first(); 

            return view('top', [      
            'aaa' => $uploads, 'myData' => $myData,'movieComment' => $movieComment
  
        ]);
    }
    //topページコメント追加********************************************************* 
    public function comment_store(Request $request){
        $myData = Auth::user();
        $uploads = Movie::orderBy('created_at', 'desc')->first(); 
       // $movieInfo = Movie::find($request->id);  //MovieのIDを取得する
        $movieComment = new Moviecomment; 
        $movieComment -> movie_id = $request->id; 
        $movieComment -> user_id = $myData->id;
        $movieComment -> movie_comment = $request->movie_comment;
        $movieComment -> comment_time = $request->published;
        
        $movieComment -> save();//databaseにコメント情報を登録したい
     
       return redirect('/');
    }     
    
     
    //topページいいね機能
    public function favorite(Request $request){
        $movie_id = $request->movie_id;

        $name = DB::table('post')->where('movie_id', $movie_id)->first();

        $names = $name->user_id;   //mgoodsテーブルのuser_id

        $user = Auth::user();

        //$favname = $user['name'];//ログインユーザー情報のnameだけ取ってくる。

        $judge = DB::select('select * from mgoods where movie_id = ? and user_id = ?', [$movie_id, $names]);

        

        if(!$judge){

            DB::insert('insert into mgoods (movie_id, user_id) values (?,?)',[$movie_id,$names]);            

        }else{

            DB::delete('delete from mgoods where movie_id = ? and user_id = ?',[$movie_id,$names]);     

        }

        //return redirect()->back()->withInput();
        return view('top', ['judge' => $judge, 'd' => $movie_id]);

    }

        
    //動画追加画面表示********************************************************* 
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
           //'id' => 'required',
            // 'user_id' => 'required',
            // 'movie_url' => 'required',
            // 'user_comment' => 'required|max:200',
            // 'published' => 'required',
        ]);
    
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        //file 取得     
        $file = $request->file('item_movie');     
          
        //file が空かチェック     
        if( !empty($file) )
        {  
        //ファイル名を取得         
        //$filename = $file->getClientOriginalName(); 
         
        //ファイル名をランダム化
        $filename = str_random(10);
          
        //ファイル名を取得         
        $move = $file->move('../upload/',$filename.".mp4"); //public/upload/...　　publicの中のuploadフォルダに入る
                  
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
        $uploads->published   =  $request->published;
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
//                 $mane = User::where('name',$request->name)->get();   //上か下のどっちかいらなそう

       $mane = User::find($request->id);   //上か下のどっちかいらなそう
    //   // $mane = new User;                   //上か下のどっちかいらなそう
         $mane->name      = $request->name;   
         $mane->introduce = $request->introduce;   
         $mane->email     = $request->email;  
    //     $mane->password  = $request->password;
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
    
    //パスワード変更画面で情報更新*************PWの暗号化を戻したり暗号化したりの処理が不明、現在のPWと入力されたPWの一致を確認して新しいPWに変更する******************************************
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

        
        // ->limit(5)->get(); 5件とれる　　　//limit() 件数を指定して取れる
        $m_name = Movie::where('item_movie', $movie_item_name)->get();   //whereで条件を絞る$movie_item_nameはURLと同じものを取得している

        
        
            return view('movies', [
            'm_name' => $m_name, 'myData' => $myData
        ]);
        
    }
    
    //ログアウト処理
     public function getLogout(){
     Auth::logout();
    return redirect('/');
     }
    
}
