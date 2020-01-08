@extends('layouts.app')
@section('content')

<!--cssファイルの読み込み-->
<link rel="stylesheet" href="{{ asset('css/style.css') }}"> 

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
                <div>
                    
                    <p id="{{ $cu -> id}}" class="userComment">                    
                        <a href="/user/{{ $cu -> name}}" class="link">
                            <b>{{ $cu -> name}}</b>
                        </a>
                        <i class="far fa-comments"></i> {{ $cu -> movie_comment}}
                        @if($cu->user_id == $myData ->id )
                        <input type="button" name="clear" value="削除筋" class="btn btn-warning btn-sm" onclick="deleteC('{{ $cu -> id}}');" >
                        @endif
                    </p>
                   
                </div>
            @endforeach   
            
            
            
           </div>
        </div>
        
        <!--test-->
        <!--<div id="test" name="test2">-->
           
        <!--    <input type="button" id="button" value="ハイオク満タン"/>-->
        <!--    <p id="ppp" name="mantan">Huuuuuuuuuuuuu</p>-->
        <!--</div>-->

       
       <!--右側カラム-->
       
        <div class="col-sm-6 col-md-4">   
        
                <div><a href="{{ url('upload2') }}"><i class="fas fa-video"></i> 筋肉投稿</a></div>
                <a href="user/{{ $myData->name }}"><i class="fas fa-user-circle"></i> マイ筋肉</a><br>
           
            <!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->

            
            <div><i class="fas fa-user"></i><a href="/user/{{ $uploads->user_name }}">{{ $uploads->user_name }}</a></div>
            <div><i class="fas fa-comment-dots"></i>{{ $uploads->user_comment }}</div> 
            <div>{{ $uploads->published }}</div>
            
            
                <div class="commentButton">コメント：<input type="text" name="movie_comment" id="movie_comment" maxlength="40"></div>
                <input type="button" name="movie_comment_button" id="movie_comment_button" class="btn btn-light" value="君の掛け声が筋肉になるよ(コメント投稿)！！">
                
            
            <!--いいねボタン-->
            
             <!-- いいね数表示    delete_flagの数を表示する-->
             <div class="iineButton">
                 <input type="button" name="good" id="good" class="btn btn-primary" value="よっ！夏の筋肉大三角形(いいね)！"/>
                 <i class="far fa-heart"></i>{{$iineCount}}
             </div>

            
        </div>
    </div>

    
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}"> 
<meta name="csrf-token2" content="{{ csrf_token() }}"> 
<meta name="csrf-token3" content="{{ csrf_token() }}"> 

