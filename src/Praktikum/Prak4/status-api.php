<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/EWA_Framework/App/Core/BaseController.php';
require_once __DIR__ . '/EWA_Framework/App/Controller/StatusApiController.php';

try {
    $controller = new StatusApiController();
    $controller->processData();
    $data = $controller->getData();
    $controller->generateResponse($data);
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
