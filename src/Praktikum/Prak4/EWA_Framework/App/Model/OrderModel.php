<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class OrderModel extends BaseModel
{
    // READ: Alle Pizzen für die Speisekarte holen
    public function getArticles(): array
    {
        $sql = "SELECT article_id, name, price, picture FROM article";
        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Fehler: " . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // CREATE: Bestellung aus Warenkorb erstellen
    public function createFromCart(string $address, array $cart): int
    {
        // 1 - Bestellung in "ordering" speichern
        $sql = "INSERT INTO ordering (address) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $address);
        $stmt->execute();
        
        $orderingId = $this->db->insert_id;
        $stmt->close();

        // 2 - Jede Pizza aus dem Warenkorb speichern
        $sql = "INSERT INTO ordered_article (ordering_id, article_id, status) VALUES (?, ?, 1)";
        $stmt = $this->db->prepare($sql);

        foreach ($cart as $item) {
            $pizzaId = $this->getArticleIdByName($item['name']);
            if ($pizzaId > 0) {
                $stmt->bind_param("ii", $orderingId, $pizzaId);
                $stmt->execute();
            }
        }
        $stmt->close();

        return $orderingId;
    }

    // Hilfsmethode: Pizza-ID aus Namen holen
    private function getArticleIdByName(string $name): int
    {
        $sql = "SELECT article_id FROM article WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? (int)$row['article_id'] : 0;
    }
}