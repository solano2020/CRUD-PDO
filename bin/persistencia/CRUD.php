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

     // metodo para actualizar la base de datos
     public function update($obj){
          try {
               $campos = "";
               foreach ($obj as $key => $value) {
                    $campos .= "`$key`=:$key,";
               }
               $campos = rtrim($campos, ",");
               $this->sql = "UPDATE {$this->tabla} SET {$campos} {$this->wheres}";
               $consulta = $this->run($obj);
               return $consulta;
          } catch (Exception $exc) {
               echo $exc->getTraceAsString();
          }
     }

     //metodo para eliminar un registro de la base de datos
     public function delete(){
         try {
              $this->sql = "DELETE FROM {$this->tabla} {$this->wheres}";
              $consulta = $this->run();
              return $consulta; 
         } catch (Exception $exc) {
              echo $exc->getTraceAsString();
         }
     }

     //metodo para crear la sentencia where AND
     public function where($key, $condition, $value){
          try {
               $this->wheres .= (strpos($this->wheres, "WHERE")) ? "AND" : "WHERE";
               $this->wheres .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
               return $this;
          } catch (Exception $exc) {
               echo $exc->getTraceAsString();
          }
     }
     
     //metodo para crear la sentencia where OR
     public function orWhere($key, $condition, $value){
          try {
               $this->wheres .= (strpos($this->wheres, "WHERE")) ? "OR" : "WHERE";
               $this->wheres .= "`$key` $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
               return $this;
          } catch (Exception $exc) {
               echo $exc->getTraceAsString();
          }
     }

     //metodo para ejecutar una sentencia (clave = valor)
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