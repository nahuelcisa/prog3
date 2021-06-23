"use strict";
/// <reference path="Persona.ts" />
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
var Entidades;
(function (Entidades) {
    var Usuario = /** @class */ (function (_super) {
        __extends(Usuario, _super);
        function Usuario(nombre, correo, clave, id, id_perfil, descripcion) {
            var _this = _super.call(this, nombre, correo, clave) || this;
            _this.id = id;
            _this.id_perfil = id_perfil;
            _this.descripcion = descripcion;
            return _this;
        }
        Usuario.prototype.ToJSON = function () {
            return JSON.stringify(this);
        };
        Usuario.prototype.ToString = function () {
            return this.ToJSON().toString();
        };
        return Usuario;
    }(Entidades.Persona));
    Entidades.Usuario = Usuario;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=Usuario.js.map