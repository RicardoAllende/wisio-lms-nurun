@extends('layouts.app')

@section('title','Plantillas de certificados')
@section('cta')
  <a href="{{route('templates.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i>Crear plantilla</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Plantillas de certificados
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Plantillas para certificado</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($templates as $template)
                            <tr>
                              <td><a href="{{ route('templates.show', $template->id) }}">{{ $i }}</a></td> @php $i++; @endphp
                              <td><a href="{{ route('templates.show', $template->id) }}">{{ $template->name }}</a></td>
                              <td>{{ $template->created_at }}</td>
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