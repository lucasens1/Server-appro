<?php
require 'config/config.php';
require 'src/services/Database.php';
require 'src/models/User.php';

// Prendo le informazioni di connessione al DB
$config = include('config/config.php');
// Collego al database con l'istanza
$database = new Database($config);
// Stanzio il pdo
$pdo = $database->getConnection();


