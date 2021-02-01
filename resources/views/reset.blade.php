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



            <form method="post" action="{{route('reset')}}"  onsubmit=" return validar()"  id="form"  class="login100-form validate-form formulario">

                @csrf
                @method('PATCH')
                <input hidden name="correo" value="{{$_GET['email']}}">
                <img class="logo"src="img/logo.jpg">

                <span class="login100-form-title p-b-34">
						Introduce Tu Nueva contraseña
					</span>


                <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user dni">
                    <input type="password" id="first-name" class="input100" type="text" name="pass1" placeholder="contraseña">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
                    <input class="input100"  id="pass2" type="password" name="pass2" placeholder="Repite la contraseña">
                    <span class="focus-input100"></span>
                </div>
                <div class= "dis-block input100 dis-flex">

                </div>



                <div class="container-login100-form-btn">
                    <button type="submit" id="enviar" class="login100-form-btn">
                        Enviar
                    </button>
                </div>

                <div class="w-full text-center p-t-27 p-b-239">
                    <div id="mensaje" class="alert alert-danger alert-dismissible fade show" role="alert">
                        Formato de contraseña erroneo ejemplo:Jm123456$

                    </div>



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
<script src="js/reset.js"></script>

</body>
</html>
