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
                            <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                              <tr>
                                <th>#</th> @php $i = 1; @endphp
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Activo</th>
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
                                  <td>
                                    @if($user->hasAvailableCourse($course->id))
                                      @if( ! $user->isEnrolledInCourse($course->id) )
                                        <a href="" class="btn btn-info btn-round">Inscribir al curso</a>
                                      @endif
                                    @else

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
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection