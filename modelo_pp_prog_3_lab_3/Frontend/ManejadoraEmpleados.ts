/// <reference path="ajax.ts" />
/// <reference path="Empleado.ts" />

namespace Modelo{
    export class ManejadoraEmpleados{

        public static MostrarEmpleados(){

            let ajax : Ajax = new Ajax();
            let ruta : string = "./backend/ListadoEmpleados.php";

            ajax.Get(ruta,ManejadoraEmpleados.MostrarEmpleadosSuccess,"accion=listar",ManejadoraEmpleados.MostrarEmpleadosFail)
        }

        public static MostrarEmpleadosSuccess(respuesta : string ){

            let arrayUsuarios : Entidades.Empleado[] = JSON.parse(respuesta);

            let div : string = `
            <table>
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Descripcion</th>
                    <th>Sueldo</th>
                    <th>Foto</th>
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
                    <th>${item.sueldo}</th>
                    <th><img src=${item.foto} width=50px height=50px></th>
                    <th> <input type="button" value="modificar" class="btn btn-dark" onclick=Modelo.ManejadoraEmpleados.BtnModificarEmpleado('${json}')></th>
                    <th> <input type="button" value="eliminar" class="btn btn-dark" onclick=Modelo.ManejadoraEmpleados.EliminarEmpleado('${json}')></th>
                </tr>`;
            });

            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTablaEmpleados')).innerHTML = div;
            
        }

        public static MostrarEmpleadosFail(respuesta : string){
            console.log(respuesta);
        }

        public static AgregarEmpleado(){
            
            let ajax : Ajax = new Ajax();
            let ruta : string = "./backend/AltaEmpleado.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil :string = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;
            let sueldo :string = (<HTMLInputElement> document.getElementById("sueldo")).value;
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));   

            let form : FormData = new FormData();
            form.append('nombre', nombre);
            form.append('correo', correo);
            form.append('clave', clave);
            form.append('id_perfil', id_perfil);
            form.append('sueldo',sueldo);
            form.append('foto', foto.files[0]);

            ajax.Post(ruta,ManejadoraEmpleados.AgregarEmpleadoSuccess,form,ManejadoraEmpleados.AgregarEmpleadoFail);
        }
        public static AgregarEmpleadoSuccess(respuesta : string){
            ManejadoraEmpleados.MostrarEmpleados();
            alert(respuesta);
            console.log(respuesta);
        }
        public static AgregarEmpleadoFail(respuesta : string){
            console.log(respuesta);
        }

        public static BtnModificarEmpleado(json : string){

            let empleado : Entidades.Empleado = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("id")).value = empleado.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = empleado.nombre;
            (<HTMLInputElement>document.getElementById("correo")).value = empleado.correo;
            (<HTMLInputElement>document.getElementById("clave")).value = empleado.clave;
            (<HTMLInputElement>document.getElementById("cboPerfiles")).value = empleado.id_perfil.toString();
            (<HTMLInputElement>document.getElementById("sueldo")).value = empleado.sueldo.toString();
            (<HTMLImageElement>document.getElementById("imgFoto")).src = empleado.foto;
        }

        public static ModificarEmpleado(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/ModificarEmpleado.php";

            let id : number = parseInt((<HTMLInputElement> document.getElementById("id")).value);
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo :string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave :string = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil :number = parseInt((<HTMLInputElement> document.getElementById("cboPerfiles")).value);
            let sueldo :number = parseInt((<HTMLInputElement> document.getElementById("sueldo")).value);
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            let pathFoto: string = (<HTMLImageElement>document.getElementById("imgFoto")).src;

            let json = `{"id":${id},"correo":"${correo}","nombre":"${nombre}","clave":"${clave}","id_perfil":${id_perfil},"sueldo":${sueldo},"pathFoto":"${pathFoto}"}`
            
            let form : FormData = new FormData();
            form.append('empleado_json',json);
            form.append('foto', foto.files[0]);

            ajax.Post(ruta,ManejadoraEmpleados.ModificarEmpleadoSuccess,form,ManejadoraEmpleados.ModificarEmpleadoFail);
        }

        public static ModificarEmpleadoSuccess(respuesta : string){

            ManejadoraEmpleados.MostrarEmpleados();

            console.log(respuesta);
            alert(respuesta);
        }

        public static ModificarEmpleadoFail(respuesta : string){
            console.log(respuesta);
        }

        public static EliminarEmpleado(json : string){

            let usuario : Entidades.Empleado = JSON.parse(json);

            let ajax : Ajax = new Ajax();
            let ruta :string = "./backend/EliminarEmpleado.php";

            let id :number  = usuario.id;
            let nombre :string = usuario.nombre;
            let correo :string = usuario.correo;

            if(confirm(`Desea borrar al empleado nombre: ${nombre}, correo: ${correo}?`)){
                let params : string = `accion=borrar&id=${id}`;
                ajax.Post(ruta,ManejadoraEmpleados.EliminarEmpleadoSuccess,params,ManejadoraEmpleados.EliminarEmpleadoFail);
            }
        }

        public static EliminarEmpleadoSuccess(respuesta : string){
            Modelo.ManejadoraEmpleados.MostrarEmpleados();

            console.log(respuesta);
            alert(respuesta);
        }

        public static EliminarEmpleadoFail(respuesta : string){
            console.log(respuesta);
        }
    }
}