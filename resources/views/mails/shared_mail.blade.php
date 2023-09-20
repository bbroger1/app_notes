<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Convite App Notes</title>
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <p>Olá, {{ $mailData['email'] }}</p>
    <p>Você foi convidado por {{ $mailData['user'] }} para se registrar em nosso sistema.</p>
    <p>Clique no link abaixo e faça o seu cadastro:</p>

    <a href="{{ $mailData['link'] }}" class="btn">App Notes</a>

    <p>Aguardamos você.</p>
</body>

</html>
