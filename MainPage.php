<?php
session_start();
require("./DB/connexion.php");
require("./Controllers/functions.php");
require("./classes/GestionUser.php");

$gestionUser = new GestionUser($dbco);

?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boutique</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--Font_Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <script>
      function addProductsToCart(productId){
        // Récupérer l'identifiant du produit et la quantité depuis le formulaire
        var quantityId = 'quantity_' + productId;
        var quantity = parseInt(document.getElementById(quantityId).value);

        fetch('./Controllers/handleCartActions.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'productId=' + encodeURIComponent(productId) + '&quantity=' + encodeURIComponent(quantity)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
        })
        .catch(error => {
          console.error('Erreur: ', error);
          alert('Produit non ajouter')
        });
        return false
      }
    </script>

  </head>
  <body>
    
<header data-bs-theme="dark">
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="./index.php" class="navbar-brand d-flex align-items-center">
        <strong>Marie_Cedet</strong>
      </a>
      <strong class="navbar-brand d-flex align-items-center">Bienvenue sur notre site</strong>

      <a href="./Views/logout.php" class="d-flex align-items-center text-decoration-none" aria-label="Logout">
      <i class="fa-solid fa-arrow-right-from-bracket" style="color: white;"></i>
      </a>
    </div>
  </div>
</header>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Self care is the best care</h1>
        <p class="lead text-body-secondary">Here at Marie_Cedet we sell safe skincare for all types of skin. We believe 'if you look good you will feel good'. So here's the best for your skin</p>
        <p>
          <a href="./index.php" class="btn btn-primary my-2">Revenir a la Page Principale</a>
          <a href="./cart.php" class="btn btn-secondary my-2">Mon Panier</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
    <?php
    $listeProduits = getListProduit();

    $count = 0;
    foreach($listeProduits as $produits) {
      // Si le compteur est un multiple de 3, ouvrez une nouvelle rangée
      if ($count % 3 == 0) {
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
      }
  ?>
        <div class="col">
          <div class="card shadow-sm">
            <img src="./images/<?php echo $produits['img_url']; ?>"  class="bd-placeholder-img card-img-top" width="100%" height="285">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($produits['name']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($produits['description']); ?></p>
              <div class="d-flex flex-column">
                <div class="mb-2">
                  <input type="number" name="" id="quantity_<?php echo $produits['id']; ?>" class="form-control" value='1' min='1'>
                </div>
                <div class="btn-group mb-2">
                  <button onclick="addProductsToCart(<?php echo $produits['id']; ?>)" class="btn btn-primary my-2">Ajouter</button>
                </div>
                </div>
                      <small class="text-body-secondary"><?php echo $produits['price']; ?>$</small>
                    </div>
            </div>
          </div>
        <?php
        // Si le compteur est un multiple de 3 ou si c'est le dernier produit, fermez la rangée
        if (($count + 1) % 3 == 0 || $count + 1 == count($listeProduits)) {
          echo '</div>'; // Fermer la rangée
        }
        $count++;
  }
  ?>
        
      </div>
    </div>
  

</main>

<footer class="text-body-secondary py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
  </div>
</footer>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
</html>
