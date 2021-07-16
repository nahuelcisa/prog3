/// <reference path="../node_modules/@types/jquery/index.d.ts" />


    const APIREST:string = "http://scaloneta/";
    
    $(function(){
        $("#btnEnviar").on("click",function(e:Event){
            Login(e);
        });
    
        $("#btnRegistro").on("click",function(){
            IrRegistro();
        });
    });
    
    function ArmarAlert(mensaje:string, tipo:string = "success"):string
    {
        let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    
        return alerta;
    }
    
    function IrRegistro():void{
    
        $.ajax({
            type: 'GET',
            url: APIREST + "registro",
            async: true
        })
        .done(function (resultado: any){
            $(location).attr('href',APIREST + "registro");
        }).fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
            console.log("error en redireccion " + errorThrown);
        });   
    }
    
    function Login(e:Event):void{
    
        e.preventDefault();
    
        let correo = $("#correo").val();
        let clave = $("#clave").val();
        let dato:any = {};
        dato.correo = correo;
        dato.clave = clave;
        
        $.ajax({
            type: 'POST',
            url: APIREST + "login",
            dataType: "json",
            data: {"user":JSON.stringify(dato)},
            async: true
        })
        .done(function (resultado: any){
    
            let mensaje:string = 'Usuario válido!';
            let tipo:string = 'success';
    
            if(resultado.exito){
                localStorage.setItem("token", resultado.jwt);
                $(location).attr('href',APIREST + "principal");
            }else{
                mensaje = resultado.mensaje;
                tipo = 'danger';
                let alerta:string = ArmarAlert(mensaje, tipo);
                $("#divResultado").html(alerta);
            }
        }).fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
    
            let retorno = JSON.parse(jqXHR.responseText);
    
            let alerta:string = ArmarAlert(retorno.mensaje, "danger");
    
            $("#divResultado").html(alerta);
        });   
    }

