<?php

class ActivityController{
    private $activityModel;

    public function __construct($pdo) {
        $this->activityModel = new Activity($pdo);
    }

    public function create($title, $description, $ownerId, $file) {
        // Valido dati
        if (empty($title) || empty($description)) {
            return [
                'messaggio' => 'Il titolo e la descrizione non possono essere vuoti',
                'success' => false
            ];
        }

        try {
            if ($this->activityModel->create($title, $description, $ownerId, $file)) {
                return [
                    'messaggio' => 'Attività creata con successo',
                    'success' => true
                ];
            } else {
                return [
                    'messaggio' => 'Controlla i dati inseriti',
                    'success' => false
                ];
            }
        } catch (Exception $e) {
            return [
                'messaggio' => 'Errore: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }
    public function getAll() {
        try {
            $activities = $this->activityModel->getAllActivities();
            return [
                'activities' => $activities,
                'success' => true
            ];
        } catch (Exception $e) {
            return [
                'messaggio' => 'Errore: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }

    public function getById($id) {
        try {
            $activity = $this->activityModel->getActivityById($id);
            if ($activity) {
                return [
                    'activity' => $activity,
                    'success' => true
                ];
            } else {
                return [
                    'messaggio' => 'Attività non trovata',
                    'success' => false
                ];
            }
        } catch (Exception $e) {
            return [
                'messaggio' => 'Errore: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }

    public function update($id, $title, $description, $ownerId, $file = null, $removeImage = false) {
        if (empty($title) || empty($description)) {
            return [
                'messaggio' => 'Il titolo e la descrizione non possono essere vuoti',
                'success' => false
            ];
        }

        try {
            if ($this->activityModel->update($id, $title, $description, $file, $removeImage)) {
                return [
                    'messaggio' => 'Attività aggiornata con successo',
                    'success' => true
                ];
            } else {
                return [
                    'messaggio' => 'Controlla i dati inseriti',
                    'success' => false
                ];
            }
        } catch (Exception $e) {
            return [
                'messaggio' => 'Errore: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }

    public function delete($id) {
        try {
            if ($this->activityModel->delete($id)) {
                return [
                    'messaggio' => 'Attività eliminata con successo',
                    'success' => true
                ];
            } else {
                return [
                    'messaggio' => 'Controlla i dati inseriti',
                    'success' => false
                ];
            }
        } catch (Exception $e) {
            return [
                'messaggio' => 'Errore: ' . $e->getMessage(),
                'success' => false
            ];
        }
    }
}