<!--スクリプト開始-->
<script>

     // buttonを押したら非同期でコメントが削除される(DBも)*************************************************************
    function deleteC(id){
        var deleteConfirm = confirm('その削除、筋肉量を2g失うが大丈夫でしょうか？');
                
        if(deleteConfirm == true){//コメント削除する選択
        	var dom_obj = document.getElementById(id);
            var dom_obj_parent = dom_obj.parentNode;
            dom_obj_parent.removeChild(dom_obj);
            
            var c_id = dom_obj.getAttribute("id"); //p->id
            
          //formdataに削除対象の情報を入れる
            var formdata_delete = new FormData();
                formdata_delete.append('id', c_id);   //コメントテーブルのidをPOST   第一引数はコントローラー側で受け取りたい名前
            
            
            //非同期の削除処理をする
            var xhr = new XMLHttpRequest();
            
            var token3 = document.getElementsByName('csrf-token3').item(0).content; 
            
            //xhr.open('DELETE', "movie/comment_delete", true);
            xhr.open('POST', "movie/comment_delete", true);
            xhr.setRequestHeader('X-CSRF-Token', token3); 
            xhr.send(formdata_delete);
            return c_id;
        }else{}       //コメント削除しない選択
        
    }


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
                    formdata.append('user_id', '{{$myid}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                    formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                    formdata.append('delete_flag', '1');
                    
                    
                    
                    isIine = false;
                     
                }else{ //いいね
                     //let isIine = true;
                     //isIine = 1;
                     element.value = "よっ！夏の筋肉大三角形(いいね)！！";
                     var formdata = new FormData();
                     formdata.append('user_id', '{{$myid}}');   //いいねテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
                     formdata.append('movie_id', '{{$uploads->id}}');   //いいねテーブルのmovie_idをPOST   第一引数はコントローラー側で受け取りたい名前
                     formdata.append('delete_flag', '0');
                   
                     
                     isIine = true;
                 
                }
                 
                var xhttpreq = new XMLHttpRequest();

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
            //var m_comme = document.getElementById("movie_comment").value;
            
            
            element2.onclick = function (){
                var m_comme = document.getElementById("movie_comment").value;
                if(m_comme == ""){
                    alert('コメントを入力してください');           
                }else{
                    //videoオブジェクトの取得 
                    var media = document.getElementById("mv");
                    var playtime = media.currentTime;//再生時間を取得する 
                    
                    var formdata_comment = new FormData();
                  
                        formdata_comment.append('user_id', '{{$myid}}');   //コメントテーブルのuser_idをPOST   第一引数はコントローラー側で受け取りたい名前
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

                    var div = document.createElement("div");  //htmlのdivをつくる　
                    var p = document.createElement("p");
                    // var a = document.createElement("a");
                    // a.href="/user/{{$myname}}";
                    // var b = document.createElement("b");
 //alert(c_id);
                    var btn = document.createElement("input");
                     btn.setAttribute("type","button");
                     btn.setAttribute("value",'削除筋');
                     btn.setAttribute("onclick",deleteC());
                    btn.className = "btn btn-warning btn-sm";

//                    var btnon = document.createElement("onclick");
  //                  btn.appendChild(btnon);
                    //btn.onclickName = "deleteC('1')";    
                        
                        comment.insertBefore(div, comment.firstChild);  //コメントdivに入っている一番最初の要素の手前にaaaを加える
                        var MC = document.createTextNode(m_comme);
                        // a.appendChild(Cname);
                        // a.appendChild(icon);
                        var Cname ='{{$myname}}';
                        var URL = "/user/{{$myname}}";
                        p.innerHTML = Cname.link(URL).bold(); //+ m_comme; //自分の名前を追加新しいフォーマットに直す
                        p.appendChild(icon);
                        p.appendChild(MC);
                        //p.insertAdjacentHTML = m_comme;
                        div.appendChild(p);
                        p.appendChild(btn);
                        
                       //btn.onclick = deleteC(id); 

                    //投稿したコメントをテキストボックスから消す
                    var mc  = document.getElementById("movie_comment");
                    mc.value = "";
                }
                
            };
             
        })
        
        
        //          <div>
        //              <p id="{{ @$cu -> id}}" class="userComment">                    
        //                 <a href="/user/{{ $cu -> name}}" class="link">
        //                     <b>{{ $cu -> name}}</b>
        //                 </a>
        //                 <i class="far fa-comments"></i> {{ $cu -> movie_comment}}
        //                 @if($cu->user_id == $myData ->id )
        //                 <input type="button" name="clear" value="削除筋" class="btn btn-warning btn-sm" onclick="deleteC('{{ $cu -> id}}');" >
        //                 @endif
        //             </p>
                   
        //         </div>
        
    //ユーザーコメントを削除する機能
  

//     //userからのコメントがあるとき
    
//   window.addEventListener('load', function(){  
        
//         var clearElement = document.getElementsByName("clear");  
//         clearElement.onclick = function (){
                
//                 //alert('その削除、筋肉量を2g失うが大丈夫でしょうか？');
//                 var deleteConfirm = confirm('その削除、筋肉量を2g失うが大丈夫でしょうか？');
                
//                 if(deleteConfirm == true){
                      
//                     var clearElement = document.getElementsByName("clear"); 
//                   　var c_id = clearElement.getAttribute('id'); //コメントしたユーザーIDの紐づいた削除ボタンのNameを取ってくる
                    
                    
                  

                    
                    //var c_id = document.getElementsByName("userID"); 

//247-263を97行目にぶち込む。moviecommnetのidは既にあるからidを使うだけ
          
                   
                    
                    //var clear_id = document.getElementById("comment_clear");
                    //var p_id = document.getElementById("@{{$cu -> id}}");
                    //　var c_id2 = clearElement2.getAttribute("id"); //コメントしたユーザーIDの紐づいた削除ボタンの紐づいた「comment,name,button」のNameを取ってくる
                    
                    //clear_id.removeChild(p_id);
                    
                //     //削除したコメントを非表示にする
                //     var clearElement2 = document.getElementById("comment_clear"); 
                //   　var c_id2 = clearElement2.getAttribute('name'); //コメントしたユーザーIDの紐づいた削除ボタンの紐づいた「comment,name,button」のNameを取ってくる
                    
                //     clearElement2.removeChild(c_id2);


                // }else{
                    
                //     //error処理を書く
                // }
        

        // };
    // })


    // }
    
    
        

  
   // test用
    // window.addEventListener('load', function(){ 
    // var aaa = document.getElementById("button");
    
    // aaa.onclick = function (){
        
    // var bbb = document.getElementById("test");  // div ->id
    // var c = document.getElementById("ppp"); //p ->id
    // //var t2 = c.getAttribute("name");//p ->name
    
    //   bbb.removeChild(c);
      
    // };
    // })





        
            
</script>








