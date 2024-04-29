<?php

class GestionProduct {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    

    public function productValid($productId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM product WHERE id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchColumn() > 0;
    }


    public function updateProduct($productId, $data) {
        $sql = "UPDATE product SET name = ?, quantity = ?, price = ?, description = ?, img_url = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'], 
            $data['quantity'], 
            $data['price'], 
            $data['description'], 
            $data['img_url'], 
            $productId
        ]);
    }

    public function getAllOrders() {
        $stmt = $this->db->query('SELECT * FROM user_order ORDER BY date DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>