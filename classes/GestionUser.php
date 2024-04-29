<?php

class GestionUser
{
    private $bdd;

    public function __construct($bd){
        $this->bdd = $bd;
    }

    //methode pour ajouter un nouveau utilisateur
    public function addUser(User $p) {
        try{
        $sql = $this->bdd->prepare("INSERT INTO user (user_name, email, pwd, token, role_id) VALUES (?, ?, ?, ?, ?)");
        $sql->execute(array(
                            $p->getUsername(),
                            $p->getEmail(),
                            $p->getPwd(),
                            $p->getToken(),
                            $p->getRoleID(),
        ));
        $userId = $this->bdd->lastInsertId();

        //Ajouter l'id du nouveau user dans une session
        session_start();
        $_SESSION['user_id'] = $userId;

    }catch(PDOException $e) {
        echo("Erreur de connexion : ");
        }
    }

    //methode pour connecter un user et verifier sa validité
    public function logUser($username, $pwd)
    {
        $sql = $this->bdd->prepare("SELECT * FROM user where user_name = ?");
        $sql->execute ([$username]);
        $user = $sql->fetch();

        //valider
        if($user) {
            if(password_verify($pwd, $user['pwd'])) {
                //password correcte
                return $user;
            }
        }
        return false;
    }

      // Méthode pour vérifier si un nom d'utilisateur existe déjà dans la base de données
    public function usernameExists($username) {
        $sql = $this->bdd->prepare("SELECT COUNT(*) FROM user WHERE user_name = ?");
        $sql->execute([$username]);
        $count = $sql->fetchColumn();
        return $count > 0;
    }

    public function emailExist($email) {
        $sql = $this->bdd->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $sql->execute([$email]);
        $count = $sql->fetchColumn();
        return $count > 0;
    }
    
    // Fonction pour récupérer un utilisateur par son nom d'utilisateur
    public function getUserByUsername($username) {
        $query = "SELECT * FROM user WHERE user_name = :user_name";
        $statement = $this->bdd->prepare($query);
        $statement->bindParam(':user_name', $username, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($user){
            return $user;
        }else{
            return false;
        }
    }

    public function getProductByName($name) {
        $query = "SELECT * FROM product WHERE product.name = '" . $name . "';";
        $statement = $this->bdd->prepare($query);
        $statement->bindParam(':name', $name, PDO::PARAM_STR); 
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getProductById($productId) {
        try{
            $query = "SELECT * FROM product WHERE id = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            // Récupérer le produit s'il existe
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                return $product;
            } else {
                return null; 
            }
        }catch(PDOException $e){
            error_log("ERREUR IN GETPRODUCTBYID: " . $e->getMessage());
            return null;
        }
    }

    public function addToCart($productId, $quantity){
        // Récupérer les informations sur le produit
        $product = $this->getProductById($productId);

         // Vérifier si le produit existe
        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            // Vérifier si le produit est déjà dans le panier
            if (isset($_SESSION['cart'][$productId])) {
                // Le produit est déjà dans le panier, mettre à jour la quantité
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            }else {
                // Le produit n'est pas dans le panier, l'ajouter
                $_SESSION['cart'][$productId] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
            }

            // Mettre à jour le panier dans la session
            //$_SESSION['cart'] = $cart;
            return array('status' => 'success', 'message' => 'Product added successfully');
        } else {
            // Le produit n'existe pas, gérer l'erreur ou afficher un message à l'utilisateur
            return array('status' => 'error', 'message' => 'Product does not exist');
        }
    }

    public function orderHasProduct($userId) {
        $query = "SELECT uo.id as order_id, uo.ref, uo.date, uo.total, ohp.product_id, ohp_quantity, ohp.price FROM user_order uo JOIN order_has_product ohp ON uo.id = ohp.order_id WHERE uo.user_id = :userId";

        try {
            $stmt = $this->bdd->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $orders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $orderId = $row['order_id'];
                if (!isset($orders[$orderId])) {
                    $orders[$orderId] = [
                        'ref' => $row['ref'],
                        'date' => $row['date'],
                        'total' => $row['total'],
                        'products' => []
                    ];
                }

                $orders[$orderId]['products'][] = [
                    'product_id' => $row['product_id'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price']
                ];
            }
            return $orders;
        } catch (PDOException $E) {
            error_log("Erreur in orderHasProduct: " . $E->getmessage());
            return null;
        }
    }
    

    public function getAllUser(){
        $stmt = $this->bdd->query('SELECT * FROM user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>