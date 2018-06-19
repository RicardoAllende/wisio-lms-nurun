@section('title')
Olvidó su contraseña
@stop
@extends('users_pages.master')
@section('breadcrumbs')
  <a href="{{ route('student.home', 'invitado') }}" class="breadcrumb">Inicio</a>
  <a class="breadcrumb">Recuperar Contraseña</a>
@stop

@section('body')

<div class="row pad-left3">
  <div class="col s6 l9">
     <hr class="line"/>
  </div>
  <div class="col s6 l3">
     <h2 class="recientes">Recuperar contraseña</h2>
  </div>
</div>
<div class="row pad-left3">
  <div class="reg col s12 l5 offset-l2">
  <p>A continuación, para recuperar su contraseña, necesitamos que nos proporcione su correo electrónico;
    si lo encontramos en la base de datos, posteriormente,
    recibirá un correo electrónico con un enlace para restablecer su contraseña:</p>
</div>
<form method="post" action="{{ route('send.reset.password.link') }}" class="form-horizontal">
  	<!-- CSRF Token -->
  	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

  	<!-- Email -->
  	<div class="reg col s12 l5 offset-l2">
  		<label class="control-label" for="email">Email</label>
  		<div class="controls">
  			<input type="text" name="email" id="email" value="" />
  		</div>
  	</div>

  	<!-- Form actions -->
  	<div class="reg col s12 l5 offset-l2">
  		<div class="controls">
  			<a class="btnAcademia" href="{{ route('login') }}">Cancelar</a>
  			<button type="submit" class="btnAcademia">Buscar</button>
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
