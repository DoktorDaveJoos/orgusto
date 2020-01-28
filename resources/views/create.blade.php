<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="w-1/2">

        <form method="POST" action="/reservations">
            @csrf
            <div class="flex flex-col">

                <label for="name">Name</label>
                <input id="name" name="name" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="person_count">Personen</label>
                <input id="person_count" name="person_count" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="starting_at">Wann</label>
                <input id="starting_at" name="starting_at" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="length">Wie lange</label>
                <input id="length" name="length" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="notice">Notiz</label>
                <input id="notice" name="notice" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="accepted_from">Von wem?</label>
                <input id="accepted_from" name="accepted_from" type="text" class="@error('title') is-invalid @enderror">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button class="bg-blue-800 text-white" type="submit">Press me</button>
            </div>


        </form>
    </div>


</body>

</html>