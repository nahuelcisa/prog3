<?php
    include_once("./clases/Producto.php");
    
    echo json_encode(Producto::TraerJSON());
?>