@extends('layouts.app')

@section('content')
<div class="jumbotron">
  <h1 class="text-center ">Binvenido</h1>
</div>
@if(session('message'))
	<div class="alert alert-success">
		{{session('message')}}
	</div>
@endif
<div class="container">
	@foreach($feeds as $feed)
	<div class="col-md-offset-2 col-md-8">
		<div class="panel panel-primary">
	 		<div class="panel-heading">{{$feed->title}}
	 		   <div class="pull-right">{{$feed->publisher}}
	 		   </div>
	 		</div>
 			<div class="panel-body">
 				<div class="col-md-6">
 					<img width="200px;" src="../storage/app/images/{{$feed->image}}" >
 				</div>
 				<div class="col-md-6">
 					{{$feed->body}}
 				</div>
 			</div>
 				<div class="panel-footer">
					{{$feed->source}}  
					<a href="{{route('deleteFeed', ['feed_id' => $feed->id])}}" class="btn btn-sm btn-danger pull-right">X</a>

					<a href="{{route('editFeed', ['feed_id' => $feed->id])}}" class="btn btn-sm btn-warning pull-right"> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					
 						
 				</div>
 			</div>
 		</div>
	
	 @endforeach
	 <div class="col-md-offset-1 col-md-10" >
				{{$feeds->links()}}
			</div>
</div>
	 

@endsection
