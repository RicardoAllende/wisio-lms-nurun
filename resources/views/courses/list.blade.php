@extends('layouts.app')

@section('title','Cursos')
@section('cta')
  <a href="{{route('courses.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Cursos
        </li>
    </ol>
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
                          <th>#</th>
                            <th>Curso</th>
                            <th>¿Ofrece certificado?</th>
                            <th>¿Ofrece diplomado?</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($courses as $course)
                              <tr>
                                <td><a href="{{route('courses.show', $course->id)}}">{{ $i }}</a></td>@php $i++; @endphp
                                <td><a href="{{route('courses.show', $course->id)}}">{{ $course->name }}</a></td>
                                <td>{{ ($course->has_constancy) ? 'Sí' : 'No' }}</td>
                                
                                @if($course->category != null )
                                  <td> <a href="{{ route('categories.show', $course->category->id) }}">{{ $course->category->name }}</a> </td>
                                @else
                                  <td>Sin categoría</td>
                                @endif
                                <td>
                                  @if($course->hasRelations())
                                    @if($course->enabled == 1)
                                      <!--<a href="{{ route('disable.course', $course->id) }}" class="btn btn-danger btn-round" >Deshabilitar</a>-->
                                    @else
                                      <!--<a href="{{ route('enable.course', $course->id) }}" class="btn btn-info btn-round" >Habilitar</a>-->
                                    @endif
                                  @else
                                    {!! Form::open(['method'=>'DELETE','route'=>['courses.destroy',$course->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                      <a href="#" class="btn btn-danger btn_delete">Eliminar</a>
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

@section('scripts')

<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
     