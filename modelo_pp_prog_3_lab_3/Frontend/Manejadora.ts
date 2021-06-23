/// <reference path="ajax.ts" />
/// <reference path="Usuario.ts" />
/// <reference path="Empleado.ts" />

namespace ModeloParcial{
     export class Manejadora{

        public static AgregarUsuarioJSON () : void{

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/AltaUsuarioJSON.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let params : string = `correo=${correo}&nombre=${nombre}&clave=${clave}`;

            ajax.Post(ruta,Manejadora.AgregarUsuarioJSONSucces,params,Manejadora.AgregarUsuarioJSONFail);
        }

        public static AgregarUsuarioJSONSucces(respuesta: string) : void{
            Manejadora.MostrarUsuariosJSON();
            console.log(respuesta);
            alert(respuesta);
        }

        public static AgregarUsuarioJSONFail(respuesta : string) : void{
            console.log(respuesta);
        }

        public static MostrarUsuariosJSON() :void{

            let ajax : Ajax = new Ajax();
            let ruta : string = "./backend/ListadoUsuariosJson.php";

            ajax.Get(ruta,Manejadora.MostrarUsuariosJSONSucces,"accion=listar",Manejadora.MostrarUsuariosJSONFail)
        }

        public static MostrarUsuariosJSONSucces(respuesta: string) : void{

            let arrayUsuarios : Entidades.Usuario[] = JSON.parse(respuesta);

            let div : string = `
            <table>
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Clave</th>
                    </tr>
                </thead>`;

            arrayUsuarios.forEach(item => {
                div += `
                <tr>
                    <th>${item.nombre}</th>
                    <th>${item.correo}</th>
                    <th>${item.clave}</th>
                </tr>`;
            });

            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = div;
            
        }

        public static MostrarUsuariosJSONFail(respuesta : string) : void{
            console.log(respuesta);
        }


        public static AgregarUsuario(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/AltaUsuario.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil :string = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;
            let params : string = `correo=${correo}&nombre=${nombre}&clave=${clave}&id_perfil=${id_perfil}`;

            ajax.Post(ruta,Manejadora.AgregarUsuarioJSONSucces,params,Manejadora.AgregarUsuarioJSONFail);
        }

        public static AgregarUsuarioSucces(respuesta: string) : void{
            console.log(respuesta);
            alert(respuesta);
        }

        public static AgregarUsuarioFail(respuesta : string) : void{
            console.log(respuesta);
        }
        
        public static VerificarUsuario() :void{

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/VerificarUsuario.php";


            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let params : string = `usuario_json={"correo":"${correo}","clave":"${clave}"}`;

            ajax.Post(ruta,Manejadora.VerificarUsuarioSucces,params,Manejadora.VerificarUsuarioFail);
        }

        public static VerificarUsuarioSucces(respuesta: string) : void{
            console.log(respuesta);
            alert(respuesta);
        }

        public static VerificarUsuarioFail(respuesta : string) : void{
            console.log(respuesta);
        }

        public static MostrarUsuarios() :void{

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/ListadoUsuario.php";

            ajax.Get(ruta,Manejadora.MostrarUsuariosSucces,`tabla=""`,Manejadora.MostrarUsuariosFail)
        }

        public static MostrarUsuariosSucces(respuesta: string) : void{
         
            let arrayUsuarios : Entidades.Usuario[] = JSON.parse(respuesta);

            let div : string = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Descripcion</th>
                        <th>Accion</th>
                    </tr>
                </thead>`;

            arrayUsuarios.forEach(item => {

                let json = JSON.stringify(item);

                div += `
                <tr>
                    <th>${item.id}</th>
                    <th>${item.nombre}</th>
                    <th>${item.correo}</th>
                    <th>${item.descripcion}</th>
                    <th> <input type="button" value="modificar" class="btn btn-dark" onclick=ModeloParcial.Manejadora.BtnModificarUsuario('${json}')></th>
                    <th> <input type="button" value="eliminar" class="btn btn-dark" onclick=ModeloParcial.Manejadora.EliminarUsuario('${json}') /> </th>
                </tr>`;
            });
            
            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = div;

        }

        public static MostrarUsuariosFail(respuesta : string) : void{
            console.log(respuesta);
        }

        public static BtnModificarUsuario(json : string){

            let usuario : Entidades.Usuario = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("id")).value = usuario.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = usuario.nombre;
            (<HTMLInputElement>document.getElementById("correo")).value = usuario.correo;
            (<HTMLInputElement>document.getElementById("clave")).value = usuario.clave;
            (<HTMLInputElement>document.getElementById("cboPerfiles")).value = usuario.id_perfil.toString();
            
        }

        public static ModificarUsuario(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/ModificarUsuario.php";

            let id :number  = parseInt((<HTMLInputElement> document.getElementById("id")).value);
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil :number = parseInt((<HTMLInputElement> document.getElementById("cboPerfiles")).value);
            let params : string = `usuario_json={"id":${id},"correo":"${correo}","nombre":"${nombre}","clave":"${clave}","id_perfil":${id_perfil}}`;

            ajax.Post(ruta,Manejadora.ModificarUsuarioSuccess,params,Manejadora.ModificarUsuarioFail)
        }

        public static ModificarUsuarioSuccess(respuesta : string){

            ModeloParcial.Manejadora.MostrarUsuarios();

            console.log(respuesta);
            alert(respuesta);
        }

        public static ModificarUsuarioFail(respuesta : string){
            console.log(respuesta);
        }

        public static EliminarUsuario(json : string){

            let usuario : Entidades.Usuario = JSON.parse(json);

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/EliminarUsuario.php";

            let id :number  = usuario.id;
            let nombre :string = usuario.nombre;
            let correo :string = usuario.correo;

            if(confirm(`Desea borrar al usuario nombre: ${nombre}, correo: ${correo}?`)){
                let params : string = `accion=borrar&id=${id}`;
                ajax.Post(ruta,Manejadora.EliminarUsuarioSuccess,params,Manejadora.EliminarUsuarioFail);
            }
        }

        public static EliminarUsuarioSuccess(respuesta : string){
            ModeloParcial.Manejadora.MostrarUsuarios();

            console.log(respuesta);
            alert(respuesta);
        }

        public static EliminarUsuarioFail(respuesta : string){
            console.log(respuesta);
        }


    }
}