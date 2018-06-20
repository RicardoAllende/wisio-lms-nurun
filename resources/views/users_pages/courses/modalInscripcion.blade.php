<div id="modalInsc" class="modal">
  <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" onclick="closeModEvDiag();">X</a>
  <div class="modal-content">
    No está inscrito en este curso, ¿quieres inscribirte para ver el contenido?
  </div>
  <div class="modal-footer">
    @if(Auth::check())
      <a class="modal-action modal-close waves-effect btnAcademia" href="{{ route('student.enrol.course', [$ascription->slug,Auth::user()->id,$course->id]) }}" id="btnInscribirse">Inscribirse</a>
    @endif
    <a class="modal-action modal-close waves-effect btnAcademia" id="btnCancelar">Cancelar</a>
  </div>
</div>
