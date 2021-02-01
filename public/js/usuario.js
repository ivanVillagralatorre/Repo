$('#formulario').on('show.bs.collapse', function() {
    $("#iconoFormulario").addClass('fa fa-arrow-alt-circle-up').removeClass('fa fa-arrow-alt-circle-down');
});

$('#formulario').on('hide.bs.collapse', function() {
    $("#iconoFormulario").addClass('fa fa-arrow-alt-circle-down').removeClass('fa fa-arrow-alt-circle-up');
});

$('#archivo').change(function (){
        if ($("#archivo").val()== ""){
            $("#iconoArchivo").css("display","none");
        }else{
            $("#iconoArchivo").css("display","inline");
        }

});

var evento = "";
var archivoValido = true;

(function() {
    var placesAutocomplete = places({
        appId: 'pl56I4LZML91',
        apiKey: 'bc9d59afe10c3766fd6fba61355e38be',
        container: document.querySelector('#direccion')
    });

    placesAutocomplete.on('change',function (e){
        evento = e.suggestion;
        autocompletarInputsDireccion();
    });

    $('#direccion').blur(function (){
        if (evento == ""){
            $('#latitud').val("");
            $('#longitud').val("");
            $('#codpostal').val("");
            $('#calle').val("");
            $('#codpostalHidden').val("");
            $('#calleHidden').val("");
            $('#direccion').val("");
        }else{
            $('#direccion').val(evento.value);
        }
    })

})();

$("#archivo").change(function (){
    let archivo = $('#archivo').val();
    if (archivo != ""){
        let extension = archivo.substring(archivo.lastIndexOf('.'), archivo.length);
        extension = extension.substring(1,extension.length);
        if (extension == "jpg" || extension=="jpeg" ||extension == "png" || extension== "pdf"){
            $("#iconoArchivo").addClass('fa fa-check-circle').removeClass('fa fa-arrow-alt-circle-up');
            $("#adjuntarPlano").css('background-color','forestgreen');
            archivoValido = true;
        }else{
            archivoValido = false;
            $("#iconoArchivo").addClass('fa fa-exclamation-triangle').removeClass('fa fa-check-circle');
            $("#adjuntarPlano").css('background-color','red');
        }
    }else{
        archivoValido = true;
        $("#adjuntarPlano").css('background-color','forestgreen');
    }
})

function validarSolicitudObra(){
    let errores = [];
    let correctos = [];

    if(evento == ""){
        errores.push('.algolia-places');
    }else{
        correctos.push('.algolia-places');
        autocompletarInputsDireccion();
    }

    if (!validarPortal()){
        errores.push('#portal');
    }else{
        correctos.push('#portal');
    }

    if (!validarPiso()){
        errores.push('#piso');
    }else{
        correctos.push('#piso');
    }

    if (!validarDescripcion()){
        errores.push('#descripcion');
    }else{
        correctos.push('#descripcion');
    }

    if (errores.length == 0 && archivoValido){
        return true;
    }else{
        aplicarEstilosError(errores);
        aplicarEstilosCorrecto(correctos);
        return false;
    }


}

function autocompletarInputsDireccion(){
    $('#latitud').val(evento.latlng.lat);
    $('#longitud').val(evento.latlng.lng);
    $('#codpostal').val(evento.postcode);
    $('#calle').val(evento.name);
    $('#codpostalHidden').val(evento.postcode);
    $('#calleHidden').val(evento.name);
}

function validarPortal(){
    let portal = $('#portal').val();
    let patron = RegExp('^[1-9][0-9]{0,2}$');
    if (portal == "" || !patron.test(portal)){
        return false;
    }
    return true;
}

function validarPiso(){
    let piso = $('#piso').val();
    let patron = RegExp('^[1-9][0-9]{0,1}[A-z]$');
    if (piso == "" || !patron.test(piso)){
        return false;
    }
    return true;
}

function validarDescripcion(){
    let desc = $('#descripcion').val();
    if (desc == "" || desc.length > 1000){
        return false;
    }
    return true;
}

function aplicarEstilosError(errores){
    errores.forEach(e => $(e).css('border','solid red 1px'));
    if (errores[0]==".algolia-places"){
        $('#direccion').focus();
    }else{
        $(errores[0]).focus();
    }

}

function aplicarEstilosCorrecto(correctos){
    correctos.forEach(e => $(e).css('border','solid black 1px'));
}
