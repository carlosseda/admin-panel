<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje</title>
</head>
<body>
    <h2>Un usuario ha enviado un mensaje desde el formulario de contacto de la web.</h2>

    <p>Se llama {{$contact->name}} y su correo electrónico es {{$contact->email}}:</p>
    <p>"{{$contact->message}}"</p>
</body>
</html>
