@extends('layouts.app')
@section('content')

<!--トップページに最新の動画を表示-->
<!--データベースの最新版だけ取り出したい-->



    <div class="container">

        <!--動画とユーザーコメントは左側カラム-->
        <div class="col-sm-6 col-md-8">
         
            <div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" src="/upload/m/{{ $uploads->item_movie }}.mp4" width="800px" controls autoplay muted></video></div>
        
            @foreach ($movieComment as $mc) 
            {{ $mc -> movie_comment}} <br>
            {{ $mc ->name }} <br>    <!-- //名前情報が入っていないから飛ばせない-->
            @endforeach
        </div>  
    

       
       <!--右側カラム-->
        <div class="col-sm-6 col-md-4">   
            <div><a href="{{ url('upload2') }}"><i class="fas fa-video"></i> 筋肉投稿</a></div>
            <a href="user/{{ $myData->name }}"><i class="fas fa-user-circle"></i> マイ筋肉</a>　<!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->
               
            
            
            <div><a href="/user/{{ $uploads->user_name }}">{{ $uploads->user_name }}</a></div>
            <div>{{ $uploads->user_comment }}</div> 
            <div>{{ $uploads->published }}</div>
            
            
            <form action="{{url('/movie/comment_store')}}" method="post">
                {{ csrf_field() }}  
                <div>コメント：<input type="text" name="movie_comment" maxlength="20"></div>
                <input type="submit"  value="君の掛け声が筋肉になるよ(コメント投稿)！！">
            
                
                <!-- id 値を送信 -->         
                <input type="hidden" name="id" value="{{$uploads->id}}" />         
                <!--/ id 値を送信 -->
            
            </form>
            
        
            
            
            @php
                $count = 0;
            @endphp
            
            @if(Auth::check())
                <form action="{{ url('/favorite') }}" method="POST">
                {{ csrf_field() }} 
                
                    
                    @foreach($judge as $j) 
                        @if($j->movie_id == $d->movie_id) 
                            @php 
                                $count = 1; 
                            @endphp 
                        @else 
                            @php 
                                $count = $count; 
                            @endphp 
                        @endif 
                    @endforeach 
                    
                    
                    
                    @if($count == 1)
                        <br>
                        <button class="btn btn-warning" name="" style="float: left;"><i class="far fa-thumbs-up"></i> よっ！夏の筋肉大三角形(取り消し)！！！
                    
                    
                        @else
                        <br>
                       
                        <button class="btn btn-success" style="float: left;"><i class="far fa-thumbs-up"></i> よっ！夏の筋肉大三角形(いいね)！！！  
                        
                    
                    @endif
                    <!-- id 値を送信 -->         
                    <input type="hidden" name="id" value="{{$uploads->id}}" />         
                    <!--/ id 値を送信 -->
                                
                </form>
            
            @endif
        </div>
    </div>



    
@endsection




<script>
    
//いいねとかコメントの非同期処理を書く
    
</script>