<?php

require_once "conexion.php";

class modeloDeportes {

    static public function mdlBuscarDeportePorSede($tabla, $id){
        try {
            $conn = Conexion::conectar();
    
            $query = "SELECT d.* FROM $tabla d
                      JOIN sedes s ON d.id_sede = s.id_sede
                      WHERE s.id_sede = :id";
    
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
    
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $resultados;
    
        } catch (PDOException $e) {
            // Manejar la excepción según tus necesidades (por ejemplo, loggear el error, mostrar un mensaje al usuario, etc.)
            echo "Error: " . $e->getMessage();
        }
    }
    

    static public function mdlDeportesPorSede($tabla, $tabla2, $sede){
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT deportes.*
                    FROM $tabla as deportes
                    INNER JOIN $tabla2 ON deportes.id_sede = $tabla2.id_sede
                    WHERE $tabla2.ubicacion = :sede";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':sede', $sede, PDO::PARAM_STR);

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

    static public function mdlMostrarDeporte($tabla) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Preparar la consulta SQL con un JOIN
            $stmt = $conn->prepare("SELECT d.*, s.ubicacion
                                    FROM $tabla d
                                    INNER JOIN sedes s ON d.id_sede = s.id_sede");
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener los resultados como un array asociativo
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Cerrar la conexión
            Conexion::cerrar($conn);
    
            // Devolver los resultados
            return $resultados;
    
        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
            return null; // O manejar de otra manera según tus necesidades
        }
    }
    

    static public function mdlAgregarDeporte($tabla, $datos) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "INSERT INTO $tabla (nombre, id_sede) VALUES (:nombre, :id_sede)";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':id_sede', $datos['id_sede'], PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el ID del nuevo deporte insertado
            $idDeporteInsertado = $conn->lastInsertId();

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver el ID del deporte insertado
            return $idDeporteInsertado;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }



    static public function mdlEliminarDeporte($tabla, $idDeporte) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "DELETE FROM $tabla WHERE id_deporte = :id_deporte";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_deporte', $idDeporte, PDO::PARAM_INT);

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



    static public function mdlFiltrarDeporte($tabla, $idDeporte) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT * FROM $tabla WHERE id_deporte = :id_deporte";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_deporte', $idDeporte, PDO::PARAM_INT);

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

    static public function mdlActualizarDeporte($tabla, $datos) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Construir la consulta SQL
            $sql = "UPDATE $tabla SET nombre = :nombre, id_sede = :nuevo_id_sede WHERE id_deporte = :id_deporte";
    
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
    
            // Bind de parámetros
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':id_deporte', $datos['id_deporte'], PDO::PARAM_INT);
            $stmt->bindParam(':nuevo_id_sede', $datos['id_sede'], PDO::PARAM_INT);
    
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
