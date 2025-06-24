<?php
abstract class Table {
    // Paramètres de la classe
    protected $pdo;
    protected $name_table;
    protected $columns;
    protected $primary_key;

    public function __construct(PDO $pdo, $name_table, $columns, $primary_key) {
        $this->pdo = $pdo;
        $this->name_table = $name_table;
        $this->columns = $columns;
        $this->primary_key = $primary_key;
    }
    
    /**
     * Affiche tous les enregistrements de la table.
     *
     * @return array Les enregistrements récupérés.
     */
    public function affiche() {
        $sql = "SELECT * FROM {$this->name_table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Insère un enregistrement dans la table.
     *
     * @param array $data Tableau associatif colonne => valeur.
     * @return string Message de succès.
     */
    public function insert(array $data) {
        // On filtre les données pour ne prendre en compte que les colonnes autorisées.
        $data = array_intersect_key($data, array_flip($this->columns));
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(function($col) {
            return ":" . $col;
        }, array_keys($data)));
        
        $sql = "INSERT INTO {$this->name_table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return "Enregistrement ajouté avec succès.";
    }
    
    /**
     * Modifie un enregistrement identifié par sa clé primaire.
     *
     * @param mixed $id   Valeur de l'identifiant.
     * @param array $data Tableau associatif des colonnes à modifier.
     * @return string Message de succès.
     */
    public function modifi($id, array $data) {
        // Filtrage des données selon les colonnes autorisées.
        $data = array_intersect_key($data, array_flip($this->columns));
        $setParts = [];
        foreach ($data as $col => $value) {
            $setParts[] = "{$col} = :{$col}";
        }
        $setClause = implode(", ", $setParts);
        $sql = "UPDATE {$this->name_table} SET {$setClause} WHERE {$this->primary_key} = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;
        $stmt->execute($data);
        return "Enregistrement avec l'ID {$id} modifié avec succès.";
    }
    
    /**
     * Supprime un enregistrement identifié par sa clé primaire.
     *
     * @param mixed $id Valeur de l'identifiant.
     * @return string Message de succès.
     */
    public function supprimer($id) {
        $sql = "DELETE FROM {$this->name_table} WHERE {$this->primary_key} = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return "Enregistrement avec l'ID {$id} supprimé avec succès.";
    }
}
?>