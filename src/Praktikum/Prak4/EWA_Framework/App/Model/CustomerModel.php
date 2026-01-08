<?php
require_once __DIR__ . '/../Core/BaseModel.php';

Class CustomerModel extends BaseModel{

   public function getOrderById(int $orderingId): array {
    $sql = "
        SELECT 
            o.ordering_id, o.address , o.ordering_time ,
            group_concat(a.name SEPARATOR ', ' )AS pizzas,
            count(oa.ordered_article_id) AS amount,
            SUM(a.price) AS total_price,
            MIN(oa.status) AS min_status,
            MAX(oa.status)AS max_status
        from ordering o 
        join ordered_article oa ON o.ordering_id = oa.ordering_id
        join article a ON oa.article_id = a.article_id
        Where o.ordering_id = ?
        group by o.ordering_id , o.address ,o.ordering_time
    ";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $orderingId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
    }
}