@extends('layouts.app')

@section('title', 'Reporte de '.$course->name)
@section('cta')
  <a href="{{route('courses.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Curso</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li><a href="{{ route('list.courses.report') }}">Reportes</a></li>
        <li>Curso: {{ $course->name }}</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Médicos inscritos</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="users-table" >
                        <thead>
                            <tr>
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cédula profesional</th>
                                <th>Calificación</th>
                            </tr>
                        </thead>
                      </table>
                      </div>
                      
                    </div>
                    <div class="ibox-footer"></div>
                </div>
              </div>
      </div>
</div>
@endsection

@section('scripts')
<script>
  $( document ).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'Bfrtip',
        ajax: "{{ route('get.users.data.diplomado', $course->id) }}",
        columns: [
            {data: 'email'},
            {data: 'firstname'},
            {data: 'lastname'},
            {data: 'professional_license'},
            {data: 'score_in_diplomado'},
        ]
    });
  });
</script>
@endsection