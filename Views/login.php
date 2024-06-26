
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Sign_in</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

    

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

  <?php
session_start();
require_once("../Controllers/flash_messages.php");
require_once("../classes/GestionUser.php");
require_once("../DB/connexion.php");

//generer le token csrf
if(!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$gestionUser = new GestionUser($dbco);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $username = $_POST['inputUser'];
    $inputPassword = $_POST['inputPassword'];
    //$passwordHash = SaltedCode::addSalt($inputPassword);

    $user = $gestionUser->getUserByUsername($username);

    if($user) {
      //user est correct 
      $_SESSION['user_id'] = $user['id'];
      //if (password_verify($inputPassword, $user['pass'])) {
        $_SESSION['user_name'] = $user['user_name'];
        if($username === 'SuperAdmin') {
          $_SESSION['user_name'] = 'SuperAdmin';
          header('Location: InterfaceAdmin.php'); //poko f sa
          exit();
      }else {
        header('Location: ../MainPage.php');
      }
      exit();
    /* }else{
      echo"<script>alert('Invalid Password!'); window.location.href = 'login.php';</script>";
    }*/
  }else{
    echo"<script>alert('User inexistant!'); window.location.href = '../index.php';</script>";
  }
  }else{
    echo"<script>alert('Invalid CSRF Token!'); window.location.href = 'login.php';</script>";
  }
  // Regenerate CSRF token after processing the form
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<div class="container max-width-md">
  <div class="col-md">
    <div class="col-md-12">
    <form class="form-signin" method="post" action="">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <img class="mb-4" src="../images/newLogo.png" alt="" width="112" height="112">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputUser" class="sr-only">UserName</label>
        <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="UserName" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block"  type="submit" value="send" name="send">Sign in</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

