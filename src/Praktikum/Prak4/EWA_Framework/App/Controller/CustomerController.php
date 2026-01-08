<?php
require_once __DIR__ . '/../Model/CustomerModel.php';

class CustomerController extends BaseController 
{
     // 1 - Daten holen
    public function getData() : array
    {
        $orderingId = $_SESSION['last_ordering_id'] ?? null; 

        if($orderingId === null) return [];

        $model = new CustomerModel();
        
        return $model->getOrderById($orderingId);
    }

    // 2 - Formular verarbeiten
    public function processData() : void
    {

    }

    // 3 - Seite anzeigen
    public function generateResponse(array $data) : void
    {
        $viewData = [
            'data'  => $data,
            'title' => 'Bestellstatus'
        ];
        $this->renderHtml(__DIR__ . '/../View/customer.view.php', $viewData);
    }
}
