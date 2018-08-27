/**
 * Created by windows 8.1 on 01/02/2018.
 */
$(document).ready(function(){
    ocultarcargando();
});
function mostrarcargando() {
    $('#cargando').fadeIn('slow');
    $('#cuerpocargando').fadeIn('slow');
}
function ocultarcargando() {
    $('#cargando').fadeOut('slow');
    $('#cuerpocargando').fadeOut('slow');
}