<?php

class Conexion {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $database = "panamericano2030";

    public static function conectar() {
        try {
            $conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$database, self::$username, self::$password);
            // Establecer el modo de error de PDO a excepción
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }

    public static function cerrar($conn) {
        $conn = null;
    }
}

?>
