"use strict";
/// <reference path="ajax.ts" />
/// <reference path="Usuario.ts" />
/// <reference path="Empleado.ts" />
var ModeloParcial;
(function (ModeloParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarUsuarioJSON = function () {
            var ajax = new Ajax();
            var ruta = "./backend/AltaUsuarioJSON.php";
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var params = "correo=" + correo + "&nombre=" + nombre + "&clave=" + clave;
            ajax.Post(ruta, Manejadora.AgregarUsuarioJSONSucces, params, Manejadora.AgregarUsuarioJSONFail);
        };
        Manejadora.AgregarUsuarioJSONSucces = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.AgregarUsuarioJSONFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.MostrarUsuariosJSON = function () {
            var ajax = new Ajax();
            var ruta = "./backend/ListadoUsuariosJson.php";
            ajax.Get(ruta, Manejadora.MostrarUsuariosJSONSucces, "accion=listar", Manejadora.MostrarUsuariosJSONFail);
        };
        Manejadora.MostrarUsuariosJSONSucces = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                    <th>Nombre</th>\n                    <th>Correo</th>\n                    <th>Clave</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                div += "\n                <tr>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.correo + "</th>\n                    <th>" + item.clave + "</th>\n                </tr>";
            });
            div += "</table>";
            document.getElementById('divTabla').innerHTML = div;
        };
        Manejadora.MostrarUsuariosJSONFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.AgregarUsuario = function () {
            var ajax = new Ajax();
            var ruta = "./backend/AltaUsuario.php";
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var params = "correo=" + correo + "&nombre=" + nombre + "&clave=" + clave + "&id_perfil=" + id_perfil;
            ajax.Post(ruta, Manejadora.AgregarUsuarioJSONSucces, params, Manejadora.AgregarUsuarioJSONFail);
        };
        Manejadora.AgregarUsuarioSucces = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.AgregarUsuarioFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.VerificarUsuario = function () {
            var ajax = new Ajax();
            var ruta = "./backend/VerificarUsuario.php";
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var params = "usuario_json={\"correo\":\"" + correo + "\",\"clave\":\"" + clave + "\"}";
            ajax.Post(ruta, Manejadora.VerificarUsuarioSucces, params, Manejadora.VerificarUsuarioFail);
        };
        Manejadora.VerificarUsuarioSucces = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.VerificarUsuarioFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.MostrarUsuarios = function () {
            var ajax = new Ajax();
            var ruta = "./backend/ListadoUsuario.php";
            ajax.Get(ruta, Manejadora.MostrarUsuariosSucces, "tabla=\"\"", Manejadora.MostrarUsuariosFail);
        };
        Manejadora.MostrarUsuariosSucces = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                        <th>ID</th>\n                        <th>Nombre</th>\n                        <th>Correo</th>\n                        <th>Descripcion</th>\n                        <th>Accion</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                var json = JSON.stringify(item);
                div += "\n                <tr>\n                    <th>" + item.id + "</th>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.correo + "</th>\n                    <th>" + item.descripcion + "</th>\n                    <th> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=ModeloParcial.Manejadora.BtnModificarUsuario('" + json + "')></th>\n                    <th> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=ModeloParcial.Manejadora.EliminarUsuario('" + json + "') /> </th>\n                </tr>";
            });
            div += "</table>";
            document.getElementById('divTabla').innerHTML = div;
        };
        Manejadora.MostrarUsuariosFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.BtnModificarUsuario = function (json) {
            var usuario = JSON.parse(json);
            document.getElementById("id").value = usuario.id.toString();
            document.getElementById("nombre").value = usuario.nombre;
            document.getElementById("correo").value = usuario.correo;
            document.getElementById("clave").value = usuario.clave;
            document.getElementById("cboPerfiles").value = usuario.id_perfil.toString();
        };
        Manejadora.ModificarUsuario = function () {
            var ajax = new Ajax();
            var ruta = "./backend/ModificarUsuario.php";
            var id = parseInt(document.getElementById("id").value);
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = parseInt(document.getElementById("cboPerfiles").value);
            var params = "usuario_json={\"id\":" + id + ",\"correo\":\"" + correo + "\",\"nombre\":\"" + nombre + "\",\"clave\":\"" + clave + "\",\"id_perfil\":" + id_perfil + "}";
            ajax.Post(ruta, Manejadora.ModificarUsuarioSuccess, params, Manejadora.ModificarUsuarioFail);
        };
        Manejadora.ModificarUsuarioSuccess = function (respuesta) {
            ModeloParcial.Manejadora.MostrarUsuarios();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.ModificarUsuarioFail = function (respuesta) {
            console.log(respuesta);
        };
        Manejadora.EliminarUsuario = function (json) {
            var usuario = JSON.parse(json);
            var ajax = new Ajax();
            var ruta = "./backend/EliminarUsuario.php";
            var id = usuario.id;
            var nombre = usuario.nombre;
            var correo = usuario.correo;
            if (confirm("Desea borrar al usuario nombre: " + nombre + ", correo: " + correo + "?")) {
                var params = "accion=borrar&id=" + id;
                ajax.Post(ruta, Manejadora.EliminarUsuarioSuccess, params, Manejadora.EliminarUsuarioFail);
            }
        };
        Manejadora.EliminarUsuarioSuccess = function (respuesta) {
            ModeloParcial.Manejadora.MostrarUsuarios();
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.EliminarUsuarioFail = function (respuesta) {
            console.log(respuesta);
        };
        return Manejadora;
    }());
    ModeloParcial.Manejadora = Manejadora;
})(ModeloParcial || (ModeloParcial = {}));
//# sourceMappingURL=Manejadora.js.map