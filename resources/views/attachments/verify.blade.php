<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verificación de los attachments</title>
</head>
<body>
    <table>
        <?php $i = 1; ?>
        @foreach($attachments as $attachment)
        <tr>
            <td><a href="/{{ $attachment->url }}" target="_blank">{{ $attachment->url }}</a></td>
            <td><?php if (file_exists($attachment->url)) { echo 'ok'; } else { echo 'Este recurso no existe'; } ?></td>
        </td>
        @endforeach
    </table>
</body>
</html>