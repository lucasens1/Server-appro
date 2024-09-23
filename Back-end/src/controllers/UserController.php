<?php
class UserController {
    private $userModel;
    // Costrutto richiamo sempre il pdo
    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }
    // Registrazione mi servo della variabile che richiama il modello dell'utente
    public function register($username, $email, $password){
        if($this->userModel->register($username, $email, $password)){
            return ["messaggio" => "Registrazione effettuata con successo", "success" => true];
        } else {
            return ["messaggio" => "Registrazione fallita", "success" => false];
        }
    }

    public function login($email, $password){
        $userLoggato = $this->userModel->login($email, $password);
        if($userLoggato){
            return [
                'messaggio' => 'Login effettuato con successo'. htmlspecialchars($userLoggato['username']).'!',
                "success" => true,
                "user" => $userLoggato
            ];
        } else {
            return ["message" => "Email o password errati.", "success" => false];
        }
    }
}