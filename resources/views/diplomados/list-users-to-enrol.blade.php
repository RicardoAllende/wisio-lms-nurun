@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('list.diplomados') }}">Diplomados</a>
        </li>
        <li>
          {{ $ascription->name }}
        </li>
        <li>
          Administrar usuarios
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Listado de médicos, inscripción a {{ $ascription->name }}</h5><br>
                    </div>
                    <div class="ibox-content">
                      <br>
                        @if($users->count() > 0)
                          <center id="loading"><img src="/css/loading.gif"alt=""></center>
                          <div class="table-responsive" id="userList" style="display:none;">
                            <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                              <tr>
                                <th>#</th> @php $i = 1; @endphp
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cédula profesional</th>
                                <th>Activo</th>
                                <th>Adscripción</th>
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
                                  <td>{{ $user->cedula }}</td>
                                  <td>{{ ($user->enabled == 1) ? 'Activo' : 'Inactivo' }}</td>
                                  <td>@if($user->hasAscriptions()){{ $user->ascriptions->first()->name }}
                                    @else <a href="{{route('users.edit', $user->id)}}" > Asignar a alguna adscripción </a> @endif
                                  </td>
                                  <td>
                                    @if($user->isEnrolledInDiplomado($ascription->id))
                                        <a href="{{ route('detach.user.to.diplomado', [$ascription->id, $user->id]) }}" class="btn btn-danger btn-round" >Quitar del diplomado</a>
                                    @else
                                        <a href="{{ route('attach.user.to.diplomado', [$ascription->id, $user->id]) }}" class="btn btn-success btn-round" >Inscribir al diplomado</a>
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
                       <!--$users->links()-->
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
