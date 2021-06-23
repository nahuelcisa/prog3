var AdministrarValidaciones = function (e) {
    var sueldoMaximo = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());
    var dni = parseInt(document.getElementById("txtDni").value);
    var sueldo = parseInt(document.getElementById("txtSueldo").value);
    var legajo = parseInt(document.getElementById("txtLegajo").value);
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spanTxtApellido", true);
    }
    else {
        AdministrarSpanError("spanTxtDni", false);
    }
    if (!ValidarCamposVacios("txtNombre")) {
        AdministrarSpanError("spanTxtNombre", true);
    }
    else {
        AdministrarSpanError("spanTxtNombre", false);
    }
    if (!ValidarCombo("cboSexo", "---")) {
        AdministrarSpanError("spanCboSexo", true);
    }
    else {
        AdministrarSpanError("spanCboSexo", false);
    }
    if (!ValidarRangoNumerico(dni, 1000000, 55000000)) {
        AdministrarSpanError("spanTxtDni", true);
    }
    else {
        AdministrarSpanError("spanTxtDni", false);
    }
    if (!ValidarRangoNumerico(legajo, 100, 550)) {
        AdministrarSpanError("spanTxtLegajo", true);
    }
    else {
        AdministrarSpanError("spanTxtLegajo", false);
    }
    if (!ValidarRangoNumerico(sueldo, 8000, sueldoMaximo)) {
        AdministrarSpanError("spanTxtSueldo", true);
    }
    else {
        AdministrarSpanError("spanTxtSueldo", false);
    }
    if (!ValidarCamposVacios("file")) {
        AdministrarSpanError("spanFile", true);
    }
    else {
        AdministrarSpanError("spanFile", false);
    }
    e.preventDefault();
    if (ValidarCamposVacios("txtNombre") &&
        ValidarCamposVacios("txtApellido") &&
        ValidarCamposVacios("file") &&
        ValidarCombo("cboSexo", "---") &&
        ValidarRangoNumerico(dni, 1000000, 55000000) &&
        ValidarRangoNumerico(legajo, 100, 550) &&
        ValidarRangoNumerico(sueldo, 8000, sueldoMaximo)) {
        Main.MandarEmpleado();
    }
};
var AdministrarValidacionesLogin = function (e) {
    var dni = parseInt(document.getElementById("txtDni").value);
    if (!ValidarRangoNumerico(dni, 1000000, 55000000)) {
        AdministrarSpanError("spanTxtDni", true);
    }
    else {
        AdministrarSpanError("spanTxtDni", false);
    }
    if (!ValidarCamposVacios("txtApellido")) {
        AdministrarSpanError("spanTxtApellido", true);
    }
    else {
        AdministrarSpanError("spanTxtApellido", false);
    }
    if (!VerificarValidacionesLogin()) {
        e.preventDefault();
    }
};
var ValidarCamposVacios = function (id) {
    var valor = document.getElementById(id).value;
    valor = valor.replace(/ /g, "");
    if (valor === "" || valor == null || valor == undefined) {
        return false;
    }
    return true;
};
var ValidarRangoNumerico = function (numero, min, max) {
    if (numero >= min && numero <= max) {
        return true;
    }
    return false;
};
var ValidarCombo = function (id, incorrecto) {
    var valor = document.getElementById(id).value;
    if (valor !== incorrecto) {
        return true;
    }
    return false;
};
var ObtenerTurnoSeleccionado = function () {
    var elemento = (document.querySelectorAll('input[name="rdoTurno"]'));
    var flag = 0;
    if (elemento != null) {
        for (var i = 0; i < elemento.length; i++) {
            if (elemento[i].checked) {
                return elemento[i].value;
            }
        }
    }
    return "0";
};
var ObtenerSueldoMaximo = function (turno) {
    switch (turno) {
        case "0":
            return 20000;
        case "1":
            return 18500;
        default:
            return 25000;
    }
};
var AdministrarSpanError = function (id, bool) {
    var span = document.getElementById(id);
    if (bool) {
        span.style.display = "block";
    }
    else {
        span.style.display = "none";
    }
};
var VerificarValidacionesLogin = function () {
    var spanDni = document.getElementById("spanTxtDni").style.display;
    var spanApellido = document.getElementById("spanTxtApellido").style.display;
    if (spanDni === "none" && spanApellido === "none") {
        return true;
    }
    return false;
};
var AdministrarModificar = function (dni) {
    var input = document.getElementById("hiddenInput");
    var myForm = document.getElementById('formMostrar');
    input.value = dni;
    myForm.submit();
};
var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this.xhr.open('GET', ruta);
            _this.xhr.send();
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            _this.xhr.open('POST', ruta, true);
            if (typeof (params) == "string") {
                _this.xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            }
            else {
                _this.xhr.setRequestHeader("enctype", "multipart/form-data");
            }
            _this.xhr.send(params);
            _this.xhr.onreadystatechange = function () {
                if (_this.xhr.readyState === Ajax.DONE) {
                    if (_this.xhr.status === Ajax.OK) {
                        success(_this.xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this.xhr.status);
                        }
                    }
                }
            };
        };
        this.xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="ajax.ts" />
