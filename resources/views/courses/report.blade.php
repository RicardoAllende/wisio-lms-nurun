@extends('layouts.app')

@section('title', 'Reporte de '.$course->name)
@section('cta')
  <a href="{{route('courses.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li><a href="{{ route('list.courses.report') }}">Reportes</a></li>
        <li>Curso: {{ $course->name }}</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Médicos inscritos</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                            <tr>
                                <th>#</th> @php $i = 1; @endphp
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Activo</th>
                                <th>Calificación</th>
                                <th>Fecha de inscripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($users as $user)
                                <tr>
                                  <td>{{$i}}</td>@php $i++; @endphp
                                  <td><a href="{{ route('users.show' , $user->id) }}">{{$user->email}}</a></td>
                                  <td>{{ $user->firstname }}</td>
                                  <td>{{ $user->lastname }}</td>
                                  <td>{{ ($user->enabled == 1) ? 'Activo' : 'Inactivo' }}</td>
                                  <td> {{ $user->scoreInCourse($course->id) }} </td>
                                  <td>{{ $user->pivot->created_at }}</td>
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
                      
                    </div>
                    <div class="ibox-footer">
                      
                    </div>
                </div>
              </div>
      </div>
</div>
@endsection