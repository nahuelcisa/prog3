namespace Entidades
{
    export class RetornoJSON
    {
        public exito: boolean;
        public mensaje: string;

        public constructor(exito: boolean, mensaje: string)
        {
            this.exito = exito;
            this.mensaje = mensaje;
        }
    }
}