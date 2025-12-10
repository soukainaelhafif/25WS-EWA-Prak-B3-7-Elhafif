<?php
require_once __DIR__ . '/../Model/OrderModel.php';

class OrderController extends BaseController
{
    protected ?OrderModel $orderModel = null;

    /**
     * Hilfsmethode, um das Model lazy zu initialisieren.
     */
    protected function getOrderModel(): OrderModel
    {
        if ($this->orderModel === null) {
            $this->orderModel = new OrderModel();
        }
        return $this->orderModel;
    }

    /**
     * Wird vom Framework aufgerufen, um Daten für die View zu holen.
     */
    public function getData(): array
    {
        return $this->getOrderModel()->getArticles();
    }

    /**
     * Verarbeitet das Abschicken des Bestellformulars.
     */
    public function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $address = trim($_POST['address'] ?? '');

        if ($address === '') {
            header('Location: index.php?message=error');
            exit;
        }

        // ================== 1) Versuche, den kompletten Warenkorb aus cart_json zu lesen ==================
        $cartJson  = $_POST['cart_json'] ?? '';
        $cartItems = [];

        if ($cartJson !== '') {
            $decoded = json_decode($cartJson, true);

            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    // Erwartete Keys aus dem JS: id, amount
                    $pizzaId = isset($item['id']) ? (int)$item['id'] : 0;
                    $amount  = isset($item['amount']) ? (int)$item['amount'] : 0;

                    if ($pizzaId > 0 && $amount > 0) {
                        $cartItems[] = [
                            'pizza_id' => $pizzaId,
                            'amount'   => $amount,
                        ];
                    }
                }
            }
        }

        $orderModel = $this->getOrderModel();

        // ================== 2) Wenn cart_json valide ist → mehrere Pizzen speichern ==================
        if (count($cartItems) > 0) {
            $orderingId = $orderModel->createOrderFromCart($address, $cartItems);

        // ================== 3) Fallback: altes Verhalten (eine Pizza + amount) ==================
        } else {
            $pizzaId = filter_input(INPUT_POST, 'pizza_id', FILTER_VALIDATE_INT);
            $amount  = filter_input(INPUT_POST, 'amount',   FILTER_VALIDATE_INT);

            if ($pizzaId === false || $pizzaId <= 0 || $amount === false || $amount < 1) {
                header('Location: index.php?message=error');
                exit;
            }

            $orderingId = $orderModel->createOrderSingle($address, $pizzaId, $amount);
        }

        // ================== 4) Weiterleitung mit PRG-Pattern ==================
        if ($orderingId !== false && $orderingId !== null) {
            $_SESSION['last_ordering_id'] = (int)$orderingId;
            header('Location: customer.php?message=success');
            exit;
        }

        header('Location: index.php?message=error');
        exit;
    }

    /**
     * View rendern
     */
    public function generateResponse(array $data): void
    {
        $viewData = [
            'data'  => $data,
            'title' => 'Pizza bestellen',
        ];

        $this->renderHtml(__DIR__ . '/../View/index.view.php', $viewData);
    }
}
