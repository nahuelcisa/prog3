/// <reference path="Persona.ts" />

namespace Entidades{
    export class Usuario extends Persona{
        public id : number;
        public id_perfil : number;
        public descripcion : string;

        public constructor(nombre:string, correo:string, clave:string, id:number, id_perfil:number, descripcion:string)
        {
            super(nombre,correo,clave);
            this.id = id;
            this.id_perfil = id_perfil;
            this.descripcion = descripcion;
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