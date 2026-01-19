<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>


</head>
<body>
<header>
    @if (Route::has('login'))
        <nav>
            @auth
                <a
                    href="{{ url('/dashboard') }}"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                    >
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>
<div>
    <main>
    </main>
</div>

@if (Route::has('login'))
    <div></div>
@endif
</body>
</html>
