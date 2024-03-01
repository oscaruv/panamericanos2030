<?php

require_once "conexion.php";

class modeloSedes {

    static public function mdlConsultarSedePorId($tabla, $idSede) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Construir la consulta SQL
            $sql = "SELECT * FROM $tabla WHERE id_sede = :id_sede";
    
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
    
            // Bind de parámetros
            $stmt->bindParam(':id_sede', $idSede, PDO::PARAM_INT);
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener los resultados como un array asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Cerrar la conexión
            // Conexion::cerrar();
    
            // Devolver los resultados
            return $resultados;
    
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }
    

    static public function mdlMostrarSedes($tabla) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT * FROM $tabla";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados como un array asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver los resultados
            return $resultados;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }


    static public function mdlAgregarSede($tabla, $datos) {
        try {
            var_dump( $datos);
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "INSERT INTO $tabla (ubicacion) VALUES (:ubicacion)";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':ubicacion', $datos['ubicacion'], PDO::PARAM_STR);
            // $stmt->bindParam(':numero_deportes', $datos['numero_deportes'], PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el ID de la nueva sede insertada
            $idSedeInsertada = $conn->lastInsertId();

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver el ID de la sede insertada
            return $idSedeInsertada;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }

    static public function mdlEliminarSede($tabla, $idSede) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "DELETE FROM $tabla WHERE id_sede = :id_sede";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_sede', $idSede, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el número de filas afectadas
            $numFilasAfectadas = $stmt->rowCount();

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver el número de filas afectadas
            return $numFilasAfectadas;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }

    static public function mdlFiltrarSede($tabla, $idSede) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT * FROM $tabla WHERE id_sede = :id_sede";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_sede', $idSede, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados como un array asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver los resultados
            return $resultados;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }

    static public function mdlActualizarSede($tabla, $datos) {
        try {
            var_dump($datos);
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "UPDATE $tabla SET ubicacion = :ubicacion WHERE id_sede = :id_sede";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':ubicacion', $datos['nueva_ubicacion'], PDO::PARAM_STR);
            // $ubicacion = implode(',', $datos['nueva_ubicacion']);
            // $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);


            // $stmt->bindParam(':numero_deportes', $datos['numero_deportes'], PDO::PARAM_INT);
            $stmt->bindParam(':id_sede', $datos['id_sede'], PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el número de filas afectadas
            $numFilasAfectadas = $stmt->rowCount();

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver el número de filas afectadas
            return $numFilasAfectadas;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }



}

?>
