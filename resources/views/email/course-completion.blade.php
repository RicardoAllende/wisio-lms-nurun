<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {!! Form::open(['route' => 'sql.form','class'=>'form-horizontal','method' => 'post']) !!}
        <div class="form-group">
            {!! Form::label('statement', 'Email:',['class'=>'control-label col-sm-2']); !!}
            <div class="col-sm-10">
                {!! Form::text('statement',null,['class'=>'form-control','placeholder'=>'Correo electrónico', 'required'=>'']) !!}
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Login',['class'=>'btn btn-primary','id'=>'guardar']) !!}
            </div>
        </div>
    {!! Form::close() !!}
</body>
</html>