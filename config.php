<?php
//faire les autolodeur qui appele les classe automatiquement les classe
spl_autoload_register(function ($className) {
    // Définir les répertoires où chercher vos classes.
    $directories = [
        __DIR__ . '/models/',
        __DIR__ . '/controllers/',
        // Ajoutez d'autres dossiers si nécessaire
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
//creation de objet de connexion a la  base de donne
$db = new Database('localhost', 'gestion_pointage', 'root', '');
$pdo = $db->connexion();








?>