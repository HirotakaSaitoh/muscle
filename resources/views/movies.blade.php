@extends('layouts.app')
@section('content')

<!--個別の動画を表示するview-->


<div class="container">
    
            <!--動画とユーザーコメントは左側カラム-->
        <div class="col-sm-6 col-md-8">
                @foreach($m_name as $mn)
       
                <div><video src="/upload/m/{{ $mn->item_movie }}.mp4" width="700" controls autoplay muted></video></div>
                <!--publicはviewのデータはデフォルトでここに置いてある-->
                <div>{{ $mn->user_comment }}</div> 
                <div>{{ $mn->published }}</div>
                <div>{{ $mn->user_name }}</div>
    
                <!--いいねボタンをここにつくる-->
                
                @endforeach

        </div>  
        
        
        <div class="col-sm-6 col-md-4">
            
             <div><a href="{{ url('upload2') }}"><i class="fas fa-video"></i>筋肉投稿</href></div>
             <a href="../user/{{ $myData->name }}"><i class="fas fa-user-circle"></i>マイ筋肉</a>　<!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->
        
        </div>
   
</div>




    
@endsection


<script type="text/javascript" src="">
    
    // いいねボタンのスクリプト
    
</script>