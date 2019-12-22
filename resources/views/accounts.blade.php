@extends('layouts.app')
@section('content')

<!--CSSファイルの埋め込み-->
<link rel="stylesheet" href="{{ asset('css/style.css') }}"> 

<div class="container">
  <div class="row">
      <div class="col-sm-12">
               
        <div class="row">
            <div class="col-sm-4">
                @if($query2->user_image == null)
                    <img src="/upload/image/noimage.png"  class="img-fluid">
                    <!--class="img-thumbnail w-25"-->
                @else
                    <img src="/upload/image/{{$query2->user_image}}"class="img-fluid">
                @endif    
            </div>
            <div class="col-sm-8">
                <div class="row">
                    {{'名前：' . $query2->name }}  
                    @if ($myData->id === $query2->id)
                        <a href="{{ url('management') }}" class="btn btn-info px-1 py-1" style="float">プロフィール編集</a>
                        <br>
                    @else 
                        <p></p>
                    @endif
                    
                </div>
                <div class="row">
                    <div >{{'自己紹介：' .$query2->introduce }}</div>
                    <br>
                </div>   
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



