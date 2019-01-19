@extends('layouts.app')

@section('title','Usuarios')

@section('subtitle')
    <ol class="breadcrumb">
      @if(isset($ascription))
        <li>
          Notificaciones
        </li>
      @endif
    </ol>
@endsection

@section('content')
<?php set_time_limit(0); ?>
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Usuarios @isset($ascription) inscritos en {{$ascription->name}} @endif </h5><br>
                    </div>
                    <div class="ibox-content">
                      <br>
                          <div class="table-responsive" id="userList">
                            <table class="table table-striped table-bordered table-hover" id="users-table">
                            <thead>
                              <tr>
                                <th>Email</th>
                                <th>Ver notificaciones</th>
                                <th>Cédula profesional</th>
                                <th>Recordatorios mensuales</th>
                                <th>Recordatorios semanales</th>
                                <th>Primera notificación enviada</th>
                                <th>Última notificación enviada</th>
                                <th>Último acceso al sistema</th>
                                <th>Deshabilitar usuario</th>
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
            ajax: "{{ route('get.users.for.notification') }}",
            columns: [
                {data: 'email'},
                {data: 'userLink'},
                {data: 'professional_license'},
                {data: 'numMonthReminders'},
                {data: 'numWeekReminders'},
                {data: 'firstNotification'},
                {data: 'lastNotification'},
                {data: 'last_access'},
                {data: 'actions'},
            ]
        });
  });
  </script>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection
