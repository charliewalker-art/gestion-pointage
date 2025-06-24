<?php
//inclure la classe Pére
require ('Table.php');

//creation de la classe Employe fils de la classe TABLE
class Employe extends Table {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'EMPLOYE', ['numEmp', 'Nom', 'Prenom', 'poste', 'salaire', 'email'], 'numEmp');
    }

    //fonction de generation de ID autoincremENT
    public function genereIDEmployer() {
        $sql = "SELECT numEmp FROM {$this->name_table} ORDER BY numEmp DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $lastId = $stmt->fetchColumn();
        
        if ($lastId) {
            $num = (int)substr($lastId, 1) + 1;
            return 'E' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            return 'E001';
        }
    }

    /**
     * Affiche tous les enregistrements de la table, triés par numEmp en ordre décroissant.
     *
     * @return array Les enregistrements récupérés.
     */
    public function afficheEmployer() {
        $sql = "SELECT * FROM {$this->name_table} ORDER BY numEmp ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime plusieurs enregistrements identifiés par leurs clés primaires.
     *
     * @param array $ids Tableau des valeurs des identifiants.
     * @return string Message de succès.
     */
    public function efface(array $ids) {
        $placeholders = implode(', ', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM {$this->name_table} WHERE {$this->primary_key} IN ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($ids);
        return "Enregistrements supprimés avec succès.";
    }

       // Fonction de recherche d'employés par nom ou prénom
       public function rechercheEmployer($keyword) {
        $sql = "SELECT * FROM {$this->name_table} WHERE Nom LIKE :keyword OR Prenom LIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    }  
    ?>