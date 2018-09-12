@extends('layouts.app')

@section('title','Reporte de cursos')
@section('cta')
  <a href="{{route('courses.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>Reportes</li>
        <li>Cursos</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Cursos</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th>Nombre del curso</th>
                            <th>Promedio del diplomado</th>
                            <th>Médicos que hicieron la evaluación</th>
                            <th>Médicos aprobados</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($courses as $course)
                              <tr>
                                <td>{{ ($course->diplomaAvg() == "") ? "0" : $course->diplomaAvg() }}</td>
                                <td>{{ $course->approvedInDiploma() }}</td>
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
     