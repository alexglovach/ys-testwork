<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YT-Testwork by AG</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    {!! Form::open() !!}
    {!! Form::label('domain', 'Enter domain:') !!}<br>
    {!! Form::text('domain') !!}<br>
    {!! Form::submit('Check') !!}<br>
    {!! Form::close() !!}
    @isset($messages)
        @isset($messages["domain"])
            <p>Domain: {{$messages['domain']}}</p>
        @endisset
        @isset($messages["status"])
            <p>Site status is {{$messages['status']}} {{$messages['phrase']}} </p>
        @endisset
        @isset($messages["time"])
            <p>Site downloaded in {{$messages["time"]}}</p>
        @endisset
        @if($messages["error"])
            <p>{{$messages["errorMessage"]}}</p>
        @endif
    @endisset

</div>
</body>
</html>
