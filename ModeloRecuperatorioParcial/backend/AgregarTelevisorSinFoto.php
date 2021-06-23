<?php

    require_once ("./clases/Televisor.php");

    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
    $paisOrigen = isset($_POST['paisOrigen']) ? $_POST['paisOrigen'] : NULL;

    $array = Televisor::Traer();

    if($tipo != NULL && $precio != NULL && $paisOrigen != NULL)
    {
        $tele = new Televisor(0,$tipo,$precio,$paisOrigen,"");

        if($tele->Verificar($array)){

            $tele->Agregar();
            echo "Se agrego con exito.";
        }
        else
        {
            echo "La tele ya se encuentra en la base.";
        }
    }

?>