@extends('layout')
@include('layout_nav')
@include('layout_footer')

@section('body')
    <body>
    <div id="pagina">
    @yield('nav')
    <!-- Masthead-->
        <header class="masthead">

            <div class="container">
                <div class="masthead-subheading">Ayuntamiento de Vitoria-Gasteiz</div>
                <div class="masthead-heading text-uppercase">Permisos de obra</div>
                <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="/login">Iniciar Sesion</a>
            </div>
        </header>
        @yield('footer')
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/principal.js"></script>
    </body>
@endsection

@section('head')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Grupo 1" />
    <title>Ayuntamiento Vitoria-Gasteiz</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <!-- Google fonts-->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/inicio.css" rel="stylesheet" />
    <link href="css/nav.css" rel="stylesheet" />
    <link href="css/footer.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
@endsection
