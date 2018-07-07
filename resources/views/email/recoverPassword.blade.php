@extends('email/layouts/default')

@section('content')
<div class="row">
  <div class="col s12 m6">
    <div class="card white">
      <div class="card-content">
        <p>Hemos recibido una solicitud para reestablecer la contraseña, si no fuiste tú, haz caso omiso de este mensaje, si has sido tú da clic en el siguiente enlace para recuperar tu contraseña:</p>
      <p class="pad2"><a href="{{ $token }}" class="btnAcademia">{{$token}}</a></p>
        
        <p>Gracias,</p>

        <p>Equipo AcademiaMC</p>
      </div>

    </div>
  </div>

</div>


@stop
