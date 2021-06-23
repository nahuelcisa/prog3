var Entidades;
(function (Entidades) {
    var Producto = /** @class */ (function () {
        function Producto(nombre, origen) {
            this.nombre = nombre;
            this.origen = origen;
        }
        Producto.prototype.ToJSON = function () {
            return JSON.stringify(this);
        };
        Producto.prototype.ToString = function () {
            return this.ToJSON().toString();
        };
        return Producto;
    }());
    Entidades.Producto = Producto;
})(Entidades || (Entidades = {}));
