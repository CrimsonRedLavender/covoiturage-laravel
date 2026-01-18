<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BestMeds - Covoiturage</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/css/style.css">

    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
</head>

<body>

@include('layouts.navigation')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Errors custom uniquement -->
@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<!-- Ces errors sont passés auto par Laravel (validations, etc) -->
@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="container">
    <header>
        <h1>{{ $title ?? '' }}</h1>
    </header>

    {{ $slot }}
</div>


<footer>
    BestMeds - Covoiturage © {{ date('Y') }}
</footer>

</body>
</html>
