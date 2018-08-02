@section('title')
Actualizacion de información
@stop

@extends('users_pages.master')

@section('body')
<div class="row pad-left3">
  <h2 class="recientes">Actualizacion de información</h2>
  <div class="col s6 l9">
     <hr class="line"/>
  </div>
  <div class="col s6 l3">
     <h2 class="recientes">Ingrese sus Datos</h2>
  </div>
</div>

<div class="row">
  {{ ($user->last_profile_update == '') ? 'Por favor, complete/actualice su información' : '' }}
  {!! Form::model($user, ['route' => ['student.update.request'], 'class'=>'form-horizontal col s12','method' => 'post']) !!}
  <div class="row">
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('email', 'Correo electrónico:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::label('email', $user->email ,['class'=>'form-control' ]) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('firstname', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('firstname',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '', 'pattern' => "[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50']) !!}
    </div>
    <div class="reg col s12 l6 offset-l3">
        {!! Form::label('lastname', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
        {!! Form::text('lastname',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '', 'pattern' => "[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50']) !!}
    </div>


    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('gender', 'Género:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::select('gender', ['1' => 'Masculino', '2' => 'Femenino'], $user->enum_gender , ['class' => '', 'required' => '']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('specialty_id', 'Especialidad:',['class'=>'']); !!}
      <select name="specialty_id" id="specialty_id" required class="">
        @inject('specialtiesController','App\Http\Controllers\AdminControllers\SpecialtiesController')
        @foreach($specialtiesController->getAllSpecialties() as $specialty)
          <option {{ ($user->specialty_id == $specialty->id) ? 'selected' : '' }} value="{{$specialty->id}}"> {{$specialty->name}} </option>
        @endforeach
      </select>
    </div>
    <div class="reg col s12 l6 offset-l3">
        {!! Form::label('consultation_type', 'Tipo de consulta:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::select('consultation_type', ['1' => 'Pública', '2' => 'Privada', '3' => 'Mixta'], $user->enum_consultation_type, ['class' => '', 'required' => '']) !!}

    </div>
    <div class="reg col s12 l6 offset-l3">
    {!! Form::label('mobile_phone', 'Teléfono -Exclusivo Celular-',['class'=>'control-label col-sm-2']); !!}
          {!! Form::text('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono -Exclusivo Celular-', 'required' => '', 'pattern' => "[0-9]{10}", 'title'=> "Únicamente números", 'maxlength' => '10']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('state_id', 'Estado:',['class'=>'']); !!}
      @inject('states','App\Http\Controllers\Users_Pages\UserController')
      <select name="state_id" id="state_id" required class="">
        @foreach($states->getAllStates() as $state)
          <option {{ ($user->state_id == $state->id) ? 'selected' : '' }} value="{{$state->id}}"> {{$state->name}} </option>
        @endforeach
      </select>
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('zip', 'Código postal:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('zip',null,['class'=>'form-control','placeholder'=>'54660 -Únicamente números-', 'required' => '', 'pattern' => "[0-9]{5}", 'title'=> "Únicamente números", 'maxlength' => '5']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('city', 'Ciudad:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('city',null,['class'=>'form-control','placeholder'=>'Ciudad', 'required' => '', 'pattern' => "[a-z0-9A-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}", 'title'=>"Únicamente letras", 'maxlength' => '50']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('address', 'Dirección:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('address',null,['class'=>'form-control','placeholder'=>'Dirección completa']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
      <input type="password" name="password" id="password" class="form-control" placeholder="Escriba aquí su contraseña, si no desea cambiarla, deje este campo vacío">
    </div>

    <div class="reg col s12 l8 offset-l3">
      <input type="submit" id="validate" class="btnAcademia" value="Actualizar información" >
    </div>
  </div>
  {!! Form::close() !!}
</div>
@endsection

@section('extrajs')
  <script>
    $('select').material_select();
  </script>
@endsection
