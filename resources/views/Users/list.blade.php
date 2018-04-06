@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
  <a href="/users/create" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>A continuación aparecen todos los cursos que se encuentran en el sistema</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha de inscripción</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                              <tr>
                              <td><a href="/users/{{ $user->id }}/">{{ $user->first_name }}</a></td>
                              <td>{{ $user->last_name }}</td>
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
                      
                    </div>
                </div>
              </div>
      </div>
</div>

                        


@endsection

@section('scripts')

<script src="js/sweetalert2.min.js"></script>
<script src="js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">
@endsection
