@extends('layouts.app')

@section('title','Usuarios')
@section('cta')
<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('list.diplomados') }}">Diplomados</a>
        </li>
        <li>
          {{ $ascription->name }}
        </li>
        <li>
          Administrar usuarios
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Listado de médicos, inscripción a {{ $ascription->name }}</h5><br>
                    </div>
                    <div class="ibox-content">
                      <br>
                          <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="users-table">
                            <thead>
                              <tr>
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cédula profesional</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
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
  <script>
  $( document ).ready(function() {
    $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excelHtml5', 'pdf', 'print'
            ],
            ajax: "{{ route('get.users.for.ascription.enrollment', $ascription->id) }}",
            columns: [
                {data: 'email'},
                {data: 'firstname'},
                {data: 'lastname'},
                {data: 'professional_license'},
                {data: 'status'},
                {data: 'enrollment'},
            ]
    });
  });
  </script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
