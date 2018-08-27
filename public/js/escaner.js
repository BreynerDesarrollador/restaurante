/**
 * Created by windows 8.1 on 01/02/2018.
 */
$(document).ready(function () {
    var mensaje = $("#mensajeescanear");
    let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
    scanner.addListener('scan', function (content) {
        $.post('/clienteescaner', {
            'codigo': content,
            '_token': $('meta[name=csrf-token]').attr('content')
        }, function (data) {
            //Materialize.toast(data, 4000);
            if (data.mensaje == "OK") {
                location.href = "/cliente";
            } else {
                Materialize.toast(data.mensaje, 4000);
            }
        }).fail(function (error) {
            mensaje.html('Error:' + error.responseText);
            Materialize.toast('Error:' + error.responseText, 4000);
        });
        //Materialize.toast(content, 4000);
    });
//if (!'{collect(session()->get('cliente'))}}') {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            if (cameras.length == 1) {
                scanner.start(cameras[0]);
            } else {
                scanner.start(cameras[1]);
            }

        } else {
            Materialize.toast('No se pudo conectar con la camara.', 4000);
            mensaje.html('No se ha podido acceder a la camara, por favor <a href=\"/cliente\">recargue nuevamente la pagina.</a>');
        }
    }).catch(function (e) {
        Materialize.toast(e.responseText, 4000);
        mensaje.html('A ocurrido un error: \n:' + e.message + "\n <a href=\"/cliente\">recargue nuevamente la pagina.</a>");
    });
//}
});
