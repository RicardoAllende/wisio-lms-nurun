@if(isset($ascription))
    <div id="modal2" class="modal" style="height:85%; width:90%" >
        <a class="waves-effect waves-light btn-small cerrarModal modal-close" style="color:white !important;">X</a>
        <div class="modal-content">
            <center>
                <img src="{{ $ascription->calendarUrl() }}" 
                    style="width:80%; height:80%;" alt="Calendario" />
            </center>
        </div>
    </div>
@endif