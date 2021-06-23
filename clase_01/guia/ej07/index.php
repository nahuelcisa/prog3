<?php

    $hoy = date("d.m.y - g:i:s a");

    echo $hoy;

    switch(date("m")){
        case "01":
        case "02":
        case "03":
            echo "<br>Es Verano.";
            break;
        case "04":
        case "05":
        case "06":
            echo "<br>Es oto;o.";
            break;
        case "07":
        case "08":
        case "09": 
            echo "<br>Es invierno.";
            break;
        case "10":
        case "11":
        case "12":
            echo "<br>Es primavera.";
            break;

    }

?>