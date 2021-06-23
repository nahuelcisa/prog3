/// <reference path="Producto.ts" />
namespace Entidades{
    export class ProductoEnvasado extends Producto{

        public id : number;
        public codigo_barra : string;
        public precio : number;
        public pathFoto : string;

        public constructor(nombre: string, origen: string, id: number, codigoBarra: string, precio: number, pathFoto: string)
        {
            super(nombre, origen);
            this.id = id;
            this.codigo_barra = codigoBarra;
            this.precio = precio;
            this.pathFoto = pathFoto;
        }

        public ToJSON() : string
        {
            return JSON.stringify(this);
        }

        public ToString() : string
        {
            return this.ToJSON().toString();
        }
    }
}