@extends('layouts.app')

@section('title','Reporte de adscripciones')
@section('cta')
  <!-- <a href="{{route('ascriptions.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Adscripción</a> -->
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Reportes
        </li>
        <li>Adscripciones</li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Adscripciones</h5>
                        
                    </div>
                    <div class="ibox-content">
                    @if($ascriptions->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Adscripción</th>
                            <th>Slug</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Cantidad de cursos</th>
                            <th>Usuarios</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($ascriptions as $ascription)
                            <tr>
                              <td><a href="{{ route('show.ascription.report' , $ascription->id) }}">{{ $i }}</a></td>@php $i++; @endphp
                              <td><a href="{{ route('show.ascription.report' , $ascription->id) }}">{{ $ascription->name }}</a></td>
                              <td>{{ $ascription->slug }}</td>
                              <td>{{ $ascription->description }}</td>
                              <td>
                              {{ ($ascription->enabled == 1) ? 'Disponible' : 'No disponible' }}</td>
                              <td>{{ $ascription->courses->count() }}</td>
                              <td>{{ $ascription->users->count() }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                      </table>
                      </div>
                    @else
                    <center>
                      <h3>Aún no existen adscripciones</h3><br>
                      <a href="{{route('ascriptions.create')}}" class="btn btn-primary ">
                        <i class='fa fa-plus'></i> Crear Adscripción
                      </a>
                    </center>
                    @endif
                    </div>
                    <div class="ibox-footer">
                      
                    </div>
                </div>
              </div>
      </div>
</div>                       
@endsection
