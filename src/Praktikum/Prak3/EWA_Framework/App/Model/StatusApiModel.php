<?php

require_once __DIR__ . '/../Core/BaseModel.php';

class StatusApiModel extends BaseModel
{
    public function getOrderData(int $orderingId): array
    {
        $sql = "
            SELECT 
                o.ordering_id,
                GROUP_CONCAT(a.name ORDER BY a.name SEPARATOR ', ') AS pizzas,
                COUNT(oa.ordered_article_id)                        AS amount,
                SUM(a.price)                                        AS total_price,
                MIN(oa.status)                                      AS min_status,
                MAX(oa.status)                                      AS max_status
            FROM ordering o
            JOIN ordered_article oa ON oa.ordering_id = o.ordering_id
            JOIN article a          ON a.article_id    = oa.article_id
            WHERE o.ordering_id = ?
            GROUP BY o.ordering_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows   = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $rows;
    }
}
