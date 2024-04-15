<?php

class User {
    private $id;
    private $user_name;
    private $email;
    private $pwd;
    private $token;
    private $role_id;

    //definir les constructeurs
    public function __construct($i, $us, $em, $pw, $tk, $ri)
    {
        $this->id = $i;
        $this->user_name = $us;
        $this->email = $em;
        $this->pwd=$pw;
        $this->role_id=$ri;
    }

      //Definir les getters et les setters
    public function setID($id){
        $this->id = $id;
    }
    public function setUserName($user_name){
        $this->user_name = $user_name;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setPwd($pwd){
        $this->pwd = $pwd;
    }
    public function setToken($token){
        $this->token = $token;
    }
    public function roleID($role_id){
        $this->role_id = $role_id;
    }


    public function getID(){
        return $this->id;
    }
    public function getUsername(){
        return $this->user_name;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPwd(){
        return $this->pwd;
    }
    public function getToken(){
        return $this->token;
    }
    public function getRoleID(){
        return $this->role_id;
    }

}

?>