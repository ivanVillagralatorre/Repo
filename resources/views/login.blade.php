<!DOCTYPE html>
<html lang="es">
<head>
	<title>AyuntamientoDeVitoria</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="img/logo.jpg"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">



</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">



				<form method="post" action="{{route('login')}}" class="login100-form validate-form formulario">
					@csrf



                    <img class="logo"src="img/logo.jpg">

					<span class="login100-form-title p-b-34">
						Introduce Tus Creedenciales
					</span>


					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user dni">
						<input id="first-name" class="input100" type="text" name="dni" placeholder="DNI/NIf">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
						<span class="focus-input100"></span>
					</div>
                    <div class= "dis-block input100 dis-flex">
                        <label for="rol" class="txt1  "><p style="font-size: 170%;">Permiso:</p></label>
                    </div>

                    <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                       <select style="border-color: lightgray" class="input100" name="rol" id="rol" >
                                @foreach($roles   as $rol)
                                    <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                           @endforeach
                        </select>
                        <span class="focus-input100"></span>
                    </div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							entrar
						</button>
					</div>

					<div class="w-full text-center p-t-27 p-b-239">
						<span class="txt1 ">
							Olvidaste tu
                            <a href="/emailtestform" class="txt2">
							 Contraseña?
						</a>|<a href="/registro" class="txt2">
							 Registrate
						</a>
						</span>


                        <div style="display:{{$dato ?? 'none'}}"class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error</strong> Usuario  No Encontrado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                       @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error</strong>Tipo de datos invalidos.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @isset($registro)
                            <div class="alert alert-success" role="alert">
                                Registro realizado exitosamente, inicia sesión
                            </div>
                        @endisset
					</div>

					<div class="w-full text-center">
						<a href="/" class="txt3">
							Pagina principal
						</a>
					</div>
				</form>


				<div class="login100-more" style="background-image: url('img/bg-01.jpg');"></div>
			</div>
		</div>
	</div>



	<div id="dropDownSelect1"></div>



    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
    <script src="js/prueba.js"></script>

</body>
</html>
