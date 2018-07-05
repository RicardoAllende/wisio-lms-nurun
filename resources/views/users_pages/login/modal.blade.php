
<div id="modal1" class="modal">
    <a class="waves-effect waves-light btn-small cerrarModal modal-close" style="color:white !important;">X</a>
    <div class="modal-content">
        <div class="modal-header center">
            <h3 class="center ingreso">Ingreso</h3>

        </div>
        <br>
        <div class="modal-body">
            <div class="row ">
              <div class="col s12 l6 offset-l3">
                {!! Form::open(['route' => 'request.login','class'=>'form-horizontal','method' => 'post','enctype'=>'multipart/form-data']) !!}
                    <div class="form-group">
                        {!! Form::label('email_label', 'Email:',['class'=>'control-label col-sm-2']); !!}
                        <div class="col-sm-10">
                            {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'required'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::label('password', 'Contraseña:',['class'=>'control-label col-sm-2']); !!}
                    <div class="col-sm-10">
                        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña', 'required' => '']) !!}
                    </div>
                    </div>
                    @if(isset($notification))
                    <input type="hidden" name="notification" value="{{$notification->code}}">
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 center">
                            <div>

                            </div>
                            {!! Form::submit('Continuar',['class'=>'btnAcademia padright','id'=>'guardar']) !!}
                            <span class="icon-bt_derecha iconbtncontinuar"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        </div>
                    </div>
                {!! Form::close() !!}
              </div>

            </div>
            <div class="row">
              <div class="col s12 center">
              <p>¿Olvidó la contraseña? Haga <a class="upscase linkM" href="{{ route('forgot.password') }}" >click Aquí</a> para crear una nueva</p>
                <br>
                <br>
                <hr class="line"/>
                <br>
                <p>¿Aún no se ha registrado?</p>
                <br>
                <div class="col s12 aprender-mas hide-on-small-only">
                    @if(isset($ascription))
                        <a href="{{ route('show.register.form.pharmacy', $ascription->slug)}}" class="btnAcademia">Crear una nueva cuenta <span class="icon-registrese iconbtn"></span></a>
                    @else
                        <a href="{{ route('register')}}" class="btnAcademia">Crear una nueva cuenta <span class="icon-registrese iconbtn"></span></a>
                    @endif

               </div>
               <div class="col s12 aprender-mas hide-on-med-and-up">
                   @if(isset($ascription))
                       <a href="{{ route('show.register.form.pharmacy', $ascription->slug)}}" >Crear cuenta <span class="icon-registrese iconbtn"></span></a>
                   @else
                       <a href="{{ route('register')}}" >Crear cuenta <span class="icon-registrese iconbtn"></span></a>
                   @endif

              </div>
              </div>

            </div>
        </div>

    </div>


</div>
