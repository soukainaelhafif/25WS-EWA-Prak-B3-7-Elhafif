<?php
error_reporting(E_ALL); // ZEIG MIR ALLE FEHLER 
ini_set('display_errors', 1); // ZEIG FEHLER IM BROWSER AN

require_once __DIR__ . '/EWA_Framework/App/Core/BaseController.php'; // VORLAGE mit renderHTML()
require_once __DIR__ . '/EWA_Framework/App/Controller/OrderController.php';

try {
    $controller = new OrderController(); // CONTROLLER ERSTELLEN
    $controller->processData();       // FORMULARDATEN VERARBEITEN 
    $data = $controller->getData();   // DATEN HOLEN
    $controller->generateResponse($data); // HTML ANZEIGEN 
} catch (Exception $e) {
    http_response_code(500); // SERVER FEHLER
    echo "<h1>Interner Serverfehler</h1><p>Ein Fehler ist aufgetreten: " . htmlspecialchars($e->getMessage()) . "</p>";
}
