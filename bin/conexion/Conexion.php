<?php


class Conexion{

    private $conexion;
    private $configuracion = [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "crud-pdo",
        "port" => "3306",
        "username" => "root",
        "password" => "191243",
        "charset" => "utf8mb4"
    ];

    public function __construct()
    {
        
    }

    public function conectar(){
        try {
           $driver = $this->configuracion["driver"];
           $server = $this->configuracion["host"];
           $db = $this->configuracion["database"];
           $port = $this->configuracion["port"];
           $user = $this->configuracion["username"];
           $password = $this->configuracion["password"];
           $codification = $this->configuracion["charset"];

           //URL de conexion
           $url = "{$driver}:host={$server}:{$port};"
                   ."dbname={$db}; charset={$codification}";
           // creamos la conexion
           $this->conexion = new PDO($url,$user, $password);
          echo "CONECTADO";
        } catch (Exception $exe) {
            echo "No se pudo conectar";   
            echo $exe->getTraceAsString();
        }
    }

}