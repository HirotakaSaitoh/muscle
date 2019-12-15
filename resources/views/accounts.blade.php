@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row">
      <div class="col-sm-12">
               
        <div class="row">
            @if($query2->user_image == null)
                <img src="/upload/image/noimage.png"  class="mx-auto d-block">
                <!--class="img-thumbnail w-25"-->
            @else
                <img src="/upload/image/{{$query2->user_image}}"class="mx-auto d-block">
            @endif    
            
            <div class="col-sm-2">{{'名前：' . $query2->name }}</div>
            <div class="col-sm-2">
                @if ($myData->id === $query2->id)
                    <a href="{{ url('management') }}" class="btn btn-info px-1 py-1" style="float">プロフィール編集</a>
                    <br>
                @else 
                    <p></p>
                @endif
            </div>
        </div>    
        <div class="row-sm-12">
            <div >{{'自己紹介：' .$query2->introduce }}</div>
            <br>
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



