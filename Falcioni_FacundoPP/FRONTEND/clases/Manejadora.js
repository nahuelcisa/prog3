"use strict";
/// <reference path="Ajax.ts" />
/// <reference path="Producto.ts" />
/// <reference path="ProductoEnvasado.ts" />
var ModeloParcial;
(function (ModeloParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarProductoJSON = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('origen').value;
            var ajax = new ModeloParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post("./BACKEND/AltaProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        Manejadora.VerificarProductoJSON = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('origen').value;
            var ajax = new ModeloParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post("./BACKEND/VerificarProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new ModeloParcial.Ajax();
            ajax.Get("./BACKEND/ListadoProductosJSON.php", Manejadora.SuccessListadoJSON, "", Manejadora.Fail);
        };
        Manejadora.MostrarCookie = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('origen').value;
            var ajax = new ModeloParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Get("./BACKEND/MostrarCookie.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        Manejadora.SuccessListadoJSON = function (respuesta) {
            document.getElementById('divTabla').innerHTML = respuesta;
        };
        Manejadora.Success = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        Manejadora.Fail = function (respuesta) {
            console.log(respuesta);
            alert(respuesta);
        };
        /*
            AgregarProductoSinFoto.php: Se recibe por POST el parámetro producto_json (codigoBarra, nombre, origen y
            precio), en formato de cadena JSON. Se invocará al método Agregar.
            Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

            ListadoProductosEnvasados.php: (GET) Se mostrará el listado completo de los productos envasados (obtenidos
            de la base de datos) en una tabla (HTML con cabecera). Invocar al método Traer.
            Nota: Si se recibe el parámetro tabla con el valor mostrar, retornará los datos en una tabla (HTML con cabecera),
            preparar la tabla para que muestre la imagen, si es que la tiene.
            Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON.

        */
        Manejadora.AgregarProductoSinFoto = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('origen').value;
            var codigoBarra = parseInt(document.getElementById('codigoBarra').value);
            var precio = parseFloat(document.getElementById('precio').value);
            var ajax = new ModeloParcial.Ajax();
            var producto = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio, "");
            var json = JSON.stringify(producto);
            var parametros = "producto_json=" + json;
            ajax.Post("./BACKEND/AgregarProductoSinFoto.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        return Manejadora;
    }());
    ModeloParcial.Manejadora = Manejadora;
})(ModeloParcial || (ModeloParcial = {}));
//# sourceMappingURL=Manejadora.js.map