<!-- Conteneur principal -->
<div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg">

  <!-- Messages -->
  <div class="space-y-4">
    <?php if ($successMessage): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        <?= htmlspecialchars($successMessage) ?>
      </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <?= htmlspecialchars($errorMessage) ?>
      </div>
    <?php endif; ?>

    <!-- Messages de session -->
    <?php if (isset($_SESSION['message'])): ?>
      <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
        <?= htmlspecialchars($_SESSION['message']) ?>
      </div>
      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Formulaire PDF -->
  <form method="post" action="pdf.php" class="mt-6 space-y-4">
    <label for="idEmploye" class="block font-medium text-gray-700">ID Employé :</label>
    <input type="text" id="idEmploye" name="idEmploye" required
           class="w-?? border border-gray-300 p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Entre le id de l'employe pour gerenre le pdf">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Générer PDF</button>
  </form>

  <!-- Barre de recherche -->
  <form method="post" class="mt-6 flex items-center gap-4">
    <input type="hidden" name="search" value="search">
    <input type="text" name="keyword"
           class=" w-15 border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400"
           placeholder="Rechercher par nom ou prénom" required>
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Rechercher</button>
  </form>

  <!-- Bouton d'ajout -->
  <div class="mt-6">
    <button id="openAddModal" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
      Ajouter Employé
    </button>
  </div>

  <!-- Boîte modale d'ajout -->
  <div id="addModal"
       class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg relative">
      <span class="close absolute top-2 right-2 text-gray-500 hover:text-gray-900 cursor-pointer text-2xl">&times;</span>
      <h2 class="text-xl font-bold mb-4">Ajouter un Employé</h2>
      <form method="post">
        <input type="hidden" name="create" value="1">
        <!-- Champs du formulaire -->
        <div class="mb-4">
          <label for="Nom" class="block text-gray-700">Nom</label>
          <input type="text" id="Nom" name="Nom" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
          <label for="Prenom" class="block text-gray-700">Prénom</label>
          <input type="text" id="Prenom" name="Prenom" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
          <label for="poste" class="block text-gray-700">Poste</label>
          <input type="text" id="poste" name="poste" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
          <label for="salaire" class="block text-gray-700">Salaire</label>
          <input type="number" id="salaire" name="salaire" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input type="email" id="email" name="email" class="border p-2 w-full" required>
        </div>
        <div class="flex justify-end space-x-2">
          <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Ajouter</button>
          <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded closeBtn">Annuler</button>
        </div>
      </form>
    </div>
  </div>

    <!-- Tableau avec scroll vertical et horizontal -->
    <div class="mt-6 overflow-x-auto overflow-y-auto max-h-96 border border-gray-200 rounded">
    <table class="min-w-full bg-white">
      <thead class="sticky top-0 bg-white">
        <tr>
          <th class="py-2 px-4 border-b"><input type="checkbox" id="selectAll"></th>
          <th class="py-2 px-4 border-b">Numéro</th>
          <th class="py-2 px-4 border-b">Nom</th>
          <th class="py-2 px-4 border-b">Prénom</th>
          <th class="py-2 px-4 border-b">Poste</th>
          <th class="py-2 px-4 border-b">Salaire</th>
          <th class="py-2 px-4 border-b">Email</th>
          <th class="py-2 px-4 border-b">Actions</th>
        </tr>
      </thead>
      <tbody id="employeeTable">
        <?php foreach ($employes as $employe): ?>
          <tr data-numemp="<?= htmlspecialchars($employe['numEmp']) ?>">
            <td class="py-2 px-4 border-b">
              <input type="checkbox" class="selectRow" name="selected[]" value="<?= htmlspecialchars($employe['numEmp']) ?>">
            </td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['numEmp']) ?></td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['Nom']) ?></td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['Prenom']) ?></td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['poste']) ?></td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['salaire']) ?></td>
            <td class="py-2 px-4 border-b"><?= htmlspecialchars($employe['email']) ?></td>
            <td class="py-2 px-4 border-b relative">
              <button type="button"
                      class="toggleDropdown bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-700 font-medium py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-150">
                &#8942;
              </button>
              <div class="dropdownMenu absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                <a href="#"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 modifyDropdown"
                   data-field="Nom">Modifier</a>
                <a href="#"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 deleteDropdown">
                  Supprimer
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Formulaires cachés -->
  <form id="pointageForm" method="post" action="./controllers/Pointagetraitement.php">
    <input type="hidden" name="action" value="pointage">
    <input type="hidden" name="selected_ids" id="selected_ids">
    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded mt-4">Pointage Sélectionné</button>
  </form>

  <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
      <span class="close absolute top-2 right-2 text-gray-500 hover:text-gray-900 cursor-pointer text-2xl">&times;</span>
      <h2 class="text-xl font-bold mb-4">Supprimer un Employé</h2>
      <form method="post">
        <input type="hidden" name="delete" value="1">
        <input type="hidden" name="numEmp" id="deleteNumEmp">
        <p class="mb-4">Êtes-vous sûr de vouloir supprimer cet employé ?</p>
        <div class="flex justify-end space-x-2">
          <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Supprimer</button>
          <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded closeBtn">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <form id="updateForm" method="post" class="hidden">
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="numEmp" id="updateNumEmp">
    <input type="hidden" name="Nom" id="updateNom">
    <input type="hidden" name="Prenom" id="updatePrenom">
    <input type="hidden" name="poste" id="updatePoste">
    <input type="hidden" name="salaire" id="updateSalaire">
    <input type="hidden" name="email" id="updateEmail">
  </form>
  </div>


  <script src="./views/js/employe_modale_ajoute.js" ></script>
