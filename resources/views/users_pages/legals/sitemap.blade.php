@section('title')
Mapa del sitio
@stop
@extends('users_pages.master')


@section('body')

<div class="row pad-left3">
  <div class="col s6 l9">
    <hr class="line"/>
  </div>
  <div class="col s6 l3">
    <h2 class="recientes">Mapa del sitio</h2>
  </div>

        <div class="row ">
            <div class="card white col s12">
              <h5>Academia Mc</h5>
              <ul class="browser-default">
                <li><a href="{{ route('student.home', $ascription->slug) }}">Login</a></li>
                <li><a href="{{ route('student.home', $ascription->slug) }}">Inicio</a></li>
                <li><a href="{{ route('student.home', $ascription->slug) }}">Cursos recientes</a></li>
                <li><a href="{{ route('student.funciona', $ascription->slug) }}">Como funciona</a></li>
                <li><a href="{{ route('student.show.experts', $ascription->slug) }}">Profesores </a></li>
                <li><a href="{{ route('student.own.courses', $ascription->slug) }}">Mis cursos *</a></li>
                <li><a href="{{ route('student.list.evaluations', $ascription->slug) }}">Evaluaciones *</a></li>
                <li><a href="{{ route('certificates.list', $ascription->slug) }}">Certificados *</a></li>
              </ul>
              <p>* Para usuarios logueados.</p>
              <h5>Legales</h5>
              <ul class="browser-default">
                <li><a href="{{ route('student.terms', $ascription->slug) }}">Términos de uso</a></li>
                <li><a href="{{ route('student.privacity', $ascription->slug) }}">Aviso de privacidad</a></li>
                <li><a href="{{ route('student.pharmacovigilance', $ascription->slug) }}">Aviso de farmacovigilancia</a></li>
                <li><a href="{{ route('student.twitter.terms', $ascription->slug) }}">Términos de uso de Twitter</a></li>
                <li><a href="{{ route('student.sitemap', $ascription->slug) }}">Mapa del Sitio</a></li>
              </ul>
            </div>
        </div>
</div>

@stop
