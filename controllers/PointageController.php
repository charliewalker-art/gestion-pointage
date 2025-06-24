<?php
class PointageController {
    private $pointage;

    public function __construct($pdo) {
        // Instanciation de l'objet Pointage
        $this->pointage = new Pointage($pdo);
        $successMessage = '';
        $errorMessage = '';
        $absentEmployees = [];

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['action'])) {
                    $action = $_POST['action'];
                    $datePointage = $_POST['datePointage'] ?? null;
                    $numEmp = $_POST['numEmp'] ?? null;

                    if ($action === 'edit' && $datePointage && $numEmp) {
                        // Modifier un pointage
                        $pointageValue = $_POST['pointage'];
                        $result = $this->pointage->modifierPointage($datePointage, $numEmp, $pointageValue);
                        if ($result !== false) {
                            $successMessage = $result;
                        } else {
                            $errorMessage = 'Erreur lors de la modification du pointage.';
                        }
                    } elseif ($action === 'delete' && $datePointage && $numEmp) {
                        // Supprimer un pointage
                        $result = $this->pointage->supprimerPointage($datePointage, $numEmp);
                        if ($result !== false) {
                            $successMessage = $result;
                        } else {
                            $errorMessage = 'Erreur lors de la suppression du pointage.';
                        }
                    } elseif ($action === 'dateabsent' && $datePointage) {
                        // Liste des employés absents
                        $result = $this->pointage->listeEmployesAbsents($datePointage);
                        if ($result !== false) {
                            $absentEmployees = $result;
                        } else {
                            $errorMessage = 'Erreur lors de la récupération des employés absents.';
                        }
                    }
                }
            }

            // Récupération de l'ensemble des pointages
            $pointages = $this->pointage->affiche();

        } catch (Exception $e) {
            $errorMessage = 'Erreur : ' . $e->getMessage();
        }

        // Inclusion de la vue (les variables $successMessage, $errorMessage et $absentEmployees seront accessibles dans la vue)
        require_once __DIR__ . '/../views/pointageView.php';
    }

    // Méthode pour récupérer tous les pointages
    public function readAll() {
        return $this->pointage->affiche();
    }

    // Méthode pour mettre à jour un pointage
    public function update($datePointage, $numEmp, $data) {
        return $this->pointage->modifierPointage($datePointage, $numEmp, $data);
    }

    // Méthode pour supprimer un pointage
    public function delete($datePointage, $numEmp) {
        return $this->pointage->supprimerPointage($datePointage, $numEmp);
    }
}
?>
