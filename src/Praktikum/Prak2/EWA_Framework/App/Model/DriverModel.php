<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class DriverModel extends BaseModel
{
    public function getDeliveries(): array
    {
        $sql = "
            SELECT
                o.ordering_id,
                o.address,
                GROUP_CONCAT(a.name ORDER BY a.name SEPARATOR ', ') AS articles,
                SUM(a.price) AS total_price
            FROM ordering o
            JOIN ordered_article oa ON oa.ordering_id = o.ordering_id
            JOIN article a ON oa.article_id = a.article_id
            WHERE oa.status IN (3,4)    -- Fertig oder Unterwegs
            GROUP BY o.ordering_id, o.address
            ORDER BY o.ordering_id ASC
        ";
        $result = $this->db->query($sql);
        if (!$result) {
            throw new Exception('Fehler: ' . $this->db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrderStatus(int $orderingId, int $status): bool
    {
        // Alle ordered_article zu dieser Bestellung updaten
        $stmt = $this->db->prepare("
            UPDATE ordered_article
            SET status = ?
            WHERE ordering_id = ?
        ");
        if (!$stmt) return false;

        $stmt->bind_param("ii", $status, $orderingId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function deleteDelivered(int $orderingId): bool
    {
        // Optional: nach Auslieferung löschen
        $stmt = $this->db->prepare("
            DELETE FROM ordered_article WHERE ordering_id = ?
        ");
        if (!$stmt) return false;
        $stmt->bind_param("i", $orderingId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
