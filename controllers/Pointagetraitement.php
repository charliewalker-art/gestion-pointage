<?php
session_start();
require ('../config.php');

class PointageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "pointage") {
            // Création du modèle Pointage
            $pointageModel = new Pointage($this->pdo);
            
            // Traitement des employés sélectionnés (si présents)
            if (isset($_POST["selected_ids"])) {
                $ids = json_decode($_POST["selected_ids"], true);
                if (!empty($ids)) {
                    $message = $pointageModel->insertmultiple($ids);
                    $_SESSION['message'] = $message;
                }
            }
            
            // Appel de la fonction insererEmployesNonSelectionnes avec la date d'aujourd'hui
            $today = date('Y-m-d');
            $messageNonSelect = $pointageModel->insererEmployesNonSelectionnes($today);
            $_SESSION['message_non_select'] = $messageNonSelect;
            
            // Redirection vers la page précédente
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}

$controller = new PointageController($pdo);
$controller->handleRequest();
?>
