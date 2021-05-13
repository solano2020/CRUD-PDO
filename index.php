<?php
require_once "./bin/conexion/Conexion.php";
require_once "./bin/persistencia/CRUD.php";

$crud = new Crud("usuario");
//insercion prueba
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

//actualizar prueba
/* $resultado = $crud->where("id", "=", 1)->update([
    "nombres" => "fernel1"
]);
echo $resultado; 
 */

//prueba eliminar 
/* $resultado = $crud->where("id", "=", 2)->delete();
echo "filas eliminadas" . $resultado; */

$lista = $crud->get();
echo "<pre>";
var_dump($lista);
echo "</pre>";