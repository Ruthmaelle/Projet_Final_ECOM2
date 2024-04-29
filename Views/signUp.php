<?php
session_start();

require_once("../Controllers/flash_messages.php");

// Fonction pour générer un jeton CSRF
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fonction pour generer un nouveau jeton CSRF
function regenerateCsrfToken() {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  return $_SESSION['csrf_token'];
}
?>

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
      <form class="form-signin" method="post">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <img class="mb-4" src="../images/newLogo.png" alt="" width="112" height="112">
        <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
        
        <label for="inputUser" class="sr-only">UserName</label>
        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="UserName" required autofocus>
        <?php // Afficher les messages d'erreur et réinitialiser la session signup_errors
        flash('username_error');
            ?>
            <br>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email Address" required autofocus>
        <?php // Afficher les messages d'erreur et réinitialiser la session signup_errors
            flash('email_error');
            ?>
            <br>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <?php // Afficher les messages d'erreur et réinitialiser la session signup_errors
            flash('password_error');
            ?>
            <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit" value="Envoyer" name="envoyer">Sign up</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<?php
//j'ai pas encore fait mes validations
require("../classes/User.php");
require("../classes/GestionUser.php");
require("../Controllers/functions.php");
require_once("../classes/ValidateUser.php");
require_once("../DB/connexion.php");
$gestionUser = new GestionUser($dbco);



// Vérifier si le formulaire a été soumis et récupérer les données du formulaire
extract($_POST);

// Vérifier si la demande est un POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {
  if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
  } else {
      die("CSRF token mismatch.");
  }
}

if (isset($envoyer)) {
      $_SESSION["form-signin"] = $_POST;

      //reset les messages d'erreurs
      unset($_SESSION['signup_errors']);

    $username = $a_POST['inputUser'];
    $email = $_POST['inputEmail'];
    $password = ($_POST['inputPassword']);
    $token = hash('sha256', random_bytes(32));

    $role_id = 3; //l'id par defaut pour les clients
    if($username === 'SuperAdmin' && $email === 'superAdmin@admin.teccart' && $password==='987654321') {
      $role_id=1;
    }


    // Validation des données
    $validator = new Validations();
    // Validation de l'email
    $emailValidation = $validator->validateEmail($email);
    // Validation du mot de passe
    $passwordValidation = $validator->validatePassword($password);
    // Validation du nom d'utilisateur
    $usernameValidation = $validator->validateUsername($username);

    // Check validations
    if (!$usernameValidation->isValid) {
      flash('username_error', $usernameValidation->message, 'alert alert-danger');
      exit();
  }
  if (!$emailValidation->isValid) {
      flash('email_error', $emailValidation->message, 'alert alert-danger');
      exit();
  }
  if (!$passwordValidation->isValid) {
      flash('password_error', $passwordValidation->message, 'alert alert-danger');
      exit();
  }

    //verification
    if($usernameValidation->isValid && $emailValidation->isValid && $passwordValidation->isValid) {
        if(!$gestionUser->usernameExists($username)) {
          //les info sont deja utiliser
          $_SESSION['username_error'] = [
            'userN' => 'Ce username existe deja',
            'email' => '',
            'pwd' => ''
          ];
        }elseif (!$gestionUser-> emailExist($email)) {
          $_SESSION['password_error'] = [
            'userN' => '',
            'email' => 'Email deja existant',
            'pwd' => ''
          ];
        }
      $newPass = SaltedCode::addSalt($password);
      $new_User = new User(null, $username, $email, $newPass, $token, $role_id);
      // Ajouter l'utilisateur à la base de données
      $gestionUser = new GestionUser($dbco);
      $gestionUser->addUser($new_User);
      $_SESSION['signed_user'] = [
        'username' => $username,
        'password' => $password
      ];
      regenerateCsrfToken();
        header('Location: ../MainPage.php');
        exit();
  } else {
      // Gérer les erreurs de validation
      /*$_SESSION['signup_errors'] = [
        'userN' => $usernameValidation->message,
        'email' => $emailValidation->message,
        'pwd' => $passwordValidation->message
      ];*/
  }
}

?>
  </body>
</html>

<?php
   /* if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Tous les champs doivent être remplis.');</script>";
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
            $url = "../index.php";            ;
            header('Location: ' . $url);
            exit();
        } catch(PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
        
    }
}

*/

/*$validator = new Validations();

    // Validation de l'email
    $emailValidation = $validator->validateEmail($_POST['email']);

    // Validation du mot de passe
    $passwordValidation = $validator->validatePassword($_POST['pwd']);

    // Validation du nom d'utilisateur
    $usernameValidation = $validator->validateUsername($_POST['user_name']);

    // Vérifiez si toutes les validations sont valides
    if($emailValidation->isValid() && $passwordValidation->isValid() && $usernameValidation->isValid()) {
        // Les données sont valides, continuez avec le traitement
        // Ajoutez votre logique ici
    } else {
        // Il y a des erreurs de validation, traitez-les en conséquence
        // Vous pouvez utiliser $emailValidation->getMessage(), $passwordValidation->getMessage(), $usernameValidation->getMessage() pour afficher des messages d'erreur
    }
*/
?>