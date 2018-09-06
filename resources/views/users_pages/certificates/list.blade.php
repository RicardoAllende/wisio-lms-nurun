@section('title')
Certificados
@stop
@extends('users_pages.master')

@section('breadcrumbs')
  <a href="{{ route('student.home', $ascription->slug) }}" class="breadcrumb">Inicio</a>
  <a href="{{ route('certificates.list', $ascription->slug) }}" class="breadcrumb">Certificados</a>
@stop

@section('body')
<div class="row pad-left3" style="min-height: 500px;">
    <div class="col s6 l5">
        <hr class="line"/>
    </div>
    <div class="col s6 l7">
        <h4 class="recientes">Certificados disponibles para descargar</h4>
    </div>
    <br><br>
    @if($certificates->isNotEmpty())
        <ul class="collection">
        @foreach($certificates as $certificate) <?php /* Certificate is a course with pivot  */ ?>
            <li class="collection-item avatar">
                <!-- <i class="material-icons circle">folder</i> -->
                <img src="{{ $certificate->category->getMainImgUrl() }}" class="circle" alt="{{ $certificate->name }}">
                <span class="title">{{ $certificate->name }}</span>
                <a target='_blank' href="{{ route('download.certificate.of.course', [$ascription->slug, $certificate->slug]) }}" class="btnAcademia secondary-content">Descargar</a>
            </li>
        @endforeach
        </ul>
    @else
        <!-- <h5>Sin diplomas disponibles para descargar, si concluyó algún curso y requiere constancia,
        póngase en contacto con <a href="mailto:{{ config('constants.support_email') }}">{{ config('constants.support_email') }}</a></h5> -->
        <br><br>
        <h5>Sin certificados disponibles para descargar</h5>
    @endif


    @if($diplomas->isNotEmpty())
    <div class="col s6 l5">
        <hr class="line"/>
    </div>
    <div class="col s6 l7">
        <h4 class="recientes">Diplomados disponibles para descargar</h4>
    </div>
    <br><br>
        <ul class="collection">
        @foreach($diplomas as $diploma) <?php /* diplomado is a course with pivot  */ ?>
            <li class="collection-item avatar">
                <!-- <i class="material-icons circle">folder</i> -->
                <img src="{{ $diploma->getMainImgUrl() }}" class="circle" alt="{{ $diploma->name }}">
                <span class="title">{{ $diploma->name }}</span>
                <a target='_blank' href="{{ route('download.diploma.of.course', [$ascription->slug, $diploma->slug]) }}" class="btnAcademia secondary-content">Descargar</a>
            </li>
        @endforeach
        </ul>
    @endif

    
</div>
@stop
@section('extrajs')
<script>
    cambiarItem("menuCertificados");
</script>
@stop
