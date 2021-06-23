"use strict";
var Entidades;
(function (Entidades) {
    var Persona = /** @class */ (function () {
        function Persona(nombre, correo, clave) {
            this.nombre = nombre;
            this.correo = correo;
            this.clave = clave;
        }
        Persona.prototype.ToJSON = function () {
            return JSON.stringify(this);
        };
        Persona.prototype.ToString = function () {
            return this.ToJSON().toString();
        };
        return Persona;
    }());
    Entidades.Persona = Persona;
})(Entidades || (Entidades = {}));
//# sourceMappingURL=Persona.js.map