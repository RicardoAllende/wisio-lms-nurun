<div id="modalInsc" class="modal">
  <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" onclick="closeModEvDiag();">X</a>
  <div class="modal-content">

    No estas inscrito en este curso, ¿quieres inscribirte para ver el contenido?

    </div>
    <div class="modal-footer">
    <a  class="modal-action modal-close waves-effect btnAcademia" href="{{ route('student.enrol.course', [Auth::user()->ascription()->slug,Auth::user()->id,$course->id]) }}" id="btnInscribirse">Inscribirse</a>
    <a  class="modal-action modal-close waves-effect btnAcademia" id="btnCancelar">Cancelar</a>
  </div>
</div>
