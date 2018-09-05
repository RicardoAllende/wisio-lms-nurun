<!-- style="height: 50% !important; width: 50% !important; overflow: hidden;" -->
<div id="info-diploma" class="modal">
  <!-- <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" >X</a> -->
  <br><br><br>
  <div class="modal-content">
    <h4 style="text-align: center;" class="recientes" id="nombre-del-modulo">{{ $diploma->name }}</h4>
    <br>
    <div style="padding: 10%; text-align: center;" class="user pad-left3" >
      <!-- <p id="intentosId" ></p> -->
        Para realizar este diploma, es necesario haber cursado y aprobado los siguientes cursos (calificación mínima {{ $diploma->minimum_previous_score }}):
      <ul>
        @foreach($diploma->courses as $course)
          <li> {{ $course->name }}</li> 
        @endforeach
      </ul>
      <p id="calificacionP"></p>
    </div>
    <!-- <p>Inf</p> -->
  </div>
  <div class="modal-footer">
    <!-- <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a> -->
  </div>
</div>