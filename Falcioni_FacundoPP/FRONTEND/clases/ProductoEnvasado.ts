/// <reference path="Producto.ts" />

namespace Entidades
{
    export class ProductoEnvasado extends Producto
    {
        public id: number;
        public codigoBarra: string;
        public precio: number;
        public pathFoto: string;

        public constructor(nombre: string , origen: string, id: number = 0, codigoBarra: string = "", precio: number = 0, pathFoto: string = "")
        {
            super(nombre, origen);
            this.id = id;
            this.codigoBarra = codigoBarra;
            this.precio = precio;
            this.pathFoto = pathFoto;
        }
        
        public ToString()
        {
            return `${super.ToString()} - ${this.id} - ${this.codigoBarra} - ${this.precio} - ${this.pathFoto}`;
        }

        public ToJSON()
        {
            return JSON.stringify(this);
        }
    }
}