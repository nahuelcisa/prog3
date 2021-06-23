<?php

    require_once ("./clases/Usuario.php");

    $arch = Usuario::TraerTodos();

    foreach($arch as $item){
        echo $item . "\n";
    }

?>