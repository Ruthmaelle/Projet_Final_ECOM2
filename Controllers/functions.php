<?php

class SaltedCode {
    public static function addSalt($password){

        $salt = random_bytes(16);
        $hashPass = password_hash($password, PASSWORD_BCRYPT, ['salt' => $salt]);
    
        return $hashPass;
    }
    
}

?>