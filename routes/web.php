<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Movie;
use Illuminate\Http\Request;

// /**
// * 動画を表示(top.blade.php)
// */
// Route::get('/', function () {
//     return view('top');
// });


//動画追加画面表示 


Route::get('/upload', function () {     
     return view('uploads');
    });
    
    
    
    
//動画追加
Route::post('/upload', function (Request $request) { 
//upload -> topに

    //バリデーション
    $validator = Validator::make($request->all(), [
        'id' => 'required',
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
    
        //data登録
        $uploads = new Movie;
        //$uploads = Movie::where('id',Auth::user()->id)->find($request->id);
        $uploads->user_id   ='111'; // $request->user_id;
        $uploads->movie_url = 'test'; //$request->'movie_url';
        $uploads->user_comment ='test';// $request->user_comment;
        $uploads->published   = '2017-03-07 00:00:00'; //$request->published;
        $uploads->save();
        return redirect('/upload');
        //後で、topに戻す！！！！！！！！！！！！！！！！！！！！！！！！！！！！！

}); 


Route::get('/account', function () {  
    $uploads = Movie::orderBy('created_at', 'asc')->get();
return view('accounts', [      
    'uploads' => $uploads    
    ]); 
});

// /**
// * 動画を追加(uploads.blade.php)
// */
// Route::post('/upload', function (Request $request) {
    
    
    
    
    
//     return view('uploads');
// });


// /**  * 新「本」を追加  */ 
// Route::post('/books', function (Request $request) {     
//     // 
// }); 





// use App\User;
// use Illuminate\Http\Request;

// /**
// *アカウントページ (acount.blade.php)
// */

// /**
// * 本を削除 
// */
// Route::delete('', function () {
//     //
// });


// use App\Movie;
// use Illuminate\Http\Request;

// /**
// *管理ページ (management.blade.php)
// */


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
