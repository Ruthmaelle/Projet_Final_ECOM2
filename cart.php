<?php
session_start();

require_once("./DB/connexion.php");
require_once("./classes/GestionUser.php");

// Créer une instance de GestionUser pour gérer les opérations sur les utilisateurs et les produits
$gestionUser = new GestionUser($dbco);
//$userId = $_SESSION['user_id'];
//$orderHistory = $gestionUser->orderHasProduct($userId);

// Vérifier si le panier existe dans la session
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart = array();
    echo"<script>alert('Your cart is empty!'); window.location.href = 'MainPage.php';</script>";
} else {
  $cart = $_SESSION['cart'];
}


$totalPrice = 0; //initialiser le prix total

// Calculer le prix total en parcourant chaque produit dans le panier
foreach ($cart as $productId => $details) {
    $totalPrice += $details['price'] * $details['quantity'];
}
$totalPrice -=5;
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Panier</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script>
        function updateQnt(productId, del){
            var qtyInput = document.getElementById('quantity_' + productId);
            var newQnt = parseInt(qtyInput.value) + del;

            if (newQnt < 0) newQnt = 0;
            qtyInput.value = newQnt;

            fetch('./Controllers/updateCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `productId=${productId}&quantity=${newQnt}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                  document.getElementById('total_price').innerText = '$' + data.newTotal;
                  if (newQnt === 0) {
                    document.getElementById('product_row_' + productId).remove();
                  }
                }else{
                  alert(data.message);
                }
            })
            .catch(error => console.error("Error: ", error));
        }
    </script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>

    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="./images/newLogo.png" width="100px" height="95px">
      <h2>Checkout form</h2>
      <p class="lead">Merci d’avoir visité notre site. Voici votre page de paiement avec votre panier.</p>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Votre Panier</span>
          <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          <?php foreach ($cart as $id => $product): ?>
            <li class="list-group-item d-flex justify-content-between 1h-sm">
                <div>
                    <h6 class="my-0"><?php echo htmlspecialchars($product['name']); ?></h6>
                    <small class="text-muted">Quantity: </small>
                    <button onclick="updateQnt(<?php echo $id; ?>, -1)">-</button>
                    <input type="text" id="quantity_<?php echo $id; ?>" value="<?php echo $product['quantity']; ?>" readonly style="width: 30px;">
                    <button onclick="updateQnt(<?php echo $id; ?>, 1)">+</button>
                </div>
                <span class="text-muted">$<?php echo number_format($product['price'], 2)?></span>
            </li>
            <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>FIRST/TIME</small>
            </div>
            <span class="text-success">−$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$<?php echo number_format($totalPrice, 2); ?></strong>
          </li>
          <div id='paypal-button-container'></div>
          <script src="https://www.paypal.com/sdk/js?client-id=Ac56bODbm8klviNNzmbRSANqg1p3C2TQdMl1ZFbnh-RDiMx9rUkinv41WyjXGkiSOiEIsS3cNSxw4HC5&currency=CAD"></script>
          <script>
            paypal.Buttons({
              createOrder: function(data, actions) {
                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: '<?= $totalPrice ?>'
                    }
                  }]
                });
              },
              onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                  alert('Transaction complete ' + details.payer.name.given_name + '!');
                  fetch('./Controllers/handleSession.php',) /*{
                    method: 'post',
                    headers: {
                      'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                      orderID: data.orderID,
                      details: details,
                      total: '<?= $totalPrice ?>',
                      userID: '<?= $_SESSION['user_id'] ?>'
                    })
                  }).then(response => response.json())
                    .then(data => {
                    if(data.success) {
                        alert('Order Confirmed'); window.location.href = './MainPage.php';
                    } else {
                        alert('Failed to process order.');
                    }
                });*/
              });
            },
              onError: function(err) {
                console.log("Erreur dans le paiement", err);
                alert("Paiement échoué!");
              }
            }).render('#paypal-button-container').then(function(){
              
            })
          </script>
        </ul>

        <form class="card p-2">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </form>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="username" class="form-label">Username</label>
              <div class="input-group has-validation">
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" id="username" placeholder="Username" required>
              <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-body-secondary">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-body-secondary">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" required>
                <option value="">Choose...</option>
                <option>United States</option>
                <option>Canada</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            <div class="col-md-4">
              <label for="state" class="form-label">State</label>
              <select class="form-select" id="state" required>
                <option value="">Choose...</option>
                <option>California</option>
                <option>Montreal</option>
                <option>Toronto</option>
              </select>
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Zip</label>
              <input type="text" class="form-control" id="zip" placeholder="" required>
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address">
            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info">Save this information for next time</label>
          </div>

          <hr class="my-4">

        </form>
      </div>
    </div>
  </main>


</div>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
</html>
