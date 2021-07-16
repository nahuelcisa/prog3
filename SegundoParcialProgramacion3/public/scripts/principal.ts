/// <reference path="../node_modules/@types/jquery/index.d.ts" />

    const APIREST: string = "http://scaloneta/";
    
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
    function ArmarTablaAutos(): void {
    
        VerificarJWT();
    
        let token = localStorage.getItem("token") as string;
    
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
                        url: APIREST + "autos",
                        dataType: "json",
                        data: {},
                        headers: { "token": token },
                        async: true
                    })
                        .done(function (resultado: any) {
    
                            if (perfil == 'propietario') {
    
                                let tabla: string = tablaAutosPropietario(resultado);
                                $("#divIzq").html(tabla);
    
                                /*$('[data-action="eliminar"]').on('click', function (e) {
    
                                    let obj_auto_string = $("#btnEliminar").attr("data-obj_auto") as string;
                                    let obj_auto = JSON.parse(obj_auto_string);
                                    let id = parseInt(obj_auto.id)
    
                                    if (confirm("Desea eliminar?")) {
                                        EliminarAuto(id, token);
                                    }
                                });*/
                                let btn: JQuery<HTMLElement> = $('[data-action="eliminar"]');

                                if (btn) {
                                    btn.on('click', function () {
                                        
                                        let auto_json: string = $(this).attr("data-obj_auto") as string;
                                        let autoObj = JSON.parse(auto_json);
                                        let id = parseInt(autoObj.id);
                            
                                        if(confirm("Desea eliminar?")){
                                            EliminarAuto(id,token);
                                        }
                                        
                                    });
                                }
                            }
                            else if (perfil == "encargado") {
                                let tabla: string = "";
    
                                tabla = `<table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Color</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Modificar</th>
                        </tr>
                        </thead>
                        <tbody>`;
    
                                resultado.dato.forEach(item => {
                                    tabla += `<tr>
                            <td>${item.color}</td>
                            <td>${item.marca}</td>
                            <td>${item.precio}</td>
                            <td>${item.modelo}</td>
                            <td>
                            <a href='#' class='btn btn-success' data-action='modificar' data-obj_auto='${JSON.stringify(item)}'title='Modificar'
                            data-toggle='modal' data-target='#ventana_modal_auto' id="btnModificar" ><i class='bi bi-pencil'></i></a>
                            </td>
                        </tr>`;
                                });
    
                                tabla += `</tbody>
                        </table>`;
    
                                $("#divIzq").html(tabla);
    
                                let btnModificar: JQuery<HTMLElement> = $('[data-action="modificar"]');

                                    if (btnModificar) {
                                        btnModificar.on('click', function () {
                                            
                                            let auto_json: string = $(this).attr("data-obj_auto") as string;
                                            let autoObj = JSON.parse(auto_json);
                                
                                            ModificarAuto(autoObj,token);
                                            
                                        });
                                    }
                            }
                            else if (perfil == "empleado") {
                                let colores = resultado.mensaje;
                                $("#divIzq").html(colores);
                            }
                        })
                        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                            $("#divIzq").html("No hay autos para mostrar.");
                        });
                } else {
                    console.log("asda");
                }
            })
            .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
    
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
    function VerificarJWT(): void {
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
                    } else {
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
            .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
    
                let retorno = JSON.parse(jqXHR.responseText);
    
                let alerta: string = ArmarAlert(retorno.mensaje, "danger");
    
                $("#divResultado").html(alerta);
            });
    }
    /* #endregion */
    
    /* #region  Funcion que redirecciona a Login */
    function IrLogin(): void {
    
        $.ajax({
            type: 'GET',
            url: APIREST + "loginusuarios",
            async: true
        })
            .done(function (resultado: any) {
                $(location).attr('href', APIREST + "loginusuarios");
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error en redireccion " + errorThrown);
            });
    }
    
    /* #endregion */
    
    /* #region  Funcion que me arma la tabla de autos para propietarios */
    function tablaAutosPropietario(resultado: any): string {
        let tabla = ""
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
    
        resultado.forEach(item => {
            tabla += `<tr>
            <td>${item.id}</td>
            <td>${item.color}</td>
            <td>${item.marca}</td>
            <td>${item.precio}</td>
            <td>${item.modelo}</td>
            <td>
            <a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='${JSON.stringify(item)}'title='Eliminar'
            data-toggle='modal' data-target='#ventana_modal_auto' id="btnEliminar" ><i class='bi bi-x-circle'></i></a>
            </td>
        </tr>`;
        });
    
        tabla += `</tbody>
        </table>`;
    
        return tabla;
    }
    /* #endregion */
    
    /* #region  Funcion Eliminar Auto */
    function EliminarAuto(id: number, token: string) {
        $.ajax({
            type: 'DELETE',
            url: APIREST,
            dataType: "json",
            data: JSON.stringify({ "id_auto": id }),
            headers: { "token": token },
            async: true
        }).done(function (resultado: any) {
            ArmarTablaAutos();
        }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
            console.log("error eliminar.");
        });
    }
    /* #endregion */
    
    /* #region  Funcion ModificarAuto */
    function ModificarAuto(item: any, token: string): void {
        let id = item.id;
        let form: string = `
        <div class="container ">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-4 mt-2 p-4 rounded-3 " style="background-color: #383838;">
                <form action="">
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="bi bi-badge-tm-fill pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" class="form-control" placeholder="Marca" id="txtMarca" value="${item.marca}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="bi bi-palette-fill pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Color" class="form-control" id="txtColor" value="${item.color}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="bi bi-bicycle pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Modelo" class="form-control" id="txtModelo" value="${item.modelo}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="bi bi-cash pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Precio" class="form-control" id="txtPrecio" value="${item.precio}">
                        </div>
                    </div>
                    <div class="row content-center">
                                <br>
                                <br>
                            <div id="divResultado" class="col-12 col-md-12">
                    </div>
                    <div class="row justify-content-around mt-4">
                        <button type="submit" id="btnEnviarModificacion" class="col-5 btn btn-primary">Modificar</button>
                        <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;
    
        $("#divIzq").html(form);
    
    
        $("#btnEnviarModificacion").on("click", function (e) {
    
            let auto: any = {};
            let marca = $("#txtMarca").val();
            let color = $("#txtColor").val();
            let modelo = $("#txtModelo").val();
            let precio = $("#txtPrecio").val();
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
            }).done(function (resultado: any) {
                let mensaje: string = 'Usuario válido!';
                let tipo: string = 'success';
    
                console.log(resultado.mensaje);
                
                if (resultado.exito) {
                    ArmarTablaAutos();
                    e.preventDefault();
                }
                else {
                    e.preventDefault();
                    mensaje = resultado.mensaje;
                    tipo = 'danger';
                    let alerta: string = ArmarAlert(mensaje, tipo);
                    $("#divIzq").html(alerta);
                }
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error modificar.");
            });
        });
    }
    /* #endregion */
    
    /* #region  Funcion Alta Auto */
    function AltaAuto(): void {
    
        VerificarJWT();
    
        let form: string = `
        <div class="container bg-darkcyan">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-4 mt-2 p-4 rounded-3 " style="background-color: darkcyan;">
                <form action="">
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-trademark pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" class="form-control" placeholder="Marca" id="txtMarca">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-palette pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Color" class="form-control" id="txtColor">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class="fas fa-car pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Modelo" class="form-control" id="txtModelo">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <i class=" fas fa-dollar-sign pb-1 px-2 mx-1 rounded border" style="background-color: white; font-size: 1.5rem"></i>
                            <input type="text" placeholder="Precio" class="form-control" id="txtPrecio">
                        </div>
                    </div>
                    <div class="row content-center">
                                <br>
                                <br>
                            <div id="divResultadoAgregarAuto" class="col-12 col-md-12 container-fluid">
                            </div>
                    </div>
                    <div class="row justify-content-around mt-4">
                        <button type="submit" id="btnAgregar" class="col-5 btn btn-primary">Agregar</button>
                        <button type="reset" class="col-5 btn btn-warning text-light">Limpiar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;
    
        $("#divIzq").html(form);
    
    
        $("#btnAgregar").on("click", function (e) {
    
            let auto: any = {};
            let marca = $("#txtMarca").val();
            let color = $("#txtColor").val();
            let modelo = $("#txtModelo").val();
            let precio = $("#txtPrecio").val();
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
            }).done(function (resultado: any) {
                let mensaje: string = 'Usuario válido!';
                let tipo: string = 'success';
                console.log(resultado.mensaje);
                if (resultado.exito) {
                    e.preventDefault();
                    mensaje = resultado.mensaje;
                    let alerta: string = ArmarAlert(mensaje, tipo);
                    $("#divResultadoAgregarAuto").html(alerta);
                }
                else {
                    
                    mensaje = resultado.mensaje;
                    tipo = 'danger';
                    let alerta: string = ArmarAlert(mensaje, tipo);
                    $("#divResultadoAgregarAuto").html(alerta);
                    e.preventDefault();
                }
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error al agregar.");
            });
        });
    }
    
    /* #endregion */
    
    /* #region  Funcion que arma los alerts de bootstrap */
    function ArmarAlert(mensaje: string, tipo: string = "success"): string {
        let alerta: string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
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
            .done(function (resultado: any) {
                localStorage.removeItem("token");
                $(location).attr('href', APIREST + "loginusuarios");
            }).fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                console.log("error en redireccion " + errorThrown);
            });
    }
    /* #endregion */
    
    /* #region  Filtrar autos por precio y color rojo. */
    function FiltrarAutosPrecioColor() {
        VerificarJWT();
    
        let token = localStorage.getItem("token") as string;
    
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
                        url: APIREST + "autos",
                        dataType: "json",
                        data: {},
                        headers: { "token": token },
                        async: true
                    })
                        .done(function (resultado: any) {
    
                            if (perfil == 'propietario') {
    
                                let filtrado = resultado.filter((dato: any) => dato.precio > 199999 && dato.color !=  "rojo");
    
                                let tabla = ""
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
    
                                filtrado.forEach(item => {
                                    tabla += `<tr>
                            <td>${item.id}</td>
                            <td>${item.color}</td>
                            <td>${item.marca}</td>
                            <td>${item.precio}</td>
                            <td>${item.modelo}</td>
                            <td>
                            <a href='#' class='btn btn-danger' data-action='eliminar' data-obj_auto='${JSON.stringify(item)}'title='Eliminar'
                            data-toggle='modal' data-target='#ventana_modal_auto' id="btnEliminar" ><i class='bi bi-x-circle'></i></a>
                            </td>
                        </tr>`;
                                });
    
                                tabla += `</tbody>
                        </table>`;
    
                                $("#divDer").html(tabla);

                                let btn: JQuery<HTMLElement> = $('[data-action="eliminar"]');

                                if (btn) {

                                    btn.on('click', function () {
        
                                        let obj_auto_string = $("#btnEliminar").attr("data-obj_auto") as string;
                                        let obj_auto = JSON.parse(obj_auto_string);
                                        let id = parseInt(obj_auto.id)
        
                                        if (confirm("Desea eliminar?")) {
        
                                            EliminarAuto(id,token);
                                            $("#divDer").html('se elimino con exito');
                                        }
                                    });
                                }
                            }
                            else if
                                (perfil == 'encargado') {
    
                                let filtrado = resultado.dato.filter((dato: any) => dato.precio > 199999 && dato.color != "rojo");
    
                                let tabla: string = "";
    
                                tabla = `<table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Color</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Modificar</th>
                        </tr>
                        </thead>
                        <tbody>`;
    
                                filtrado.forEach(item => {
                                    tabla += `<tr>
                            <td>${item.color}</td>
                            <td>${item.marca}</td>
                            <td>${item.precio}</td>
                            <td>${item.modelo}</td>
                            <td>
                            <a href='#' class='btn btn-success' data-action='modificar' data-obj_auto='${JSON.stringify(item)}'title='Modificar'
                            data-toggle='modal' data-target='#ventana_modal_auto' id="btnModificar" ><i class='bi bi-pencil'></i></a>
                            </td>
                        </tr>`;
                                });
    
                                tabla += `</tbody>
                        </table>`;
    
                                $("#divDer").html(tabla);
    
                                let btnModificar: JQuery<HTMLElement> = $('[data-action="modificar"]');

                                    if (btnModificar) {
                                        btnModificar.on('click', function () {
                                            
                                            let auto_json: string = $(this).attr("data-obj_auto") as string;
                                            let autoObj = JSON.parse(auto_json);
                                
                                            ModificarAuto(autoObj,token);
                                            $("#divDer").html('');
                                        });
                                    }
                            }
                        })
                        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                            let alerta: string = ArmarAlert("No hay autos.", "info");
    
                            $("#divInfo").html(alerta);
                        });
                } else {
                    console.log("asda");
                }
            })
            .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
    
                console.log("error peticion jwt para tomar el perfil");
            });
    }
    /* #endregion */
    
    /* #region  Funcion mostrar promedio de precios */
    function PrecioPromedioAutos() {
        VerificarJWT();
    
        let token = localStorage.getItem("token") as string;
    
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
                        url: APIREST + "autos",
                        dataType: "json",
                        data: {},
                        headers: { "token": token },
                        async: true
                    })
                        .done(function (resultado: any) {
    
                            if (perfil == 'propietario') {

                                let mapeado = resultado.filter(function (auto: any) {
                                    if (auto.marca[0] == 'F' || auto.marca[0] == "f") {
                                        return { precio: auto.precio};
                                    }
                                });
                                
                                let prom = mapeado.reduce((a: any, x: any) => parseInt(a) + parseInt(x.precio), 0) / mapeado.length;
                                let mensaje = "El precio promedio de autos es: " + prom;

                                if(isNaN(prom)){
                                    mensaje = "El precio promedio de autos es: 0";

                                }
    
                                let alerta: string = ArmarAlert(mensaje, "info");
                                $("#divInfo").html(alerta);
                                
                            }
                            else if
                                (perfil == 'encargado') {
                                    let mapeado = resultado.dato.filter(function (auto: any) {
                                        if (auto.marca[0] == 'F' || auto.marca[0] == "f") {
                                            return { precio: auto.precio};
                                        }
                                    });
                            

                                let prom = mapeado.reduce((a: any, x: any) => parseInt(a) + parseInt(x.precio), 0) / mapeado.length;
                                let mensaje = "El precio promedio de autos es: " + prom;

                                if(isNaN(prom)){
                                 mensaje = "El precio promedio de autos es: 0";
                                }
    
                                let alerta: string = ArmarAlert(mensaje, "info");
    
                                $("#divInfo").html(alerta);
                            
                            }
                        })
                        .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
                            let alerta: string = ArmarAlert("No hay autos.", "info");
    
                            $("#divInfo").html(alerta);
                        });
                } else {
                    console.log("asda");
                }
            })
            .fail(function (jqXHR: any, textStatus: any, errorThrown: any) {
    
                console.log("error peticion jwt para tomar el perfil");
            });
    }
    
    /* #endregion */
    
    /* #region  Funcion mostrar solo empleados y sus fotos. */

function SoloEmpleados() {
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

                        if (perfil == "encargado") {
                            let mapeado = resultado.map(function (usuario: any) {
                                if (usuario.perfil == 'empleado' || usuario.perfil == "encargado") {
                                    return { nombre: usuario.nombre, foto: usuario.foto, correo: "", apellido: "", perfil: "" };
                                }
                            });
                            mapeado = mapeado.filter((dato: any) => dato !== undefined);
                            let tabla = `<table class='table'> 
                                  <thead>
                                    <tr>
                                      <td>NOMBRE</td>
                                      <td>FOTO</td>
                                    </tr>
                                  </thead>
                                  <tbody>`;
                            mapeado.forEach((usuario: any) => {
                                tabla += `<tr>
                                              <td>${usuario.nombre}</td>
                                              <td>
                                                  <img src='${usuario.foto}' style='width: 50px; heigth: 50px'>
                                              </td>
                                          </tr>`;
                            });
                            tabla += `</tbody></table>`

                            $("#divIzq").html(tabla);
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
}
/* #endregion */

