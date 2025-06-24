<?php
require_once __DIR__ . '/../models/Conge.php';

class CongeController {
    private $conge;

    public function __construct($pdo) {
        $this->conge = new Conge($pdo);
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'ajouter':
                        $newConge = [
                            'numEmp'      => $_POST['numEmp'],
                            'motif'       => $_POST['motif'],
                            'nbrjr'       => $_POST['nbrjr'],
                            'dateDemande' => $_POST['dateDemande'],
                            'dateRetour'  => $_POST['dateRetour'],
                            'numConge'    => $this->conge->generateId(),
                        ];
                        $successMessage = $this->conge->create($newConge);
                        break;

                    case 'modifier':
                        $editConge = [
                            'numEmp'      => $_POST['numEmp'],
                            'motif'       => $_POST['motif'],
                            'nbrjr'       => $_POST['nbrjr'],
                            'dateDemande' => $_POST['dateDemande'],
                            'dateRetour'  => $_POST['dateRetour']
                        ];
                        $successMessage = $this->conge->modifie($_POST['numConge'], $editConge);
                        break;

                    
                    
                    
                    
                    
                    
                    
                    
                        case 'supprimer':
                        $successMessage = $this->conge->supprimer($_POST['numConge']);
                        break;

                    default:
                        throw new Exception('Action inconnue : ' . $_POST['action']);
                }
                
            }
        } 
        
        
        
        catch (Exception $e) {
            // Gérer les exceptions
            $errorMessage = 'Erreur : ' . $e->getMessage();
        }

        // Récupérer les congés
        $conges = $this->conge->afficheconge();

        // Inclure la vue
        require_once __DIR__ . '/../views/congeView.php';
    }

    // Créer un nouveau congé
    public function create($data) {
        $data['numConge'] = $this->conge->generateId();
        return $this->conge->create($data);
    }

    // Lire tous les congés
    public function readAll() {
        return $this->conge->afficheconge();
    }

    // Mettre à jour un congé
    public function update($id, $data) {
        return $this->conge->modifie($id, $data);
    }

            // Supprimer un congé
    public function delete($id) {
        return $this->conge->supprimer($id);
    }
}
?>
