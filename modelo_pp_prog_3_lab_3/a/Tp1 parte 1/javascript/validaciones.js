var ValidarCamposVacios = function (id) {
    var valor = document.getElementById(id).value;
    valor = valor.replace(/ /g, "");
    if (valor === "" || valor == undefined) {
        return false;
    }
    return true;
};
var ValidarRangoNumerico = function (num, numMinimo, numMaximo) {
    if (num >= numMinimo && num <= numMaximo) {
        return true;
    }
    return false;
};
var ValidarCombo = function (id, valIncorrecto) {
    var valor = document.getElementById(id).value;
    if (valor !== valIncorrecto) {
        return true;
    }
    return false;
};
var ObtenerTurnoSeleccionado = function () {
    var elemento = (document.querySelectorAll('input[name="rdoTurno"]'));
    var valor = 0;
    var turno = "";
    for (var i = 0; i < elemento.length; i++) {
        if (elemento[i].checked) {
            valor = parseInt(elemento[i].value);
            break;
        }
    }
    switch (valor) {
        case 0:
            turno = "Mañana";
            break;
        case 1:
            turno = "Tarde";
            break;
        case 2:
            turno = "Noche";
            break;
    }
    return turno;
};
var ObtenerSueldoMaximo = function (turno) {
    switch (turno) {
        case "Mañana":
            return 20000;
        case "Tarde":
            return 18500;
        default:
            return 25000;
    }
};
