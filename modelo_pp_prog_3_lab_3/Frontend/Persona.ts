namespace Entidades{
    export class Persona{

        public nombre : string;
        public correo : string;
        public clave : string;

        public constructor(nombre : string, correo : string, clave : string){
            this.nombre = nombre;
            this.correo = correo;
            this.clave = clave;
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

