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
var PrimerParcial;
(function (PrimerParcial) {
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
    PrimerParcial.Ajax = Ajax;
})(PrimerParcial || (PrimerParcial = {}));
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
        Producto.prototype.ToJSON = function () {
            return JSON.stringify(this);
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
            if (id === void 0) { id = 0; }
            if (codigoBarra === void 0) { codigoBarra = ""; }
            if (precio === void 0) { precio = 0; }
            if (pathFoto === void 0) { pathFoto = ""; }
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
        ProductoEnvasado.prototype.ToJSON = function () {
            return JSON.stringify(this);
        };
        return ProductoEnvasado;
    }(Entidades.Producto));
    Entidades.ProductoEnvasado = ProductoEnvasado;
})(Entidades || (Entidades = {}));
var Entidades;
(function (Entidades) {
    var RetornoJSON = /** @class */ (function () {
        function RetornoJSON(exito, mensaje) {
            this.exito = exito;
            this.mensaje = mensaje;
        }
        return RetornoJSON;
    }());
    Entidades.RetornoJSON = RetornoJSON;
})(Entidades || (Entidades = {}));
/// <reference path="Ajax.ts" />
/// <reference path="Producto.ts" />
/// <reference path="ProductoEnvasado.ts" />
/// <reference path="RetornoJSON.ts" />
/// <reference path="IParte2.ts" />
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        /* #region  Parte 1 */
        Manejadora.AgregarProductoJSON = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var ajax = new PrimerParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post("./BACKEND/AltaProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        Manejadora.VerificarProductoJSON = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var ajax = new PrimerParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post("./BACKEND/VerificarProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new PrimerParcial.Ajax();
            ajax.Get("./BACKEND/ListadoProductosJSON.php", Manejadora.SuccessListadoJSON, "", Manejadora.Fail);
        };
        Manejadora.MostrarInfoCookie = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var ajax = new PrimerParcial.Ajax();
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Get("./BACKEND/MostrarCookie.php", Manejadora.SuccessMostrarInfo, parametros, Manejadora.Fail);
        };
        Manejadora.SuccessMostrarInfo = function (respuesta) {
            document.getElementById('divInfo').innerHTML = respuesta;
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
        Manejadora.AgregarProductoSinFoto = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var codigoBarra = document.getElementById('codigoBarra').value;
            var precio = parseFloat(document.getElementById('precio').value);
            var ajax = new PrimerParcial.Ajax();
            var producto = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio);
            var json = JSON.stringify(producto);
            var parametros = "producto_json=" + json;
            ajax.Post("./BACKEND/AgregarProductoSinFoto.php", Manejadora.AdministrarMensajeAgregarSinFoto, parametros, Manejadora.Fail);
        };
        Manejadora.AdministrarMensajeAgregarSinFoto = function (respuesta) {
            var jsonRespuesta = JSON.parse(respuesta);
            if (jsonRespuesta.exito) {
                Manejadora.MostrarProductosEnvasados();
                alert(respuesta);
                console.log(respuesta);
            }
            else {
                alert(respuesta);
                console.log(respuesta);
            }
        };
        Manejadora.MostrarProductosEnvasados = function () {
            var ajax = new PrimerParcial.Ajax();
            ajax.Get("./BACKEND/ListadoProductosEnvasados.php", Manejadora.ListadoProductosEnvasados, "", Manejadora.Fail);
        };
        /* #region  Parte 2 */
        Manejadora.EliminarProducto = function (json) {
            var producto = JSON.parse(json);
            var ajax = new PrimerParcial.Ajax();
            var parametros = "producto_json=" + json;
            if (!confirm("Desea eliminar el producto " + producto.nombre + " - " + producto.origen + "?")) {
                return;
            }
            else {
                ajax.Post("./BACKEND/EliminarProductoEnvasado.php", Manejadora.MostrarProductosEnvasados, parametros, Manejadora.Fail);
            }
        };
        Manejadora.ModificarProducto = function () {
            var ajax = new PrimerParcial.Ajax();
            var id = document.getElementById("idProducto").value;
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = document.getElementById("precio").value;
            var idNumber = parseInt(id);
            var precioNumber = parseInt(precio);
            var producto = new Entidades.ProductoEnvasado(nombre, origen, idNumber, codigoBarra, precioNumber);
            var json = JSON.stringify(producto);
            var parametros = "producto_json=" + json;
            ajax.Post("./BACKEND/ModificarProductoEnvasado.php", Manejadora.MostrarProductosEnvasados, parametros, Manejadora.Fail);
        };
        Manejadora.Modificar = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("cboOrigen").value = producto.origen;
            document.getElementById("codigoBarra").value = producto.codigoBarra;
            document.getElementById("precio").value = producto.precio.toString();
        };
        Manejadora.ListadoProductosEnvasados = function (respuesta) {
            var arrayProductos = JSON.parse(respuesta);
            var tabla = "<table> <tr> <td> ID </td> <td> NOMBRE </td> <td> ORIGEN </td> <td> CODIGO BARRA </td> <td> PRECIO </td> <td> FOTO </td> </tr>";
            arrayProductos.forEach(function (element) {
                var json = JSON.stringify(element);
                tabla += "\n                <tr>\n                    <th>" + element.id + "</th>\n                    <th>" + element.nombre + "</th>\n                    <th>" + element.origen + "</th>\n                    <th>" + element.codigoBarra + "</th>\n                    <th>" + element.precio + "</th>\n                    <th><input type=\"button\" value=\"Modificar\" class=\"btn btn-dark\" \n                    onclick=PrimerParcial.Manejadora.Modificar('" + json + "')></th>\n                    <th><input type=\"button\" value=\"Eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.EliminarProducto('" + json + "')></th>\n                </tr>";
            });
            tabla += "</table>";
            document.getElementById('divTabla').innerHTML = tabla;
        };
        /* #endregion */
        /* #region  Parte 3 */
        Manejadora.VerificarProductoEnvasado = function () {
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var ajax = new PrimerParcial.Ajax();
            var parametros = "obj_producto={\"nombre\":\"" + nombre + "\",\"origen\":\"" + origen + "\"}";
            ajax.Post("./BACKEND/VerificarProductoEnvasado.php", Manejadora.SuccessMostrarInfo, parametros, Manejadora.Fail);
        };
        Manejadora.AgregarProductoFoto = function () {
            var _a;
            var ajax = new PrimerParcial.Ajax();
            var id = document.getElementById("idProducto").value;
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = document.getElementById("precio").value;
            var foto = (_a = document.getElementById("foto").files) === null || _a === void 0 ? void 0 : _a.item(0);
            var form = new FormData();
            if (foto) {
                form.append("foto", foto);
                form.append("id", id);
                form.append("nombre", nombre);
                form.append("origen", origen);
                form.append("codigoBarra", codigoBarra);
                form.append("precio", precio);
            }
            ajax.Post("./BACKEND/AgregarProductoEnvasado.php", Manejadora.AdministrarMensaje, form, Manejadora.Fail);
        };
        Manejadora.AdministrarMensaje = function (respuesta) {
            var jsonRespuesta = JSON.parse(respuesta);
            if (jsonRespuesta.exito) {
                Manejadora.MostrarProductosEnvasadosFoto();
            }
            else {
                alert(respuesta);
                console.log(respuesta);
            }
        };
        Manejadora.EnviarProductoEnvasadoModificado = function () {
            var _a;
            var ajax = new PrimerParcial.Ajax();
            var id = parseInt(document.getElementById("idProducto").value);
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = parseInt(document.getElementById("precio").value);
            var foto = (_a = document.getElementById("foto").files) === null || _a === void 0 ? void 0 : _a.item(0);
            var form = new FormData();
            var producto = new Entidades.ProductoEnvasado(nombre, origen, id, codigoBarra, precio);
            if (foto) {
                form.append("foto", foto);
                form.append("producto_json", JSON.stringify(producto));
            }
            ajax.Post("./BACKEND/ModificarProductoEnvasadoFoto.php", Manejadora.MostrarProductosEnvasadosFoto, form, Manejadora.Fail);
        };
        Manejadora.ModificarProductoFoto = function (json) {
            var producto = JSON.parse(json);
            document.getElementById("idProducto").value = producto.id.toString();
            document.getElementById("nombre").value = producto.nombre;
            document.getElementById("cboOrigen").value = producto.origen;
            document.getElementById("codigoBarra").value = producto.codigoBarra;
            document.getElementById("precio").value = producto.precio.toString();
            document.getElementById("imgFoto").src = "./BACKEND/" + producto.pathFoto;
        };
        Manejadora.ListadoProductosEnvasadosFoto = function (respuesta) {
            var arrayProductos = JSON.parse(respuesta);
            var tabla = "<table> <tr> <td> ID </td> <td> NOMBRE </td> <td> ORIGEN </td> <td> CODIGO BARRA </td> <td> PRECIO </td> <td> FOTO </td> </tr>";
            arrayProductos.forEach(function (element) {
                var json = JSON.stringify(element);
                tabla += "\n                <tr>\n                    <th>" + element.id + "</th>\n                    <th>" + element.nombre + "</th>\n                    <th>" + element.origen + "</th>\n                    <th>" + element.codigoBarra + "</th>\n                    <th>" + element.precio + "</th>\n                    <th><img src=./BACKEND/" + element.pathFoto + " alt=fotoProducto height=50px widht=50px/></th>\n                    <th><input type=\"button\" value=\"Modificar\" class=\"btn btn-dark\" \n                    onclick=PrimerParcial.Manejadora.ModificarProductoFoto('" + json + "')></th>\n                    <th><input type=\"button\" value=\"Eliminar\" class=\"btn btn-dark\" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('" + json + "')></th>\n                </tr>";
            });
            tabla += "</table>";
            document.getElementById('divTabla').innerHTML = tabla;
        };
        Manejadora.BorrarProductoFoto = function (json) {
            var producto = JSON.parse(json);
            var ajax = new PrimerParcial.Ajax();
            var parametros = "producto_json=" + json;
            if (!confirm("Desea eliminar el producto " + producto.nombre + " - " + producto.origen + "?")) {
                return;
            }
            else {
                ajax.Post("./BACKEND/BorrarProductoEnvasado.php", Manejadora.MostrarProductosEnvasadosFoto, parametros, Manejadora.Fail);
            }
        };
        Manejadora.MostrarProductosEnvasadosFoto = function () {
            var ajax = new PrimerParcial.Ajax();
            ajax.Get("./BACKEND/ListadoProductosEnvasados.php", Manejadora.ListadoProductosEnvasadosFoto, "", Manejadora.Fail);
        };
        /* #endregion */
        /* #region  Parte 4 */
        Manejadora.MostrarBorradosJSON = function () {
            var ajax = new PrimerParcial.Ajax();
            ajax.Get("./BACKEND/MostrarBorradosJSON.php", Manejadora.MostrarBorradosJSONConsola, "", Manejadora.Fail);
        };
        Manejadora.MostrarBorradosJSONConsola = function (respuesta) {
            console.log(respuesta);
            document.getElementById("divTabla").innerHTML = respuesta;
        };
        Manejadora.MostrarFotosModificados = function () {
            var ajax = new PrimerParcial.Ajax();
            ajax.Post("./BACKEND/MostrarFotosDeModificados.php", Manejadora.MostrarEnTabla, "", Manejadora.Fail);
        };
        Manejadora.MostrarEnTabla = function (respuesta) {
            document.getElementById("divTabla").innerHTML = respuesta;
        };
        Manejadora.FiltrarListado = function () {
            var ajax = new PrimerParcial.Ajax();
            var nombre = document.getElementById('nombre').value;
            var origen = document.getElementById('cboOrigen').value;
            var parametros = "nombre=" + nombre + "&origen=" + origen;
            ajax.Post("./BACKEND/FiltrarProducto.php", Manejadora.MostrarEnTabla, parametros, Manejadora.Fail);
        };
        /* #endregion */
        /* #region  x */
        Manejadora.prototype.MostrarBorradosJSON = function () {
        };
        Manejadora.prototype.MostrarFotoModificados = function () {
        };
        Manejadora.prototype.FiltrarListado = function () {
        };
        Manejadora.prototype.EliminarProducto = function (json) {
        };
        Manejadora.prototype.ModificarProducto = function (json) {
        };
        Manejadora.prototype.VerificarProductoEnvasado = function () {
        };
        Manejadora.prototype.AgregarProductoFoto = function () {
        };
        Manejadora.prototype.BorrarProductoFoto = function (json) {
        };
        Manejadora.prototype.ModificarProductoFoto = function (json) {
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));
