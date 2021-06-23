<?php
    session_start();
    function ValidarSesion($path)
    {
        if($_SESSION["DNIEmpleadoBD"] == FALSE)
        {
           header("Location: $path");
        }
    }
?>