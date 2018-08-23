<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Volvo sitemap renew password</title>

</head>
<body>
    <h1>Hello {{ $user->firstname }}</h1>
    <p>
        You can renew your password by <a href="{{ route('auth.renewPassword', ['recoverHash' => $uniqueHash]) }}">clicking here</a>. <br />
        If the link don't work, copy paste it in your browser: {{ route('auth.renewPassword', ['recoverHash' => $uniqueHash]) }}
    </p>
</body>
</html>