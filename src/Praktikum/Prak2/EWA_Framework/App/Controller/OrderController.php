<?php
require_once __DIR__ . '/../Model/OrderModel.php';

class OrderController extends BaseController
{    
    // 1 - Daten holen
    public function getData(): array
    {
        $model = new OrderModel();
        return $model->getArticles();
    }

    
    // 2 - Formular verarbeiten
    public function processData(): void
    {
        // a - Wurde Formularn abgeschickt!? (post)
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            return;
        }

        // b - Formulardaten holen aus DB
        $address = trim($_POST['address'] ?? '');
        $pizza_id = (int) ($_POST['pizza_id'] ?? 0);
        $amount = (int) ($_POST['amount'] ?? 1);



        // c - Validieren ist alles ausgefüllt!?
        if($address ==='' || $pizza_id <= 0 || $amount < 1){
            header('Location: index.php?message=error');
            exit;
        }

        // d - In DB speichern
        $model = new OrderModel();
        $orderingId = $model->create($address, $pizza_id ,$amount);

        // e - PRG Pattern Weiterleitung
        if($orderingId){
            $_SESSION['last_ordering_id'] = $orderingId;
            header('location: customer.php?message=success');
            exit;
        }
        header('location: index.php?message=error');
        exit;
    }
    

    //3 - Seite anzeigen
    public function generateResponse(array $data): void
    {
        $viewData = [
            'data' => $data,
            'title' => 'Pizza bestellen'
        ];

        $this->renderHtml(__DIR__ . '/../View/index.view.php', $viewData);
        
    }
}
