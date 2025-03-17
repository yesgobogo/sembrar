<?php
    // Creamos una clase para posteriormente
    // convertirla en un objeto y reutilizarla
    class Conexion{

        public function get_conexion(){
            $user = "root";
            $pass = "";
            $host = "localhost";
            $db = "sena";
            $conexion = new PDO("mysql: host=$host; dbname=$db;", $user, $pass);
            return $conexion;
        }
    }

?>