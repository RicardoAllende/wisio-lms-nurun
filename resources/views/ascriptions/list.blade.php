@extends('layouts.app')

@section('title','Adscripciones')
@section('cta')
  <a href="{{route('ascriptions.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Evaluación</a>
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
                            <th>Adscripción</th>
                            <th>Slug</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Cantidad de cursos</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($ascriptions as $ascription)
                              <tr>
                              <td><a href="{{ action('AscriptionsController@show' , $ascription->id) }}">{{ $ascription->name }}</a></td>
                              <td>{{ $ascription->slug }}</td>
                              <td>{{ $ascription->description }}</td>
                              <td>{{ ($ascription->status == 1)? 'Disponible' : 'No disponible' }}</td>
                              <td>{{ $ascription->courses->count() }}</td>
                              <td>
                                  {!! Form::open(['method'=>'delete','route'=>['ascriptions.destroy',$ascription->id],'style'=>'display:inline;']) !!}
                                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']); !!}
                                    <!--<a href="{{route('ascriptions.destroy',$ascription->id)}}" class="btn btn-danger btn_delete" >Eliminar</a>-->
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
     
