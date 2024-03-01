<?php

require_once "../modelos/ModeloSedes.php";

class ControladorSedes {

    public function mostrarSede($idSede) {
        // Llamar al modelo para filtrar sede
        $resultados = ModeloSedes::mdlFiltrarSede('sedes', $idSede);

        // Lógica para mostrar los resultados en la vista
        // ...


        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);
    }

    public function mostrarSedes() {
        // Llamar al modelo para filtrar sede
        $resultados = ModeloSedes::mdlMostrarSedes('sedes');

        // Lógica para mostrar los resultados en la vista
        // ...


        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);
    }

    public function agregarSede($datosSede) {
        // Llamar al modelo para agregar sede
        $idNuevaSede = ModeloSedes::mdlAgregarSede('sedes', $datosSede);

        // Lógica para manejar el resultado en la vista
        // ...

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($idNuevaSede);
    }

    public function actualizarSede($datosSede) {
        // Llamar al modelo para actualizar sede
        $numFilasAfectadas = ModeloSedes::mdlActualizarSede('sedes', $datosSede);

        // Lógica para manejar el resultado en la vista
        // ...

         // Devolver los datos en formato JSON
        //  header('Content-Type: application/json');
        //  return json_encode($numFilasAfectadas);
        return $numFilasAfectadas;
    }

    public function eliminarSede($idSede) {
        // Llamar al modelo para eliminar sede
        $numFilasAfectadas = ModeloSedes::mdlEliminarSede('sedes', $idSede);

        // Lógica para manejar el resultado en la vista
        // ...

        // Ejemplo de retorno del número de filas afectadas (puedes adaptarlo según tus necesidades)
        return $numFilasAfectadas;
    }
}


// Crear una instancia del controlador
$controlador = new ControladorSedes();

// Manejar la solicitud según el método de la solicitud (GET, POST, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los atletas y devolver la respuesta en formato JSON
    $atletas = $controlador->mostrarSedes();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Verificar si se reciben datos válidos
    $data = json_decode(file_get_contents("php://input"), true);
    var_dump($data);
    // ID del elemento a eliminar
    $ubicacion = $data['nueva_ubicacion'];
    $id_sede = $data['id_sede'];
    if (isset($id_sede) && isset($ubicacion)) {
        // Crear un array con los datos para actualizar la ubicación de la sede
        $datosActualizarSede = [
            'id_sede' => $id_sede,
            'nueva_ubicacion' => $ubicacion,
        ];

        // Actualizar la sede utilizando el controlador
        $actualizacionExitosa = $controlador->actualizarSede($datosActualizarSede);
        // var_dump($actualizacionExitosa);
        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($actualizacionExitosa) {
            echo json_encode(['mensaje' => 'Ubicación de la sede actualizada con éxito']);
        } else {
            echo json_encode(['error' => 'Error al actualizar la ubicación de la sede']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la solicitud POST para agregar una nueva sede
    // inputUbicacion
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $ubicacion = $data['inputUbicacion'];
    // Verificar si se reciben datos válidos (puedes mejorar esta verificación según tus necesidades)
    if (isset($ubicacion)) {
        // Crear un array con los datos de la nueva sede
        $datosNuevaSede = [
            'ubicacion' => $ubicacion,
        ];

        // Agregar la nueva sede utilizando el controlador
        $idNuevaSede = $controlador->agregarSede($datosNuevaSede);

        // Devolver una respuesta, por ejemplo, el ID de la nueva sede
        echo json_encode(['id_nueva_sede' => $idNuevaSede]);
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
}  elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Manejar la solicitud POST para eliminar una sede
    $data = json_decode(file_get_contents("php://input"), true);

    // ID del elemento a eliminar
    $id = $data['id_sede'];
    // Verificar si se reciben datos válidos
    if (isset($id)) {
        // Crear un array con los datos del ID de la sede a eliminar
        $idSedeEliminar = $id;

        // Eliminar la sede utilizando el controlador
        $eliminacionExitosa = $controlador->eliminarSede($idSedeEliminar);

        // Devolver una respuesta, por ejemplo, un mensaje de éxito o error
        if ($eliminacionExitosa) {
            echo json_encode(['mensaje' => 'Sede eliminada con éxito']);
        } else {
            echo json_encode(['error' => 'Error al eliminar la sede']);
        }
    } else {
        // Manejar caso de datos no válidos
        echo json_encode(['error' => 'Datos no válidos']);
    }
} else {
    // Manejar otros métodos de solicitud según sea necesario
    // ...
}
?>
