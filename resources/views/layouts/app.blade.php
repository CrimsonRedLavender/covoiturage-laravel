<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BestMeds - Covoiturage</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

{{-- Single unified navigation --}}
@include('layouts.navigation')

<!-- PAGE CONTENT -->
<div class="container">
    <header>
        <h1>{{ $title ?? '' }}</h1>
    </header>

    {{ $slot }}
</div>

<!-- FOOTER -->
<footer>
    BestMeds - Covoiturage © {{ date('Y') }}
</footer>

</body>
</html>
