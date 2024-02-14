<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME')}}</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css'])
    </head>
    <body class="antialiased">

        <div id="app"></div>

        @vite(['resources/js/app.js'])

        <script>
        window.AppConfig = {
            name: '{{ env('APP_NAME') }}',
            url: '{{ env('APP_URL') }}',
            csrf: '{{ csrf_token() }}',
        }
    </script>
    </body>
    <noscript>
        <strong>We're sorry but this application doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
</html>
