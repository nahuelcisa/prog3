namespace Entidades
{
    export class Producto
    {
        public nombre: string;
        public origen: string;

        public constructor(nombre: string, origen: string)
        {
            this.nombre = nombre;
            this.origen = origen;
        }

        public ToString(): string
        {
            return `${this.nombre} - ${this.origen}`;
        }

        public ToJSON()
        {
            return JSON.stringify(this);
        }
    }
}