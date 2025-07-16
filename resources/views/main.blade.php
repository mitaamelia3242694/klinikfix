<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Klinik')</title>
    <link rel="stylesheet" href="{{ asset('css/blank.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="container">

        @include('partials.sidebar')

        <main class="main">
            @include('partials.header')

            <section class="blank-content">
                @yield('content')
            </section>

        </main>
    </div>
</body>

</html>
