$(document).ready;
{
    $('input').click(function () {
        $('#first-name').css("border", "#e6e6e6 solid 1px");
        $('#pass2').css("border", "#e6e6e6 solid 1px");
    });
    $('#mensaje').css('display', 'none');
}
function validar() {
    if ($('#first-name').val() == '' && $('#pass2').val() == '') {
        $('#first-name').css("border", "red solid 1px");
        $('#pass2').css("border", "red solid 1px");
        return false;
    }
    else {
        if ($('#first-name').val() == $('#pass2').val()) {
            var cadena = $('#first-name').val();
            var patt = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\\[-`{-~]).{6,64}$');
            if (patt.test(cadena)) {
                return true;
            }
            else {
                $('#first-name').css("border", "red solid 1px");
                $('#mensaje').css('display', 'inline-block');
                return false;
            }
        }
        else {
            $('#pass2').css("border", "red solid 1px");
            return false;
        }
    }
}
/*^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$*/
