<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluación {{ $evaluation->name }}</title>
</head>
<body>
    <main>
        <h1>Evaluación: {{ $evaluation->name }}</h1>
        <h2>Veces realizada {{ Auth::user()->evaluationAttempts($evaluation->id) }} </h2>
    </main>
    @if(Auth::user()->hasAnotherAttemptInEvaluation($evaluation->id) )
    <form action="{{ route('grade.evaluation', Auth::user()->ascriptionSlug()) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" >
        <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">
        @foreach($evaluation->questions as $question)
        <p>Pregunta: {{$question->content}}</p>
        <ol>
            @foreach($question->options as $option)
            <li><label><input type="radio" name="{{ 'question'.$question->id }}" checked required value="{{ $option->id }}">{{ $option->content }}</label></li>
            @endforeach
        </ol>
        @endforeach
        <input type="submit" value="Calificar">
    </form>
    @else
        <h3>Ya no puede hacer esta evaluación nuevamente</h3>
    @endif
</body>
</html>