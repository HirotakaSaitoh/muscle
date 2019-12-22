@extends('layouts.app')
@section('content')

<!--トップページに最新の動画を表示-->
<!--データベースの最新版だけ取り出したい-->

<!--<div class="p-3 mb-2 bg-secondary text-white">.bg-secondary</div>-->

    <div class="container">

        <!--動画とユーザーコメントは左側カラム-->
        <div class="col-sm-6 col-md-8" >
         
            <div class="embed-responsive embed-responsive-16by9">
                <video id="mv" class="embed-responsive-item" src="/upload/m/{{ $uploads->item_movie }}.mp4" width="800px" controls autoplay muted></video>
            </div>
            
           <div id="comment">
            @foreach ($commentUser as $cu) 
                <div><i class="far fa-comments"></i><p>{{ $cu -> movie_comment}}{{ $cu -> name}}</p></div>
                
               
            @endforeach    
            </div>
            
          
            
        </div>  
    

       
       <!--右側カラム-->

        <!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->
        <div class="col-sm-6 col-md-4">   
            @if($check =0)
                <div><a href="{{ url('upload2') }}"><i class="fas fa-video"></i> 筋肉投稿</a></div>
                <a href="user/{{ $myData->name }}"><i class="fas fa-user-circle"></i> マイ筋肉</a><br>
            @endif
            @if($check = 1)
            
            @endif
            
            
            
            
            <div><i class="fas fa-user"></i><a href="/user/{{ $uploads->user_name }}">{{ $uploads->user_name }}</a></div>
            <div><i class="fas fa-comment-dots"></i>{{ $uploads->user_comment }}</div> 
            <div>{{ $uploads->published }}</div>
            
            
            <!--<form action="{{url('/movie/comment_store')}}" method="post">-->
            <!--    {{ csrf_field() }}  -->
                <div>コメント：<input type="text" name="movie_comment" id="movie_comment" maxlength="20"></div>
                <input type="button" name="movie_comment_button" id="movie_comment_button"  value="君の掛け声が筋肉になるよ(コメント投稿)！！">
                
                
                <!-- id 値を送信 -->         
                <!--<input type="hidden" name="id" value="{{$uploads->id}}" />-->
                <!--<input type="hidden" name="comment_time" value="{{$uploads->id}}" />  -->
                <!--/ id 値を送信 -->
            
            <!--</form>-->
            
            <!--いいねボタン-->
            <input type="button" name="good" id="good" value="よっ！夏の筋肉大三角形(いいね)！"/>
            
             <!-- いいね数表示 工事中-->
             <i class="far fa-heart"></i>
             <!--delete_flagの数を表示する-->
             <div>{{$iineCount}}</div>
             
           
            
        </div>
    </div>

    
@endsection








<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta name="csrf-token2" content="{{ csrf_token() }}"> 




<!--スクリプト開始-->
<script>
    var check = '{{$check}}';
    if(check == 1){
    
        alert('ログインしてない');

   
    }else{
        
         //いいねの非同期処理を書く*********************************************************************
        
            //変数　isIineの初期値をfalseとして設定する
            let isIine = false;
           //let isIine = 0;
             
             //ボタンを押したら「よっ！夏の筋肉大三角形(いいね)！」実装
             window.addEventListener('load',  function(){        //画面を読み込んだらScriptを実行
             var element = document.getElementById("good");
             if(isIine == true){
                 element.value = "ベテルギウス大爆発(取り消し)！！";
             }else{
                 element.value = "よっ！夏の筋肉大三角形(いいね)！！";
             }
             
             //いいねと取り消しをクリックしたときの関数
             element.onclick = function (){
                 
                if(isIine == true){ //いいね取り消し
                    //let isIine = false;
                     //isIine = 0;
                    element.value = "ベテルギウス大爆発(取り消し)！！";
                    var formdata = new FormData();
                    formdata.append('user_id', '{{$myData->id}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                    formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                    formdata.append('delete_flag', '1');
                    
                    
                    
                    isIine = false;
                     
                }else{ //いいね
                     //let isIine = true;
                     //isIine = 1;
                     element.value = "よっ！夏の筋肉大三角形(いいね)！！";
                     var formdata = new FormData();
                     formdata.append('user_id', '{{$myData->id}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                     formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                     formdata.append('delete_flag', '0');
                   
                     
                     isIine = true;
                 
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
                     
                     
                     
                //いいね数の表示を書く
                //divの中を今あるやつを検索して書き換える（inner.htmlとかで書き換える
                 
            };
            } )   
             
             
        
        //コメントの非同期処理を書く*************************************************************************************    
             window.addEventListener('load', function(){        //画面を読み込んだらScriptを実行
                var element2 = document.getElementById("movie_comment_button");
                var m_comme = document.getElementById("movie_comment").value;
                element2.onclick = function (){
                    if(m_comme == ""){
                        alert('コメントを入力してください');           
                    }else{
                        //videoオブジェクトの取得 
                        var media = document.getElementById("mv");
                        var playtime = media.currentTime;//再生時間を取得する 
                        
                        var formdata_comment = new FormData();
                       
            
                            formdata_comment.append('user_id', '{{$myData->id}}');   //コメントテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                            formdata_comment.append('movie_id', '{{$uploads->id}}');   //コメントテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                            
                            formdata_comment.append('movie_comment', m_comme);
                            formdata_comment.append('comment_time', playtime);   //コメントテーブルのcomment_timeをPOST   第一引数はコントローラー側で受け取りたい名前
                    
                        var xhttpreq2 = new XMLHttpRequest();
                        
                        var token = document.getElementsByName('csrf-token2').item(0).content; 
                            xhttpreq2.open("POST", "movie/comment_store", true); //MovieControllerのcomment_storeにPOST
                            xhttpreq2.setRequestHeader('X-CSRF-Token', token); 
                            xhttpreq2.send(formdata_comment);
                        
                        //非同期でコメント表示させる方法    
                        var comment = document.getElementById("comment");    //divのidを引っ張ってくる
                        var icon = document.createElement("i");
                            icon.className = "far fa-comments";
                        
                        var aaa = document.createElement("div");  //htmlのdivをつくる
                        var p = document.createElement("p");
                            
                            
                            
                            aaa.appendChild(icon);
                            comment.insertBefore(aaa, comment.firstChild);  //コメントdivに入っている一番最初の要素の手前にaaaを加える
                            p.innerHTML = m_comme + " " + "{{$myData->name}}";      //自分の名前を追加
                            aaa.appendChild(p);
                            
                            
                            
                        //投稿したコメントをテキストボックスから消す
                        var mc  = document.getElementById("movie_comment");
                        mc.value = "";
                    }
                    
                };
                 
            })
            
        
    }
     
</script>



