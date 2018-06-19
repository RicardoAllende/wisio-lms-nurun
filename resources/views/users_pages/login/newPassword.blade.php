@section('title')
Nueva contraseña
@stop
@extends('users_pages.master')
@section('breadcrumbs')
  <a href="{{ route('student.home', 'invitado') }}" class="breadcrumb">Inicio</a>
  <a class="breadcrumb">Nueva Contraseña</a>
@stop

@section('body')

<div class="row pad-left3">
  <div class="col s6 l9">
     <hr class="line"/>
  </div>
  <div class="col s6 l3">
     <h2 class="recientes">Nueva contraseña</h2>
  </div>
</div>
<div class="row pad-left3">
  <div class="reg col s12 l5 offset-l2">
  <p>Ingrese la nueva contraseña para reestablecerla:</p>
</div>
	<form method="post" action="{{ route('request.set.new.password') }}" class="form-horizontal">
  	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

  	<div class="reg col s12 l5 offset-l2">
      <div class="control-group">
		<label class="control-label" for="password">Contraseña nueva</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			<input type="hidden" name="email" value="{{ $user->email }}">
		</div>
	</div>

	<!-- Confirm New Password  -->
	<div class="control-group">
		<label class="control-label" for="password_confirm">Confirme la nueva contraseña</label>
		<div class="controls">
			<input type="password" name="password_confirm" id="password_confirm" value="" />

		</div>
	</div>



	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btnAcademia">Actualizar Contraseña</button>
		</div>
	</div>
  	</div>
  </form>

</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

@stop
