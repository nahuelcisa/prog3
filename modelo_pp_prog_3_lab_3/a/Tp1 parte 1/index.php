<?php

    require_once "empleado.php";
    require_once "persona.php";
    require_once "fabrica.php";

    $emp = new Empleado("nahuel","cisa",2341234,'M',223,423.42,"tarde");
    $emp1 = new Empleado("Giuliana","Perez",2341534,'F',243,723.42,"ma;ana");
    $emp2 = new Empleado("Luis","Rodriguez",2341236,'M',2274,443.42,"tarde");
    $emp3 = new Empleado("felipe","bb",421,'M',453,4413.42,"ma;ana");
    
    $vecIdiomas = array("Español","Ingles","Frances");



    echo $emp->Hablar($vecIdiomas);

    echo "<br/>";

    echo $emp->ToString();
    echo "<br/>";
    echo $emp1->ToString();
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";

    $fab = new Fabrica("aloha");

    $fab->AgregarEmpleado($emp);
    $fab->AgregarEmpleado($emp1);
    $fab->AgregarEmpleado($emp2);
    $fab->AgregarEmpleado($emp3);
    $fab->AgregarEmpleado($emp);

    $fab->EliminarEmpleado($emp1);

    echo $fab->ToString();




?>