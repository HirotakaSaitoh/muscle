<!-- resources/views/uploads.blade.php -->
<link rel="stylesheet" href="{{ asset('css/upload.css') }}"> 
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
<div class="container">
    <!--<div class="card-body">-->
        <div class="card-title">
            孤高の筋肉をUPしたまえ<br>
            　
        </div>
        
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <!-- 本のタイトル -->
        <!--uploadではなくmovie画面に遷移する-->
        <form enctype="multipart/form-data" action="{{ url('upload2') }}" method="POST" class="form-horizontal">    
            {{ csrf_field() }}

            
            
            
            
            
            <div class="row">
                <div class="col-md-12">
                   <label></label>  
                   <input type="file" name="item_movie"> <br>
                    
                </div>
            </div>
            
            <div class="row">
            
               <div class="col-sm-12">   
                <label for="user_comment" class="col-sm-3">コメント(200文字以内)<br></label>
                <input type="text" name="user_comment" class="col-sm-8">
               </div>
            
               
            </div><br>
            　
            
            <div class="row">
                <div class=" col-sm-12">
                
                    <button type="submit" class="btn btn-info">
                    Upload 200kg
                    </button>
                </div>
            </div>
            
            
            
            
        </form>
    </div>

</div>
    
    
@endsection