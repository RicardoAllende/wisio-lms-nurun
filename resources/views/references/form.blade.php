@extends('layouts.app')

@section('title', (isset($reference)) ? 'Editar referencia' : 'Crear Referencia')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          <a href="{{ route('modules.show', $module->id) }}">Módulo: <strong>{{ $module->name }}</strong></a>
        </li>
        <li>
            {{ (isset($reference)) ? 'Editar referencia' : 'Crear Referencia' }}
        </li>
    </ol>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ (isset($reference)) ? 'Editar referencia' : 'Crear Referencia' }}</h5>
                        
                    </div>
                    <div class="ibox-content">
                      <div class="row ">

                        @if(!isset($reference))
                          {!! Form::open(['route' => ['references.store', $module->id],'class'=>'form-horizontal','method' => 'post']) !!}
                        @else
                          {!! Form::model($reference,['route' => ['references.update', $module->id, $reference->id],'class'=>'form-horizontal','method' => 'put']) !!}
                        @endif                            
                            <div class="form-group">
                              {!! Form::label('content', 'Referencia:',['class'=>'control-label col-sm-2']); !!}
                              <div class="col-sm-10">
                                <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="Referencia">@if(isset($reference)){{ $reference->content }}@endif</textarea>
                              </div>
                            </div>
                            <input type="hidden" name="module_id" value="{{ $module->id }}">
                            <div class="form-group"> 
                                <div class="col-sm-offset-2 col-sm-10">
                                <a href="{{route('references.index', $module->id)}}" class="btn btn-default">Cancelar</a>
                                    {!! Form::submit('Guardar',['class'=>'btn btn-primary', 'id' => 'btnSave']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
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
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
@endsection