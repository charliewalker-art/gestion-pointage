<?php
require ('Table.php');


class Pointage extends Table {
    public function __construct(PDO $pdo) {
        parent::__construct($pdo, 'POINTAGE', ['datePointage', 'numEmp', 'pointage'], ['datePointage', 'numEmp']);
    }

  // Fonction pour retourner les données de la table POINTAGE
  public function affichePointage() {
    $sql = "SELECT * FROM {$this->name_table} ORDER BY datePointage ASC, numEmp ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



        // inset un pointage
        public function insertmultiple(array $ids) {
            $pointage = 1;
            $values = [];
            $idsInserted = [];
        
            foreach ($ids as $id) {
                // Vérifier si l'employé a déjà été pointé aujourd'hui
                $checkSql = "SELECT COUNT(*) as total FROM {$this->name_table} WHERE numEmp = :id AND DATE(datePointage) = CURRENT_DATE";
                $stmtCheck = $this->pdo->prepare($checkSql);
                $stmtCheck->execute(['id' => $id]);
                $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                
                if ($result['total'] == 0) {
                    // Pas encore pointé aujourd'hui, on prépare l'insertion
                    $values[] = "(CURRENT_TIMESTAMP, :id_$id, $pointage)";
                    $idsInserted[] = $id;
                }
            }
            
            if (empty($values)) {
                return "Aucun pointage à effectuer. Tous les employés ont déjà été pointés aujourd'hui.";
            }
            
            // Construction de la requête d'insertion multiple
            $valuesString = implode(', ', $values);
            $sql = "INSERT INTO {$this->name_table} (datePointage, numEmp, pointage) VALUES $valuesString";
            $stmt = $this->pdo->prepare($sql);
            
            // Préparation des paramètres pour chaque insertion
            foreach ($idsInserted as $id) {
                $stmt->bindValue(":id_$id", $id);
            }
            
            $stmt->execute();
            
            return "Le pointage a été effectué avec succès pour les IDs : " . implode(', ', $idsInserted);
        }
        








 public function insererEmployesNonSelectionnes($date) {
        // Récupérer les numéros d'employés qui n'ont pas été pointés pour la date donnée
        $sql_select = "SELECT e.numEmp
                       FROM EMPLOYE e
                       WHERE e.numEmp NOT IN (
                           SELECT numEmp FROM {$this->name_table}
                           WHERE DATE(datePointage) = :date
                       )";
        $stmt_select = $this->pdo->prepare($sql_select);
        $stmt_select->bindParam(':date', $date);
        $stmt_select->execute();
        $ids = $stmt_select->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($ids)) {
            return "Aucun employé non sélectionné pour la date $date.";
        }
        
        // Préparer l'insertion avec pointage à 0 pour chaque employé non pointé
        $pointage = 0;
        $values = [];
        foreach ($ids as $id) {
            $values[] = "(CURRENT_TIMESTAMP, '$id', $pointage)";
        }
        $valuesString = implode(', ', $values);
        $sql_insert = "INSERT INTO {$this->name_table} (datePointage, numEmp, pointage) VALUES $valuesString";
        $stmt_insert = $this->pdo->prepare($sql_insert);
        $stmt_insert->execute();
        
        return "Le pointage a été inséré avec succès pour les employés non sélectionnés : " . implode(', ', $ids);
    }
  

    //envois des email au employe absent
    public function listeEmployesAbsentsemail($date) {
        $sql = "SELECT e.Nom, e.Prenom, e.email
                FROM EMPLOYE e
                JOIN POINTAGE p ON e.numEmp = p.numEmp
                WHERE DATE(p.datePointage) = :date AND p.pointage = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
// Fonction pour lister les employés présents
public function listeEmployesPresents($date) {
    $sql = "SELECT e.Nom, e.Prenom
            FROM EMPLOYE e
            JOIN POINTAGE p ON e.numEmp = p.numEmp
            WHERE date(p.datePointage) = :date AND p.pointage = TRUE";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour modifier un pointage
 public function modifierPointage($datePointage, $numEmp, $pointage) {
    $sql = "UPDATE {$this->name_table} SET pointage = :pointage WHERE datePointage = :datePointage AND numEmp = :numEmp";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
    'datePointage' => $datePointage, 
    'numEmp'     => $numEmp, 
    'pointage'   => $pointage
    ]);
    return "Le pointage pour l'employé $numEmp le $datePointage a été modifié avec succès.";
    }

// Fonction pour supprimer un pointage
    public function supprimerPointage($datePointage, $numEmp) {
    $sql = "DELETE FROM {$this->name_table} WHERE datePointage = :datePointage AND numEmp = :numEmp";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
    'datePointage' => $datePointage, 
    'numEmp'     => $numEmp
    ]);
    return "Le pointage pour l'employé $numEmp le $datePointage a été supprimé avec succès.";
    }

    //fonction 
public function listeEmployesAbsents($date) {
    $sql = "SELECT * FROM {$this->name_table} WHERE pointage = FALSE AND DATE(datePointage) = :date";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}