@section('title')
Certificados
@stop
@extends('users_pages.master')
@section('body')
<div class="row pad-left3" style="min-height: 500px;">
    <div class="col s6 l5">
        <hr class="line"/>
    </div>
    <div class="col s6 l7">
        <h2 class="recientes">Certificados de cursos disponibles para descargar</h2>
    </div>
    <br><br>
    @if($certificates->count() > 0)
        <ul class="collection">
        @foreach($certificates as $certificate) <?php /* Certificate is a course with pivot  */ ?>
            <li class="collection-item avatar">
                <!-- <i class="material-icons circle">folder</i> -->
                <img src="{{ $certificate->getMainImgUrl() }}" class="circle" alt="{{ $certificate->name }}">
                <span class="title">{{ $certificate->name }}</span>
                <p>Fecha de obtención: {{ $certificate->pivot->updated_at }}</p>
                <a href="#descargando-diploma" class="btnAcademia secondary-content">Descargar</a>
            </li>
        @endforeach
        </ul>
    @else
        <h5>Sin diplomas disponibles para descargar, si concluyó algún curso y requiere constancia, 
        póngase en contacto con <a href="mailto:{{ config('constants.support_email') }}">{{ config('constants.support_email') }}</a></h5>
    @endif
</div>
@stop
@section('extrajs')
<script>
    cambiarItem("menuCertificados");
</script>
@stop