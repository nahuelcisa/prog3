/// <reference path="Ajax.ts" />
/// <reference path="Producto.ts" />
/// <reference path="ProductoEnvasado.ts" />
/// <reference path="RetornoJSON.ts" />
/// <reference path="IParte2.ts" />

namespace PrimerParcial {
    export class Manejadora implements IParte2, IParte3, IParte4 {

        /* #region  Parte 1 */
        public static AgregarProductoJSON(): void {
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;
            let ajax = new Ajax();

            let parametros: string = `nombre=${nombre}&origen=${origen}`;
            ajax.Post("./BACKEND/AltaProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        }

        public static VerificarProductoJSON() {
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;
            let ajax = new Ajax();

            let parametros: string = `nombre=${nombre}&origen=${origen}`;
            ajax.Post("./BACKEND/VerificarProductoJSON.php", Manejadora.Success, parametros, Manejadora.Fail);
        }

        public static MostrarProductosJSON(): void {
            let ajax = new Ajax();
            ajax.Get("./BACKEND/ListadoProductosJSON.php", Manejadora.SuccessListadoJSON, "", Manejadora.Fail);
        }

        public static MostrarInfoCookie(): void {
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;
            let ajax = new Ajax();
            let parametros: string = `nombre=${nombre}&origen=${origen}`;
            ajax.Get("./BACKEND/MostrarCookie.php", Manejadora.SuccessMostrarInfo, parametros, Manejadora.Fail);
        }

        public static SuccessMostrarInfo(respuesta: string): void {
            (<HTMLDivElement>document.getElementById('divInfo')).innerHTML = respuesta;
        }

        public static SuccessListadoJSON(respuesta: string): void {
            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = respuesta;
        }


        public static Success(respuesta: string): void {
            console.log(respuesta);
            alert(respuesta);
        }

        public static Fail(respuesta: string): void {
            console.log(respuesta);
            alert(respuesta);
        }

        public static AgregarProductoSinFoto(): void {
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;
            let codigoBarra: string = (<HTMLInputElement>document.getElementById('codigoBarra')).value;
            let precio: number = parseFloat((<HTMLInputElement>document.getElementById('precio')).value);
            let ajax = new Ajax();

            let producto: Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre, origen, 0, codigoBarra, precio);
            let json: string = JSON.stringify(producto);
            let parametros: string = `producto_json=${json}`

            ajax.Post("./BACKEND/AgregarProductoSinFoto.php", Manejadora.AdministrarMensajeAgregarSinFoto, parametros, Manejadora.Fail);
        }

        public static AdministrarMensajeAgregarSinFoto(respuesta: string) {
            let jsonRespuesta: Entidades.RetornoJSON = JSON.parse(respuesta);

            if (jsonRespuesta.exito) {
                Manejadora.MostrarProductosEnvasados();
                alert(respuesta);
                console.log(respuesta);
            }
            else {
                alert(respuesta);
                console.log(respuesta);
            }
        }

        public static MostrarProductosEnvasados(): void {
            let ajax = new Ajax();
            ajax.Get("./BACKEND/ListadoProductosEnvasados.php", Manejadora.ListadoProductosEnvasados, "", Manejadora.Fail);
        }

        /* #region  Parte 2 */
        public static EliminarProducto(json: string) {
            let producto: Entidades.ProductoEnvasado = JSON.parse(json);
            let ajax = new Ajax();

            let parametros: string = `producto_json=${json}`;
            if (!confirm(`Desea eliminar el producto ${producto.nombre} - ${producto.origen}?`)) {
                return;
            }
            else {
                ajax.Post("./BACKEND/EliminarProductoEnvasado.php", Manejadora.MostrarProductosEnvasados, parametros, Manejadora.Fail);
            }
        }

        public static ModificarProducto() {
            let ajax = new Ajax();
            let id: string = (<HTMLInputElement>document.getElementById("idProducto")).value;
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let codigoBarra: string = (<HTMLInputElement>document.getElementById("codigoBarra")).value;
            let precio: string = (<HTMLInputElement>document.getElementById("precio")).value;

            let idNumber: number = parseInt(id);
            let precioNumber: number = parseInt(precio);

            let producto: Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre, origen, idNumber, codigoBarra, precioNumber);
            let json: string = JSON.stringify(producto);

            let parametros: string = `producto_json=${json}`
            ajax.Post("./BACKEND/ModificarProductoEnvasado.php", Manejadora.MostrarProductosEnvasados, parametros, Manejadora.Fail);
        }

