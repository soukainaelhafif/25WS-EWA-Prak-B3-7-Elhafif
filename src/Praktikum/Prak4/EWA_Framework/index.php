<?php
require_once 'App/Core/DebugHelper.php';
require_once 'App/Controller/IndexController.php';

try {
    $controller = new IndexController();
    $controller->handleRequest();
} catch (Exception $e) {
    header("Content-type: text/html; charset=UTF-8");
    echo "<h1>Unexpected error occurred</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}