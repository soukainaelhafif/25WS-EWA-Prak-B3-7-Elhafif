<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/EWA_Framework/App/Core/BaseController.php';
require_once __DIR__ . '/EWA_Framework/App/Controller/CustomerController.php';

try {
    $controller = new CustomerController();
    $controller->processData();
    $data = $controller->getData();
    $controller->generateResponse($data);
} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Interner Serverfehler</h1><p>Ein Fehler ist aufgetreten: " . htmlspecialchars($e->getMessage()) . "</p>";
}
