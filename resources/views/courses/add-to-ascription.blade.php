@extends('layouts.app')

@section('title','Cursos')
@section('cta')
  <a href="{{route('ascriptions.show', $ascription_id)}}" class="btn btn-primary "><i class='fa fa-plus'></i> Ver adscripción</a>
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
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                              <tr>
                                <td><a href="/courses/{{ $course->id }}/">{{ $course->name }}</a></td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->created_at }}</td>
                                <td>
                                    @if($course->belongsToAscription($ascription_id))
                                        <button>Pertenece</button>
                                    @else
                                        <button>No pertenece</button>
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