window.onload = function () {
    Main.RefrescarPagina();
};
var Main;
(function (Main) {
    Main.RefrescarPagina = function () {
        console.clear();
        //console.log(respuesta);
        MostrarForm();
        Main.MostrarEmpleados();
    };
    Main.MostrarEmpleados = function () {
        var ajax = new Ajax();
        ajax.Post("./backend/mostrar.php", MostrarEmpleadosSuccess);
    };
    function MostrarForm() {
        var ajax = new Ajax();
        ajax.Post("./index.php", MostrarFormSuccess);
    }
    Main.MostrarForm = MostrarForm;
    Main.EliminarEmpleado = function (legajo) {
        var ajax = new Ajax();
        var parametros = "legajo=" + legajo;
        ajax.Get("./backend/eliminar.php", DeleteSuccess, parametros, Fail);
    };
    function MostrarEmpleadosSuccess(empleados) {
        console.clear();
        console.log(empleados);
        document.getElementById("divEmpleados").innerHTML = empleados;
    }
    Main.MostrarEmpleadosSuccess = MostrarEmpleadosSuccess;
    function MostrarFormSuccess(respuesta) {
        console.log(respuesta);
        document.getElementById("divFrm").innerHTML = respuesta;
    }
    Main.MostrarFormSuccess = MostrarFormSuccess;
    function DeleteSuccess(retorno) {
        console.clear();
        console.log(retorno);
        Main.MostrarEmpleados();
    }
    Main.DeleteSuccess = DeleteSuccess;
    function Fail(retorno) {
        console.clear();
        console.log(retorno);
        alert("Ha ocurrido un ERROR!!!");
    }
    Main.Fail = Fail;
    function ModificarEmpleado(dni) {
        var ajax = new Ajax();
        var parametros = "dni=" + dni;
        ajax.Post("./index.php", MostrarFormSuccess, parametros, Fail);
    }
    Main.ModificarEmpleado = ModificarEmpleado;
    function MandarEmpleado() {
        var ajax = new Ajax();
        var dni = document.getElementById("txtDni").value;
        var nombre = document.getElementById("txtNombre").value;
        var apellido = document.getElementById("txtApellido").value;
        var sueldo = document.getElementById("txtSueldo").value;
        var legajo = document.getElementById("txtLegajo").value;
        var turno = ObtenerTurnoSeleccionado();
        var sexo = document.getElementById("cboSexo").value;
        var archivo = document.getElementById("file").files;
        var modificar = document.getElementById("hdnModificar").value;
        var form = new FormData();
        form.append('file', archivo[0]);
        form.append("txtNombre", nombre);
        form.append("txtDni", dni);
        form.append("txtApellido", apellido);
        form.append("txtSueldo", sueldo);
        form.append("txtLegajo", legajo);
        form.append("rdoTurno", turno);
        form.append("cboSexo", sexo);
        form.append("hdnModificar", modificar);
        ajax.Post("./backend/administracion.php", Main.RefrescarPagina, form, Fail);
    }
    Main.MandarEmpleado = MandarEmpleado;
})(Main || (Main = {}));
