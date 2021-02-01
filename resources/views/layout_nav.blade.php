

@section('nav')
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container">
            <img src="img/logos/logo.jpg" alt="logo" class="img-fluid" id="logo" />
            @if($botonNav == 'INICIAR SESION')
            <button class="navbar-toggler navbar-toggler-right d-lg-block" onclick="redireccionarLogin()">
                {{ $botonNav }}
            </button>
            @else
                <button class="navbar-toggler navbar-toggler-right d-lg-block" href="#" data-toggle="modal" data-target="#ventana-logout">
                    {{ $botonNav }}
                </button>

                <div class="modal fade" id="ventana-logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cerrar sesión</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="background-color: white; border: 0">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">¿Estas seguro de que quieres cerrar sesión?</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                <a class="btn btn-primary" style="background-color: forestgreen; border: 0" href="/">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </nav>
@endsection

