/// <reference path="ajax.ts" />
/// <reference path="ProductoEnvasado.ts" />
/// <reference path="Producto.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarProductoJSON = function () {
            var ajax = new Ajax();
            var ruta = "../backend/AltaProductoJSON.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var params = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post(ruta, Manejadora.AgregarProductoJSONSuccess, params, Manejadora.Fail);
        };
        Manejadora.AgregarProductoJSONSuccess = function (respuesta) {
            Manejadora.MostrarProductosJSON();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new Ajax();
            var ruta = "../backend/ListadoProductosJSON.php";
            ajax.Get(ruta, Manejadora.MostrarProductosJSONSuccess, "listar=listar", Manejadora.Fail);
        };
        Manejadora.MostrarProductosJSONSuccess = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                    <th>Nombre</th>\n                    <th>Origen</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                div += "\n                <tr>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.origen + "</th>\n                </tr>";
            });
            div += "</table>";
            document.getElementById('divTabla').innerHTML = div;
        };
        Manejadora.VerificarProductoJSON = function () {
            var ajax = new Ajax();
            var ruta = "../backend/VerificarProductoJSON.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var params = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post(ruta, Manejadora.VerificarProductoJSONSuccess, params, Manejadora.Fail);
        };
        Manejadora.VerificarProductoJSONSuccess = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.MostrarInfoCookie = function () {
            var ajax = new Ajax();
            var ruta = "../backend/MostrarCookie.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var params = "nombre=" + nombre + "&origen=" + origen;
            ajax.Get(ruta, Manejadora.MostrarInfoCookieSuccess, params, Manejadora.Fail);
        };
        Manejadora.MostrarInfoCookieSuccess = function (respuesta) {
            document.getElementById('divInfo').innerHTML = respuesta;
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.AgregarProductoSinFoto = function () {
            var ajax = new Ajax();
            var ruta = "../backend/AgregarProductoSinFoto.php";
            var codigo_barra = document.getElementById("codigoBarra").value;
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var precio = parseFloat(document.getElementById("precio").value);
            var params = "producto_json={\"codigo_barra\":\"" + codigo_barra + "\",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"precio\":" + precio + "}";
            ajax.Post(ruta, Manejadora.AgregarProductoSinFotoSuccess, params, Manejadora.Fail);
        };
        Manejadora.AgregarProductoSinFotoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasados();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.MostrarProductosEnvasados = function () {
            var ajax = new Ajax();
            var ruta = "../backend/ListadoProductosEnvasados.php";
            ajax.Get(ruta, Manejadora.MostrarProductosEnvasadosSuccess, "tabla=\"\"", Manejadora.Fail);
        };
        Manejadora.MostrarProductosEnvasadosSuccess = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                        <th>ID</th>\n                        <th>Nombre</th>\n                        <th>Origen</th>\n                        <th>CodigoBarra</th>\n                        <th>Precio</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                var json = JSON.stringify(item);
                if (item.pathFoto == "") {
                    div += "\n                <tr>\n                    <th>" + item.id + "</th>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.origen + "</th>\n                    <th>" + item.codigo_barra + "</th>\n                    <th>" + item.precio + "</th>\n                    <th> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.BtnModificarProducto('" + json + "')></th>\n                    <th> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.EliminarProducto('" + json + "') /> </th>\n                </tr>";
                }
            });
            div += "</table>";
            document.getElementById('divTabla').innerHTML = div;
        };
        Manejadora.BtnModificarProducto = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigo_barra.toString();
            document.getElementById("cboOrigen").value = producto.origen;
            document.getElementById("precio").value = producto.precio.toString();
        };
        Manejadora.ModificarProducto = function () {
            var ajax = new Ajax();
            var ruta = "../backend/ModificarProductoEnvasado.php";
            var id = parseInt(document.getElementById("id").value);
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("origen").value;
            var codigo_barras = document.getElementById("codigoBarra").value;
            var precio = parseInt(document.getElementById("precio").value);
            var json = "producto_json={\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigo_barra\":" + codigo_barras + ",\"precio\":" + precio + "}";
            ajax.Post(ruta, Manejadora.ModificarProductoSuccess, json, Manejadora.Fail);
        };
        Manejadora.ModificarProductoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasados();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.EliminarProducto = function (json) {
            var producto = JSON.parse(json);
            var ajax = new Ajax();
            var ruta = "../backend/EliminarProductoEnvasado.php";
            var id = producto.id;
            var nombre = producto.nombre;
            var origen = producto.origen;
            if (confirm("Desea borrar al empleado nombre: " + nombre + ", correo: " + origen + "?")) {
                var params = "producto_json=" + json;
                ajax.Post(ruta, Manejadora.EliminarProductoSuccess, params, Manejadora.Fail);
            }
        };
        Manejadora.EliminarProductoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasados();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.VerificarProductoEnvasado = function () {
            var ajax = new Ajax();
            var ruta = "../backend/VerificarProductoEnvasado.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var params = "obj_producto={\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\"}";
            ajax.Post(ruta, Manejadora.VerificarProductoEnvasadoSuccess, params, Manejadora.Fail);
        };
        Manejadora.VerificarProductoEnvasadoSuccess = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.MostrarProductosEnvasadosFoto = function () {
            var ajax = new Ajax();
            var ruta = "../backend/ListadoProductosEnvasados.php";
            ajax.Get(ruta, Manejadora.MostrarProductosEnvasadosFotoSuccess, "tabla=\"\"", Manejadora.Fail);
        };
        Manejadora.MostrarProductosEnvasadosFotoSuccess = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                        <th>ID</th>\n                        <th>Nombre</th>\n                        <th>Origen</th>\n                        <th>CodigoBarra</th>\n                        <th>Precio</th>\n                        <th>Foto</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                var json = JSON.stringify(item);
                if (item.pathFoto != "") {
                    div += "\n                <tr>\n                    <th>" + item.id + "</th>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.origen + "</th>\n                    <th>" + item.codigo_barra + "</th>\n                    <th>" + item.precio + "</th>\n                    <th><img src=" + item.pathFoto + " width=50px height=50px></th>\n                    <th> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.btnModificarProductoFoto('" + json + "')></th>\n                    <th> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.EliminarProductoFoto('" + json + "') /> </th>\n                </tr>";
                }
            });
            div += "</table>";
            document.getElementById('divTabla').innerHTML = div;
        };
        Manejadora.AgregarProductoFoto = function () {
            var ajax = new Ajax();
            var ruta = "../backend/AgregarProductoEnvasado.php";
            var codigo_barra = document.getElementById("codigoBarra").value;
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var precio = parseFloat(document.getElementById("precio").value);
            var foto = document.getElementById("foto");
            var form = new FormData();
            form.append('codigoBarra', codigo_barra);
            form.append('nombre', nombre);
            form.append('origen', origen);
            form.append('precio', precio.toString());
            form.append('foto', foto.files[0]);
            ajax.Post(ruta, Manejadora.AgregarProductoFotoSuccess, form, Manejadora.Fail);
        };
        Manejadora.AgregarProductoFotoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasadosFoto();
            alert(respuesta);
            console.log(respuesta);
        };
        Manejadora.btnModificarProductoFoto = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("codigoBarra").value = producto.codigo_barra.toString();
            document.getElementById("cboOrigen").value = producto.origen;
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("imgFoto").src = producto.pathFoto;
        };
        Manejadora.ModificarProductoFoto = function () {
            var ajax = new Ajax();
            var ruta = "../backend/ModificarProductoEnvasadoFoto.php";
            var id = parseInt(document.getElementById("idProducto").value);
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigo_barras = parseInt(document.getElementById("codigoBarra").value);
            var precio = parseInt(document.getElementById("precio").value);
            var foto = document.getElementById("foto");
            var json = "{\"id\":" + id + ",\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\",\"codigo_barra\":" + codigo_barras + ",\"precio\":" + precio + ",\"pathFoto\":\"\"}";
            var form = new FormData();
            form.append('producto_json', json);
            form.append('foto', foto.files[0]);
            ajax.Post(ruta, Manejadora.ModificarProductoFotoSuccess, form, Manejadora.Fail);
        };
        Manejadora.ModificarProductoFotoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.EliminarProductoFoto = function (json) {
            var producto = JSON.parse(json);
            var ajax = new Ajax();
            var ruta = "../backend/BorrarProductoEnvasado.php";
            var id = producto.id;
            var nombre = producto.nombre;
            var origen = producto.origen;
            if (confirm("Desea borrar al empleado nombre: " + nombre + ", correo: " + origen + "?")) {
                var params = "obj_producto=" + json;
                ajax.Post(ruta, Manejadora.EliminarProductoFotoSuccess, params, Manejadora.Fail);
            }
        };
        Manejadora.EliminarProductoFotoSuccess = function (respuesta) {
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.MostrarBorradosJSON = function () {
            var ajax = new Ajax();
            var ruta = "../backend/MostrarBorradosJSON.php";
            ajax.Get(ruta, Manejadora.MostrarBorradosJSONSuccess, "tabla=\"\"", Manejadora.Fail);
        };
        Manejadora.MostrarBorradosJSONSuccess = function (respuesta) {
            console.log(respuesta);
            document.getElementById('divInfo').innerHTML = respuesta;
        };
        Manejadora.MostrarFotosModificados = function () {
            var ajax = new Ajax();
            var ruta = "../backend/MostrarFotosDeModificados.php";
            ajax.Get(ruta, Manejadora.MostrarFotosModificadosSuccess, "tabla=\"\"", Manejadora.Fail);
        };
        Manejadora.MostrarFotosModificadosSuccess = function (respuesta) {
            document.getElementById('divTabla').innerHTML = respuesta;
        };
        Manejadora.FiltrarListado = function () {
            var ajax = new Ajax();
            var ruta = "../backend/FiltrarProductos.php";
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            ajax.Post(ruta, Manejadora.FiltrarProductosSuccess, "nombre=" + nombre + "&origen=" + origen, Manejadora.Fail);
        };
        Manejadora.FiltrarProductosSuccess = function (respuesta) {
            document.getElementById('divTabla').innerHTML = respuesta;
        };
        Manejadora.Fail = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
