<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Sign_Up</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

    <!-- Bootstrap core CSS -->
<link href="/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      body, html {
        height: 100%;
        background-color: white; /* Couleur de fond gris pour le conteneur */
      }

      .container {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .form-signin {
        background-color: #f0f0f0;
        
      }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/CSS/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
<div class="container max-width-md">
  <div class="col">
    <div class="col-md-9">
      <form class="form-signin" action="">
        <img class="mb-4" src="../images/newLogo.png" alt="" width="112" height="112">
        <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
        <label for="inputUser" class="sr-only">UserName</label>
        <input type="text" id="inputUser" class="form-control" placeholder="UserName" required autofocus>
        <br>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>


<?php
require("../classes/User.php");
require("../classes/GestionUser.php");
require("../functions/functions.php");
include 'functions.php';


// Vérifier si le formulaire a été soumis et récupérer les données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['inputUser'];
    $email = $_POST['inputEmail'];
    $password = SaltedCode::addSalt($_POST['inputPassword']);
    $token = hash('sha256', random_bytes(32));

    $role_id = 3; //l'id par defaut pour les clients
    if($username === 'superAdmin' && $email === 'superAdmin@admin.com' && $password==='987654321') {
      $role_id=1;
    }



    $new_User = new User(null, $username, $email, $password, $token, null);

    // Valider les données (vous pouvez ajouter des validations supplémentaires ici)
    if (empty($username) || empty($email) || empty($password)) {
        echo "Tous les champs doivent être remplis.";
    } else {
        // Connexion à la base de données
        $db_username = "root";
        $db_password = "";
        $dbname = "ecom2_project";


        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $gestionUser = new GestionUser($conn);
            //ajout d'un nouveau user
            $gestionUser->addUser($new_User);
            echo "<script>alert('Utilisateur enregistré avec succès.');</script>";
            header('Location: ');
            exit();
        } catch(PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }

        // Fermer la connexion
        $conn = null;
    }
}





?>