@extends('layouts.app')
@section('content')

<!--CSSファイルの埋め込み-->
<link rel="stylesheet" href="{{ asset('css/account_style.css') }}"> 

<div class="container">
  <div class="row">
    
        <div class="row d-flex justify-content-center">
            
                <div class="col-sm-4 col-xs-12">
                    @if($query2->user_image == null)
                        <img src="/upload/image/noimage.png"  class="img_icon">
                    @else
                        <img src="/upload/image/{{$query2->user_image}}" class="img_icon">
                    @endif    
                </div>
                <div class="col-sm-8  col-xs-12">
                    <div >
                        {{'名前：' . $query2->name }}  
                        @if ($myData->id === $query2->id)
                            <a href="{{ url('management') }}" class="btn btn-info px-1 py-1" style="float">プロフィール編集</a>
                            <br>
                        @else 
                            <p></p>
                        @endif
                        
                    </div>
                    <div>
                        <br>
                        {{'自己紹介：' .$query2->introduce }}
                        <br>
                    </div>   
                </div>
            
        </div>    
 
    </div>  
      
    
  　<div class="row"> 
      
        @foreach($query as $que)
            <div class="col-sm-4">
                <div>
                    <a href="/m/{{ $que->item_movie }}">
                        <video src="/upload/m/{{ $que->item_movie }}.mp4" width="100%" controls autoplay muted></video>
                    </a>
                </div>
                <div>{{ $que->user_comment }}</div> 
                </br>
            </div>
        @endforeach
       
  </div>
</div>

         
                

        
        
            
    

       
   
@endsection



