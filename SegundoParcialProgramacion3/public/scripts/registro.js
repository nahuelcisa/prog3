"use strict";
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://scaloneta/";
$(function () {
    $("#btnEnviarRegistro").on("click", function (e) {
        Registro(e);
    });
});
function Registro(e) {
    e.preventDefault();
    var correo = $("#txtCorreo").val();
    var clave = $("#txtClave").val();
    var nombre = $("#txtNombre").val();
    var apellido = $("#txtApellido").val();
    var perfil = $("#dpPerfil").val();
    var foto = $("#foto").prop("files")[0];
    var param = {
        "correo": correo,
        "clave": clave,
        "nombre": nombre,
        "apellido": apellido,
        "perfil": perfil,
    };
    var form = new FormData();
    var usuario = JSON.stringify(param);
    form.append("usuario", usuario);
    form.append("foto", foto);
    $.ajax({
        type: 'POST',
        url: APIREST + "usuarios",
        dataType: "json",
        data: form,
        async: true,
        contentType: false,
        processData: false
    }).done(function (resultado) {
        var mensaje = 'Usuario válido!';
        var tipo = 'success';
        if (resultado.exito) {
            alert(resultado.mensaje);
            $(location).attr('href', APIREST + "loginusuarios");
        }
        else {
            mensaje = resultado.mensaje;
            tipo = 'danger';
            var alerta = ArmarAlert(mensaje, tipo);
            $("#divResultado").html(alerta);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error en agregar " + errorThrown);
    });
}
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    return alerta;
}
//# sourceMappingURL=registro.js.map