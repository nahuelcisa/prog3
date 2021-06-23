namespace Entidades{
    export class Producto{

        public nombre : string;
        public origen : string;

        public constructor(nombre : string, origen : string){
            this.nombre = nombre;
            this.origen = origen;
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