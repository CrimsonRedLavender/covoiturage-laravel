{{-- resources/views/components/head.blade.php --}}
<title>{{ $title ?? 'My App' }}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

@vite(['resources/css/app.css', 'resources/js/app.js'])

{{ $slot }}
