@extends('layouts.app')

@section('content')

@if(session('message'))
	<div class="alert alert-success">
		{{session('message')}}
	</div>
@endif
<div class="container">
	<br><br>
	<h1>Ultimas noticias <hr></h1>
	@foreach($feeds as $feed)
	<div class="col-md-offset-2 col-md-8">
		<div class="panel panel-primary">
	 		<div class="panel-heading">{{$feed->title}}
	 		   <div class="pull-right">{{$feed->publisher}}
	 		   </div>
	 		</div>
 			<div class="panel-body">
 				<div class="col-md-6"> 
 					<?php $valor =  strpos ( $feed->image , "static") ?>

 					@if($valor == false)
 					 	<img width="200px;" src="../storage/app/images/{{$feed->image}}" >
 					 @else()
 					 	<img width="200px;" src="{{$feed->image}}">
 					 	 						@endif


 					
 				</div>
 				<div class="col-md-6">
 					{{$feed->body}}
 				</div>
 			</div>
 				<div class="panel-footer">
 					<a href="{{route('deleteFeed', ['feed_id' => $feed->id])}}" class="btn btn-sm btn-danger pull-right">X</a>

					<a href="{{route('editFeed', ['feed_id' => $feed->id])}}" class="btn btn-sm btn-warning pull-right"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					<a href="{{$feed->source}}">{{$feed->source}}</a>  
					
					
 						
 				</div>
 			</div>
 		</div>
	
	 @endforeach
	 <div class="col-md-offset-1 col-md-10" >
				{{$feeds->links()}}
			</div>
</div>
	 

@endsection
