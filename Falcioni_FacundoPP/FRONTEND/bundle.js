"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var ModeloParcial;
(function (ModeloParcial) {
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
    ModeloParcial.Ajax = Ajax;
})(ModeloParcial || (ModeloParcial = {}));
var Entidades;
(function (Entidades) {
    var Producto = /** @class */ (function () {
        function Producto(nombre, origen) {
            this.nombre = nombre;
            this.origen = origen;
        }
        Producto.prototype.ToString = function () {
            return this.nombre + " - " + this.origen;
        };
        return Producto;
    }());
    Entidades.Producto = Producto;
})(Entidades || (Entidades = {}));
/// <reference path="Producto.ts" />
var Entidades;
(function (Entidades) {
    var ProductoEnvasado = /** @class */ (function (_super) {
        __extends(ProductoEnvasado, _super);
        function ProductoEnvasado(nombre, origen, id, codigoBarra, precio, pathFoto) {
            var _this = _super.call(this, nombre, origen) || this;
            _this.id = id;
            _this.codigoBarra = codigoBarra;
            _this.precio = precio;
            _this.pathFoto = pathFoto;
            return _this;
        }
        ProductoEnvasado.prototype.ToString = function () {
            return _super.prototype.ToString.call(this) + " - " + this.id + " - " + this.codigoBarra + " - " + this.precio + " - " + this.pathFoto;
        };
        return ProductoEnvasado;
    }(Entidades.Producto));
    Entidades.ProductoEnvasado = ProductoEnvasado;
})(Entidades || (Entidades = {}));
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
            var codigoBarra = parseInt(document.getElementById('origen').value);
            var precio = parseFloat(document.getElementById('precio').value);
            var ajax = new ModeloParcial.Ajax();
            var producto = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio, "");
            var json = JSON.stringify(producto);
            ajax.Post("./BACKEND/AgregarProductoSinFoto.php", Manejadora.Success, json, Manejadora.Fail);
        };
        return Manejadora;
    }());
    ModeloParcial.Manejadora = Manejadora;
})(ModeloParcial || (ModeloParcial = {}));
//# sourceMappingURL=bundle.js.map