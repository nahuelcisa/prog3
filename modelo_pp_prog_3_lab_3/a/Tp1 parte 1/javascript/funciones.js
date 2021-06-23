var AdministrarValidaciones = function (e) {
    if (!ValidarCamposVacios("txtApellido") ||
        !ValidarCamposVacios("txtNombre")) {
        alert("Uno o mas de un campo esta vacio.");
        e.preventDefault();
        return;
    }
    var dniObtenido = document.getElementById("txtDni").value;
    var legajoObtenido = document.getElementById("txtLegajo").value;
    var sueldoObtenido = document.getElementById("txtSueldo").value;
    var sueldoMax = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    if (!ValidarRangoNumerico(parseInt(dniObtenido), 1000000, 55000000)) {
        alert("Dni incorrecto.");
        e.preventDefault();
        return;
    }
    if (!ValidarRangoNumerico(parseInt(legajoObtenido), 100, 550)) {
        alert("Legajo incorrecto.");
        e.preventDefault();
        return;
    }
    if (!ValidarRangoNumerico(parseInt(sueldoObtenido), 8000, sueldoMax)) {
        alert("Sueldo incorrecto.");
        e.preventDefault();
        return;
    }
    if (!ValidarCombo("cboSexo", "---")) {
        alert("Seleccione sexo");
        e.preventDefault();
        return;
    }
};
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
