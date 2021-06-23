/// <reference path="ajax.ts" />
/// <reference path="ProductoEnvasado.ts" />
/// <reference path="Producto.ts" />

namespace PrimerParcial {

    export class Manejadora {

        public static AgregarProductoJSON(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/AltaProductoJSON.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let params : string = `nombre=${nombre}&origen=${origen}`;

            ajax.Post(ruta,Manejadora.AgregarProductoJSONSuccess,params,Manejadora.Fail);
        }

        public static AgregarProductoJSONSuccess( respuesta : string){

            Manejadora.MostrarProductosJSON();
            console.log(respuesta);
            alert(respuesta);

        }

        public static MostrarProductosJSON(){

            let ajax : Ajax = new Ajax();
            let ruta : string = "../backend/ListadoProductosJSON.php";

            ajax.Get(ruta,Manejadora.MostrarProductosJSONSuccess,"listar=listar",Manejadora.Fail)
        }

        public static MostrarProductosJSONSuccess(respuesta : string){

            let arrayUsuarios : Entidades.Producto[] = JSON.parse(respuesta);

            let div : string = `
            <table>
                <thead>
                    <tr>
                    <th>Nombre</th>
                    <th>Origen</th>
                    </tr>
                </thead>`;

            arrayUsuarios.forEach(item => {
                div += `
                <tr>
                    <th>${item.nombre}</th>
                    <th>${item.origen}</th>
                </tr>`;
            });

            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = div;
        }

        public static VerificarProductoJSON(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/VerificarProductoJSON.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let params : string = `nombre=${nombre}&origen=${origen}`;

            ajax.Post(ruta,Manejadora.VerificarProductoJSONSuccess,params,Manejadora.Fail);
        }

        public static VerificarProductoJSONSuccess(respuesta : string){
            console.log(respuesta);
            alert(respuesta);
        }

        public static MostrarInfoCookie(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/MostrarCookie.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let params : string = `nombre=${nombre}&origen=${origen}`;

            ajax.Get(ruta,Manejadora.MostrarInfoCookieSuccess,params,Manejadora.Fail);

        }

        public static MostrarInfoCookieSuccess(respuesta : string){
            (<HTMLDivElement>document.getElementById('divInfo')).innerHTML = respuesta;
            console.log(respuesta);
            alert(respuesta);
        }      

        public static AgregarProductoSinFoto(){

            let ajax : Ajax = new Ajax();
            let ruta : string = "../backend/AgregarProductoSinFoto.php";

            let codigo_barra :string = (<HTMLInputElement> document.getElementById("codigoBarra")).value;
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let precio :number = parseFloat((<HTMLInputElement> document.getElementById("precio")).value);
            let params : string = `producto_json={"codigo_barra":"${codigo_barra}","nombre":"${nombre}","origen":"${origen}","precio":${precio}}`;
            
            ajax.Post(ruta,Manejadora.AgregarProductoSinFotoSuccess,params,Manejadora.Fail);
        }

        public static AgregarProductoSinFotoSuccess(respuesta : string){
            Manejadora.MostrarProductosEnvasados();
            console.log(respuesta);
            alert(respuesta);
        }

