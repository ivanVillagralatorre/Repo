@extends('layout')
@include('layout_nav')
@include('layout_footer')

@section('head')
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ayuntamiento Vitoria-Gasteiz</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/nav.css" rel="stylesheet" />
    <link href="css/footer.css" rel="stylesheet" />
    <link href="css/tecnico.css" rel="stylesheet" />
    <link href="css/paginacion.css" rel="stylesheet" />
    <link href="css/obras.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script src="js/tecnico.js"></script>
@endsection

@section('body')
    <body class="sb-nav-fixed">
    @yield('nav')

    <main class="container">
        <div class="d-lg-flex justify-content-between">
            <div id="izquierda" class="flex-column">
                <h1>Obras pendientes por aceptar</h1>
                @if(count($obrasSolicitadas) != 0)
                    @foreach($obrasSolicitadas as $obra)
                        <div class="obra">
                            <div class="titulo-obra d-flex justify-content-between" id="obra{{$obra->id}}" data-toggle="collapse" href="#obraCompleta{{$obra->id}}" aria-controls="obraCompleta{{$obra->id}}">
                                <p><b>ID: {{$obra->id}} </b>&nbsp{{ $obra->direccionString }}</p>
                                <div>
                                    <span><b>Estado:</b> <span>{{ $obra->estadoString}}</span></span>
                                </div>
                            </div>

                            <div id="obraCompleta{{$obra->id}}" class="collapse cuerpo-obra">
                                <div class="">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Estructura:</b> {{$obra->tipo_estructura}}</div>
                                        <div><b>Obra:</b> {{$obra->tipo_obra}}</div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Fecha de inicio:</b> {{$obra->fecha_inicio}}</div>
                                        <div><b>Fecha final:</b> {{$obra->fecha_fin}}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Solicitante:</b> {{$obra->datosSolicitante["nombre"]}}</div>
                                        <div><b>Teléfono:</b> {{$obra->datosSolicitante["telefono"]}}</div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <div><b>Email:</b> {{$obra->datosSolicitante["email"]}}</div>
                                    </div>
                                </div>
                                <div>
                                    <p><b>Descripción: </b>{{$obra->descripcion}}</p>
                                </div>
                                @if($obra->plano != null)
                                    <div class="d-flex justify-content-center">
                                        <a href="/public/{{$obra->plano}}" class="botonDescargar">Descargar plano</a>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between flex-wrap" style="margin-top: 40px">
                                    <a href="/tecnico/obra/aceptar/{{$obra->id}}" class="botonAceptarObra">Aceptar</a>
                                    <button href="#" data-toggle="modal" data-target="#ventana-confirm{{ $obra->id }}" class="botonDenegarObra">Denegar</button>
                                </div>

                            </div>
                            <div class="modal fade" id="ventana-confirm{{ $obra->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Denegar Solicitud</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="background-color: white; border: 0">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">¿Estas seguro de que quieres denegar esta solicitud?</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                            <a class="btn btn-primary" style="background-color: #d11f1f; border: 0" href="/tecnico/obra/denegar/{{$obra->id}}">Denegar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="d-flex justify-content-center"><span style="padding: 5px 10px; background: white; border: solid black 1px; border-radius: 5px;font-weight: bold">No tienes obras pendientes por aceptar</span></p>
                @endif
            </div>
            <div id="derecha" class="">
                <h1 id="h1Formulario2">Obras a cargo</h1>
                @if(count($obrasAceptadas) != 0)
                    @foreach($obrasAceptadas as $obra)
                        <script>crearMarcadorMapa({{$obra->latitud}},{{$obra->longitud}})</script>
                        <div class="obra">
                            <div class="titulo-obra d-flex justify-content-between" id="obra{{$obra->id}}" data-toggle="collapse" href="#obraCompleta{{$obra->id}}" aria-controls="obraCompleta{{$obra->id}}">
                                <p><b>ID: {{$obra->id}} </b>&nbsp{{ $obra->direccionString }}</p>
                                <div>
                                    <span><b>Estado:</b> <span>{{ $obra->estadoString}}</span></span>
                                </div>
                            </div>

                            <div id="obraCompleta{{$obra->id}}" class="collapse cuerpo-obra">
                                <div class="">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Estructura:</b> {{$obra->tipo_estructura}}</div>
                                        <div><b>Obra:</b> {{$obra->tipo_obra}}</div>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Fecha de inicio:</b> {{$obra->fecha_inicio}}</div>
                                        <div><b>Fecha final:</b> {{$obra->fecha_fin}}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div><b>Solicitante:</b> {{$obra->datosSolicitante["nombre"]}}</div>
                                        <div><b>Teléfono:</b> {{$obra->datosSolicitante["telefono"]}}</div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <div><b>Email:</b> {{$obra->datosSolicitante["email"]}}</div>
                                    </div>
                                </div>
                                <div>
                                    <p><b>Descripción: </b>{{$obra->descripcion}}</p>
                                </div>
                                @if($obra->plano != null)
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <a href="/public/{{$obra->plano}}" class="botonDescargar">Descargar plano</a>
                                        @if($obra->estado != 4)
                                            <a href="tecnico/{{$obra->estado."/".$obra->id}}" class="botonCambiarEstado">{{$obra->mensajeCambiarEstado ?? "Avanzar estado"}}</a>
                                        @endif
                                    </div>
                                @else
                                    @if($obra->estado != 4)
                                        <div class="d-flex justify-content-center">
                                            <a href="tecnico/{{$obra->estado."/".$obra->id}}" class="botonCambiarEstado">{{$obra->mensajeCambiarEstado ?? "Avanzar estado"}}</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="d-flex justify-content-center"><span style="padding: 5px 10px; background: white; border: solid black 1px; border-radius: 5px;font-weight: bold">No tienes obras a cargo</span></p>
                @endif
                {{ $obrasAceptadas->links('pagination::bootstrap-4') }}
                <h1>Geolocalización de las obras</h1>
                <div id="map">

                </div>
                <script>
                    inicializarMapa();
                    establecerMarcadores();
                </script>
            </div>
        </div>
    </main>
    @yield('footer')
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/usuario.js"></script>
    <script src="js/principal.js"></script>
    </body>
@endsection
