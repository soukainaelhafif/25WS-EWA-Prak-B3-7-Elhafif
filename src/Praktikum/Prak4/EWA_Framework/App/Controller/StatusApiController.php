<?php

require_once __DIR__ . '/../Model/StatusApiModel.php';

class StatusApiController extends BaseController
{
    public function getData(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // letzte Bestellung aus der Session
        $orderingId = $_SESSION['last_ordering_id'] ?? null;
        
        if (!$orderingId) {
            // keine Bestellung in dieser Session
            return [];
        }

        // Model erstellen und Daten holen
        $model = new StatusApiModel();
        return $model->getOrderData((int)$orderingId);
    }

    public function processData(): void
    {
        // API-Endpunkt: kein POST zu verarbeiten
    }

    public function generateResponse(array $data): void
    {
        $this->renderJson($data);
    }
}
