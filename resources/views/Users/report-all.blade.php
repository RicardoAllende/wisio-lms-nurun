@extends('layouts.app')

@section('title','Reporte de usuarios')
@section('cta')
<!--<div style="display=inline;">
  <a href="{{route('users.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Usuario</a>
</div>-->
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>Reportes</li>
        <li>Usuarios</li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Reporte de médicos inscritos en el sistema </h5><br>
                    </div>
                    <div class="ibox-content">
                      <br>
                        @if($users->count() > 0)
                          <div class="table-responsive" id="userList">
                            <table class="table table-striped table-bordered table-hover" id="users-table">
                            <thead>
                              <tr>
                                <th>Ver</th> @php $i = 1; @endphp
                                <th>Correo electrónico</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Cédula profesional</th>
                                <th>Teléfono móvil</th>
                                <th>Activo</th>
                                <th>Adscripción</th>
                                <th>Diplomado</th>
                                <th>Fecha de inscripción</th>
                                <th>Último acceso al sistema</th>
                              </tr>
                            </thead>
                          </table>
                          
                        </div>
                      @else
                        <h3>Sin usuarios</h3>
                      @endif
                      
                      
                    </div>
                    <div class="ibox-footer">
                       <!--$users->links()-->
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
        ajax: "{{ route('get.users.data.admin') }}",
        columns: [
            {data: 'userLink'},
            {data: 'email'},
            {data: 'firstname'},
            {data: 'lastname'},
            {data: 'cedula'},
            {data: 'mobile_phone'},
            {data: 'status'},
            {data: 'ascription_name'},
            {data: 'diplomados'},
            {data: 'created_at'},
            {data: 'last_access'},
        ]
    });
  });
  </script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection