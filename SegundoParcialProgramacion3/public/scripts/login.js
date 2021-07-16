"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://scaloneta/";
$(function () {
    $("#btnEnviar").on("click", function (e) {
        Login(e);
    });
    $("#btnRegistro").on("click", function () {
        IrRegistro();
    });
});
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    return alerta;
}
function IrRegistro() {
    $.ajax({
        type: 'GET',
        url: APIREST + "registro",
        async: true
    })
        .done(function (resultado) {
        $(location).attr('href', APIREST + "registro");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error en redireccion " + errorThrown);
    });
}
function Login(e) {
    e.preventDefault();
    var correo = $("#correo").val();
    var clave = $("#clave").val();
    var dato = {};
    dato.correo = correo;
    dato.clave = clave;
    $.ajax({
        type: 'POST',
        url: APIREST + "login",
        dataType: "json",
        data: { "user": JSON.stringify(dato) },
        async: true
    })
        .done(function (resultado) {
        var mensaje = 'Usuario válido!';
        var tipo = 'success';
        if (resultado.exito) {
            localStorage.setItem("token", resultado.jwt);
            $(location).attr('href', APIREST + "principal");
        }
        else {
            mensaje = resultado.mensaje;
            tipo = 'danger';
            var alerta = ArmarAlert(mensaje, tipo);
            $("#divResultado").html(alerta);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
//# sourceMappingURL=login.js.map