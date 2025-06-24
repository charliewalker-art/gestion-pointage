<?php
session_start();
require ('config.php');



$accueilContent = '
<div class="max-w-4xl mx-auto text-center px-4">
  <div class="bg-white bg-opacity-80 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
    
    <h1 class="text-description">GESTION DU POINTAGE ET CONGÉ DE PERSONNEL</h1>
    <p class="text-lg text-gray-700 mb-8">
      Optimisez la gestion de vos employés avec notre application simple et performante
    </p>
    
    <div class="mx-auto max-w-xs sm:max-w-md animate-fade-in">
      <img src="image/fond.png" alt="Illustration" class="w-full"/>
    </div>
  
  </div>
</div>
';







?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestion du Pointage & Congé</title>
        <script src="./views/css/style.js" ></script>
        <link rel="stylesheet" href="./views/css/index.css">
        <link rel="stylesheet" href="./views/css/conge.css">
        <link rel="stylesheet" href="./views/css/pointage.css">
 
</head>

<body class="antialiased text-gray-800">

  <!-- Incure le menu nav barre -->
   <?php require ('./views/template/menu_nav.php') ?>
  

   <!-- CONTENEUR    -->
  <header class="pt-24 bg-image  min-h-screen flex items-center">
   
  
  <?php
  // Routage simple
  $page = isset($_GET['page']) ? $_GET['page'] : '';

  switch ($page) {
      case 'employe':
          $controller = new EmployeController($pdo);
          break;

      case 'conge':
          $controller = new CongeController($pdo);
          break;

      case 'pointage':
          $controller = new PointageController($pdo);
          break;

      default:
          echo $accueilContent ;
          break;
  }



  ?>


</header>
  
  <script src="./views/js/index.js" ></script>

</body>
</html>
