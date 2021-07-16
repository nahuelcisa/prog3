/// <reference path="../node_modules/@types/jquery/index.d.ts" />


    const APIREST:string = "http://scaloneta/";
    
    $(function(){
    
        $("#btnEnviarRegistro").on("click",function(e:Event){
            Registro(e);
        });
    });
    
    function Registro(e:Event):void{
    
        e.preventDefault();
    
        let correo = $("#txtCorreo").val();
        let clave = $("#txtClave").val();
        let nombre = $("#txtNombre").val();
        let apellido = $("#txtApellido").val();
        let perfil = $("#dpPerfil").val();
        let foto = $("#foto").prop("files")[0];
    
        let param = {
            "correo":correo,
            "clave":clave,
            "nombre":nombre,
            "apellido":apellido,
            "perfil":perfil,
        }
    
        let form : FormData = new FormData();
    
        let usuario : string = JSON.stringify(param);
    
        form.append("usuario",usuario);
        form.append("foto",foto);
    
        $.ajax({
            type: 'POST',
            url: APIREST + "usuarios",
            dataType: "json",
            data: form,
            async: true,
            contentType: false,
            processData: false
        }).done(function (resultado:any) {
    
            let mensaje:string = 'Usuario válido!';
            let tipo:string = 'success';
    
            if(resultado.exito){
                alert(resultado.mensaje);
                $(location).attr('href',APIREST + "loginusuarios");
            }else{
                mensaje = resultado.mensaje;
                tipo = 'danger';
                let alerta:string = ArmarAlert(mensaje, tipo);
                $("#divResultado").html(alerta);
            }
        }).fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
            console.log("error en agregar " + errorThrown);
        });
    }
    
    function ArmarAlert(mensaje:string, tipo:string = "success"):string
    {
        let alerta:string = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable" role="alert">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += '<span class="text-justify text-left">' + mensaje + ' </span></div>';
    
        return alerta;
    }

