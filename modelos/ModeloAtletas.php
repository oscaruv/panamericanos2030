
<?php

require_once "conexion.php";

class modeloAtletas {

    static public function mdlbuscarDeportistaPorSedeyDeporte($sedeId, $deporteId){
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Preparar la consulta SQL con un JOIN y condiciones WHERE
            $stmt = $conn->prepare("SELECT atletas.*, deportes.nombre AS nombre_deporte
            FROM atletas
            JOIN deportes ON atletas.id_deporte = deportes.id_deporte
            JOIN sedes ON deportes.id_sede = sedes.id_sede
            WHERE deportes.id_deporte = :deporteId
                AND sedes.id_sede = :sedeId;");
    
            // Asociar los valores de los parámetros con marcadores de posición
            $stmt->bindParam(":deporteId", $deporteId, PDO::PARAM_INT);
            $stmt->bindParam(":sedeId", $sedeId, PDO::PARAM_INT);
    
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
    

    static public function mdlMostrarAtleta($tabla, $tabla2, $tabla3, $sede, $deporte){
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT atletas.*
                    FROM $tabla as atletas
                    INNER JOIN $tabla2 ON atletas.id_deporte = $tabla2.id_deporte
                    INNER JOIN $tabla3 ON $tabla2.id_sede = $tabla3.id_sede
                    WHERE $tabla3.ubicacion = :sede AND $tabla2.nombre = :deporte";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':sede', $sede, PDO::PARAM_STR);
            $stmt->bindParam(':deporte', $deporte, PDO::PARAM_STR);

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

    static public function mdlMostrarAtletas($tabla) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Preparar la consulta SQL con un JOIN
            $stmt = $conn->prepare("SELECT a.*, d.nombre AS nombre_deporte
                                    FROM $tabla a
                                    INNER JOIN deportes d ON a.id_deporte = d.id_deporte");
    
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
    
    



    static public function mdlAgregarAtleta($tabla, $datos) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "INSERT INTO $tabla (identificacion, nombre, apellido, id_deporte) VALUES (:identificacion, :nombre, :apellido, :id_deporte)";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':identificacion', $datos['identificacion'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $datos['apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':id_deporte', $datos['id_deporte'], PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el ID del nuevo registro insertado
            $idAtletaInsertado = $conn->lastInsertId();

            // Cerrar la conexión
            // Conexion::cerrar();

            // Devolver el ID del atleta insertado
            return $idAtletaInsertado;

        } catch (PDOException $e) {
            // Manejar errores de la base de datos
            echo "Error: " . $e->getMessage();
        }
    }


    static public function mdlEliminarAtleta($tabla, $idAtleta) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "DELETE FROM $tabla WHERE id_atleta = :id_atleta";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_atleta', $idAtleta, PDO::PARAM_INT);

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


    static public function mdlFiltrarAtletas($tabla, $idAtleta) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();

            // Construir la consulta SQL
            $sql = "SELECT * FROM $tabla WHERE id_atleta = :id_atleta";

            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Bind de parámetros
            $stmt->bindParam(':id_atleta', $idAtleta, PDO::PARAM_INT);

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

    static public function mdlActualizarAtleta($tabla, $datos) {
        try {
            // Conectar a la base de datos
            $conn = Conexion::conectar();
    
            // Construir la consulta SQL
            $sql = "UPDATE $tabla SET identificacion = :identificacion, nombre = :nombre, apellido = :apellido, id_deporte = :id_deporte WHERE id_atleta = :id_atleta";
    
            // Preparar la consulta
            $stmt = $conn->prepare($sql);
    
            // Bind de parámetros
            $stmt->bindParam(':identificacion', $datos['nuevo_identificacion'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $datos['nuevo_nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $datos['nuevo_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':id_deporte', $datos['nuevo_id_deporte'], PDO::PARAM_INT);
            $stmt->bindParam(':id_atleta', $datos['id_atleta'], PDO::PARAM_INT);
    
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


