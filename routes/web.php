<?php

use App\Movie;
use Illuminate\Http\Request;

// トップページの動画を表示(top.blade.php)
Route::get('/', 'MoviesController@top');

//topページ でコメントを追加 
Route::post('/movie/comment_store', 'MoviesController@comment_store');  //comment_storeページと言うviewの無い更新ページを作ってリダイレクトでページに戻す

//topページ でコメント削除 
Route::post('/movie/comment_delete', 'MoviesController@comment_delete');  //comment_deleteページと言うviewの無い更新ページを作ってリダイレクトでページに戻す


//topページ いいね機能
Route::post('/favorite', 'MoviesController@favorite');





//動画のclickで動画を拡大表示
//Route::match(['get','post'], '/m/{m_name}', 'MoviesController@movie');
Route::match(['get','post'], '/m/{movie_item_name}', 'MoviesController@movie'); //アカウントページの方法を参考。movie table のitem_nameをURLにできている。




//ログイン認証
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//ログアウト
Route::get('/logout', 'MoviesController@getLogout');

//accountページの動画を順番に表示
Route::get('/user/{user_name}', 'MoviesController@index');
//userはInstagramで言うところの/p/とか/stories/
//{user_name}は各動画個別のURL


//動画追加画面表示 
Route::get('/upload2', 'MoviesController@upload2'); 


//動画追加
Route::post('/upload2','MoviesController@store2');  
//upload -> topに


//ログイン認証チェック 
Route::group(['middleware' => 'auth'], function () { 
    //管理ページ (managements.blade.php)に移動
    Route::get('/management', 'MoviesController@management');
    
    //管理ページ で情報更新 
    Route::post('/management/user_update', 'MoviesController@user_update');  //user_updateページと言うviewの無い更新ページを作ってリダイレクトでページに戻す
    
    //パスワード変更ページに移動 (managementPWs.blade.php)
    Route::get('/management/pw', 'MoviesController@managementPW');
    
    //パスワード変更ページでパスワード更新 
    Route::post('/management/PW_update', 'MoviesController@PW_update');  //PW_updateページと言うviewの無い更新ページを作ってリダイレクトでページに戻す
    
    
});




//テストのやつ
Route::get('/test', 'MoviesController@favorite');  //@はコントローラーと関数を結びつける








// /**
// * 本を削除 
// */
// Route::delete('', function () {
//     //
// });
