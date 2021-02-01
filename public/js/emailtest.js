function validacion() {
    if ($('#exampleInputEmail1').val() == '') {
        $('#exampleInputEmail1').css("border", "red solid 1px");
        return false;
    }
    else {
        return true;
    }
}
