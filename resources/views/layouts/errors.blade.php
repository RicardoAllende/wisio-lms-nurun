@if ($errors->any())
    <div class="alert alert-danger">
        <h6>Corrija los errores de abajo:</h6>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif