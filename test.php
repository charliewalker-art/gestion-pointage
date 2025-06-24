<?php
// index.php
require 'config.php';
$conge = new Conge($pdo);
$liste = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dateDebut'], $_POST['dateFin'])) {
    $dateDebut = $_POST['dateDebut'];
    $dateFin   = $_POST['dateFin'];
    $liste = $conge->employesEnCongeEntreDates($dateDebut, $dateFin);
    $showModal = true;
} else {
    $showModal = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Employés en congé</title>
  <script src="./views/css/style.js" ></script>
</head>
<body class="bg-gray-100 p-6">


    <h1 class="text-2xl font-bold mb-4">Filtrer les congés</h1>
    <form method="POST" class="space-y-4">
      <div>
        <label for="dateDebut" class="block text-sm font-medium text-gray-700">Date de début</label>
        <input type="date" id="dateDebut" name="dateDebut"
               class="mt-1 block w-2xl rounded-md border-gray-300 shadow-sm"
               required>
      </div>
      <div>
        <label for="dateFin" class="block text-sm font-medium text-gray-700">Date de fin</label>
        <input type="date" id="dateFin" name="dateFin"
               class="mt-1 block w-2xl rounded-md border-gray-300 shadow-sm"
               required>
      </div>
      <button type="submit"
              class="w-2xl py-2 px-4 bg-green-400 text-white font-semibold rounded-lg hover:bg-green-700">
        Rechercher
      </button>
    </form>


  <!-- Modal -->
  <div id="resultModal"
       class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 max-w-4xl w-full relative">
      <button id="closeModal"
              class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
      <h2 class="text-xl font-semibold mb-4">Résultats des congés</h2>

      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">N° Employé</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nom</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Prénom</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date demande</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Date retour</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php if (empty($liste)): ?>
            <tr>
              <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                Aucun employé en congé sur cette période.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($liste as $emp): ?>
              <tr>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($emp['numEmp']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($emp['Nom']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($emp['Prenom']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($emp['dateDemande']) ?></td>
                <td class="px-4 py-2 text-sm"><?= htmlspecialchars($emp['dateRetour']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('resultModal');
      const closeBtn = document.getElementById('closeModal');

      // Si POST, on affiche la modal
      <?php if ($showModal): ?>
        modal.classList.remove('hidden');
      <?php endif; ?>

      // Bouton de fermeture
      closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
      });

      // Clic hors de la fenêtre pour fermer
      modal.addEventListener('click', e => {
        if (e.target === modal) {
          modal.classList.add('hidden');
        }
      });
    });
  </script>

</body>
</html>
