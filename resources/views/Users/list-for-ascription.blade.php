@extends('layouts.app')

@section('title','Usuarios inscritos en '.$ascription->name)
@section('cta')
<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('ascriptions.index') }}">Adscripciones</strong></a>
        </li>
        <li class="active">
            <a href="{{ route('ascriptions.show', $ascription->id) }}">Adscripción: {{ $ascription->name }} </strong></a>
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos los usuarios que pertenecen a la adscripción</h5>
                    </div>
                      <center id="loading"><img src="/css/loading.gif"alt=""></center>
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>@php $i = 1; @endphp
                            <th>Correo electrónico</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Activo</th>
                            <th>Pertenece a</th><!-- De momento considerando una adscripción por usuario, pero en bd se permiten varias-->
                            <th>Fecha de inscripción</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                              <tr>
                              <td>{{$i}}</td>@php $i++; @endphp
                              <td><a href="{{ action('UsersController@show' , $user->id) }}">{{$user->email}}</a></td>
                              <td>{{ $user->firstname }}</td>
                              <td>{{ $user->lastname }}</td>
                              <td>{{ ($user->enable == 1) ? 'Activo' : 'Inactivo' }}</td>
                              <td>@if($user->ascriptions->count() > 0){{ $user->ascription()->name }}@else Sin adscripción @endif</td>
                              <td>{{ $user->created_at }}</td>
                              <!--<td>
                                @if($user->belongsToAscription($ascription->id))
                                  <a href="{{ route('dissociate.user.for.ascription', [$user->id, $ascription->id]) }}" class="btn btn-danger">Quitar</a>
                                @else
                                  <a href="{{ route('enroll.user.to.ascription', [$user->id, $ascription->id]) }}" class="btn btn-info">Agregar</a>
                                @endif
                              </td>-->
                              </tr>
                            @endforeach
                          
                        </tbody>
                      </table>
                      </div>
                      
                    </div>
                    <div class="ibox-footer">
                      <!--{ $users->links()-->
                    </div>
                </div>
              </div>
      </div>
</div>

                        


@endsection

@section('scripts')
<script>
  $('#btnSearch').click(function(e){
    var search = $('#search').val();
    if(search != ''){
      var type = $('input:radio[name=optionsRadios]:checked').val();
      var redirectTo = "";
      if( type == 'email'){
        redirectTo = email.replace("input", search);
      }else{
        redirectTo = name.replace("input", search);
      }
      window.location.href = redirectTo;
    }
  });
  $('.optionsRadio').click(function (){
    var type = $(this).val();
    if( type == 'email'){
      $('#search').attr('placeholder', 'Buscar por email');
    }else{
      $('#search').attr('placeholder', 'Buscar por nombre');
    }
  });
</script>
<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
