<?php

    require_once ("./clases/Cocinero.php");

    $arch = Cocinero::TraerTodos();

    echo json_encode($arch);

?>