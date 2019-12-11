<!--アカウント情報の管理ページ-->
@extends('layouts.app')
@section('content')

<!--左側カラムのタブ-->
<p>まだ未完成。PWの暗号化を戻したり暗号化したりの処理が不明、現在のPWと入力されたPWの一致を確認して新しいPWに変更したい。</p>

<ul>
    <li><a href="{{ url('management')}}">プロフィールを編集</a></li>
    
    <li>パスワードを変更</li>
</ul>


<!--右側カラム：変更内容-->
<form action="{{ url('management/PW_update')}}" method="POST">   
    {{ csrf_field() }}   
    
    <label for='now_password'>現在のパスワード</label>
    <input type="text" name="now_password" ><br>
    
    <label for='new_password1'>新しいパスワード</label>
    <input type="text" name="new_password1" ><br>
    
    <label for='new_password2'>新しいパスワード（確認用）</label>
    <input type="text" name="new_password2" ><br>

    <!-- id 値を送信 -->         
    <input type="hidden" name="id" value="{{$myData->id}}" />         
    <!--/ id 値を送信 -->


    
    
    <button type="submit" class="">   
    パスワードを変更        
    </button>   
</form>


    
@endsection