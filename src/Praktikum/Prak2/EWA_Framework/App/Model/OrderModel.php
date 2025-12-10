<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class OrderModel extends BaseModel
{
    /**
     * Alle Artikel (Pizzen) für die Speisekarte.
     */
    public function getArticles(): array
    {
        $sql = "SELECT article_id, name, price, picture FROM article";
        $result = $this->db->query($sql);
        if (!$result) {
            throw new Exception("Datenbankabfrage fehlgeschlagen: " . $this->db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Alte Variante: nur EINE Pizzasorte mit amount.
     * Wird jetzt intern auf createOrderFromCart abgebildet.
     */
    public function createOrderSingle(string $address, int $pizzaId, int $amount)
    {
        if ($pizzaId <= 0 || $amount < 1) {
            return false;
        }

        $items = [
            [
                'pizza_id' => $pizzaId,
                'amount'   => $amount,
            ],
        ];

        return $this->createOrderFromCart($address, $items);
    }

    /**
     * Neue Variante: Bestellung mit mehreren Pizzen anlegen.
     *
     * $cartItems Beispiel:
     * [
     *   ['pizza_id' => 1, 'amount' => 2],
     *   ['pizza_id' => 3, 'amount' => 1],
     * ]
     *
     * @return int|false ordering_id oder false bei Fehler
     */
    public function createOrderFromCart(string $address, array $cartItems)
    {
        $db = $this->getDb();

        if (empty($cartItems)) {
            return false;
        }

        // Transaktion: entweder alles speichern oder gar nichts
        $db->begin_transaction();

        try {
            // 1. Bestellung in "ordering" speichern
            $stmtOrder = $db->prepare("INSERT INTO ordering (address) VALUES (?)");
            if (!$stmtOrder) {
                throw new Exception($db->error);
            }

            $stmtOrder->bind_param("s", $address);

            if (!$stmtOrder->execute()) {
                throw new Exception($stmtOrder->error);
            }

            $orderingId = $db->insert_id;
            $stmtOrder->close();

            // 2. Alle Pizzen in "ordered_article" eintragen
            $stmtPizza = $db->prepare("
                INSERT INTO ordered_article (ordering_id, article_id, status)
                VALUES (?, ?, 1)
            ");
            if (!$stmtPizza) {
                throw new Exception($db->error);
            }

            foreach ($cartItems as $item) {
                $pizzaId = isset($item['pizza_id']) ? (int)$item['pizza_id'] : 0;
                $amount  = isset($item['amount'])   ? (int)$item['amount']   : 0;

                if ($pizzaId <= 0 || $amount <= 0) {
                    continue; // ungültige Items überspringen
                }

                for ($i = 0; $i < $amount; $i++) {
                    $stmtPizza->bind_param("ii", $orderingId, $pizzaId);
                    if (!$stmtPizza->execute()) {
                        throw new Exception($stmtPizza->error);
                    }
                }
            }

            $stmtPizza->close();

            // Alles OK → committen
            $db->commit();
            return $orderingId;

        } catch (Throwable $e) {
            // Fehler → alles zurückrollen
            $db->rollback();
            // Optional: Logging
            // error_log("Bestellung fehlgeschlagen: " . $e->getMessage());
            return false;
        }
    }
}
