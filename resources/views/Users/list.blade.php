@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos los usuarios que se encuentran en el sistema</h5><br>
                    </div>
                    <div class="ibox-content">
                      <div class="input-group">
                          <input type="text" class="form-control" name="search" id="search" placeholder="Buscar por email">
                          <span class="input-group-btn"><button id="btnSearch" type="button" class="btn btn-primary">Buscar</button></span>
                      </div>
                      <div class="text-right">
                      Buscar por: 
                          <label> <input type="radio" checked value="email" id="optionsRadios1" class="optionsRadio" name="optionsRadios"> Email </label>
                          <label> <input type="radio" value="name" id="optionsRadios1" class="optionsRadio" name="optionsRadios"> Nombre </label>&nbsp;
                      </div>
                      <br>
                      
                        <div class="table-responsive">
                          <!--<table class="table table-striped table-bordered table-hover dataTables">-->
                          <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Correo electrónico</th>
                              <th>Nombre</th>
                              <th>Apellidos</th>
                              <th>Activo</th>
                              <th>Adscripción</th><!-- De momento considerando una adscripción por usuario, pero en bd se permiten varias-->
                              <th>Fecha de inscripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($users as $user)
                                <tr>
                                <td><a href="{{ action('UsersController@show' , $user->id) }}">{{$user->email}}</a></td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ ($user->enable == 1) ? 'Activo' : 'Inactivo' }}</td>
                                <td>@if($user->hasAscriptions()){{ $user->ascriptions->first()->name }}
                                  @else <a href="{{route('users.edit', $user->id)}}" > Asignar a alguna adscripción </a> @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['users.destroy',$user->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                      <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
                                    {!! Form::close() !!}
                                </td>
                                </tr>
                              @endforeach
                            
                          </tbody>
                        </table>
                      </div>
                      
                      
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
    var email = "{{route('search.users.by.email', '')}}";
    var name = "{{route('search.users.by.name', '')}}";
    $('#btnSearch').click(function(e){
      var search = $('#search').val();
      if(search != ''){
        var type = $('input:radio[name=optionsRadios]:checked').val();
        var redirectTo = "";
        if( type == 'email'){
          redirectTo = email + "/" + search;
        }else{
          redirectTo = name + "/" + search;
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
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
