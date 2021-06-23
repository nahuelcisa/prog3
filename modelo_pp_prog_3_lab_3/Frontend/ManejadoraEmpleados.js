"use strict";
/// <reference path="ajax.ts" />
/// <reference path="Empleado.ts" />
var Modelo;
(function (Modelo) {
    var ManejadoraEmpleados = /** @class */ (function () {
        function ManejadoraEmpleados() {
        }
        ManejadoraEmpleados.MostrarEmpleados = function () {
            var ajax = new Ajax();
            var ruta = "./backend/ListadoEmpleados.php";
            ajax.Get(ruta, ManejadoraEmpleados.MostrarEmpleadosSuccess, "accion=listar", ManejadoraEmpleados.MostrarEmpleadosFail);
        };
        ManejadoraEmpleados.MostrarEmpleadosSuccess = function (respuesta) {
            var arrayUsuarios = JSON.parse(respuesta);
            var div = "\n            <table>\n                <thead>\n                    <tr>\n                    <th>ID</th>\n                    <th>Nombre</th>\n                    <th>Correo</th>\n                    <th>Descripcion</th>\n                    <th>Sueldo</th>\n                    <th>Foto</th>\n                    </tr>\n                </thead>";
            arrayUsuarios.forEach(function (item) {
                var json = JSON.stringify(item);
                div += "\n                <tr>\n                    <th>" + item.id + "</th>\n                    <th>" + item.nombre + "</th>\n                    <th>" + item.correo + "</th>\n                    <th>" + item.descripcion + "</th>\n                    <th>" + item.sueldo + "</th>\n                    <th><img src=" + item.foto + " width=50px height=50px></th>\n                    <th> <input type=\"button\" value=\"modificar\" class=\"btn btn-dark\" onclick=Modelo.ManejadoraEmpleados.BtnModificarEmpleado('" + json + "')></th>\n                    <th> <input type=\"button\" value=\"eliminar\" class=\"btn btn-dark\" onclick=Modelo.ManejadoraEmpleados.EliminarEmpleado('" + json + "')></th>\n                </tr>";
            });
            div += "</table>";
            document.getElementById('divTablaEmpleados').innerHTML = div;
        };
        ManejadoraEmpleados.MostrarEmpleadosFail = function (respuesta) {
            console.log(respuesta);
        };
        ManejadoraEmpleados.AgregarEmpleado = function () {
            var ajax = new Ajax();
            var ruta = "./backend/AltaEmpleado.php";
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var sueldo = document.getElementById("sueldo").value;
            var foto = document.getElementById("foto");
            var form = new FormData();
            form.append('nombre', nombre);
            form.append('correo', correo);
            form.append('clave', clave);
            form.append('id_perfil', id_perfil);
            form.append('sueldo', sueldo);
            form.append('foto', foto.files[0]);
            ajax.Post(ruta, ManejadoraEmpleados.AgregarEmpleadoSuccess, form, ManejadoraEmpleados.AgregarEmpleadoFail);
        };
        ManejadoraEmpleados.AgregarEmpleadoSuccess = function (respuesta) {
            ManejadoraEmpleados.MostrarEmpleados();
            alert(respuesta);
            console.log(respuesta);
        };
        ManejadoraEmpleados.AgregarEmpleadoFail = function (respuesta) {
            console.log(respuesta);
        };
        ManejadoraEmpleados.BtnModificarEmpleado = function (json) {
            var empleado = JSON.parse(json);
            document.getElementById("id").value = empleado.id.toString();
            document.getElementById("nombre").value = empleado.nombre;
            document.getElementById("correo").value = empleado.correo;
            document.getElementById("clave").value = empleado.clave;
            document.getElementById("cboPerfiles").value = empleado.id_perfil.toString();
            document.getElementById("sueldo").value = empleado.sueldo.toString();
            document.getElementById("imgFoto").src = empleado.foto;
        };
        ManejadoraEmpleados.ModificarEmpleado = function () {
            var ajax = new Ajax();
            var ruta = "./backend/ModificarEmpleado.php";
            var id = parseInt(document.getElementById("id").value);
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = parseInt(document.getElementById("cboPerfiles").value);
            var sueldo = parseInt(document.getElementById("sueldo").value);
            var foto = document.getElementById("foto");
            var pathFoto = document.getElementById("imgFoto").src;
            var json = "{\"id\":" + id + ",\"correo\":\"" + correo + "\",\"nombre\":\"" + nombre + "\",\"clave\":\"" + clave + "\",\"id_perfil\":" + id_perfil + ",\"sueldo\":" + sueldo + ",\"pathFoto\":\"" + pathFoto + "\"}";
            var form = new FormData();
            form.append('empleado_json', json);
            form.append('foto', foto.files[0]);
            ajax.Post(ruta, ManejadoraEmpleados.ModificarEmpleadoSuccess, form, ManejadoraEmpleados.ModificarEmpleadoFail);
        };
        ManejadoraEmpleados.ModificarEmpleadoSuccess = function (respuesta) {
            ManejadoraEmpleados.MostrarEmpleados();
            console.log(respuesta);
            alert(respuesta);
        };
        ManejadoraEmpleados.ModificarEmpleadoFail = function (respuesta) {
            console.log(respuesta);
        };
        ManejadoraEmpleados.EliminarEmpleado = function (json) {
            var usuario = JSON.parse(json);
            var ajax = new Ajax();
            var ruta = "./backend/EliminarEmpleado.php";
            var id = usuario.id;
            var nombre = usuario.nombre;
            var correo = usuario.correo;
            if (confirm("Desea borrar al empleado nombre: " + nombre + ", correo: " + correo + "?")) {
                var params = "accion=borrar&id=" + id;
                ajax.Post(ruta, ManejadoraEmpleados.EliminarEmpleadoSuccess, params, ManejadoraEmpleados.EliminarEmpleadoFail);
            }
        };
        ManejadoraEmpleados.EliminarEmpleadoSuccess = function (respuesta) {
            Modelo.ManejadoraEmpleados.MostrarEmpleados();
            console.log(respuesta);
            alert(respuesta);
        };
        ManejadoraEmpleados.EliminarEmpleadoFail = function (respuesta) {
            console.log(respuesta);
        };
        return ManejadoraEmpleados;
    }());
    Modelo.ManejadoraEmpleados = ManejadoraEmpleados;
})(Modelo || (Modelo = {}));
//# sourceMappingURL=ManejadoraEmpleados.js.map