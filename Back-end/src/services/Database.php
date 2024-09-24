<?php
class Database {
    private $pdo;
    // Costruttore che usa la configurazione da config.php
    public function __construct($config) 
    {
        // DSN (Data Source Name)
        $dsn = 'mysql:host=' . $config['db_host'] . ';port=' . $config['db_port'] . ';dbname=' . $config['db_name'];
        try{
            // PDO per connettersi al DB -> PHP Data Objects, interfaccia per accedere ai DB
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
            // Imposta l'attributo ERRMODE per lanciare eccezioni in caso di errore
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Errore di connessione: ' . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}