<!-- resources/views/uploads.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            動画をアップロードしなさい！
        </div>
        
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <!-- 本のタイトル -->
        <!--uploadではなくmovie画面に遷移する-->
        <form enctype="multipart/form-data" action="{{ url('upload') }}" method="POST" class="form-horizontal">    
            {{ csrf_field() }}

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="user_comment" class="col-sm-3 control-label">コメント</label>
                    <input type="text" name="user_comment" class="form-control">
                </div>
                
                  <div class="form-group col-md-6">
                    <label for="published" class="col-sm-3 control-label">公開日</label>
                    <input type="date" name="published" class="form-control">
                </div>    
                
                    <!--動画を追加-->
               <div class="col-sm-6">    
                   <label>動画</label>  
                   <input type="file" name="item_movie"> 
               </div> 
               
            </div>
            
            <!-- 本 登録ボタン -->
            <div class="form-row">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                    Save
                    </button>
                </div>
            </div>
        </form>
    </div>

    
    
@endsection