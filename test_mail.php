<?php
// Inclure le fichier de configuration (connexion à la base de données et définition de la classe Pointage)
require_once 'config.php';

// Inclure le fichier contenant la fonction sendEmail
require 'traitement_mail.php';

// Créer une instance de la classe Pointage avec la connexion PDO
$pointage = new Pointage($pdo);

// Définir la date souhaitée (ici fixée au 19 mars 2025)
$date = date('Y-m-d');

// Récupérer la liste des employés absents avec leurs emails pour la date donnée
$employesAbsents = $pointage->listeEmployesAbsentsemail($date);

// Vérifier si des employés absents ont été trouvés
if (!empty($employesAbsents)) {

   
    foreach ($employesAbsents as $employe) {
        // echo "Nom : " . htmlspecialchars($employe['Nom']) ."  "     ;
        // echo "Prénom : " . htmlspecialchars($employe['Prenom']) . " "   ;
        echo "Email : " . htmlspecialchars($employe['email'])    ;

        // Appeler la fonction sendEmail avec les paramètres email et prénom de l'employé
        // Le troisième paramètre est ici fixé à 'Votre responsable'
        sendEmail($employe['email'], $employe['Prenom'], 'Votre responsable');
    }
} else {
    echo "<p>Aucun employé absent trouvé pour la date du $date.</p>";
}




?>