<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="@yield('bodyclass')">

    <header class="header">
        @include('includes.header')
    </header>

    <section class="section">
        @yield('content')
    </section>

    <footer class="footer">
        @include('includes.footer')
    </footer>

</body>
</html>