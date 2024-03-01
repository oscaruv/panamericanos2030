<?php

require_once "../modelos/ModeloDeportes.php";

class ControladorDeportes {

    public function mostrarDeporte($id_deporte) {
        // Llamar al modelo para filtrar deporte
        $resultados = ModeloDeportes::mdlFiltrarDeporte('deportes', $id_deporte);

        // Lógica para mostrar los resultados en la vista
        // ...

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);
    }

    public function mostrarDeportes() {
        // Llamar al modelo para filtrar deporte
        $resultados = ModeloDeportes::mdlMostrarDeporte('deportes');

        // Lógica para mostrar los resultados en la vista
        // ...

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);
    }


    public function agregarDeporte($datosDeporte) {
        // Llamar al modelo para agregar deporte
        $idNuevoDeporte = ModeloDeportes::mdlAgregarDeporte('deportes', $datosDeporte);

        // Lógica para manejar el resultado en la vista
        // ...

        // Ejemplo de retorno del ID del nuevo deporte (puedes adaptarlo según tus necesidades)
        return $idNuevoDeporte;
    }

    public function actualizarDeporte($datosDeporte) {
        // Llamar al modelo para actualizar deporte
        $numFilasAfectadas = ModeloDeportes::mdlActualizarDeporte('deportes', $datosDeporte);

        // Lógica para manejar el resultado en la vista
        // ...

        // Ejemplo de retorno del número de filas afectadas (puedes adaptarlo según tus necesidades)
        return $numFilasAfectadas;
    }

    public function eliminarDeporte($idDeporte) {
        // Llamar al modelo para eliminar deporte
        $numFilasAfectadas = ModeloDeportes::mdlEliminarDeporte('deportes', $idDeporte);

        // Lógica para manejar el resultado en la vista
        // ...

        // Ejemplo de retorno del número de filas afectadas (puedes adaptarlo según tus necesidades)
        return $numFilasAfectadas;
    }

    public function buscarDeportesPorSede($idDeporte){
        $numFilasAfectadas = ModeloDeportes::mdlBuscarDeportePorSede('deportes', $idDeporte);
        return $numFilasAfectadas; 
    }
}

// Crear una instancia del controlador
$controlador = new ControladorDeportes();
$data = json_decode(file_get_contents("php://input"), true);
// Manejar la solicitud según el método de la solicitud (GET, POST, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los atletas y devolver la respuesta en formato JSON
    $atletas = $controlador->mostrarDeportes();
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['sedeDeporte'])) {
    // Manejar la solicitud POST para agregar una nueva sede
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $sedeDeporte = $data['sedeDeporte'];

    $nombreDeporte = $data['nombreDeporte'];
    // Verificar si se reciben datos válidos (puedes mejorar esta verificación según tus necesidades)
    if (isset($nombreDeporte) AND isset($sedeDeporte) ) {
        // Crear un array con los datos de la nueva sede
        $datosNuevaSede = [
            'nombre' => $nombreDeporte,
            'id_sede' => $sedeDeporte,
        ];

        // Agregar la nueva sede utilizando el controlador
        $idNuevaSede = $controlador->agregarDeporte($datosNuevaSede);

        // Devolver una respuesta, por ejemplo, el ID de la nueva sede
        echo json_encode(['id_nuevo_deporte' => $idNuevaSede]);
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Manejar la solicitud POST para eliminar una sede
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $id = $data['id_deporte'];
    // Verificar si se reciben datos válidos
    if (isset($id)) {
        // Crear un array con los datos del ID de la sede a eliminar
        $idDeporteEliminar = $id;

        // Eliminar la sede utilizando el controlador
        $eliminacionExitosa = $controlador->eliminarDeporte($idDeporteEliminar);

        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($eliminacionExitosa) {
            echo json_encode(['mensaje' => 'Deporte eliminado con éxito']);
        } else {
            echo json_encode(['error' => 'Error al eliminar deporte']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos para borrar deporte']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $id_deporte = $data['id_deporte'];
    $id_sede = $data['id_sede'];
    $nombre = $data['nombre'];
    // Verificar si se reciben datos válidos
    if (isset($id_deporte) && isset($id_sede) && isset($nombre)) {
        // Crear un array con los datos para actualizar la ubicación de la sede
        $datosActualizarSede = [
            'id_deporte' => $id_deporte,
            'id_sede' => $id_sede,
            'nombre' => $nombre,
        ];

        // Actualizar la sede utilizando el controlador
        $actualizacionExitosa = $controlador->actualizarDeporte($datosActualizarSede);

        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($actualizacionExitosa) {
            echo json_encode(['mensaje' => 'Ubicación de la sede actualizada con éxito']);
        } else {
            echo json_encode(['error' => 'Error al actualizar la ubicación de la sede']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos para actualizar inmformacion']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $data['sedeId']) {

    // ID del elemento a eliminar
    $sedeId = $data['sedeId'];

    // Verificar si se reciben datos válidos (puedes mejorar esta verificación según tus necesidades)
    if (isset($sedeId) ) {
        // Crear un array con los datos de la nueva sede


        // Agregar la nueva sede utilizando el controlador
        $response = $controlador->buscarDeportesPorSede($sedeId);
        
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
?>