        public static Modificar(json: string) {
            let producto: Entidades.ProductoEnvasado = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("idProducto")).value = producto.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = producto.nombre;
            (<HTMLInputElement>document.getElementById("cboOrigen")).value = producto.origen;
            (<HTMLInputElement>document.getElementById("codigoBarra")).value = producto.codigoBarra;
            (<HTMLInputElement>document.getElementById("precio")).value = producto.precio.toString();
        }

        public static ListadoProductosEnvasados(respuesta: string): void {
            let arrayProductos: Entidades.ProductoEnvasado[] = JSON.parse(respuesta);

            let tabla = "<table> <tr> <td> ID </td> <td> NOMBRE </td> <td> ORIGEN </td> <td> CODIGO BARRA </td> <td> PRECIO </td> <td> FOTO </td> </tr>";

            arrayProductos.forEach(element => {

                let json: string = JSON.stringify(element);

                tabla += `
                <tr>
                    <th>${element.id}</th>
                    <th>${element.nombre}</th>
                    <th>${element.origen}</th>
                    <th>${element.codigoBarra}</th>
                    <th>${element.precio}</th>
                    <th><input type="button" value="Modificar" class="btn btn-dark" 
                    onclick=PrimerParcial.Manejadora.Modificar('${json}')></th>
                    <th><input type="button" value="Eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.EliminarProducto('${json}')></th>
                </tr>`;
            });
            tabla += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = tabla;
        }
        /* #endregion */

        /* #region  Parte 3 */
        public static VerificarProductoEnvasado(): void {
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;
            let ajax = new Ajax();

            let parametros = `obj_producto={"nombre":"${nombre}","origen":"${origen}"}`;

            ajax.Post("./BACKEND/VerificarProductoEnvasado.php", Manejadora.SuccessMostrarInfo, parametros, Manejadora.Fail);
        }

        public static AgregarProductoFoto(): void {
            let ajax = new Ajax();
            let id: string = (<HTMLInputElement>document.getElementById("idProducto")).value;
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let codigoBarra: string = (<HTMLInputElement>document.getElementById("codigoBarra")).value;
            let precio: string = (<HTMLInputElement>document.getElementById("precio")).value;
            let foto: File | null | undefined = (<HTMLInputElement>document.getElementById("foto")).files?.item(0);

            let form: FormData = new FormData();

            if (foto) {
                form.append("foto", foto);
                form.append("id", id);
                form.append("nombre", nombre);
                form.append("origen", origen);
                form.append("codigoBarra", codigoBarra);
                form.append("precio", precio);
            }

            ajax.Post("./BACKEND/AgregarProductoEnvasado.php", Manejadora.AdministrarMensaje, form, Manejadora.Fail);
        }


        public static AdministrarMensaje(respuesta: string) {
            let jsonRespuesta: Entidades.RetornoJSON = JSON.parse(respuesta);

            if (jsonRespuesta.exito) {
                Manejadora.MostrarProductosEnvasadosFoto();
            }
            else {
                alert(respuesta);
                console.log(respuesta);
            }
        }

        public static EnviarProductoEnvasadoModificado(): void {
            let ajax = new Ajax();
            let id: number = parseInt((<HTMLInputElement>document.getElementById("idProducto")).value);
            let nombre: string = (<HTMLInputElement>document.getElementById("nombre")).value;
            let origen: string = (<HTMLInputElement>document.getElementById("cboOrigen")).value;
            let codigoBarra: string = (<HTMLInputElement>document.getElementById("codigoBarra")).value;
            let precio: number = parseInt((<HTMLInputElement>document.getElementById("precio")).value);
            let foto: File | null | undefined = (<HTMLInputElement>document.getElementById("foto")).files?.item(0);

            let form: FormData = new FormData();
            let producto: Entidades.ProductoEnvasado = new Entidades.ProductoEnvasado(nombre, origen, id, codigoBarra, precio);

            if (foto) {
                form.append("foto", foto);
                form.append("producto_json", JSON.stringify(producto));
            }

            ajax.Post("./BACKEND/ModificarProductoEnvasadoFoto.php", Manejadora.MostrarProductosEnvasadosFoto, form, Manejadora.Fail);
        }

