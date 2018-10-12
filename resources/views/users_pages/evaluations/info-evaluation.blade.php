<div id="info-evaluation" class="modal" style="height: 50%; width: 50%; overflow: hidden;">
  <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" onclick="showEvaluation()" >X</a>
  <br><br><br>
  <div class="modal-content">
    <h4 style="text-align: center;" class="recientes" id="nombre-del-modulo">@if(isset($evaluation)) Información de la evaluación {{ $evaluation->name }} @endif</h4>
    <br>
    <div style="padding: 10%; text-align: center;" class="user pad-left3" >
      <p id="intentosId" >@if(isset($maximum_attempts)) Usted ha realizado esta evaluación {{ $numTries }} veces, de {{ $maximum_attempts }} posibles.  @endif </p>
      <p id="calificacionP">Calificación: @if(isset($numTries)) @if($numTries == 0) No disponible @else {{ $score }} @endif @endif </p>
    </div>
    <!-- <p>Inf</p> -->
  </div>
  <div class="modal-footer">
    <!-- <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a> -->
  </div>
</div>