var ValidarCamposVacios: Function = (id: string): boolean =>{

    let valor: string = (<HTMLInputElement> document.getElementById(id)).value;

    valor = valor.replace(/ /g, "");

    if(valor === "" || valor == undefined)
    {
        return false;
    }
    return true;
}

var ValidarRangoNumerico: Function = (num: number, numMinimo: number, numMaximo: number): boolean =>{

    if(num >= numMinimo && num <= numMaximo)
    {
        return true;
    }
    return false;
}

var ValidarCombo: Function = (id: string, valIncorrecto: string): boolean =>{

    let valor: string = (<HTMLInputElement> document.getElementById(id)).value;

    if(valor !== valIncorrecto)
    {
        return true;
    }
    return false;
}

var ObtenerTurnoSeleccionado : Function = () : string => {

    let elemento : NodeListOf<HTMLInputElement> = (document.querySelectorAll('input[name="rdoTurno"]'));
    let valor : number = 0;
    let turno : string = "";
    
    for(let i: number = 0; i < elemento.length; i++)
    {
        if(elemento[i].checked)
        {
            valor = parseInt(elemento[i].value)
            break;
        }
    }
    
   switch(valor)
   {
       case 0:
           turno = "Mañana";
           break;
       case 1:
           turno = "Tarde";
           break;
       case 2:
           turno = "Noche";
           break;
   }
    
    return turno;
}

var ObtenerSueldoMaximo: Function = (turno: string): number =>{
    
    switch(turno)
    {
        case "Mañana":
            return 20000;
        case "Tarde":
            return 18500;    
        default:
            return 25000;
    }
}