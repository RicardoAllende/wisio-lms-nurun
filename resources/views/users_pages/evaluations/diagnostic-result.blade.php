<div><br>
    <h4>Resultados de la evaluación: {{ $evaluation->name }}</h4><br>
    <p>Preguntas contestadas correctamente: {{ $summatory }} de {{ $numQuestions }}</p><br>
    <p>Calificación: {{ round($evaluationAverage, 2) }} </p>
    <br>
</div>