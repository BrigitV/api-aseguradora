<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'controllers/CotizarController.php';
require_once 'config/Database.php';

// Crear instancia de la base de datos y controlador
$db = new Database();
$conn = $db->getConnection();
$controller = new CotizarController($conn);
// Manejar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Formato JSON inválido');
        }       
        $response = $controller->cotizar($input);
        echo json_encode($response);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}