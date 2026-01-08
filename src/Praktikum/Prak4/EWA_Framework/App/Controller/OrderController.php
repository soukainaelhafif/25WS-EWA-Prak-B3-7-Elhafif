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
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $address = trim($_POST['address'] ?? '');
        $cart_json = $_POST['cart_json'] ?? '';

        // Validieren
        if ($address === '' || empty($cart_json)) {
            header('Location: index.php?message=error');
            exit;
        }

        // JSON zu Array umwandeln
        $cart = json_decode($cart_json, true);

        if (empty($cart)) {
            header('Location: index.php?message=error');
            exit;
        }

        // In DB speichern
        $model = new OrderModel();
        $orderingId = $model->createFromCart($address, $cart);

        if ($orderingId) {
            $_SESSION['last_ordering_id'] = $orderingId;
            header('Location: customer.php?message=success');
            exit;
        }
        
        header('Location: index.php?message=error');
        exit;
    }

    // 3 - Seite anzeigen
    public function generateResponse(array $data): void
    {
        $viewData = [
            'data' => $data,
            'title' => 'Pizza bestellen'
        ];
        $this->renderHtml(__DIR__ . '/../View/index.view.php', $viewData);
    }
}