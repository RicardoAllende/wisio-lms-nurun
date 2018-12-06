@extends('layouts.app')

@section('title','Notificaciones del usuario')
@section('cta')
<div style="display=inline;">
  <a href="{{route('disable.user', $user->id)}}" class="btn btn-danger btn-round"></i>Desactivar usuario</a>
</div>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('notifications.list.users') }}">Notificaciones</a>
        </li>
        <li>
          <a href="{{ route('users.show', $user->id) }}">{{$user->full_name}}</a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        Notificaciones enviadas al correo: <a href="mailto:{{$user->email}}">{{ $user->email }}</a> 
                        @if($user->hasACallNotification())
                        Usuario en lista de personas por llamar, número: <a href="tel:{{$user->mobile_phone}}">{{ $user->mobile_phone }}</a>
                        @endif
                    </div>
                    <div class="ibox-content">
                      <br>
                          <div class="table-responsive" id="userList">
                            <table class="table table-striped table-bordered table-hover dataTables">
                            <thead>
                              <tr>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Visto</th>
                                <th>¿Accedió siguiendo el enlace?</th>
                                <th>Curso</th>
                                <th>Enviado el</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->code }}</td>
                                    <td>{{ $notification->type }}</td>
                                    <td>{{ ( $notification->viewed ) ? "Sí" : 'No' }}</td>
                                    <td>{{ ($notification->accessed) ? "Sí" : 'No' }}</td>
                                    <td>{{ $notification->course->name }}</td>
                                    <td>{{ $notification->created_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="ibox-footer"></div>
                </div>
              </div>
      </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
