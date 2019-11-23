@extends('layouts.app')
@section('content')

@foreach ($uploads as $upload)  
<div>{{ $upload->id }}</div>    
<div>{{ $upload->user_id }}</div> 
<div>{{ $upload->movie_url }}</div> 
<div>{{ $upload->user_comment }}</div> 
<div>{{ $upload->published }}</div>
@endforeach 
   
   
   
@endsection