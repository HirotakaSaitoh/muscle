@extends('layouts.app')
@section('content')

<!--個別の動画を表示するview-->
   

<div><a href="{{ url('upload2') }}">投稿</href></div>
<a href="../user/{{ $myData->name }}">マイアカウント</a>　<!--＊＊＊＊＊ログイン時はマイアカウントへのリンクボタン、非ログイン時は登録ボタン＊＊＊＊＊＊＊＊-->
   

@foreach($m_name as $mn)
   
<div><video src="/upload/m/{{ $mn->item_movie }}.mp4" width="800" controls autoplay muted></video></div>
<!--publicはviewのデータはデフォルトでここに置いてある-->
<div>{{ $mn->user_comment }}</div> 
<div>{{ $mn->published }}</div>
<div>{{ $mn->user_name }}</div>

<!--いいねボタンをここにつくる-->

@endforeach
    
@endsection


<script type="text/javascript" src="">
    
    // いいねボタンのスクリプト
    
</script>