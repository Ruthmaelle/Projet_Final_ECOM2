<?php

class SaltedCode {
    public static function addSalt($inputPassword){

        return password_hash($inputPassword, PASSWORD_BCRYPT);
        
    }
    
}

function getListProduit() {
    global $dbco;

    try{
        // Préparer la requête SQL pour sélectionner tous les produits
        $query = "SELECT * FROM product";
        $statement = $dbco->prepare($query);
        $statement->execute();

         // Récupérer les résultats de la requête sous forme de tableau associatif
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }catch(PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur ou enregistrez-le dans un fichier journal
        echo "Erreur lors de la récupération des produits : " . $e->getMessage();
        return array(); // Retourner un tableau vide en cas d'erreur
    }
}

?>
