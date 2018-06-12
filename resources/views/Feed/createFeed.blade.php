@extends('layouts.app')

@section('content')
<div class="container">
	<div class="container">
		<form action="{{ url('/save-feed') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
			<h1>Crear Notica</h1>
			{{ csrf_field() }}

			@if($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{$error}}</li>
						@endforeach
					</ul>
				</div>
			@endif
<fieldset>
<!-- Form Name -->
<legend></legend>
		<div class="form-group">
		  <label class="col-md-3 control-label" for="title">Nombre </label>  
		  <div class="col-md-8 has-error">
		  <input id="title" name="title" type="text" placeholder="Escriba aqui" class="form-control input-md">
		    </div>
		  </div>
		  <div class="form-group">
		  <label class="col-md-3 control-label" for="body">Descripcion </label>  
		  <div class="col-md-8">
		  <input id="body" name="body" type="text" placeholder="Escriba aqui" class="form-control input-md" >
		    </div>
		  </div>
		  <div class="form-group">
		  <label class="col-md-3 control-label" for="source">Fuente</label>  
		  <div class="col-md-8">
		  <input id="source" name="source" type="text" placeholder="Escriba aqui" class="form-control input-md" >
		    
		  </div>
		</div>
		 <div class="form-group">
		  <label class="col-md-3 control-label" for="publisher">Editor</label>  
		  <div class="col-md-8">
		  <input id="publisher" name="publisher" type="text" placeholder="Escriba aqui" class="form-control input-md" >
		    
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-3 control-label" for="imagen">Imagen</label>  
		  <div class="col-md-8">
		  <input id="image" name="image" type="file" placeholder="" class="form-control input-md">
		    
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
