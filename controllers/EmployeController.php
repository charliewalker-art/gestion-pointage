<?php
//require_once __DIR__ . '/../models/Employe.php';

class EmployeController {
    private $employe;

    public function __construct($pdo) {
        $this->employe = new Employe($pdo);
        // Logique de traitement des requêtes HTTP
        $successMessage = '';
        $errorMessage = '';

        if (isset($_GET['success'])) {
            $successMessage = $_GET['success'];
        }

        if (isset($_GET['error'])) {
            $errorMessage = $_GET['error'];
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['create'])) {
                    // Insérer un nouvel employé
                    $newEmploye = [
                        'numEmp' => $this->employe->genereIDEmployer(),
                        'Nom' => $_POST['Nom'],
                        'Prenom' => $_POST['Prenom'],
                        'poste' => $_POST['poste'],
                        'salaire' => $_POST['salaire'],
                        'email' => $_POST['email']
                    ];
                    $successMessage = $this->employe->insert($newEmploye);
                } elseif (isset($_POST['update'])) {
                    // Modifier un employé
                    $editEmploye = [
                        'Nom' => $_POST['Nom'],
                        'Prenom' => $_POST['Prenom'],
                        'poste' => $_POST['poste'],
                        'salaire' => $_POST['salaire'],
                        'email' => $_POST['email']
                    ];
                    $successMessage = $this->employe->modifi($_POST['numEmp'], $editEmploye);
                } elseif (isset($_POST['delete'])) {
                    // Supprimer un employé
                    $successMessage = $this->employe->supprimer($_POST['numEmp']);
                } elseif (isset($_POST['search'])) {
                    // Rechercher des employés
                    $employes = $this->employe->rechercheEmployer($_POST['keyword']);
                }
            }
            // Récupérer les employés
            if (!isset($employes)) {
                $employes = $this->employe->afficheEmployer();
            }
        } catch (Exception $e) {
            // Gérer les exceptions
            $errorMessage = 'Erreur : ' . $e->getMessage();
        }

        // Inclure la vue
        require_once __DIR__ . '/../views/employeView.php';
    }

    // Créer un nouvel employé
    public function create($data) {
        $data['numEmp'] = $this->employe->genereIDEmployer();
        return $this->employe->insert($data);
    }

    // Lire tous les employés
    public function readAll() {
        return $this->employe->afficheEmployer();
    }

    // Mettre à jour un employé
    public function update($id, $data) {
        return $this->employe->modifi($id, $data);
    }

    // Supprimer un employé
    public function delete($id) {
        return $this->employe->supprimer($id);
    }

    // Rechercher des employés par nom ou prénom
    public function search($keyword) {
        return $this->employe->rechercheEmployer($keyword);
    }
}
?>
