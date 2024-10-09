<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Modifica per consentire solo il frontend React
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Aggiungi tutti i metodi che intendi utilizzare
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json'); // Imposta l'header per JSON

// Gestisci la richiesta preflight (OPTIONS) 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Config
$config = require '../config/config.php';
// Modelli
require_once __DIR__ . '/../src/models/User.php';
require_once __DIR__ . '/../src/models/Activity.php';

$dsn = 'mysql:host=' . $config['db_host'] . ';port=' . $config['db_port'] . ';dbname=' . $config['db_name'];
$dbuser = $config['db_user'];
$dbpassword = $config['db_pass'];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Gestione delle rotte RESTful
switch ($requestUri) {
        // Rotte per gli utenti
    case '/users':
        if ($requestMethod === 'POST') {
            // Registrazione dell'utente
            $user = new User($pdo);

            // Leggi il corpo della richiesta e decodifica i dati JSON
            $data = json_decode(file_get_contents('php://input'), true);

            // Assicurati che i dati siano stati decodificati correttamente
            if (isset($data['username'], $data['email'], $data['password'])) {
                $username = $data['username'];
                $email = $data['email'];
                $password = $data['password'];

                // Registrazione dell'utente
                if ($user->register($username, $email, $password)) {
                    echo json_encode(["message" => "Utente registrato con successo!"]);
                } else {
                    echo json_encode(["error" => "Registrazione fallita."]);
                }
            } else {
                // Se le chiavi non sono state trovate, restituisci un errore
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Dati mancanti."]);
            }
        } else {
            // Gestisci metodi non supportati
            http_response_code(405); // Method Not Allowed
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;


        // Rotte per Utente specifico
    case (preg_match('/^\/users\/(\d+)$/', $requestUri, $matches) ? true : false):
        $userId = $matches[1]; // ID dell'utente
        if ($requestMethod === 'GET') {
            $user = new User($pdo);
            $userData = $user->getUserById($userId);
            if ($userData) {
                echo json_encode($userData);
            } else {
                echo json_encode(["error" => "Utente non trovato."]);
            }
        } else {
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;

    case '/login':
        if ($requestMethod === 'POST') {
            $user = new User($pdo);

            // Leggi il corpo della richiesta e decodifica i dati JSON
            $data = json_decode(file_get_contents('php://input'), true);

            // Verifica che email e password siano presenti nei dati
            if (isset($data['email'], $data['password'])) {
                $email = $data['email'];
                $password = $data['password'];

                // Prova a effettuare il login
                if ($user->login($email, $password)) {
                    // Prendo i dati utente!
                    $userData = $user->getUserByEmail($email);
                    echo json_encode(["message" => "Login effettuato con successo!", "user" => $userData]);
                } else {
                    http_response_code(401); // Unauthorized
                    echo json_encode(["error" => "Credenziali non valide."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Dati mancanti."]);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;

    case '/activities':
        if ($requestMethod === 'GET') {
            // Recupera tutte le attività
            $activity = new Activity($pdo);
            $activities = $activity->getAllActivities();
            echo json_encode($activities); // Rispondi con JSON
        } elseif ($requestMethod === 'POST') {
            // Crea una nuova attività
            $activity = new Activity($pdo);
            $title = $_POST['title'];
            $description = $_POST['description'];
            $ownerId = $_POST['owner_id']; // Assicurati di avere l'ID dell'utente loggato
            $file = $_FILES['image'] ?? null; // Aggiungi ?? null per gestire i file opzionali
            $activity->create($title, $description, $ownerId, $file);
            echo json_encode(["message" => "Attività creata con successo!"]);
        } else {
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;

        // Rotte per attività specifiche
    case (preg_match('/^\/activities\/(\d+)$/', $requestUri, $matches) ? $matches[0] : false):
        $activityId = $matches[1]; // ID dell'attività
        if ($requestMethod === 'GET') {
            // Recupera un'attività specifica
            $activity = new Activity($pdo);
            $activityData = $activity->getActivityById($activityId);
            if ($activityData) {
                echo json_encode($activityData); // Rispondi con JSON
            } else {
                echo json_encode(["error" => "Attività non trovata."]);
            }
        } elseif ($requestMethod === 'PUT') {
            // Aggiorna un'attività
            parse_str(file_get_contents("php://input"), $_PUT); // Recupera i dati della richiesta PUT
            $activity = new Activity($pdo);
            $title = $_PUT['title'] ?? null;
            $description = $_PUT['description'] ?? null;
            $file = $_FILES['image'] ?? null; // Se ci sono file da caricare
            $activity->update($activityId, $title, $description, $file);
            echo json_encode(["message" => "Attività aggiornata con successo!"]);
        } elseif ($requestMethod === 'DELETE') {
            // Elimina un'attività
            $activity = new Activity($pdo);
            $activity->delete($activityId);
            echo json_encode(["message" => "Attività eliminata con successo!"]);
        } else {
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;

    case preg_match('/^\/activities\/user\/(\d+)$/', $requestUri, $matches) ? $matches[0] : false:
        $userId = $matches[1]; // Cattura l'ID dell'utente
        if ($requestMethod === 'GET') {
            $activity = new Activity($pdo);
            $activities = $activity->getActivitiesByUserId($userId);

            if (empty($activities)) {
                echo json_encode(["error" => "Nessuna attività trovata per l'ID utente: $userId."]);
            } else {
                echo json_encode($activities);
            }
        } else {
            echo json_encode(["error" => "Metodo non supportato."]);
        }
        break;


    default:
        echo json_encode(["error" => "404 Not Found", "Request" => $requestMethod]); // Rotta non trovata
        break;
}
