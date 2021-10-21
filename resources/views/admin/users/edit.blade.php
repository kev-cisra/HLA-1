<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HilaturasLosAngeles') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicons/logo_Original.png') }}" />
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased uppercase">
        <div class="tw-w-full tw-flex tw-flex-wrap tw-content-center tw-my-8">

            {!! Form::model($user, ['route'=> ['admin.users.update', $user], 'method' => 'put']) !!}

            <div class="tw-p-4 tw-justify-center tw-items-center md:tw-flex md:tw-flex-wrap tw-uppercase tw-gap-4 md:tw-gap-4">
                @foreach ($roles as $role)
                    <div class="tw-block sm:tw-flex sm:tw-flex-col tw-w-full md:tw-w-1/6 tw-my-2 tw-justify-center tw-items-center tw-p-2 tw-bg-violet-400 tw-rounded-full tw-border-2 tw-border-violet-600">
                        <label class="tw-items-center">
                            {!! Form::checkbox('roles[]', $role->id, null,
                            ['class'=> 'tw-form-checkbox tw-w-6 tw-h-6 tw-rounded-full tw-bg-white tw-border-4 tw-appearance-none tw-cursor-pointer tw-text-violet-600']) !!}
                            <span class="tw-ml-2 tw-text-black tw-font-bold tw-text-xs">{{$role->name}}</span>
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="tw-flex tw-justify-center tw-mx-48">
                {!! Form::submit('Asigna o modifica Roles', ['class'=>'tw-uppercase tw-mt-8 tw-w-full tw-bg-blueGray-400 tw-text-gray-800 tw-font-bold tw-rounded tw-border-b-2 tw-border-sky-500 hover:tw-border-sky-600 hover:tw-bg-sky-500 hover:tw-text-white tw-shadow-md tw-py-2 tw-px-6 tw-inline-flex tw-items-center']) !!}
            {!! Form::close() !!}
            </div>

            @if (session('info'))
                <div class="tw-w-full tw-p-4 tw-mx-32 tw-mt-14 tw-bg-green-100 tw-border-l-4 tw-border-green-500 tw-text-green-700" role="alert">
                    <p class="tw-font-bold">Exito!!</p>
                    <p>{{session('info')}}</p>
                </div>
            @endif
        </div>

    </body>
</html>
