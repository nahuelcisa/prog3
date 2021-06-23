var AdministrarValidaciones : Function = (e: Event) =>
{
    if(
        !ValidarCamposVacios("txtApellido") ||
        !ValidarCamposVacios("txtNombre")
    )
    {
        alert("Uno o mas de un campo esta vacio.");
        e.preventDefault();
        return;
    }

    let dniObtenido : string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let legajoObtenido : string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
    let sueldoObtenido : string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
    let sueldoMax : number = ObtenerSueldoMaximo(ObtenerTurnoSeleccionado());

    if(!ValidarRangoNumerico(parseInt(dniObtenido), 1000000, 55000000 ))
    {
        alert("Dni incorrecto.");
        e.preventDefault();
        return;
    }

    if(!ValidarRangoNumerico(parseInt(legajoObtenido),100,550))
    {
        alert("Legajo incorrecto.");
        e.preventDefault();
        return;
    }

    if(!ValidarRangoNumerico(parseInt(sueldoObtenido),8000,sueldoMax))
    {
        alert("Sueldo incorrecto.");
        e.preventDefault();
        return;
    }

    if(!ValidarCombo("cboSexo","---"))
    {
        alert("Seleccione sexo");
        e.preventDefault();
        return;
    }
}