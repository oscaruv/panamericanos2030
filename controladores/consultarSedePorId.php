<?php

require_once "../modelos/ModeloSedes.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el id_sede enviado en el cuerpo de la solicitud
    $idSede = json_decode(file_get_contents("php://input"), true)['id_sede'];

    // Llamar al método mdlConsultarSedePorId y obtener los resultados
    $resultados = modeloSedes::mdlConsultarSedePorId("sedes", $idSede);

    // Devolver los resultados como JSON
    echo json_encode($resultados);
} else {
    // Si la solicitud no es de tipo POST, devolver un error
    http_response_code(400);
    echo json_encode(array("mensaje" => "Error: La solicitud debe ser de tipo POST"));
}

?>
