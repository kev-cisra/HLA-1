<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name='robots' content='noindex,nofollow' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HilaturasLosAngeles') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicons/logo_Original.png') }}" />
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" media="all" >
        <link href="{{asset('css/Welcome.css')}}" rel="stylesheet" media="all" >
        <link rel="stylesheet" href="{{ asset('css/cards.css') }}" media="all" >
        <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="all" >
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" media="all" >

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="tw-bg-gray-100">
        @inertia
        @include('sweetalert::alert')

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
