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
    <link href="css/paginacion.css" rel="stylesheet" />
    <link href="css/usuario.css" rel="stylesheet" />
    <link href="css/obras.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
@endsection

@section('body')
    <body class="sb-nav-fixed">
    @yield('nav')

    <main class="container">
        <div class="d-lg-flex justify-content-between">
            <div id="izquierda" class="flex-column">
                <h1 id="h1Formulario" data-toggle="collapse" href="#formulario" aria-controls="formulario">Solicitar Nueva Obra <span id="iconoFormulario" class="fa fa-arrow-alt-circle-down"></span></h1>
                <h1 id="h1Formulario2">Solicitar Nueva obra</h1>
                <form class="collapse" id="formulario" method="post" action="{{route('usuario.solicitarObra')}}" enctype="multipart/form-data" onsubmit="return validarSolicitudObra()">
                    @csrf
                    <div id="div-direccion">
                        <h2>Dirección</h2>
                        <div id="div-algolia">
                            <label for="direccion"><b>Direccion:</b> </label> <input type="text" id="direccion" placeholder="Direccion..." />
                        </div>
                        <div>
                            <label for="codpostal"><b>Código postal:</b> </label> <input type="text" id="codpostal" value="" disabled>
                        </div>
                        <div>
                            <label for="calle"><b>Calle:</b> </label> <input type="text" id="calle" value="" disabled>
                        </div>
                        <div>
                            <label for="portal"><b>Nº portal:</b> </label> <input type="text" id="portal" name="portal" placeholder="ej: 18">
                        </div>
                        <div>
                            <label for="piso"><b>Piso:</b> </label> <input type="text" id="piso" name="piso" placeholder="ej: 3C">
                        </div>

                        <input type="hidden" name="latitud" id="latitud" value="">
                        <input type="hidden" name="longitud" id="longitud" value="">
                        <input type="hidden" name="calle" id="calleHidden" value="">
                        <input type="hidden" name="codpostal" id="codpostalHidden" value="">


                    </div>
                    <div id="div-obra">
                        <h2>Obra</h2>
                        <div>
                            <label for="tipoEstructura"><b>Tipo de estructura:</b> </label>
                            <select id="tipoEstructura" name="estructura">
                                @foreach($tiposEstructura as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tipoObra"><b>Tipo de obra:</b> </label>
                            <select id="tipoObra" name="obra">
                                @foreach($tiposObra as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="div-descripcion">
                            <label for="descripcion"><b>Descripción:</b> </label>
                            <textarea placeholder="Escriba una descripción..." id="descripcion" rows="3" name="descripcion"></textarea>
                        </div>

                        <div id="div-archivo">
                            <label for="archivo" id="adjuntarPlano" style="cursor: pointer">Adjuntar plano<span class="fa fa-check-circle" id="iconoArchivo"></span></label>
                            <input type="file" name="archivo" id="archivo">
                        </div>
                    </div>
                    <div id="boton-formulario">
                        <button type="submit">Enviar</button>
                    </div>
                </form>
            </div>
            <div id="derecha" class="">
                <h1>Obras Solicitadas</h1>
                @if(count($obras) > 0)
                @foreach($obras as $obra)
                    <div class="obra">
                        <div class="titulo-obra d-flex justify-content-between" id="obra{{$obra->id}}" data-toggle="collapse" href="#obraCompleta{{$obra->id}}" aria-controls="obraCompleta{{$obra->id}}">
                            <p><b>ID: {{$obra->id}} </b>&nbsp{{ $obra->direccionString }}</p>
                            <div>
                                <span><b>Estado:</b> <span>{{ $obra->estado}}</span></span>
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
                                    <div><b>Técnico:</b> {{$obra->datosTecnico["nombre"]}}</div>
                                    <div><b>Teléfono:</b> {{$obra->datosTecnico["telefono"]}}</div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <div><b>Email:</b> {{$obra->datosTecnico["email"]}}</div>
                                </div>
                            </div>
                            <div>
                                <p><b>Descripción: </b>{{$obra->descripcion}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    <p class="d-flex justify-content-center"><span style="padding: 5px 10px; background: white; border: solid black 1px; border-radius: 5px;font-weight: bold">No tienes obras solicitadas</span></p>
                @endif
                {{ $obras->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </main>
    @yield('footer')
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
    <script src="js/usuario.js"></script>
    <script src="js/principal.js"></script>
    </body>
@endsection
