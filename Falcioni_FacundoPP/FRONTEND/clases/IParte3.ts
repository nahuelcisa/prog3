namespace PrimerParcial
{
    export interface IParte3
    {
        VerificarProductoEnvasado(): void;
        AgregarProductoFoto(): void;
        BorrarProductoFoto(json: string): void;
        ModificarProductoFoto(json: string): void;
    }
}