<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
</head>
<body>
    <h3>Saludos, {{ $user->name . ' ' . $user->surname }}</h3>
    <p>Gracias por registrarte como <strong>{{ $user->role }}</strong> en API Biblioteca.</p>
    <p>¡Bienvenido!</p>
</body>
</html>
