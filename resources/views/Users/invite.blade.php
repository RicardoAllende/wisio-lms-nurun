@extends('layouts.app')

@section('title', "Crear enlace de invitación")

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('users.index') }}">Usuarios</a>
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
        @if(isset($route))
            <h5>Comparta el link con el médico para que realice su incripción</h5>
        @else
            <h5>Ingrese su código y la Adscripción a la cual irá dirigida la invitación</h5>
        @endif
        </div>
        <div class="ibox-content">
          <div class="row">
            @if( ! isset($route))
                {!! Form::open(['route' => 'request.invite.form','class'=>'form-horizontal','method' => 'post']) !!}
                <div class="form-group">
                {!! Form::label('code', 'Código del representante de ventas:',['class'=>'control-label col-sm-2']); !!}
                <div class="col-sm-10">
                    {!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Código del representante de ventas']) !!}
                </div>
                </div>

                <div class="form-group">
                {!! Form::label('ascription_id', 'Adscripción o farmacia a la que pertenece:',['class'=>'control-label col-sm-2']); !!}
                <div class="col-sm-10">
                <select name="ascription_slug" id="ascription_slug" class="form-control" required>
                    <option value="">Seleccionar</option>
                    @foreach($ascriptions as $ascription)
                    <option value="{{$ascription->slug}}">{{ $ascription->name }}</option>
                    @endforeach
                </select>
                </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{route('admin.dashboard')}}" class="btn btn-default">Cancelar</a>
                        {!! Form::submit('Crear',['class'=>'btn btn-primary btn-round']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @else
                <h2>Debe enviar el enlace al médico: <a href="{{ $route }}">{{ $route }}</a></h2>
            @endif

          </div>
        </div>
        <div class="ibox-footer">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection