/// <reference path="Usuario.ts" />
/// <reference path="ajax.ts" />

namespace Entidades{
    
    export class Empleado extends Usuario{
        
        public sueldo : number;
        public foto : string;

        public constructor(nombre:string, correo:string, clave:string, id:number, id_perfil:number, perfil:string,sueldo:number, foto:string){
            super(nombre,correo,clave,id,id_perfil,perfil);
            this.sueldo = sueldo;
            this.foto = foto;
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