@extends('layouts.app')

@section('title','Especialidades')
@section('cta')
  <a href="{{route('specialties.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear especialidad</a>
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li class="active">
            Especialidades
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <h5>Especialidades</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Especialidad </th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($specialties as $specialty)
                              <tr>
                                <td><a href="{{ route('specialties.show', $specialty->id) }}">{{ $i }}</a></td> @php $i++; @endphp
                                <td><a href="{{ route('specialties.show', $specialty->id) }}">{{ $specialty->name }}</a></td>
                                <td>
                                  {!! Form::open(['method'=>'DELETE','route'=>['specialties.destroy',$specialty->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                    <a href="#" class="btn btn-danger btn-round btn_delete" >Eliminar</a>
                                  {!! Form::close() !!}
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

@section('scripts')

<script src="/js/sweetalert2.min.js"></script>
<script src="/js/method_delete_f.js"></script>

@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="/css/sweetalert2.min.css">
@endsection