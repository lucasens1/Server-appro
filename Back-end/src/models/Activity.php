<?php
class Activity
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function uploadImmagine($file)
    {
        // Documentazione
        // UPLOAD_ERR_OK = Valore: 0; Non vi sono errori, l'upload è stato eseguito con successo.
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $formatoFile = ['image/jpeg', 'image/webp', 'image/png'];
        if (!in_array($file['type'], $formatoFile)) {
            return null;
        }
        // Cartella di upload
        $uploadsDirectory = __DIR__ . '/../../public/uploads/';
        // Nome del file, unico
        $fileName = uniqid() . '-' . basename($file['name']);
        $filePath = $uploadsDirectory . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $filePath;
        }

        return null;
    }

    public function create($title, $description, $ownerId, $file)
    {
        // Subito richiamo la funzione per ottenere il path dell'immagine caricata dall'utente che sarà salvata nella col nel DB
        $imagePath = $this->uploadImmagine($file);

        $query = "INSERT INTO activities (title, description, owner_id, image_path) VALUES (:title, :description, :owner_id, :image_path)";
        $prep = $this->pdo->prepare($query);
        return $prep->execute([
            ':title' => $title,
            ':description' => $description,
            ':owner_id' => $ownerId,
            ':image_path' => $imagePath
        ]);
    }

    public function getAllActivities()
    {
        $query = "SELECT activities.*, users.email FROM activities 
                JOIN users ON activities.owner_id = users.id";
        $prep = $this->pdo->prepare($query);
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivityById($id)
    {
        $query = "SELECT * FROM activities WHERE id = :id";
        $prep = $this->pdo->prepare($query);
        $prep->execute(['id' => $id]);
        return $prep->fetch(PDO::FETCH_ASSOC);
    }
    // Gestisco l'aggiornamento, con una nota particolare per quanto riguarda l'eventuale rimozione, ossia se passo Removeimage allora quest'ultimo significa che elimino l'immagine selezionata.
    // Criticità da verificare : Eliminazione multipla?
    public function update($id, $title, $description, $file = null, $removeImage = false)
    {
        // Fetcho l'attività da modificare
        $activity = $this->getActivityById($id);
        $imagePath = $activity['image_path'] ?? null;

        // Se l'utente ha deciso di rimuovere l'immagine
        if ($removeImage && $imagePath) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $imagePath = null;
        }
        if ($file) {
            $imagePath = $this->uploadImmagine($file);
        }

        $query = "UPDATE activities SET title = :title, description = :description";

        if ($imagePath) {
            $query .= ", image_path = :image_path";
        }

        $query .= " WHERE id = :id";

        $prep = $this->pdo->prepare($query);
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':description' => $description,
        ];

        // Aggiungo eventualmente il path
        if ($imagePath) {
            $params[':image_path'] = $imagePath;
        }
        return $prep->execute($params);
    }

    public function delete($id)
    {
        $query = "DELETE FROM activities WHERE id = :id";
        $prep = $this->pdo->prepare($query);
        return $prep->execute([':id' => $id]);
    }

    public function getActivitiesByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM activities WHERE owner_id = :ownerId");
        $stmt->bindParam(':ownerId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
