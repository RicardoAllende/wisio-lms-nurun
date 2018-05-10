@extends('layouts.app')

@section('title','Cursos')
@section('cta')
  <a href="{{route('course.form.for.ascription', $ascription->id)}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <h3>Adscripción: <a href="{{ route('ascriptions.show', $ascription->id) }}" >{{$ascription->name}}</a></h3>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Cursos disponibles</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Curso</th>
                            <th>Descripción</th>
                            <th>Fecha de inicio</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                              <tr>
                                <td><a href="{{route('courses.show', $course->id)}}">{{ $course->name }}</a></td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->created_at }}</td>
                                <td>
                                    @if($course->belongsToAscription($ascription->id))
                                      <a href="{{ route('dissociate.course.of.ascription', [$course->id, $ascription->id]) }}" class="btn btn-danger btn-rounded">Quitar</a>
                                    @else
                                      <a href="{{ route('relate.course.to.ascription', [$course->id, $ascription->id]) }}" class="btn btn-success btn-rounded">Agregar</a>
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