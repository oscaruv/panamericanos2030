<?php

require_once "../modelos/ModeloAtletas.php";

class ControladorAtletas {

    public function mostrarAtleta($idAtleta) {
        $tabla = 'atletas';
        $resultados = ModeloAtletas::mdlFiltrarAtletas($tabla, $idAtleta);
        // Puedes procesar los resultados o pasarlos a la vista
        // ...

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);

    }

    public function mostrarAtletas() {
        $tabla = 'atletas';
        $resultados = ModeloAtletas::mdlMostrarAtletas($tabla);
        // Puedes procesar los resultados o pasarlos a la vista
        // ...

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);

    }

    public function agregarAtleta($datosAtleta) {
        $tabla = 'atletas';
        $idNuevoAtleta = ModeloAtletas::mdlAgregarAtleta($tabla, $datosAtleta);
        // Puedes realizar acciones adicionales después de agregar el atleta
        return $idNuevoAtleta;
    }

    public function actualizarAtleta($datosAtleta) {
        $tabla = 'atletas';
        $numFilasAfectadas = ModeloAtletas::mdlActualizarAtleta($tabla, $datosAtleta);
        // Puedes realizar acciones adicionales después de actualizar el atleta
        return $numFilasAfectadas;
    }

    public function eliminarAtleta($idAtleta) {
        $tabla = 'atletas';
        $numFilasAfectadas = ModeloAtletas::mdlEliminarAtleta($tabla, $idAtleta);
        // Puedes realizar acciones adicionales después de eliminar el atleta
        return $numFilasAfectadas;
    }

    public function buscarDeportistaPorSedeyDeporte($sedeId, $deporteId){

        $response =  ModeloAtletas::mdlbuscarDeportistaPorSedeyDeporte($sedeId, $deporteId);
        // var_dump($response);
        // die();
        return $response;

    }
}


// Crear una instancia del controlador
$controlador = new ControladorAtletas();
$data = json_decode(file_get_contents("php://input"), true);

// Manejar la solicitud según el método de la solicitud (GET, POST, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los atletas y devolver la respuesta en formato JSON
    $atletas = $controlador->mostrarAtletas();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['nombre'])) {
    // Manejar la solicitud POST para agregar una nueva sede
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $identificacion = $data['identificacion'];
    $deporte = $data['deporte'];

    // Verificar si se reciben datos válidos (puedes mejorar esta verificación según tus necesidades)
    if (isset($nombre) AND isset($apellido) AND isset($identificacion)AND isset($deporte)) {
        // Crear un array con los datos de la nueva sede
        $datosNuevaSede = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'identificacion' => $identificacion,
            'id_deporte' => $deporte,
        ];

        // Agregar la nueva sede utilizando el controlador
        $idNuevaSede = $controlador->agregarAtleta($datosNuevaSede);

        // Devolver una respuesta, por ejemplo, el ID de la nueva sede
        echo json_encode(['id_nuevo_atleta' => $idNuevaSede]);
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $identificacion = $data['identificacion'];
    $nuevo_id_deporte = $data['nuevo_id_deporte'];
    $id_atleta = $data['id_atleta'];
    // Verificar si se reciben datos válidos
    if (
        isset($nombre) &&
        isset($apellido) &&
        isset($identificacion) &&
        isset($nuevo_id_deporte) &&
        isset($id_atleta)
    ) {
        // Crear un array con los datos para actualizar el atleta
        $datosActualizarAtleta = [
            'id_atleta' => $id_atleta,
            'nuevo_id_deporte' => $nuevo_id_deporte,
            'nuevo_identificacion' => $identificacion,
            'nuevo_nombre' => $nombre,
            'nuevo_apellido' => $apellido,
            // Agrega más campos aquí según sea necesario
        ];

        // Actualizar el atleta utilizando el controlador
        $actualizacionExitosa = $controlador->actualizarAtleta($datosActualizarAtleta);

        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($actualizacionExitosa) {
            echo json_encode(['mensaje' => 'Datos del atleta actualizados con éxito']);
        } else {
            echo json_encode(['error' => 'Error al actualizar los datos del atleta']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos incompletos o no válidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Manejar la solicitud POST para eliminar una sede
    // Manejar la solicitud POST para eliminar una sede
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $id = $data['id_atleta'];
    // Verificar si se reciben datos válidos
    if (isset($id)) {
        // Crear un array con los datos del ID de la sede a eliminar
        $idAtletaEliminar = $id;

        // Eliminar la sede utilizando el controlador
        $eliminacionExitosa = $controlador->eliminarAtleta($idAtletaEliminar);

        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($eliminacionExitosa) {
            echo json_encode(['mensaje' => 'Atleta eliminado con éxito']);
        } else {
            echo json_encode(['error' => 'Error al eliminar atleta']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos elimando atleta']);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $data['sedeId'] && $data['deporteId']) {

    // ID del elemento a eliminar
    $sedeId = $data['sedeId'];
    $deporteId = $data['deporteId'];

    // Verificar si se reciben datos válidos (puedes mejorar esta verificación según tus necesidades)
    if (isset($sedeId) && isset($deporteId)) {
        // Crear un array con los datos de la nueva sede


        // Agregar la nueva sede utilizando el controlador
        $response = $controlador->buscarDeportistaPorSedeyDeporte($sedeId, $deporteId);
        
        // Devolver una respuesta, por ejemplo, el ID de la nueva sede
        echo json_encode(['response' => $response]);
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
}else {
    // Manejar otros métodos de solicitud según sea necesario
    // ...
}