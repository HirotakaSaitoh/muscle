@extends('layouts.app')
@section('content')

<!--トップページに最新の動画を表示-->
<!--データベースの最新版だけ取り出したい-->

<!--<div class="p-3 mb-2 bg-secondary text-white">.bg-secondary</div>-->

    <div class="container">

        <!--動画とユーザーコメントは左側カラム-->
        <div class="col-sm-6 col-md-8">
         
            <div class="embed-responsive embed-responsive-16by9">
                <video id="mv" class="embed-responsive-item" src="/upload/m/{{ $uploads->item_movie }}.mp4" width="800px" controls autoplay muted></video>
            </div>
            
            @foreach ($movieComment as $mc) 
            <i class="far fa-comments"></i>{{ $mc -> movie_comment}} <br>
            {{ $mc ->name }} <br>    <!-- //名前情報が入っていないから飛ばせない-->
            @endforeach
        </div>  
    

       
       <!--右側カラム-->
        <div class="col-sm-6 col-md-4">   
            <div><a href="{{ url('upload2') }}"><i class="fas fa-video"></i> 筋肉投稿</a></div>
            <a href="user/{{ $myData->name }}"><i class="fas fa-user-circle"></i> マイ筋肉</a><br>
            　
            <!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->
            
            
            
            
            <div><i class="fas fa-user"></i><a href="/user/{{ $uploads->user_name }}">{{ $uploads->user_name }}</a></div>
            <div><i class="fas fa-comment-dots"></i>{{ $uploads->user_comment }}</div> 
            <div>{{ $uploads->published }}</div>
            
            
            <!--<form action="{{url('/movie/comment_store')}}" method="post">-->
            <!--    {{ csrf_field() }}  -->
                <div>コメント：<input type="text" name="movie_comment" id="movie_comment" maxlength="20"></div>
                <input type="button" name="movie_comment_button" id="movie_comment_button" onclick="getMdTime()" value="君の掛け声が筋肉になるよ(コメント投稿)！！">
                
                
                <!-- id 値を送信 -->         
                <!--<input type="hidden" name="id" value="{{$uploads->id}}" />-->
                <!--<input type="hidden" name="comment_time" value="{{$uploads->id}}" />  -->
                <!--/ id 値を送信 -->
            
            <!--</form>-->
            
            <!--いいねボタン-->
            <input type="button" name="good" id="good" value="よっ！夏の筋肉大三角形(いいね)！"/>
            
             <!-- いいね数表示 工事中-->
             <i class="far fa-heart"></i>
             
           
            
        </div>
    </div>

    
@endsection








<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta name="csrf-token2" content="{{ csrf_token() }}"> 








<!--スクリプト開始-->
<script>



//いいねの非同期処理を書く*********************************************************************

    //変数　isIineの初期値をfalseとして設定する
    let isIine = false;
   //let isIine = 0;
     
     //ボタンを押したら「よっ！夏の筋肉大三角形(いいね)！」実装
     window.onload = function(){        //画面を読み込んだらScriptを実行
     var element = document.getElementById("good");
     if(isIine == false){
         element.value = "ベテルギウス大爆発(取り消し)！！";
     }else{
         element.value = "よっ！夏の筋肉大三角形(いいね)！！";
     }
     
     //いいねと取り消しをクリックしたときの関数
     element.onclick = function (){
         
        if(isIine == false){ //いいね取り消し
            //let isIine = false;
             //isIine = 0;
            element.value = "ベテルギウス大爆発(取り消し)！！";
            var formdata = new FormData();
            formdata.append('user_id', '{{$myData->id}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
            formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
            formdata.append('delete_flag', '1');
            isIine = true;
             
        }else{ //いいね
             //let isIine = true;
             //isIine = 1;
             element.value = "よっ！夏の筋肉大三角形(いいね)！！";
             var formdata = new FormData();
             formdata.append('user_id', '{{$myData->id}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
             formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
             formdata.append('delete_flag', '0');
             isIine = false;
         
        }
         
        var xhttpreq = new XMLHttpRequest();
        //  xhttpreq.onreadystatechange = function () {
        //     if(xhttpreq.readyState == 4 && xhttpreq.status == 200) { alert(xhttpreq.responseText);}
        //     if(xhttpreq.readyState == 4 && xhttpreq.status != 0) {alert("アップロード完了");}
        //  };
         var token = document.getElementsByName('csrf-token').item(0).content; 
             xhttpreq.open("POST", "favorite", true); //MovieControllerのfavoriteにPOST
             xhttpreq.setRequestHeader('X-CSRF-Token', token); 
             xhttpreq.send(formdata);
         
    };
    }    
     
     
     
     
     
     
     
//コメントの非同期処理を書く*************************************************************************************    
     window.onload = function(){        //画面を読み込んだらScriptを実行
        var element2 = document.getElementById("movie_comment_button");
        
        element2.onclick = function (){
            
            //videoオブジェクトの取得 
            var media = document.getElementById("mv");
            
            var playtime = media.currentTime;//再生時間を取得する 
            
            var formdata_comment = new FormData();
                formdata_comment.append('user_id', '{{$myData->id}}');   //コメントテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                formdata_comment.append('movie_id', '{{$uploads->id}}');   //コメントテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                formdata_comment.append('movie_comment', 'document.getElementById("movie_comment")');   //コメントテーブルのmovie_commentをPOST   第一引数はコントローラー側で受け取りたい名前
            
        
alert(formdata_comment);//test
console.log(formdata_comment);//test
        
            var xhttpreq2 = new XMLHttpRequest();
            
            var token = document.getElementsByName('csrf-token2').item(0).content; 
                xhttpreq2.open("POST", "movie/comment_store", true); //MovieControllerのcomment_storeにPOST
                xhttpreq2.setRequestHeader('X-CSRF-Token', token); 
                xhttpreq2.send(playtime);
                xhttpreq2.send(formdata_comment);
        };
         
    }
    
    


     
    
</script>