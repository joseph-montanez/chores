<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            font-size: 10px;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Helvetica Neue', 'Segoe UI', 'Roboto', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
            font-size: 14px;
            line-height: 1.6;
        }

        h1 {
            font-weight: 600;
            font-size: 36px;
            line-height: 100px;
            margin: 0;
        }

        h2 {
            font-family: inherit;
            font-weight: 600;
            line-height: 1.1;
        }

        a {
            color: #3097D1;
            text-decoration: none;
        }

        a {
            background-color: transparent;
        }

        .btn-lg, .btn-group-lg > .btn {
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.3333333;
            border-radius: 6px;
        }
        .btn-primary {
            color: #fff;
            background-color: #3097D1;
            border-color: #2a88bd;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            width: 100%;
        }

        h2 {
            color: #fff;
            font-size: 3em;
            text-shadow: 0 0 17px rgba(0, 0, 0, 1);
            margin: 0 0 20px;
            display: block;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .hero-bg {
            background: #222;
            height: 200px;
            width: 100%;
            clear: both;
            margin-bottom: 20px;
            background: url({{@full_asset('images/person-looking-searching-clean-1.jpg')}}) no-repeat center center;
            background-size: cover;
            background-color: rgba(0, 0, 0, 0.5);
            background-blend-mode: darken;
        }

        @media (min-width: 641px) and (max-width: 1024px) {
            .hero-bg {
                background-size: cover;
                background: rgba(0, 0, 0, 0.5) url({{@full_asset('images/person-looking-searching-clean-2.jpg')}}) no-repeat center center;
                background-blend-mode: darken;
                height: 468px;
            }
        }

        @media (min-width: 1025px) and (max-width: 1500px) {
            .hero-bg {
                background-size: cover;
                background: rgba(0, 0, 0, 0.5) url({{@full_asset('images/person-looking-searching-clean-3.jpg')}}) no-repeat center center;
                background-blend-mode: darken;
                height: 468px;
            }
        }

        @media (min-width: 1501px) {
            .hero-bg {
                background-size: cover;
                background: rgba(0, 0, 0, 0.5) url({{@full_asset('images/person-looking-searching-clean-4.jpg')}}) no-repeat center center;
                background-blend-mode: darken;
                height: 468px;
            }
        }

        .hero-content {
            position: relative;
            display: -webkit-box;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            height: 100%;
        }

        .col, .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .col, .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }

        @media (min-width: 992px) {
            .col-md-9 {
                float: left;
                width: 75%;
            }

        }

        @media (max-width: 767px) {
            .top-right {
                margin-top: 10px;
                margin-bottom: -15px;
                display: block;
                position: inherit;
                text-align: center;
            }
        }

        @media (min-width: 768px) {
            .col-sm-offset-1 {
                margin-left: 8.33333333%;
            }
            .col-sm-3 {
                float: left;
                width: 25%;
            }
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }
    </style>
</head>
<body>
@if (Route::has('login'))
    <div class="top-right links">
        @if (Auth::check())
            <a href="{{ @full_url('/home') }}">Home</a>
        @else
            <a href="{{ @full_url('/login') }}">Log In</a>
            <a href="{{ @full_url('/register') }}">Register</a>
        @endif
    </div>
@endif

<div class="content">

    <h1>{{ config('app.name') }}</h1>
    <div class="hero-bg">
        <div class="hero-content">
            <div>
                <h2>Who's turn is it for laundry?</h2>
                <a href="{{ @full_url('/register') }}" class="btn-lg btn-primary">Let's Get Started</a>
            </div>
        </div>
    </div>

    <h3>We Save You Time!</h3>
    <div class="col-md-9 col-centered">
        <div class="col-sm-3 col-sm-offset-1">
            <h4>Daily Chores</h4>
            <p>Multiple times a day, weekly, twice a week. Its all possible</p>
        </div>
        <div class="col-sm-3 col-sm-offset-1">
            <h4>Distribute Work</h4>
            <p>Chores can be assigned randomly, or each person can take turns.</p>
        </div>
        <div class="col-sm-3 col-sm-offset-1">
            <h4>Device Ready</h4>
            <p>Want it on your phone, tablet or even a print out?</p>
        </div>
    </div>
</div>

</body>
</html>
