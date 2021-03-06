﻿<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gerência Rural</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-image: url("{{asset('img/fundo.jpg')}}");
            background-repeat: no-repeat;
            background-size: cover;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 70%;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 10px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .navbar-custom {
            background: linear-gradient(white 30%, transparent);
            color: #ffffff;
            padding: 40px;
        }

        .links>a {
            color: black;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    @if (Route::has('login'))
    <nav class="navbar-custom">
        @auth
        <div class="top-right links">
            <a href="{{ url('/home') }}">Home</a>
        </div>
        @else
        <div class="top-right links">
            <a href="{{ route('login') }}">Login</a>
        </div>
        @endauth
    </nav>
    @endif
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="content">

            <div class="title m-b-md">
                <img src="{{ asset('img/tec.svg') }}" style="width:70%;">
            </div>

        </div>
    </div>
</body>

</html>