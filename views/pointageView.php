<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'envoye_email') {
    ob_start();
    include 'test_mail.php';
    $message = ob_get_clean();
}
?>
<div class="p-6 max-w-4xl mx-auto bg-white rounded shadow-md space-y-6">
  <!-- Message -->
  <?php if (!empty($message)): ?>
    <div class="p-4 bg-green-100 text-green-700 rounded-md">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <!-- Bouton Email -->
  <form method="POST" class="flex justify-end">
    <input type="hidden" name="action" value="envoye_email">
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
      Envoyer Email
    </button>
  </form>

  <!-- Titre -->
  <h2 class="text-2xl font-semibold">Tableau de Pointage</h2>

  <!-- Messages succès / erreur -->
  <?php if (!empty($successMessage)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
      <?= $successMessage ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($errorMessage)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      <?= $errorMessage ?>
    </div>
  <?php endif; ?>

  <!-- Recherche absents -->
  <form method="post" class="flex items-center gap-4 mb-4">
    <label for="datePointage" class="font-medium">Date d'absence :</label>
    <input type="date" name="datePointage" id="datePointage" required class="border px-3 py-2 rounded">
    <input type="hidden" name="action" value="dateabsent">
    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
      Rechercher
    </button>
  </form>

  <!-- Tableau scrollable -->
  <div class="overflow-y-auto max-h-96 border border-gray-300 rounded-md shadow-sm">
    <table class="w-full table-auto">
      <thead class="bg-gray-100 text-left sticky top-0 z-10">
        <tr>
          <th class="p-2">Date de Pointage</th>
          <th class="p-2">Numéro d'Employé</th>
          <th class="p-2">Pointage</th>
          <th class="p-2">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; ?>
        <?php foreach ($pointages as $p): 
          $i++;
          $dt = new DateTime($p['datePointage']);
          $fd = $dt->format('H:i d/m/Y');
        ?>
        <tr class="border-t hover:bg-gray-50" id="row-<?= $i ?>"
            data-datepointage="<?= htmlspecialchars($p['datePointage']) ?>"
            data-numemp="<?= htmlspecialchars($p['numEmp']) ?>"
            data-pointage="<?= $p['pointage'] ? '1' : '0' ?>">
          <td class="p-2"><?= htmlspecialchars($fd) ?></td>
          <td class="p-2"><?= htmlspecialchars($p['numEmp']) ?></td>
          <td class="p-2" id="pointage-cell-<?= $i ?>">
            <?= $p['pointage'] ? 'Oui' : 'Non' ?>
          </td>
          <td class="p-2 relative" id="action-cell-<?= $i ?>">
            <!-- Bouton 3 points stylé -->
            <button
              onclick="toggleDropdown(<?= $i ?>)"
              class="toggleDropdown bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-700 font-medium py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-150"
              type="button"
            >
              &#8942;
            </button>
            <!-- Dropdown -->
            <div
              id="dropdown-<?= $i ?>"
              class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow-md z-20"
            >
              <button
                onclick="editRow(<?= $i ?>)"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                type="button"
              >Modifier</button>
              <button
                onclick="openDeleteModal(<?= $i ?>)"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                type="button"
              >Supprimer</button>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Modale des absents -->
  <?php if (!empty($_POST['datePointage']) && $_POST['action'] === 'dateabsent'): ?>
    <div id="absentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">
          Employés absents pour la date <?= htmlspecialchars($_POST['datePointage']) ?>
        </h2>
        <?php if (!empty($absentEmployees)): ?>
          <table class="w-full table-auto border">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-2">Date</th>
                <th class="p-2">Numéro d'Employé</th>
                <th class="p-2">Statut</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($absentEmployees as $abs): ?>
                <tr class="border-t">
                  <td class="p-2"><?= htmlspecialchars($_POST['datePointage']) ?></td>
                  <td class="p-2"><?= htmlspecialchars($abs['numEmp']) ?></td>
                  <td class="p-2">Absent</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-gray-600">Aucun employé absent pour cette date.</p>
        <?php endif; ?>
        <button onclick="closeAbsentModal()"
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                type="button"
        >
          Fermer
        </button>
      </div>
    </div>
  <?php endif; ?>

  <!-- Formulaire caché pour actions -->
  <form id="actionForm" method="post" class="hidden">
    <input type="hidden" name="datePointage" id="form-datePointage">
    <input type="hidden" name="numEmp"      id="form-numEmp">
    <input type="hidden" name="action"      id="form-action">
    <input type="hidden" name="pointage"    id="form-pointage">
  </form>

  <!-- Modale de confirmation suppression -->
  <div id="deleteModal"
       class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Confirmation de suppression</h2>
      <p class="text-gray-700 mb-6" id="deleteModalMessage">
        Êtes-vous sûr de vouloir supprimer ce pointage ?
      </p>
      
      
      <div class="flex justify-end space-x-4">
        <button class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500" onclick="closeDeleteModal()" type="button" >
            Annuler
        </button>
        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="confirmDelete()" type="button">
          Confirmer
        </button>
      </div>
    
    
    </div>
  </div>
</div>

<script>
  // Ouvre/ferme le dropdown
  function toggleDropdown(index) {
    const dd = document.getElementById('dropdown-' + index);
    const all = document.querySelectorAll('[id^="dropdown-"]');
    all.forEach(d => { if (d !== dd) d.classList.add('hidden'); });
    dd.classList.toggle('hidden');
  }

  // Ferme tous les dropdown si clic à l'extérieur
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.toggleDropdown') && !e.target.closest('[id^="dropdown-"]')) {
      document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.classList.add('hidden'));
    }
  });

  // Modal absents
  function openAbsentModal() { document.getElementById('absentModal').classList.remove('hidden'); }
  function closeAbsentModal(){ document.getElementById('absentModal').classList.add('hidden'); }
  window.addEventListener('load', function(){
    <?php if (!empty($_POST['datePointage']) && $_POST['action']==='dateabsent'): ?> openAbsentModal(); <?php endif; ?>
  });

  // Édition
  let original = {};
  function editRow(i) {
    toggleDropdown(i);
    const row = document.getElementById('row-'+i);
    const cur = row.getAttribute('data-pointage');
    original[i] = {
      htmlP: document.getElementById('pointage-cell-'+i).innerHTML,
      htmlA: document.getElementById('action-cell-'+i).innerHTML
    };
    document.getElementById('pointage-cell-'+i).innerHTML = `
      <select id="edit-pointage-${i}" class="border rounded px-2 py-1">
        <option value="1" ${cur==='1'?'selected':''}>Oui</option>
        <option value="0" ${cur==='0'?'selected':''}>Non</option>
      </select>`;
    document.getElementById('action-cell-'+i).innerHTML = `
      <button onclick="confirmEdit(${i})" class="mr-2">Confirmer</button>
      <button onclick="cancelEdit(${i})">Annuler</button>`;
  }
  function confirmEdit(i) {
    const row = document.getElementById('row-'+i);
    document.getElementById('form-datePointage').value = row.getAttribute('data-datepointage');
    document.getElementById('form-numEmp').value      = row.getAttribute('data-numemp');
    document.getElementById('form-action').value      = 'edit';
    document.getElementById('form-pointage').value    = document.getElementById('edit-pointage-'+i).value;
    document.getElementById('actionForm').submit();
  }
  function cancelEdit(i) {
    if (original[i]) {
      document.getElementById('pointage-cell-'+i).innerHTML = original[i].htmlP;
      document.getElementById('action-cell-'+i).innerHTML   = original[i].htmlA;
    }
  }

  // Suppression
  let delIdx = null;
  function openDeleteModal(i) {
    toggleDropdown(i);
    delIdx = i;
    const num = document.getElementById('row-'+i).getAttribute('data-numemp');
    document.getElementById('deleteModalMessage').innerHTML =
      `Êtes-vous sûr de vouloir supprimer ce pointage pour l'employé <strong>${num}</strong> ?`;
    document.getElementById('deleteModal').classList.remove('hidden');
  }
  function closeDeleteModal() {
    delIdx = null;
    document.getElementById('deleteModal').classList.add('hidden');
  }
  function confirmDelete() {
    if (delIdx!==null) {
      const row = document.getElementById('row-'+delIdx);
      document.getElementById('form-datePointage').value = row.getAttribute('data-datepointage');
      document.getElementById('form-numEmp').value      = row.getAttribute('data-numemp');
      document.getElementById('form-action').value      = 'delete';
      document.getElementById('actionForm').submit();
    }
  }
</script>
