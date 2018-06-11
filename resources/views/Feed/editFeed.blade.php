
@extends('layouts.app')

@section('content')
<div class="container">
    
	<div class="container">
		<form action="{{ url('/update-feed', ['feed_id' => $feed->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
			<h1>Editar Notica</h1>
			{{ csrf_field() }}
<fieldset>
<!-- Form Name -->
<legend></legend>
		<div class="form-group">
		  <label class="col-md-3 control-label" for="title">Nombre </label>  
		  <div class="col-md-8">
		  <input id="title" name="title" type="text" placeholder="Escriba aqui" class="form-control input-md" value=" {{$feed->title}}"required="">
		   </div>
		  </div>
		  <div class="form-group">
		  <label class="col-md-3 control-label" for="body">Descripcion </label>  
		  <div class="col-md-8">
		  <input id="body" name="body" type="text" placeholder="Escriba aqui" class="form-control input-md" value="{{$feed->body}}" required="">
		    </div>
		  </div>
		  <div class="form-group">
		  <label class="col-md-3 control-label" for="source">Fuente</label>  
		  <div class="col-md-8">
		  <input id="source" name="source" type="text" placeholder="Escriba aqui" class="form-control input-md" value="{{$feed->source}}" required="">
		    
		  </div>
		</div>
		 <div class="form-group">
		  <label class="col-md-3 control-label" for="publisher">Editor</label>  
		  <div class="col-md-8">
		  <input id="publisher" name="publisher" type="text" placeholder="Escriba aqui" class="form-control input-md" value="{{$feed->publisher}}" required="">
		    
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-3 control-label" for="image">Imagen</label>  
		  <div class="col-md-8">

 					<?php $valor =  strpos ( $feed->image , "ep01") ?>
 					<?php $valor1 =  strpos ( $feed->image , "static") ?>

 					@if($valor || $valor1)
 						<img width="200px;" src="{{$feed->image}}">	 


 					@else
						<img width="200px;" src="../../storage/app/images/{{$feed->image}}" >
	 					@endif
		  	 	

		  <input id="image" name="image" type="file" value="{{$feed->image}}" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>
		
	<div class="form-group">
	  <label class="col-md-4 control-label" for="enviar"></label>
	  <div class="col-md-4">
	    <button type="submit" id="enviar" name="enviar" class="btn btn-success">Guardar</button>
	  </div>
	</div>

	</fieldset>
	</form>
</div>
</div>
@endsection