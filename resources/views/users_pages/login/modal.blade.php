
<div id="modal1" class="modal">
    <a class="waves-effect waves-light btn-small cerrarModal modal-close" style="color:white !important;">X</a>
    <div class="modal-content">
        <div class="modal-header center">
            <h5 class="center upscase ">Ingreso</h5>

        </div>
        <br>
        <div class="modal-body">
            <div class="row ">
              <div class="col s12 l6 offset-l3">
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
                        <div class="col-sm-offset-2 col-sm-10 center">
                            {!! Form::submit('Continuar',['class'=>'btnAcademia ','id'=>'guardar']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
              </div>

            </div>
            <div class="row">
              <div class="col s12 center">
                <p>¿Olvido la contraseña? Haga <a class="upscase">Click Aqui</a> para crear una nueva</p>
                <p>Sí no recuerda el correo registrado, haga <a class="upscase">Click Aqui</a></p>
                <br>
                <br>
                <hr class="line"/>
                <br>
                <p>¿Aún no se ha registrado?</p>
                <br>
                <div class="col s12 aprender-mas">
                  <a href="{{ route('register')}}">Crear una nueva cuenta <span class="icon-registrese iconbtn"></span></a>

               </div>
              </div>

            </div>
        </div>

    </div>


</div>
