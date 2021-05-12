<?php
require_once "./bin/conexion/Conexion.php";
require_once "./bin/persistencia/CRUD.php";

$crud = new Crud("usuario");
/* $id = $crud->insert([
     "nombres" => "fernel",
     "apellidos" => "solano",
     "edad" => 19,
     "correo" => "fernel@gmail.com",
     "telefono" => "555-666",
     "fecha_registro" => date("Y-m-d H:i:s")
]);
echo "El ID insertado es: ". $id;
echo "</br>"; */
$lista = $crud->get();
echo "<pre>";
var_dump($lista);
echo "</pre>";