<script>
  const tableBody     = document.getElementById('employeeTable');
  const deleteModal   = document.getElementById('deleteModal');
  const deleteNumEmp  = document.getElementById('deleteNumEmp');
  const updateForm    = document.getElementById('updateForm');
  const updNum        = document.getElementById('updateNumEmp');
  const updNom        = document.getElementById('updateNom');
  const updPrenom     = document.getElementById('updatePrenom');
  const updPoste      = document.getElementById('updatePoste');
  const updSalaire    = document.getElementById('updateSalaire');
  const updEmail      = document.getElementById('updateEmail');

  // Sélect All / Pointage
  document.getElementById("selectAll").addEventListener("click", e => {
    document.querySelectorAll(".selectRow").forEach(cb => cb.checked = e.target.checked);
  });
  document.getElementById("pointageForm").addEventListener("submit", function(e) {
    const sel = Array.from(document.querySelectorAll(".selectRow:checked")).map(cb => cb.value);
    if (!sel.length) { alert("Veuillez sélectionner au moins un employé !"); e.preventDefault(); return; }
    document.getElementById("selected_ids").value = JSON.stringify(sel);
  });

  // Clic hors dropdown ferme tout
  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdownMenu').forEach(menu => menu.classList.add('hidden'));
  });

  // Event delegation sur tout le tbody
  tableBody.addEventListener('click', function(e) {
    const tr = e.target.closest('tr');
    if (!tr) return;
    const num = tr.dataset.numemp;

    // 1) Toggle du menu
    if (e.target.matches('.toggleDropdown')) {
      e.stopPropagation();
      this.querySelectorAll('.dropdownMenu').forEach(m => m.classList.add('hidden'));
      e.target.nextElementSibling.classList.toggle('hidden');
    }

    // 2) Demande de modification inline
    if (e.target.matches('.modifyDropdown')) {
      e.preventDefault();
      // Cacher dropdown
      e.target.parentElement.classList.add('hidden');
      // Récupérer valeurs existantes
      const orig = {
        nom:     tr.cells[2].textContent.trim(),
        prenom:  tr.cells[3].textContent.trim(),
        poste:   tr.cells[4].textContent.trim(),
        salaire: tr.cells[5].textContent.trim(),
        email:   tr.cells[6].textContent.trim()
      };
      // Remplacer par inputs
      tr.cells[2].innerHTML = `<input type="text" value="${orig.nom}"     class="w-full border rounded p-1">`;
      tr.cells[3].innerHTML = `<input type="text" value="${orig.prenom}"  class="w-full border rounded p-1">`;
      tr.cells[4].innerHTML = `<input type="text" value="${orig.poste}"   class="w-full border rounded p-1">`;
      tr.cells[5].innerHTML = `<input type="number" value="${orig.salaire}" class="w-full border rounded p-1">`;
      tr.cells[6].innerHTML = `<input type="email" value="${orig.email}"    class="w-full border rounded p-1">`;
      // Boutons Enregistrer / Annuler
      tr.cells[7].innerHTML = `
        <button class="saveInline bg-green-500 text-white py-1 px-2 rounded">Enregistrer</button>
        <button class="cancelInline bg-gray-500 text-white py-1 px-2 rounded">Annuler</button>
      `;
      // Stocker orig dans dataset pour le cancel
      tr.dataset.orig = JSON.stringify(orig);
    }

    // 3) Annulation : on restaure
    if (e.target.matches('.cancelInline')) {
      const orig = JSON.parse(tr.dataset.orig);
      tr.cells[2].textContent = orig.nom;
      tr.cells[3].textContent = orig.prenom;
      tr.cells[4].textContent = orig.poste;
      tr.cells[5].textContent = orig.salaire;
      tr.cells[6].textContent = orig.email;
      // Remettre le dropdown original
      tr.cells[7].innerHTML = `
        <button type="button" class="toggleDropdown bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-700 font-medium py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors duration-150">
          &#8942;
        </button>
        <div class="dropdownMenu absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 modifyDropdown">Modifier</a>
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 deleteDropdown">Supprimer</a>
        </div>
      `;
    }

    // 4) Enregistrer la modif
    if (e.target.matches('.saveInline')) {
      const newVals = {
        nom:     tr.cells[2].querySelector('input').value,
        prenom:  tr.cells[3].querySelector('input').value,
        poste:   tr.cells[4].querySelector('input').value,
        salaire: tr.cells[5].querySelector('input').value,
        email:   tr.cells[6].querySelector('input').value
      };
      updNum.value     = num;
      updNom.value     = newVals.nom;
      updPrenom.value  = newVals.prenom;
      updPoste.value   = newVals.poste;
      updSalaire.value = newVals.salaire;
      updEmail.value   = newVals.email;
      updateForm.submit();
    }

    // 5) Suppression : ouverture de la modale
    if (e.target.matches('.deleteDropdown')) {
      e.preventDefault();
      e.target.parentElement.classList.add('hidden');
      deleteNumEmp.value = num;
      deleteModal.classList.remove('hidden');
    }
  });

  // Fermer la modale suppression
  deleteModal.addEventListener('click', function(e) {
    if (e.target.matches('.close') || e.target.matches('.closeBtn')) {
      deleteModal.classList.add('hidden');
    }
  });
</script>

