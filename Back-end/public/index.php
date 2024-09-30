<?php
// Includi la configurazione del database
$config = require_once __DIR__ . '/../config/config.php';

// Includi i file necessari
require_once __DIR__ . '/../src/services/Database.php';
require_once __DIR__ . '/../src/models/Activity.php'; // Percorso corretto
require_once __DIR__ . '/../src/models/User.php'; // Percorso corretto
require_once 'router.php'; 

// Stanzio il PDO qui
$database = new Database($config);
$pdo = $database->getConnection();