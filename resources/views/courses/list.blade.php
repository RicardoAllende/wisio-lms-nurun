@extends('layouts.app')

@section('title','Cursos')
@section('cta')
  <a href="{{route('courses.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
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
                            <th>Curso</th>
                            <th>Descripción</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de término</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                              <tr>
                                <td><a href="{{route('courses.show', $course->id)}}">{{ $course->name }}</a></td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->start_date }}</td>
                                <td>{{ $course->end_date }}</td>
                                @if($course->categories->count() > 0 )
                                  <td>{{ $course->categories->first()->name }}</td>
                                @else
                                  <td>Sin categoría</td>
                                @endif
                                <td>
                                    {!! Form::open(['method'=>'DELETE','route'=>['courses.destroy',$course->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                      <a href="#" class="btn btn-danger btn_delete">Eliminar</a>
                                    {!! Form::close() !!}
                                  @if($course->hasRelations())
                                    <!--<a href="#" class="btn btn-danger btn-block" disabled>Eliminar</a>-->
                                  @else
                                    
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

@section('scripts')

<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
     