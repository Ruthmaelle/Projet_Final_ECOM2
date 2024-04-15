<?php
session_start();

require_once("./DB/connexion.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
</head>
<body>

<?php
    $reponse = $dbco->prepare('SELECT * FROM product');
    $reponse->execute();
    while($row = $reponse->fetch(PDO::FETCH_ASSOC)) {

?> 
    <form action="" class="">
        <img src="./images/<?php echo $row['img_url'];?>" >
        <h4><?php echo $row['name'];?></h4>
        <p>Description: <?php echo $row['description'];?></p>
        <h4><?php echo $row['price'];?>$</h4>
        <a href="# id=<?php echo $row['id'];?>" class="">Ajouter au Panier</a>
    </form>
    <?php } ?>

</body>
</html>