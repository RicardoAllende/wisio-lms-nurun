<!-- style="height: 50% !important; width: 50% !important; overflow: hidden;" -->
<div id="info-diploma" class="modal">
  <!-- <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" >X</a> -->
  <br><br><br>
  <div class="modal-content">
    <h4 style="text-align: center;" class="recientes" id="nombre-del-modulo">{{ $diploma->name }}</h4>
    <br>
    <div style="padding: 5%; text-align: center;" class="user pad-left3" >
      <!-- <p id="intentosId" ></p> -->
      <p>{{ $diploma->description }}</p>
        Para realizar este diploma, es necesario haber cursado y aprobado los siguientes cursos (calificación mínima {{ $diploma->minimum_previous_score }}):
      <ul>
        @foreach($diploma->courses as $course)
          <li> {{ $course->name }}</li> 
        @endforeach
      </ul>
      <br>
    @if(isset($invitation))
    <br>
      <a class="btnAcademia" href="{{ route('enrol.user.in.diploma', [$ascription->slug, $diploma->slug]) }}" style="text-align: center;" >
          Inscribirse en el diplomado
      </a>
    @endif
    </div>
    <!-- <p>Inf</p> -->
  </div>
  <div class="modal-footer">
    <!-- <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a> -->
  </div>
</div>