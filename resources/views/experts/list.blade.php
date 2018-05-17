@extends('layouts.app')

@section('title','Expertos')
@section('cta')
  <a href="{{route('experts.create')}}" class="btn btn-primary "><i class='fa fa-plus'></i> Crear experto</a>
@endsection

@section('subtitle')
  <ol class="breadcrumb">
    <li>
      Expertos
    </li>
  </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                  

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Expertos</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Experto</th>
                            <th>Especialidades</th>
                            <th>Resumen</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                            @foreach($experts as $expert)
                              <tr>
                              <td>{{$i}}</td>
                              <td><a href="{{ route('experts.show', $expert->id) }}">{{ $expert->name }}</a></td>
                              <td>@php $i++;  @endphp
                              @forelse($expert->specialties as $specialty)
                                {{ $specialty->name }},
                                @empty
                                Sin especialidades
                              @endforelse
                              </td>
                              <td>{{ $expert->summary }}</td>
                              <td>
                                  {!! Form::open(['method'=>'DELETE','route'=>['experts.destroy',$expert->id],'class'=>'form_hidden','style'=>'display:inline;']) !!}
                                     <a href="#" class="btn btn-danger btn_delete" >Eliminar</a>
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
     
