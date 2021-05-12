<?php


class Crud{
     protected $tabla;
     protected $conexion;
     protected $wheres = "";
     protected $sql = null;
     
   public function __construct($tabla = null)
   { 
        $this->conexion = (new Conexion())->conectar();
        $this->tabla = $tabla;
   } 


     //consultar los registros de cualquier tabla
     public function get(){
          try {
               $this->sql = "SELECT * FROM {$this->tabla} {$this->wheres}";
               $consulta = $this->conexion->prepare($this->sql);
               $consulta->execute();
               //organizamos la informacion consultada en un arreglo de objetos
               return $consulta->fetchAll(PDO::FETCH_OBJ);
          } catch (Exception $exc) {
               echo $exc->getTraceAsString();
          }
     }

     //insertar en la base de datos
     public function insert($obj){
         try {
              $campos = implode("`, `", array_keys($obj)); //nombres`, `apellidos`, `edad
              $valores = ":" . implode(", :", array_keys($obj)); //:nombres, :apellidos, :edad
              $this->sql = "INSERT INTO {$this->tabla} (`{$campos}`) VALUES ({$valores})";
              $this->run($obj);
              $id = $this->conexion->lastInsertId();
              return $id;
         } catch (Exception $exc) {
             echo $exc->getTraceAsString();
         }
     }

     //metodo para ejecutar una sentencia
     private function run($obj = null){
          $consulta = $this->conexion->prepare($this->sql);
          if($obj !== null){
               foreach ($obj as $key => $value) {
                    if(empty($value)){
                        $value = null; 
                    }
                    $consulta->bindValue(":$key",$value);
               }
          }
          $consulta->execute();
          $this->resetValues();
          return $consulta->rowCount();
     }

     //metodo para reiniciar valores globales del la clase
     private function resetValues(){
          $this->wheres = "";
          $this->sql = null;
     } 
}