<?php
    session_start();
    function ValidarSesion($path)
    {
        if($_SESSION["DNIEmpleado"] == FALSE)
        {
           header("Location: $path");
        }
    }
?>