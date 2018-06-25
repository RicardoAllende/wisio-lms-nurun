<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach($evaluations as $evaluation)
        <ol>
        @if( ! $evaluation->hasQuestions())
            <li>Evaluación sin preguntas{{$evaluation->name}}</li>
        @endif
        </ol>
    @endforeach
</body>
</html>