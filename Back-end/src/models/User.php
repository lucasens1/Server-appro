<?php
class User{
    private $pdo;

    // Passo l'oggetto pdo per la connessione al db
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Funzione registrazione in entrata 3 parametri, hashing base
    public function register($username, $email, $password){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $prep = $this->pdo->prepare($query);

        try{
            $prep->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            // Se va a buon fine, allora restituisco True, che viene preso in UserController
            return true;
        }catch (PDOException $errore){
            return false;
        }
    }

    public function login($email, $password){
        $query = "SELECT * FROM users WHERE email = :email";
        $prep = $this->pdo->prepare($query);
        // Eseguo assegnando al binding il valore in entrata
        $prep->execute([':email' => $email]);
        // Prendo dal DB l'utente associato
        $user = $prep->fetch(PDO::FETCH_ASSOC);
        // Ora effettuo il controllo sulle password
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }

    public function getUserById($id){
        $query = "SELECT * FROM users WHERE id = :id";
        $prep = $this->pdo->prepare($query);
        $prep->execute(['id' => $id]);
        $user = $prep->fetch(PDO::FETCH_ASSOC);

        if(!$user){
            return null;
        }

        return $user;
    }
    
    public function getUserByEmail($email) {
        // Prepara la query SQL per cercare l'utente per email
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Recupera i dati dell'utente
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Restituisci i dati dell'utente o null se non trovato
        return $user ? $user : null;
    }
}

?>