        public static MostrarProductosEnvasados(){
            
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/ListadoProductosEnvasados.php";

            ajax.Get(ruta,Manejadora.MostrarProductosEnvasadosSuccess,`tabla=""`,Manejadora.Fail)

        }
        public static MostrarProductosEnvasadosSuccess(respuesta : string){
            
            let arrayUsuarios : Entidades.ProductoEnvasado[] = JSON.parse(respuesta);
            
            
            let div : string = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>CodigoBarra</th>
                        <th>Precio</th>
                    </tr>
                </thead>`;

            arrayUsuarios.forEach(item => {

                let json = JSON.stringify(item);

                if(item.pathFoto == ""){
                div += `
                <tr>
                    <th>${item.id}</th>
                    <th>${item.nombre}</th>
                    <th>${item.origen}</th>
                    <th>${item.codigo_barra}</th>
                    <th>${item.precio}</th>
                    <th> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.BtnModificarProducto('${json}')></th>
                    <th> <input type="button" value="eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.EliminarProducto('${json}') /> </th>
                </tr>`;
                }
            });
            
            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = div;
        }

        public static BtnModificarProducto(json : string){

            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("idProducto")).value = producto.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = producto.nombre;
            (<HTMLInputElement>document.getElementById("codigoBarra")).value = producto.codigo_barra.toString();
            (<HTMLInputElement>document.getElementById("cboOrigen")).value = producto.origen;
            (<HTMLInputElement>document.getElementById("precio")).value = producto.precio.toString();
        }

        public static ModificarProducto()
        {
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/ModificarProductoEnvasado.php";

            let id : number = parseInt((<HTMLInputElement> document.getElementById("id")).value);
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement>document.getElementById("origen")).value;
            let codigo_barras : string = (<HTMLInputElement>document.getElementById("codigoBarra")).value;
            let precio : number = parseInt((<HTMLInputElement>document.getElementById("precio")).value);

            let json = `producto_json={"id":${id},"nombre":"${nombre}","origen":"${origen}","codigo_barra":${codigo_barras},"precio":${precio}}`;

            ajax.Post(ruta,Manejadora.ModificarProductoSuccess,json,Manejadora.Fail);
        }

        public static ModificarProductoSuccess(respuesta : string){
            Manejadora.MostrarProductosEnvasados();
            console.log(respuesta);
            alert(respuesta);
        }

        public static EliminarProducto(json : string){

            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/EliminarProductoEnvasado.php";

            let id :number  = producto.id;
            let nombre :string = producto.nombre;
            let origen :string = producto.origen;

            if(confirm(`Desea borrar al empleado nombre: ${nombre}, correo: ${origen}?`)){
                let params : string = `producto_json=${json}`;
                ajax.Post(ruta,Manejadora.EliminarProductoSuccess,params,Manejadora.Fail);
            }
        }

        public static EliminarProductoSuccess(respuesta : string){

            Manejadora.MostrarProductosEnvasados();

            console.log(respuesta);
            alert(respuesta);
        }


        public static VerificarProductoEnvasado(){
            
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/VerificarProductoEnvasado.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let params : string = `obj_producto={"nombre":"${nombre}","origen":"${origen}"}`;

            ajax.Post(ruta,Manejadora.VerificarProductoEnvasadoSuccess,params,Manejadora.Fail);
        }

        public static VerificarProductoEnvasadoSuccess(respuesta : string ){
            console.log(respuesta);
            alert(respuesta);
        }

        public static MostrarProductosEnvasadosFoto(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/ListadoProductosEnvasados.php";

            ajax.Get(ruta,Manejadora.MostrarProductosEnvasadosFotoSuccess,`tabla=""`,Manejadora.Fail)
        }
        public static MostrarProductosEnvasadosFotoSuccess(respuesta : string){

            let arrayUsuarios : Entidades.ProductoEnvasado[] = JSON.parse(respuesta);

            let div : string = `
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>CodigoBarra</th>
                        <th>Precio</th>
                        <th>Foto</th>
                    </tr>
                </thead>`;

            arrayUsuarios.forEach(item => {

                let json = JSON.stringify(item);
                if(item.pathFoto != ""){
                div += `
                <tr>
                    <th>${item.id}</th>
                    <th>${item.nombre}</th>
                    <th>${item.origen}</th>
                    <th>${item.codigo_barra}</th>
                    <th>${item.precio}</th>
                    <th><img src=${item.pathFoto} width=50px height=50px></th>
                    <th> <input type="button" value="modificar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.btnModificarProductoFoto('${json}')></th>
                    <th> <input type="button" value="eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.EliminarProductoFoto('${json}') /> </th>
                </tr>`;
                }
            });
            
            div += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = div;
        }

        public static AgregarProductoFoto()
        {
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/AgregarProductoEnvasado.php";
            
            let codigo_barra :string = (<HTMLInputElement> document.getElementById("codigoBarra")).value;
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen :string = (<HTMLInputElement> document.getElementById("cboOrigen")).value;
            let precio :number = parseFloat((<HTMLInputElement> document.getElementById("precio")).value);
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));   

            let form : FormData = new FormData();
            form.append('codigoBarra', codigo_barra);
            form.append('nombre', nombre);
            form.append('origen', origen);
            form.append('precio', precio.toString());
            form.append('foto', foto.files[0]);

            ajax.Post(ruta,Manejadora.AgregarProductoFotoSuccess,form,Manejadora.Fail);
        }

        public static AgregarProductoFotoSuccess(respuesta : string)
        {
            Manejadora.MostrarProductosEnvasadosFoto();
            alert(respuesta);
            console.log(respuesta);
        }

        public static btnModificarProductoFoto(json : string){
            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("idProducto")).value = producto.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = producto.nombre;
            (<HTMLInputElement>document.getElementById("codigoBarra")).value = producto.codigo_barra.toString();
            (<HTMLInputElement>document.getElementById("cboOrigen")).value = producto.origen;
            (<HTMLInputElement>document.getElementById("precio")).value = producto.precio.toString();
            (<HTMLImageElement>document.getElementById("imgFoto")).src = producto.pathFoto;
        }

        public static ModificarProductoFoto(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/ModificarProductoEnvasadoFoto.php";

            let id : number = parseInt((<HTMLInputElement> document.getElementById("idProducto")).value);
            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let codigo_barras : number = parseInt((<HTMLInputElement>document.getElementById("codigoBarra")).value);
            let precio : number = parseInt((<HTMLInputElement>document.getElementById("precio")).value);
            let foto: any = (<HTMLInputElement>document.getElementById("foto"));
            

            let json = `{"id":${id},"nombre":"${nombre}","origen":"${origen}","codigo_barra":${codigo_barras},"precio":${precio},"pathFoto":""}`;

            let form : FormData = new FormData();
            form.append('producto_json',json);
            form.append('foto', foto.files[0]);

            ajax.Post(ruta,Manejadora.ModificarProductoFotoSuccess,form,Manejadora.Fail);
        }

        public static ModificarProductoFotoSuccess(respuesta : string){
            Manejadora.MostrarProductosEnvasadosFoto();
            console.log(respuesta);
            alert(respuesta);
        }

        public static EliminarProductoFoto(json : string){

            let producto : Entidades.ProductoEnvasado = JSON.parse(json);

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/BorrarProductoEnvasado.php";

            let id :number  = producto.id;
            let nombre :string = producto.nombre;
            let origen :string = producto.origen;

            if(confirm(`Desea borrar al empleado nombre: ${nombre}, correo: ${origen}?`)){
                let params : string = `obj_producto=${json}`;
                ajax.Post(ruta,Manejadora.EliminarProductoFotoSuccess,params,Manejadora.Fail);
            }
        }

        public static EliminarProductoFotoSuccess(respuesta : string){

            Manejadora.MostrarProductosEnvasadosFoto();

            console.log(respuesta);
            alert(respuesta);
        }

        public static MostrarBorradosJSON(){
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/MostrarBorradosJSON.php";

            ajax.Get(ruta,Manejadora.MostrarBorradosJSONSuccess,`tabla=""`,Manejadora.Fail)
        }

        public static MostrarBorradosJSONSuccess(respuesta : string){
            console.log(respuesta);
            (<HTMLDivElement>document.getElementById('divInfo')).innerHTML = respuesta;
        }

        public static MostrarFotosModificados(){
            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/MostrarFotosDeModificados.php";

            ajax.Get(ruta,Manejadora.MostrarFotosModificadosSuccess,`tabla=""`,Manejadora.Fail)
        }

        public static MostrarFotosModificadosSuccess(respuesta : string){
            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = respuesta;
        }

        public static FiltrarListado(){

            let ajax : Ajax = new Ajax();
            let ruta :string = "../backend/FiltrarProductos.php";

            let nombre :string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let origen : string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;

            ajax.Post(ruta,Manejadora.FiltrarProductosSuccess,`nombre=${nombre}&origen=${origen}`,Manejadora.Fail)
        }

        public static FiltrarProductosSuccess(respuesta : string){
            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = respuesta;
        }

        public static Fail(respuesta : string) : void{
            console.log(respuesta);
            alert(respuesta);
        }
    }
}