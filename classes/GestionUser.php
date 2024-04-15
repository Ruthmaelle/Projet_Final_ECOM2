<?php

class GestionUser
{
    private $bdd;

    public function __construct($bd){
        $this->bdd = $bd;
    }

    //methode pour ajouter un nouveau utilisateur
    public function addUser(User $p) {
        $sql = $this->bdd->prepare("INSERT INTO user VALUES (null, ?, ?, ?, ?, ?)");
        $sql->execute(array(
                            $p->getUsername(),
                            $p->getEmail(),
                            $p->getPwd(),
                            $p->getToken(),
                            $p->getRoleID(),
        ));
    }

}

?>