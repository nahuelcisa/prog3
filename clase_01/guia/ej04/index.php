<?php

    $acumulador = 0;
    $cont = 0;
    

    for($num = 1; $acumulador < 1000; $num++){
        $acumulador += $num;
        $cont++;

        echo "<br>Acumulador: " . $acumulador . "<br>Num: " . $num . "<br>";
    }

?>