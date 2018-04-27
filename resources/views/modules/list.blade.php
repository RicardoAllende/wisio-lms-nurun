@extends('layouts.app')

@section('title','Módulos')
@section('cta')
  <a href="{{route('modules.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Evaluación</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Evaluaciones</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Módulo</th>
                            <th>Pertenece a</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                              <tr>
                              <td><a href="{{ action('ModulesController@show' , $module->id) }}">{{ $module->name }}</a></td>
                              <td>{{ $module->courses->first()->name }}</td>
                              <td>{{ $module->description }}</td>
                              <td>{{ $module->courses->count() }}</td>
                              <td>
                                  {!! Form::open(['method'=>'delete','route'=>['modules.destroy',$module->id],'style'=>'display:inline;']) !!}
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']); !!}
                                    <!--<a href="{{route('modules.destroy',$module->id)}}" class="btn btn-danger btn_delete" >Eliminar</a>-->
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