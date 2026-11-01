<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Music App - @yield('title')</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #333; font-size: 16px; margin: 20px; }
        a { color: #e02576; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .header { border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-weight: bold; font-size: 20px; margin-right: 20px; }
        .footer { border-top: 1px solid #ccc; padding-top: 10px; margin-top: 40px; font-size: 14px; color: #777; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .error { color: red; font-size: 14px; margin-top: 5px; }
        .success { color: green; font-weight: bold; margin: 10px 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
    </style>
</head>
<body>
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>