        public static ModificarProductoFoto(json: string) {
            let producto: Entidades.ProductoEnvasado = JSON.parse(json);

            (<HTMLInputElement>document.getElementById("idProducto")).value = producto.id.toString();
            (<HTMLInputElement>document.getElementById("nombre")).value = producto.nombre;
            (<HTMLInputElement>document.getElementById("cboOrigen")).value = producto.origen;
            (<HTMLInputElement>document.getElementById("codigoBarra")).value = producto.codigoBarra;
            (<HTMLInputElement>document.getElementById("precio")).value = producto.precio.toString();
            (<HTMLImageElement>document.getElementById("imgFoto")).src = `./BACKEND/${producto.pathFoto}`;
        }

        public static ListadoProductosEnvasadosFoto(respuesta: string): void {
            let arrayProductos: Entidades.ProductoEnvasado[] = JSON.parse(respuesta);

            let tabla = "<table> <tr> <td> ID </td> <td> NOMBRE </td> <td> ORIGEN </td> <td> CODIGO BARRA </td> <td> PRECIO </td> <td> FOTO </td> </tr>";

            arrayProductos.forEach(element => {

                let json: string = JSON.stringify(element);

                tabla += `
                <tr>
                    <th>${element.id}</th>
                    <th>${element.nombre}</th>
                    <th>${element.origen}</th>
                    <th>${element.codigoBarra}</th>
                    <th>${element.precio}</th>
                    <th><img src=./BACKEND/${element.pathFoto} alt=fotoProducto height=50px widht=50px/></th>
                    <th><input type="button" value="Modificar" class="btn btn-dark" 
                    onclick=PrimerParcial.Manejadora.ModificarProductoFoto('${json}')></th>
                    <th><input type="button" value="Eliminar" class="btn btn-dark" onclick=PrimerParcial.Manejadora.BorrarProductoFoto('${json}')></th>
                </tr>`;
            });
            tabla += "</table>";

            (<HTMLDivElement>document.getElementById('divTabla')).innerHTML = tabla;
        }

        public static BorrarProductoFoto(json: string) {
            let producto: Entidades.ProductoEnvasado = JSON.parse(json);
            let ajax = new Ajax();

            let parametros: string = `producto_json=${json}`;
            if (!confirm(`Desea eliminar el producto ${producto.nombre} - ${producto.origen}?`)) {
                return;
            }
            else {
                ajax.Post("./BACKEND/BorrarProductoEnvasado.php", Manejadora.MostrarProductosEnvasadosFoto, parametros, Manejadora.Fail);
            }
        }

        public static MostrarProductosEnvasadosFoto(): void {
            let ajax = new Ajax();
            ajax.Get("./BACKEND/ListadoProductosEnvasados.php", Manejadora.ListadoProductosEnvasadosFoto, "", Manejadora.Fail);
        }
        /* #endregion */

        /* #region  Parte 4 */
        public static MostrarBorradosJSON(): void {
            let ajax = new Ajax();

            ajax.Get("./BACKEND/MostrarBorradosJSON.php", Manejadora.MostrarBorradosJSONConsola, "", Manejadora.Fail);
        }

        public static MostrarBorradosJSONConsola(respuesta: string): void {
            console.log(respuesta);
            (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = respuesta;
        }

        public static MostrarFotosModificados(): void {
            let ajax = new Ajax();

            ajax.Post("./BACKEND/MostrarFotosDeModificados.php", Manejadora.MostrarEnTabla, "", Manejadora.Fail);
        }

        public static MostrarEnTabla(respuesta: string): void {
            (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = respuesta;
        }

        public static FiltrarListado(): void {
            let ajax = new Ajax();
            let nombre: string = (<HTMLInputElement>document.getElementById('nombre')).value;
            let origen: string = (<HTMLInputElement>document.getElementById('cboOrigen')).value;

            let parametros: string = `nombre=${nombre}&origen=${origen}`;
            ajax.Post("./BACKEND/FiltrarProducto.php", Manejadora.MostrarEnTabla, parametros, Manejadora.Fail);
        }
        /* #endregion */

        /* #region  x */
        public MostrarBorradosJSON(): void {

        }
        public MostrarFotoModificados(): void {

        }
        public FiltrarListado(): void {

        }
        public EliminarProducto(json: string): void {

        }
        public ModificarProducto(json: string): void {

        }
        public VerificarProductoEnvasado(): void {

        }
        public AgregarProductoFoto(): void {

        }
        public BorrarProductoFoto(json: string): void {

        }
        public ModificarProductoFoto(json: string): void {

        }
        /* #endregion */
    }
}