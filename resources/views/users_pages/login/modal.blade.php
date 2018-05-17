
<div id="modal1" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Inicio de sesión</h4>
        </div>
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
                            {!! Form::submit('Login',['class'=>'btn deep-purple lighten-3','id'=>'guardar']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn modal-close deep-purple lighten-3" >Cerrar</button>
        </div>
    </div>


</div>
