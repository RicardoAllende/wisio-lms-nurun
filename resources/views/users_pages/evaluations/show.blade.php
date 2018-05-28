<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        @foreach($evaluation->questions as $question)
        <p>Pregunta: {{$question->content}}</p>
        <ol>
            @foreach($question->options as $option)
            <li>{{ $option->content }}</li>
            @endforeach
        </ol>
        <input type="hidden" name="{{ 'question'.$question->id }}">
        @endforeach
    </form>
</body>
</html>