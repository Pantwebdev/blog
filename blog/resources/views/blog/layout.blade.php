<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'BharatVerify Blog')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">BharatVerify Blog</a>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="text-center py-4 text-muted mt-5 border-top">
        &copy; {{ date('Y') }} BharatVerify.com
    </footer>
</body>
</html>
