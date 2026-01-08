<?php
// 1) SESSION STARTEN
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) FEHLER ANZEIGEN (NUR FÜR DIE ENTWICKLUNG)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 3) BENÖTIGTE DATEIEN LADEN
require_once __DIR__ . '/EWA_Framework/App/Core/BaseController.php';
require_once __DIR__ . '/EWA_Framework/App/Controller/OrderController.php';

// 4) CONTROLLER AUFRUFEN
try {
    $controller = new OrderController();

    // a) POST DATEN VERARBEITEN (FALLS VORHANDEN)
    $controller->processData();

    // b) DATEN AUS DB HOLEN
    $data = $controller->getData();

    // c) VIEW ANZEIGEN
    $controller->generateResponse($data);
} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Interner Serverfehler</h1><p>Ein Fehler ist aufgetreten: " . htmlspecialchars($e->getMessage()) . "</p>";
}


// MERKSATZ! Herz des MVC-Patterns
/*

try {
    // CONTROLLER ERSTELLEN
    $controller = new OrderController();
    
    // === SCHRITT 1: processData() === 
    $controller->processData();
    
    // === SCHRITT 2: getData() ===
    $data = $controller->getData();
    
    // === SCHRITT 3: generateResponse() ===
    $controller->generateResponse($data);
    
} catch (Exception $e) {
    // Fehlerbehandlung
}
 */