@extends('layouts.app')

@section('title','Módulos')
@section('cta')
  <a href="{{route('modules.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Módulo nuevo</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Módulos
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Evaluaciones</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Módulo</th>
                            <th>Curso</th>
                            <th>Editar</th>
                            <th>Evaluaciones</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($modules as $module)
                              <tr>
                              <td><a href="{{ route('modules.show' , $module->id) }}">{{ $i }}</a></td>@php $i++; @endphp
                              <td><a href="{{ route('modules.show' , $module->id) }}">{{ $module->name }}</a></td>
                              <td><a href="{{route('courses.show', $module->course->id) }}">{{ $module->course->name }}</a>  </td>
                              <td><a href="{{route('modules.edit', $module->id) }}">Editar</a></td>
                              <td>{{ $module->evaluations()->count() }}</td>
                              <td>{{ ($module->is_for_diploma) ? 'Módulo para diplomado' : '' }}</td>
                              <td>
                                <a href="{{ route('delete.module', $module->id) }}" class="btn btn-danger btn-round" >Eliminar</a>
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