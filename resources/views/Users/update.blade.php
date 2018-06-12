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
  {!! Form::open(['route' => ['student.update.request'], 'class'=>'form-horizontal col s12','method' => 'post']) !!}
  <div class="row">
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('email', 'Correo electrónico:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::email('email', $user->email ,['class'=>'form-control','placeholder'=>'Correo electrónico', 'id'=> 'email', 'required' => '', 'readonly' => '']) !!}

    </div>
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('gender', 'Género:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::select('gender', ['' => 'Seleccionar género', 'F' => 'Femenino', 'M' => 'Masculino'], null, ['class' => '', 'required' => '']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('specialty_id', 'Especialidad:',['class'=>'']); !!}
      <select name="specialty_id" id="specialty_id" required class="">
        @inject('specialtiesController','App\Http\Controllers\AdminControllers\SpecialtiesController')
        @foreach($specialtiesController->getAllSpecialties() as $specialty)
          <option value="{{$specialty->id}}"> {{$specialty->name}} </option>
        @endforeach
      </select>
    </div>
    <div class="reg col s12 l6 offset-l3">
        {!! Form::label('consultation_type', 'Tipo de consulta:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::select('consultation_type', ['' => 'Tipo de consulta', 'Pública' => 'Pública', 'Privada' => 'Privada', 'Ambas' => 'Ambas'], null, ['class' => '', 'required' => '']) !!}

    </div>
    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('mobile_phone', 'Teléfono celular:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::number('mobile_phone',null,['class'=>'form-control','placeholder'=>'Teléfono celular', 'required' => '']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('state_id', 'Estado:',['class'=>'']); !!}
      @inject('states','App\Http\Controllers\Users_Pages\UserController')
      <select name="state_id" id="state_id" required class="">
        @foreach($states->getAllStates() as $state)
          <option value="{{$state->id}}"> {{$state->name}} </option>
        @endforeach
      </select>
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('postal_code', 'Código postal:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::number('postal_code',null,['class'=>'form-control','placeholder'=>'Código Postal', 'required' => '']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('city', 'Ciudad:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('city',null,['class'=>'form-control','placeholder'=>'Ciudad', 'required' => '']) !!}
    </div>

    <div class="reg col s12 l6 offset-l3">
      {!! Form::label('address', 'Dirección:',['class'=>'control-label col-sm-2']); !!}
      {!! Form::text('address',null,['class'=>'form-control','placeholder'=>'Dirección completa', 'required' => '']) !!}
    </div>

  </div>
  <input type="submit" id="validate" class="btnAcademia" value="Actualizar información" >
  {!! Form::close() !!}
</div>
@endsection

@section('extrajs')
  <script>
    $('select').material_select();
  </script>
@endsection
