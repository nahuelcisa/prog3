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
        "perfil": perfil
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
/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://scaloneta/";
/* #region   Funcion main jquery(los onclick)*/
$(function () {
    VerificarJWT();
    $("#usuarios").on("click", function () {
        ArmarTablaUsuarios();
    });
    $("#autos").on("click", function () {
        ArmarTablaAutos();
    });
    //$("#btnApellido").on("click", function () {
    //     ArmarTablaUsuariosPropietario();
    // });
    //$("#btnAuto").on("click", function () {
    //    ArmarTablaAutosPropietario();
    // });
    $("#altaAutos").on("click", function () {
        AltaAuto();
    });
    $("#filtrarAutosPrecio").on("click", function () {
        FiltrarAutosPrecioColor();
    });
    $("#filtrarAutosPromedio").on("click", function () {
        PrecioPromedioAutos();
    });
    $("#soloEmpleados").on("click", function () {
        SoloEmpleados();
    });
    $("#Logout").on("click", function () {
        Logout();
    });
});
/* #endregion */
/* #region  Tabla de autos(general) */
function ArmarTablaAutos() {
    VerificarJWT();
    var token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado) {
        var usuario;
        if (resultado.exito) {
            var perfil_1;
            usuario = JSON.parse((resultado.payload.data));
            perfil_1 = usuario[0].perfil;
            $.ajax({
                type: 'GET',
                url: APIREST + "autos",
                dataType: "json",
                data: {},
                headers: { "token": token },
                async: true
            })
                .done(function (resultado) {
                if (perfil_1 == 'propietario') {
                    var tabla = tablaAutosPropietario(resultado);
                    $("#divIzq").html(tabla);
                    /*$('[data-action="eliminar"]').on('click', function (e) {

                        let obj_auto_string = $("#btnEliminar").attr("data-obj_auto") as string;
                        let obj_auto = JSON.parse(obj_auto_string);
                        let id = parseInt(obj_auto.id)

                        if (confirm("Desea eliminar?")) {
                            EliminarAuto(id, token);
                        }
                    });*/
                    var btn = $('[data-action="eliminar"]');
                    if (btn) {
                        btn.on('click', function () {
                            var auto_json = $(this).attr("data-obj_auto");
                            var autoObj = JSON.parse(auto_json);
                            var id = parseInt(autoObj.id);
                            if (confirm("Desea eliminar?")) {
                                EliminarAuto(id, token);
                            }
                        });
                    }
                }
                else if (perfil_1 == "encargado") {
                    var tabla_1 = "";
                    tabla_1 = "<table class=\"table\">\n                        <thead>\n                        <tr>\n                            <th scope=\"col\">Color</th>\n                            <th scope=\"col\">Marca</th>\n                            <th scope=\"col\">Precio</th>\n                            <th scope=\"col\">Modelo</th>\n                            <th scope=\"col\">Modificar</th>\n                        </tr>\n                        </thead>\n                        <tbody>";
                    resultado.dato.forEach(function (item) {
                        tabla_1 += "<tr>\n                            <td>" + item.color + "</td>\n                            <td>" + item.marca + "</td>\n                            <td>" + item.precio + "</td>\n                            <td>" + item.modelo + "</td>\n                            <td>\n                            <a href='#' class='btn btn-success' data-action='modificar' data-obj_auto='" + JSON.stringify(item) + "'title='Modificar'\n                            data-toggle='modal' data-target='#ventana_modal_auto' id=\"btnModificar\" ><i class='bi bi-pencil'></i></a>\n                            </td>\n                        </tr>";
                    });
                    tabla_1 += "</tbody>\n                        </table>";
                    $("#divIzq").html(tabla_1);
                    var btnModificar = $('[data-action="modificar"]');
                    if (btnModificar) {
                        btnModificar.on('click', function () {
                            var auto_json = $(this).attr("data-obj_auto");
                            var autoObj = JSON.parse(auto_json);
                            ModificarAuto(autoObj, token);
                        });
                    }
                }
                else if (perfil_1 == "empleado") {
                    var colores = resultado.mensaje;
                    $("#divIzq").html(colores);
                }
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                $("#divIzq").html("No hay autos para mostrar.");
            });
        }
        else {
            console.log("asda");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error peticion jwt para tomar el perfil");
    });
}
/* #endregion */
/* #region  TablaAutosParaPropietario(si se paso un id en especifico a buscar) */
/*
function ArmarTablaAutosPropietario(): void {

    VerificarJWT();

    let token = localStorage.getItem("token");

    $.ajax({
        type: 'GET',
        url: APIREST + "autos",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado: any) {

            let idAuto: number = $("#auto").val() as number;
            let auto: any = "";

            resultado.forEach(item => {
                if (item.id == idAuto) {
                    auto = item;
                }
            });

            if (auto == "") {

                $("#divIzq").html("Auto no encontrado.");

            }
            else {
                let tabla: string = "";

                tabla = `<table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Color</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Eliminar</th>
                </tr>
                </thead>
                <tbody>`;
                tabla += `<tr>
                    <td>${auto.id}</td>
                    <td>${auto.color}</td>
                    <td>${auto.marca}</td>
                    <td>${auto.precio}</td>
                    <td>${auto.modelo}</td>
                    <td>
                    <a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='${JSON.stringify(auto)}'title='Eliminar'
                    data-toggle='modal' data-target='#ventana_modal_auto' id="btnEliminar" ><i class='bi bi-x-circle'></i></a>
                    </td>
                </tr>`;
                tabla += `</tbody>
                </table>`;
                $("#divIzq").html(tabla);

                $('[data-action="eliminar"]').on('click', function (e) {

                    let obj_auto_string = $("#btnEliminar").attr("data-obj_auto") as string;
                    let obj_auto = JSON.parse(obj_auto_string);
                    let id = parseInt(obj_auto.id)

                    if (confirm("Desea eliminar?")) {

                        $.ajax({
                            type: 'DELETE',
                            url: APIREST,
                            dataType: "json",
                            data: JSON.stringify({ "id_auto": id }),
                            headers: { "token": token },
                            async: true
                        }).done(function (resultado: any) {
                            if (resultado.exito) {
                                $("#divIzq").html("Se elimino con exito.");
                            }
                        }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                            console.log("error eliminar.");
                        });

                    }

                });

            }
        })
        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
            console.log("error listado.");
        });
}
*/
/* #endregion */
/* #region  Tabla de usuarios(general) */
/*function ArmarTablaUsuarios(): void {

    VerificarJWT();

    let token = localStorage.getItem("token");

    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado: any) {

            let usuario: any;

            if (resultado.exito) {
                let perfil: string;
                usuario = JSON.parse((resultado.payload.data));
                perfil = usuario[0].perfil;

                $.ajax({
                    type: 'GET',
                    url: APIREST,
                    dataType: "json",
                    data: {},
                    headers: { "token": token },
                    async: true
                })
                    .done(function (resultado: any) {

                        if (perfil == 'propietario') {

                            $("#btnApellido").on("click", function () {

                                let apellido: string = $("#apellido").val() as string;

                                let cont: number = 0;

                                let apellidos = JSON.parse(resultado);

                                apellidos.forEach(element => {
                                    if (element == apellido) {
                                        cont++;
                                    }
                                });

                                $("#divDer").html("Aparece: " + cont + " veces.");
                            });


                            let tabla: string = `<table class=table>
                            <tr>
                                <th scope=col>Apellido</th>
                                <th scope=col>Cantidad</th>
                            </tr>
                              </thead>
                            <tbody>
                            <tr>`;

                            for (let key in resultado) {
                                tabla += `<tr>
                                        <th>
                                            ${key}
                                        </th>
                                        <th>
                                            ${resultado[key]}
                                        </th>
                                    </tr>`
                            }

                            tabla += `</tbody> </table>`;


                            $("#divDer").html(tabla);
                        }
                        else if (perfil == "encargado") {
                            let tabla: string = "";

                            tabla = `<table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Correo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Foto</th>
                    </tr>
                    </thead>
                    <tbody>`;

                            resultado.forEach(item => {
                                tabla += `<tr>
                        <td>${item.correo}</td>
                        <td>${item.nombre}</td>
                        <td>${item.apellido}</td>
                        <td>${item.perfil}</td>
                        <td><img src="../${item.foto}" width="50" height="50""></td>
                    </tr>`;
                            });

                            tabla += `</tbody>
                    </table>`;

                            $("#divDer").html(tabla);
                        }
                        else if (perfil == "empleado") {
                            let tabla: string = "";

                            tabla = `<table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Foto</th>
                    </tr>
                    </thead>
                    <tbody>`;

                            resultado.forEach(item => {
                                tabla += `<tr>
                        <td>${item.nombre}</td>
                        <td>${item.apellido}</td>
                        <td><img src="../${item.foto}" width="50" height="50""></td>
                    </tr>`;
                            });

                            tabla += `</tbody>
                    </table>`;

                            $("#divDer").html(tabla);
                        }
                    })
                    .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                        console.log("error listado.");
                    });
            } else {
                console.log("asda");
            }
        })
        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {

            console.log("error peticion jwt para tomar el perfil");
        });
}*/
/* #endregion */
/* #region  TablaUsuariosParaPropietario(si se paso un apellido en especifico a buscar) */
/*
function ArmarTablaUsuariosPropietario() {

    VerificarJWT();

    let token = localStorage.getItem("token");

    $.ajax({
        type: 'GET',
        url: APIREST,
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado: any) {


            let apellido: string = $("#apellido").val() as string;

            let cont: number = 0;

            let apellidos = resultado;

            if (apellidos[apellido]) {
                cont = apellidos[apellido];
            }

            $("#divDer").html(apellido + " Aparece: " + cont + " veces/vez en la base de datos.");
        })
        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
            console.log("error listado.");
        });
}
*/
/* #endregion */
/* #region  Funcion Verificadora de vigencia de jwt y oculta-mostrar botones */
function VerificarJWT() {
    var token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado) {
        var usuario;
        if (resultado.exito) {
            usuario = JSON.parse((resultado.payload.data));
            $("#usuario_info").html("USUARIO: " + usuario[0].apellido + ", " + usuario[0].nombre + " --- perfil: " + usuario[0].perfil);
            if (usuario[0].perfil == "propietario") {
                $("#buscarApellido").hide();
                $("#buscarAuto").hide();
                $("#soloEmpleados").hide();
            }
            else if (usuario[0].perfil == "encargado") {
                $("#buscarApellido").hide();
                $("#buscarAuto").hide();
            }
            else {
                $("#buscarApellido").hide();
                $("#buscarAuto").hide();
                $("#soloEmpleados").hide();
                $("#filtrarAutosPrecio").hide();
                $("#filtrarAutosPromedio").hide();
            }
        }
        else {
            $("#exampleModalCenter").modal('show');
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
/* #endregion */
/* #region  Funcion que redirecciona a Login */
function IrLogin() {
    $.ajax({
        type: 'GET',
        url: APIREST + "loginusuarios",
        async: true
    })
        .done(function (resultado) {
        $(location).attr('href', APIREST + "loginusuarios");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error en redireccion " + errorThrown);
    });
}
/* #endregion */
/* #region  Funcion que me arma la tabla de autos para propietarios */
function tablaAutosPropietario(resultado) {
    var tabla = "";
    tabla = "<table class=\"table\">\n        <thead>\n        <tr>\n            <th scope=\"col\">ID</th>\n            <th scope=\"col\">Color</th>\n            <th scope=\"col\">Marca</th>\n            <th scope=\"col\">Precio</th>\n            <th scope=\"col\">Modelo</th>\n            <th scope=\"col\">Eliminar</th>\n        </tr>\n        </thead>\n        <tbody>";
    resultado.forEach(function (item) {
        tabla += "<tr>\n            <td>" + item.id + "</td>\n            <td>" + item.color + "</td>\n            <td>" + item.marca + "</td>\n            <td>" + item.precio + "</td>\n            <td>" + item.modelo + "</td>\n            <td>\n            <a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='" + JSON.stringify(item) + "'title='Eliminar'\n            data-toggle='modal' data-target='#ventana_modal_auto' id=\"btnEliminar\" ><i class='bi bi-x-circle'></i></a>\n            </td>\n        </tr>";
    });
    tabla += "</tbody>\n        </table>";
    return tabla;
}
/* #endregion */
/* #region  Funcion Eliminar Auto */
function EliminarAuto(id, token) {
    $.ajax({
        type: 'DELETE',
        url: APIREST,
        dataType: "json",
        data: JSON.stringify({ "id_auto": id }),
        headers: { "token": token },
        async: true
    }).done(function (resultado) {
        ArmarTablaAutos();
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error eliminar.");
    });
}
/* #endregion */
/* #region  Funcion ModificarAuto */
function ModificarAuto(item, token) {
    var id = item.id;
    var form = "\n        <div class=\"container \">\n        <div class=\"row justify-content-center mt-5\">\n            <div class=\"col-12 col-lg-4 mt-2 p-4 rounded-3 \" style=\"background-color: #383838;\">\n                <form action=\"\">\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"bi bi-badge-tm-fill pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" class=\"form-control\" placeholder=\"Marca\" id=\"txtMarca\" value=\"" + item.marca + "\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"bi bi-palette-fill pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Color\" class=\"form-control\" id=\"txtColor\" value=\"" + item.color + "\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"bi bi-bicycle pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Modelo\" class=\"form-control\" id=\"txtModelo\" value=\"" + item.modelo + "\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"bi bi-cash pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Precio\" class=\"form-control\" id=\"txtPrecio\" value=\"" + item.precio + "\">\n                        </div>\n                    </div>\n                    <div class=\"row content-center\">\n                                <br>\n                                <br>\n                            <div id=\"divResultado\" class=\"col-12 col-md-12\">\n                    </div>\n                    <div class=\"row justify-content-around mt-4\">\n                        <button type=\"submit\" id=\"btnEnviarModificacion\" class=\"col-5 btn btn-primary\">Modificar</button>\n                        <button type=\"reset\" class=\"col-5 btn btn-warning text-light\">Limpiar</button>\n                    </div>\n                </form>\n            </div>\n        </div>\n    </div>";
    $("#divIzq").html(form);
    $("#btnEnviarModificacion").on("click", function (e) {
        var auto = {};
        var marca = $("#txtMarca").val();
        var color = $("#txtColor").val();
        var modelo = $("#txtModelo").val();
        var precio = $("#txtPrecio").val();
        auto.marca = marca;
        auto.color = color;
        auto.modelo = modelo;
        auto.precio = precio;
        $.ajax({
            type: 'PUT',
            url: APIREST,
            dataType: "json",
            data: JSON.stringify({ "id_auto": id, "auto": auto }),
            headers: { "token": token },
            async: true
        }).done(function (resultado) {
            var mensaje = 'Usuario válido!';
            var tipo = 'success';
            console.log(resultado.mensaje);
            if (resultado.exito) {
                ArmarTablaAutos();
                e.preventDefault();
            }
            else {
                e.preventDefault();
                mensaje = resultado.mensaje;
                tipo = 'danger';
                var alerta = ArmarAlert(mensaje, tipo);
                $("#divIzq").html(alerta);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("error modificar.");
        });
    });
}
/* #endregion */
/* #region  Funcion Alta Auto */
function AltaAuto() {
    VerificarJWT();
    var form = "\n        <div class=\"container bg-darkcyan\">\n        <div class=\"row justify-content-center mt-5\">\n            <div class=\"col-12 col-lg-4 mt-2 p-4 rounded-3 \" style=\"background-color: darkcyan;\">\n                <form action=\"\">\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\" fas fa-trademark pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" class=\"form-control\" placeholder=\"Marca\" id=\"txtMarca\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"fas fa-palette pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Color\" class=\"form-control\" id=\"txtColor\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\"fas fa-car pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Modelo\" class=\"form-control\" id=\"txtModelo\">\n                        </div>\n                    </div>\n                    <div class=\"mb-3\">\n                        <div class=\"d-flex\">\n                            <i class=\" fas fa-dollar-sign pb-1 px-2 mx-1 rounded border\" style=\"background-color: white; font-size: 1.5rem\"></i>\n                            <input type=\"text\" placeholder=\"Precio\" class=\"form-control\" id=\"txtPrecio\">\n                        </div>\n                    </div>\n                    <div class=\"row content-center\">\n                                <br>\n                                <br>\n                            <div id=\"divResultadoAgregarAuto\" class=\"col-12 col-md-12 container-fluid\">\n                            </div>\n                    </div>\n                    <div class=\"row justify-content-around mt-4\">\n                        <button type=\"submit\" id=\"btnAgregar\" class=\"col-5 btn btn-primary\">Agregar</button>\n                        <button type=\"reset\" class=\"col-5 btn btn-warning text-light\">Limpiar</button>\n                    </div>\n                </form>\n            </div>\n        </div>\n    </div>";
    $("#divIzq").html(form);
    $("#btnAgregar").on("click", function (e) {
        var auto = {};
        var marca = $("#txtMarca").val();
        var color = $("#txtColor").val();
        var modelo = $("#txtModelo").val();
        var precio = $("#txtPrecio").val();
        auto.marca = marca;
        auto.color = color;
        auto.modelo = modelo;
        auto.precio = precio;
        $.ajax({
            type: 'POST',
            url: APIREST,
            dataType: "json",
            data: { "auto": JSON.stringify(auto) },
            async: true
        }).done(function (resultado) {
            var mensaje = 'Usuario válido!';
            var tipo = 'success';
            console.log(resultado.mensaje);
            if (resultado.exito) {
                e.preventDefault();
                mensaje = resultado.mensaje;
                var alerta = ArmarAlert(mensaje, tipo);
                $("#divResultadoAgregarAuto").html(alerta);
            }
            else {
                mensaje = resultado.mensaje;
                tipo = 'danger';
                var alerta = ArmarAlert(mensaje, tipo);
                $("#divResultadoAgregarAuto").html(alerta);
                e.preventDefault();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("error al agregar.");
        });
    });
}
/* #endregion */
/* #region  Funcion que arma los alerts de bootstrap */
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    return alerta;
}
/* #endregion */
/* #region  Logout. */
function Logout() {
    $.ajax({
        type: 'GET',
        url: APIREST + "loginusuarios",
        async: true
    })
        .done(function (resultado) {
        localStorage.removeItem("token");
        $(location).attr('href', APIREST + "loginusuarios");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error en redireccion " + errorThrown);
    });
}
/* #endregion */
/* #region  Filtrar autos por precio y color rojo. */
function FiltrarAutosPrecioColor() {
    VerificarJWT();
    var token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado) {
        var usuario;
        if (resultado.exito) {
            var perfil_2;
            usuario = JSON.parse((resultado.payload.data));
            perfil_2 = usuario[0].perfil;
            $.ajax({
                type: 'GET',
                url: APIREST + "autos",
                dataType: "json",
                data: {},
                headers: { "token": token },
                async: true
            })
                .done(function (resultado) {
                if (perfil_2 == 'propietario') {
                    var filtrado = resultado.filter(function (dato) { return dato.precio > 199999 && dato.color != "rojo"; });
                    var tabla_2 = "";
                    tabla_2 = "<table class=\"table\">\n                        <thead>\n                        <tr>\n                            <th scope=\"col\">ID</th>\n                            <th scope=\"col\">Color</th>\n                            <th scope=\"col\">Marca</th>\n                            <th scope=\"col\">Precio</th>\n                            <th scope=\"col\">Modelo</th>\n                            <th scope=\"col\">Eliminar</th>\n                        </tr>\n                        </thead>\n                        <tbody>";
                    filtrado.forEach(function (item) {
                        tabla_2 += "<tr>\n                            <td>" + item.id + "</td>\n                            <td>" + item.color + "</td>\n                            <td>" + item.marca + "</td>\n                            <td>" + item.precio + "</td>\n                            <td>" + item.modelo + "</td>\n                            <td>\n                            <a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='" + JSON.stringify(item) + "'title='Eliminar'\n                            data-toggle='modal' data-target='#ventana_modal_auto' id=\"btnEliminar\" ><i class='bi bi-x-circle'></i></a>\n                            </td>\n                        </tr>";
                    });
                    tabla_2 += "</tbody>\n                        </table>";
                    $("#divDer").html(tabla_2);
                    var btn = $('[data-action="eliminar"]');
                    if (btn) {
                        btn.on('click', function () {
                            var obj_auto_string = $("#btnEliminar").attr("data-obj_auto");
                            var obj_auto = JSON.parse(obj_auto_string);
                            var id = parseInt(obj_auto.id);
                            if (confirm("Desea eliminar?")) {
                                EliminarAuto(id, token);
                                $("#divDer").html('se elimino con exito');
                            }
                        });
                    }
                }
                else if (perfil_2 == 'encargado') {
                    var filtrado = resultado.dato.filter(function (dato) { return dato.precio > 199999 && dato.color != "rojo"; });
                    var tabla_3 = "";
                    tabla_3 = "<table class=\"table\">\n                        <thead>\n                        <tr>\n                            <th scope=\"col\">Color</th>\n                            <th scope=\"col\">Marca</th>\n                            <th scope=\"col\">Precio</th>\n                            <th scope=\"col\">Modelo</th>\n                            <th scope=\"col\">Modificar</th>\n                        </tr>\n                        </thead>\n                        <tbody>";
                    filtrado.forEach(function (item) {
                        tabla_3 += "<tr>\n                            <td>" + item.color + "</td>\n                            <td>" + item.marca + "</td>\n                            <td>" + item.precio + "</td>\n                            <td>" + item.modelo + "</td>\n                            <td>\n                            <a href='#' class='btn btn-success' data-action='modificar' data-obj_auto='" + JSON.stringify(item) + "'title='Modificar'\n                            data-toggle='modal' data-target='#ventana_modal_auto' id=\"btnModificar\" ><i class='bi bi-pencil'></i></a>\n                            </td>\n                        </tr>";
                    });
                    tabla_3 += "</tbody>\n                        </table>";
                    $("#divDer").html(tabla_3);
                    var btnModificar = $('[data-action="modificar"]');
                    if (btnModificar) {
                        btnModificar.on('click', function () {
                            var auto_json = $(this).attr("data-obj_auto");
                            var autoObj = JSON.parse(auto_json);
                            ModificarAuto(autoObj, token);
                            $("#divDer").html('');
                        });
                    }
                }
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                var alerta = ArmarAlert("No hay autos.", "info");
                $("#divInfo").html(alerta);
            });
        }
        else {
            console.log("asda");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error peticion jwt para tomar el perfil");
    });
}
/* #endregion */
/* #region  Funcion mostrar promedio de precios */
function PrecioPromedioAutos() {
    VerificarJWT();
    var token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado) {
        var usuario;
        if (resultado.exito) {
            var perfil_3;
            usuario = JSON.parse((resultado.payload.data));
            perfil_3 = usuario[0].perfil;
            $.ajax({
                type: 'GET',
                url: APIREST + "autos",
                dataType: "json",
                data: {},
                headers: { "token": token },
                async: true
            })
                .done(function (resultado) {
                if (perfil_3 == 'propietario') {
                    var mapeado = resultado.filter(function (auto) {
                        if (auto.marca[0] == 'F' || auto.marca[0] == "f") {
                            return { precio: auto.precio };
                        }
                    });
                    var prom = mapeado.reduce(function (a, x) { return parseInt(a) + parseInt(x.precio); }, 0) / mapeado.length;
                    var mensaje = "El precio promedio de autos es: " + prom;
                    if (isNaN(prom)) {
                        mensaje = "El precio promedio de autos es: 0";
                    }
                    var alerta = ArmarAlert(mensaje, "info");
                    $("#divInfo").html(alerta);
                }
                else if (perfil_3 == 'encargado') {
                    var mapeado = resultado.dato.filter(function (auto) {
                        if (auto.marca[0] == 'F' || auto.marca[0] == "f") {
                            return { precio: auto.precio };
                        }
                    });
                    var prom = mapeado.reduce(function (a, x) { return parseInt(a) + parseInt(x.precio); }, 0) / mapeado.length;
                    var mensaje = "El precio promedio de autos es: " + prom;
                    if (isNaN(prom)) {
                        mensaje = "El precio promedio de autos es: 0";
                    }
                    var alerta = ArmarAlert(mensaje, "info");
                    $("#divInfo").html(alerta);
                }
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                var alerta = ArmarAlert("No hay autos.", "info");
                $("#divInfo").html(alerta);
            });
        }
        else {
            console.log("asda");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error peticion jwt para tomar el perfil");
    });
}
/* #endregion */
/* #region  Funcion mostrar solo empleados y sus fotos. */
function SoloEmpleados() {
    VerificarJWT();
    var token = localStorage.getItem("token");
    $.ajax({
        type: 'GET',
        url: APIREST + "login",
        dataType: "json",
        data: {},
        headers: { "token": token },
        async: true
    })
        .done(function (resultado) {
        var usuario;
        if (resultado.exito) {
            var perfil_4;
            usuario = JSON.parse((resultado.payload.data));
            perfil_4 = usuario[0].perfil;
            $.ajax({
                type: 'GET',
                url: APIREST,
                dataType: "json",
                data: {},
                headers: { "token": token },
                async: true
            })
                .done(function (resultado) {
                if (perfil_4 == "encargado") {
                    var mapeado = resultado.map(function (usuario) {
                        if (usuario.perfil == 'empleado' || usuario.perfil == "encargado") {
                            return { nombre: usuario.nombre, foto: usuario.foto, correo: "", apellido: "", perfil: "" };
                        }
                    });
                    mapeado = mapeado.filter(function (dato) { return dato !== undefined; });
                    var tabla_4 = "<table class='table'> \n                                  <thead>\n                                    <tr>\n                                      <td>NOMBRE</td>\n                                      <td>FOTO</td>\n                                    </tr>\n                                  </thead>\n                                  <tbody>";
                    mapeado.forEach(function (usuario) {
                        tabla_4 += "<tr>\n                                              <td>" + usuario.nombre + "</td>\n                                              <td>\n                                                  <img src='" + usuario.foto + "' style='width: 50px; heigth: 50px'>\n                                              </td>\n                                          </tr>";
                    });
                    tabla_4 += "</tbody></table>";
                    $("#divIzq").html(tabla_4);
                }
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error listado.");
            });
        }
        else {
            console.log("asda");
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        console.log("error peticion jwt para tomar el perfil");
    });
}
/* #endregion */
