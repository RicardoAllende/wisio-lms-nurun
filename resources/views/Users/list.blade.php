@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
      @if(isset($ascription))
        <li>
          <a href="{{ route('ascriptions.show', $ascription->id) }}">Adscripción: {{ $ascription->name}}</a>
        </li>
      @endif
        <li>
          Usuarios
        </li>
    </ol>
@endsection

@section('content')
<?php set_time_limit(0); ?>
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Usuarios @isset($ascription) inscritos en {{$ascription->name}} @endif </h5><br>
                    </div>
                    <div class="ibox-content">
                      <br>
                        @if($users->count() > 0)
                          <center id="loading"><img src="/css/loading.gif"alt=""></center>
                          <div class="table-responsive" id="userList" style="display:none;">
                            <table class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>#</th> @php $i = 1; @endphp
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Activo</th>
                                <th>Adscripción</th><!-- De momento considerando una adscripción por usuario, pero en bd se permiten varias-->
                                <th>Fecha de inscripción</th>
                                <th>Cédula profesional</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                  <tr>
                                  <td>{{$i}}</td>@php $i++; @endphp
                                  <td><a href="{{ route('users.show' , $user->id) }}">{{$user->email}}</a></td>
                                  <td>{{ $user->firstname }}</td>
                                  <td>{{ $user->lastname }}</td>
                                  <td>{{ ($user->enabled == 1) ? 'Activo' : 'Inactivo' }}</td>
                                  <td>@if($user->hasAscriptions()){{ $user->ascriptions->first()->name }}
                                    @else <a href="{{route('users.edit', $user->id)}}" > Asignar a alguna adscripción </a> @endif
                                  </td>
                                  <td>{{ $user->created_at }}</td>
                                  <td>{{ $user->cedula }}</td>
                                  <td>
                                    @if($user->hasAdvance())
                                      @if($user->enabled == 1 )
                                        <a href="{{ route('disable.user', $user->id) }}" class="btn btn-danger btn-round" >Deshabilitar</a>
                                      @else
                                        <a href="{{ route('enable.user', $user->id) }}" class="btn btn-info btn-round" >Habilitar</a>
                                      @endif
                                    @else
                                      {!! Form::open(['method'=>'DELETE','route'=>['users.destroy',$user->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                        <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                      {!! Form::close() !!}
                                    @endif
                                  </td>
                                  </tr>
                                @endforeach
                              
                            </tbody>
                          </table>
                        </div>
                      @else
                        <h3>Sin usuarios</h3>
                      @endif
                      
                      
                    </div>
                    <div class="ibox-footer">
                       {{ $users->links() }}
                    </div>
                </div>
              </div>
      </div>
</div>
@endsection

@section('scripts')
  <script src="/js/sweetalert2.min.js"></script>
  <script src="/js/method_delete_f.js"></script>
  <script>
  $( document ).ready(function() {
    $('#userList').show();
    $('#loading').hide();
  });
  </script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
