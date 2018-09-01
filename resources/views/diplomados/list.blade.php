@extends('layouts.app')

@section('title','Diplomados')
@section('cta')
  <!-- <a href="{{route('diplomas.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear Diploma</a> -->
@endsection

@section('subtitle')
    <ol class="breadcrumb">
        <li>Diplomados</li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Diplomados</h5>
                    </div>
                    <div class="ibox-content">
                    @if($diplomas->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Diplomado</th>
                            <th>Slug</th>
                            <th>Descripción</th>
                            <th>Promedio mínimo requerido</th>
                            <th>Calificación mínima aprobatoria</th>
                            <th>Cursos requeridos</th>
                            <th>Médicos inscritos</th>
                          </tr>
                        </thead>
                        <tbody>@php $i=1; @endphp
                            @foreach($diplomas as $diploma)
                            <tr>
                                <td><a href="{{ route('diplomas.show' , $diploma->id) }}">{{ $i }}</a></td>@php $i++; @endphp
                                <td><a href="{{ route('diplomas.show' , $diploma->id) }}">{{ $diploma->name }}</a></td>
                                <td>{{ $diploma->slug }}</td>
                                <th>{{ $diploma->description }}</th>
                                <td>{{ $diploma->minimum_previous_score }}</td>
                                <td>{{ $diploma->minimum_score }}</td>
                                <td>
                                    <ul>
                                    @foreach($diploma()->courses()->cursor() as $course)
                                        <li>$course->name</li>
                                    @endforeach
                                    </ul>
                                </td>
                                <td>{{ $diploma->users()->count() }}</td>
                              
                            </tr>
                            @endforeach
                            
                        </tbody>
                      </table>
                      </div>
                    @else
                    <div style="text-align: center;" >
                      <h3>Aún no existen Diplomados</h3><br>
                      <a href="{{route('diplomas.create')}}" class="btn btn-primary ">
                        <i class='fa fa-plus'></i> Crear Diploma
                      </a>
                    </div>
                    @endif
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