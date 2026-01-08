<?php
require_once __DIR__ . '/../Core/BaseModel.php';

class OrderModel extends BaseModel
{
    // READ: Alle Pizzen für die Speisekarte holen
    public function getArticles() : array {
        $sql = "SELECT article_id , name , price ,picture from article";
        $result = $this->db->query($sql);

        if(!$result){
            throw new exception("Fehler: ". $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // CREATE - NEUE BESTELLUNG ERSTELLEN
    public function create(string $address , int $pizza_id ,  int $amount){
        // 1 - Bestellung in "Ordering" speichern
        $sql = "INSERT INTO ordering (address) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $address);
        $stmt->execute();
        // 2 - Die neue ordering_id holen
        $orderingId = $this->db->insert_id;
        $stmt->close();

        // 3 - Pizzen in "ordered_article" speichern
        $sql = "INSERT INTO ordered_article (ordering_id , article_id , status) Values (?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        // Für jede Pizza
        for($i = 0 ; $i < $amount ; $i++){
            $stmt->bind_param("ii", $orderingId ,$pizza_id);
            $stmt->execute();
        }
        $stmt->close();

        return $orderingId;
    }

}
