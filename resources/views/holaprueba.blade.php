<html>
<head>

</head>
<body>
    <h1>Hola has entrado al welcome de prueba creado en views</h1>
    <form method="post" action="{{ Route('insertar') }}" onsubmit="return validarFormulario()">
        @csrf
        <input type="text" name="provincia">
        <input type="submit" value="Enviar" >
    </form>
<a href="random.php">Random.php</a>
<script src="/js/validarFormulario.js"></script>
</body>
</html>
