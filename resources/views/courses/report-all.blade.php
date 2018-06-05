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
                            <th>#</th>
                            <th>Curso</th>
                            <th>Promedio del curso</th>
                            <th>Médicos inscritos</th>
                            <th>Médicos aprobados</th>
                            <th>Médicos no aprobados</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($courses as $course)
                              <tr>
                                <td><a href="{{route('show.course.report', $course->id)}}">{{ $i }}</a></td>@php $i++; @endphp
                                <td><a href="{{route('show.course.report', $course->id)}}">{{ $course->name }}</a></td>
                                <td>{{ ($course->usersAvg() == "") ? "0" : $course->usersAvg() }}</td>
                                <td>{{ $course->numUsersEnrolled() }}</td>
                                <td>{{ $course->approvedUsers->count() }}</td>
                                <td>{{ $course->failedUsers() }}</td>
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
     