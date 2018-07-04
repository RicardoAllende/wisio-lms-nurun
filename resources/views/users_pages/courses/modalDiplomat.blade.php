<div id="modalDiplomat" class="modal">
    <a class="modal-action modal-close waves-effect waves-light btn-small cerrarModal" style="color:white !important;" onclick="closeModEvDiag();">X</a>
    <div class="modal-content">
        Este tiene un diplomado disponible, ¿desea inscribirse en él?
    </div>
    <div class="modal-footer">
        @if(Auth::check())
        <a class="modal-action modal-close waves-effect btnAcademia" href="" id="btnInscribirse">Sí</a>
        @endif
        <a class="modal-action modal-close waves-effect btnAcademia" id="btnCancelar">No</a>
    </div>
</div>