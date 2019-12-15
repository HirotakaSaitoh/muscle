<!--アカウント情報の管理ページ-->
@extends('layouts.app')
@section('content')
<div class="container">
    
    <!-- バリデーションエラーの表示に使用-->
    @include('common.errors')

    
        <!--左側カラムのタブ-->
    <div class="col-sm-3 col-md-4">
        <ul>
            <li>プロフィールを編集</li>
            
            <li><a href="{{ url('management/pw')}}">パスワードを変更</a></li>
        </ul>
    </div>
    
        <!--右側カラム：変更内容-->
    <div class="col-sm-9 col-md-8">
        
        <form enctype="multipart/form-data" action="{{ url('management/user_update') }}" method="POST" >    
            {{ csrf_field() }}
        
            @if($mane->user_image == null)
                <img src="/upload/image/noimage.png" class="img-thumbnail w-25"  >
            @else
                <img src="/upload/image/{{$mane->user_image}}" >
            @endif
            <br>
            <input type="file" name="user_image" > 
             
            <label for='name'>名前</label>
            <input type="text" name="name" value="{{$mane->name}}"><br>
            
            <label for='introduce'>自己紹介</label>
            <input type="text" name="introduce" value="{{$mane->introduce}}"><br>
            
            <label for='email'>メールアドレス </label>
            <input type="text" name="email" value="{{$mane->email}}"><br>
            
            <label>性別</label><br>
        
            <!-- id 値を送信 -->         
            <input type="hidden" name="id" value="{{$mane->id}}" />         
            <!--/ id 値を送信 -->
        
        
            <button type="submit" class="btn btn-info">
                    Save
            </button>
            

    </div>
</div>
    
@endsection

<script>

    
</script>