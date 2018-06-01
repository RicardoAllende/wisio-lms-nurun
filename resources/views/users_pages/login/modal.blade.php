
<div id="modal1" class="modal">
    <a class="waves-effect waves-light btn-small cerrarModal modal-close" style="color:white !important;"">X</a>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="recientes">Inicio de sesión</h4>
               <hr class="line"/>
        </div>
        <br>
        <div class="modal-body">
            <div class="row ">
                {!! Form::open(['route' => 'request.login','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                    <div class="form-group">
                        {!! Form::label('email_label', 'Email:',['class'=>'control-label col-sm-2']); !!}
                        <div class="col-sm-10">
                            {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'required'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                    <div class="col-sm-10">
                        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            {!! Form::submit('Acceder',['class'=>'btnAcademia','id'=>'guardar']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>


</div>
