  
<body class="body-conge">
<div class="p-6 max-w-7xl mx-auto bg-white rounded shadow-md space-y-6">

<?php
require ('test.php');
?>
  
  
  
  
  
  
  
  
  
  
  
  
  
    <!-- Bouton pour afficher la modale -->
  <button id="openJoursRestants" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
    Afficher les jours restants
  </button>

   <!-- MODALE : JOURS RESTANTS -->
   <div id="joursRestantsModal"
       class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="relative z-60 bg-white rounded-lg shadow-xl max-w-xl w-full mx-4 overflow-auto">
      <div class="p-6">
        <h3 class="text-xl font-semibold mb-4">Jours Restants des Employés</h3>
        <div class="overflow-x-auto max-h-80">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° employé</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Restants</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach ((new Conge($pdo))->joursRestants() as $r): ?>
              <tr>
                <td class="px-4 py-2"><?= htmlspecialchars($r['numEmp']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['Nom']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['Prenom']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($r['jours_restants']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="mt-4 text-right">
          <button id="closeJoursRestants"
                  class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
            Fermer
          </button>
        </div>
      </div>
    </div>
  
    </div>

<!-- Modal : Ajout -->
<div id="modal-ajouter" class="modal-conge">
  <div class="modal-inner-conge">
    <div class="modal-content-conge form-conge">
      <h2>Ajouter un Congé</h2>
      <form action="" method="POST">
        <!-- Indique l’action au contrôleur -->
        <input type="hidden" name="action" value="ajouter">

        <div>
          <label for="ajout-numEmp">Numéro d'Employé :</label>
          <input type="text" id="ajout-numEmp" name="numEmp" required>
        </div>
        <div>
          <label for="ajout-motif">Motif :</label>
          <input type="text" id="ajout-motif" name="motif" required>
        </div>
        <div>
          <label for="ajout-nbrjr">Nombre de Jours :</label>
          <input type="number" id="ajout-nbrjr" name="nbrjr" required>
        </div>
        <div>
          <label for="ajout-dateDemande">Date de début de congé :</label>
          <input type="date" id="ajout-dateDemande" name="dateDemande" required>
        </div>
        <div>
          <label for="ajout-dateRetour">Date de Retour :</label>
          <input type="date" id="ajout-dateRetour" name="dateRetour" required>
        </div>
        <div class="flex-conge justify-between-conge">
          <button type="button" id="close-modal-ajouter"
                  class="btn-conge btn-secondary-conge">Annuler</button>
          <button type="submit"
                  class="btn-conge btn-primary-conge">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>


  <!-- Modal : Modification (pour soumission classique, non utilisé pour l'édition inline) -->
  <div id="modal-modifier" class="modal-conge">
    <div class="modal-inner-conge">
      <div class="modal-content-conge form-conge">
        <h2>Modifier le Congé</h2>
        <form action="" method="POST">
          <input type="hidden" id="modal-numConge" name="numConge">
          <div style="display:none;">
            <label for="modal-numEmp">Numéro d'Employé :</label>
            <input type="text" id="modal-numEmp" name="numEmp" required>
          </div>
          <div>
            <label for="modal-motif">Motif :</label>
            <input type="text" id="modal-motif" name="motif" required>
          </div>
          <div>
            <label for="modal-nbrjr">Nombre de Jours :</label>
            <input type="number" id="modal-nbrjr" name="nbrjr" required>
          </div>
          <div>
            <label for="modal-dateDemande">Date de début de congé :</label>
            <input type="date" id="modal-dateDemande" name="dateDemande" required>
          </div>
          <div>
            <label  for="modal-dateRetour">Date de Retour :</label>
            <input type="date" id="modal-dateRetour" name="dateRetour" required>
          </div>
          <div class="flex-conge justify-between-conge">
            <button type="submit" name="action" value="modifier" class="btn-conge btn-primary-conge">Modifier</button>
            <button type="button" id="close-modal" class="btn-conge btn-secondary-conge">Annuler</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal : Suppression -->
  <div id="modal-supprimer" class="modal-conge">
    <div class="modal-inner-conge">
      <div class="modal-content-conge">
        <h2>Confirmation de Suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer ce congé ?</p>
        <form action="" method="POST">
          <input type="hidden" name="numConge">
          <input type="hidden" name="action" value="supprimer">
          <div class="flex-conge justify-between-conge">
            <button type="button" id="close-modal-supprimer" class="btn-conge btn-secondary-conge">Annuler</button>
            <button type="button" id="confirm-supprimer" class="btn-conge btn-danger-conge">Supprimer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Contenu principal -->
  <div class="container-conge">
    <!-- Affichage des messages -->
    <?php if (!empty($errorMessage)): ?>
      <div style="background-color: #fed7d7; border: 1px solid #f56565; color: #c53030; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($errorMessage); ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($successMessage)): ?>
      <div style="background-color: #c6f6d5; border: 1px solid #48bb78; color: #2f855a; padding: 1rem; border-radius: 0.25rem; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($successMessage); ?>
      </div>
    <?php endif; ?>

    <button id="open-modal-ajouter" class="btn-conge btn-primary-conge" style="margin-bottom: 1rem;">Ajouter un Congé</button>



    <h2 style="font-size: 1.5rem; font-weight: bold; margin: 2rem 0 1rem;">Liste des Congés</h2>
    
    <table class="table-conge">
      <thead>
        <tr>
          <th>Numéro de Congé</th>
          <th>Numéro Employé</th>
          <th>Motif</th>
          <th>Nombre de Jours</th>
          <th>Date de Demande</th>
          <th>Date de Retour</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($conges as $c): ?>
        <tr data-numconge="<?php echo htmlspecialchars($c['numConge']); ?>">
          <td><?php echo htmlspecialchars($c['numConge']); ?></td>
          <td data-field="numEmp"><?php echo htmlspecialchars($c['numEmp']); ?></td>
          <td data-field="motif"><?php echo htmlspecialchars($c['motif']); ?></td>
          <td data-field="nbrjr"><?php echo htmlspecialchars($c['nbrjr']); ?></td>
          <td data-field="dateDemande"><?php echo htmlspecialchars($c['dateDemande']); ?></td>
          <td data-field="dateRetour"><?php echo htmlspecialchars($c['dateRetour']); ?></td>
          <td class="relative-conge">
            <div class="dropdown-conge">
              <button type="button" class="toggleDropdown btn-conge" style="background-color: #e2e8f0; color: #374151;">&#x22EE;</button>
              <div class="dropdown-menu-conge hidden">
                <button type="button" class="dropdown-item-conge modifier-item">Modifier</button>
                <button type="button" class="dropdown-item-conge supprimer-item">Supprimer</button>
              </div>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  
  
  
  </div>
  

</div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      /* Calcul de la date de retour pour l'ajout */
      const ajoutNbrjrInput = document.getElementById('ajout-nbrjr');
      const ajoutDateDemandeInput = document.getElementById('ajout-dateDemande');
      const ajoutDateRetourInput = document.getElementById('ajout-dateRetour');
      function calculateAjoutDateRetour() {
        const nbrjr = parseInt(ajoutNbrjrInput.value);
        const dateDemande = new Date(ajoutDateDemandeInput.value);
        if (!isNaN(nbrjr) && dateDemande instanceof Date && !isNaN(dateDemande)) {
          dateDemande.setDate(dateDemande.getDate() + nbrjr);
          ajoutDateRetourInput.value = dateDemande.toISOString().split('T')[0];
        }
      }
      ajoutNbrjrInput.addEventListener('input', calculateAjoutDateRetour);
      ajoutDateDemandeInput.addEventListener('input', calculateAjoutDateRetour);

      /* Gestion des modales */
      document.getElementById('open-modal-ajouter').addEventListener('click', function () {
        document.getElementById('modal-ajouter').style.display = 'block';
      });
      document.getElementById('close-modal-ajouter').addEventListener('click', function () {
        document.getElementById('modal-ajouter').style.display = 'none';
      });
      document.querySelectorAll('.supprimer-btn, .dropdown-menu-conge .supprimer-item').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          const row = this.closest('tr');
          const numConge = row.querySelector('td:first-child').innerText;
          const modal = document.getElementById('modal-supprimer');
          modal.querySelector('input[name="numConge"]').value = numConge;
          modal.style.display = 'block';
        });
      });
      document.getElementById('close-modal-supprimer').addEventListener('click', function () {
        document.getElementById('modal-supprimer').style.display = 'none';
      });
      document.getElementById('confirm-supprimer').addEventListener('click', function () {
        const form = document.getElementById('modal-supprimer').querySelector('form');
        form.submit();
      });
      document.getElementById('close-modal')?.addEventListener('click', function () {
        document.getElementById('modal-modifier').style.display = 'none';
      });

      /* Gestion du toggle dropdown */
      document.querySelectorAll('.toggleDropdown').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          document.querySelectorAll('.dropdown-menu-conge').forEach(menu => {
            if (menu !== this.nextElementSibling) menu.classList.add('hidden');
          });
          this.nextElementSibling.classList.toggle('hidden');
        });
      });
      document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-menu-conge').forEach(menu => menu.classList.add('hidden'));
      });

      /* Edition inline ) */
      document.querySelectorAll('.dropdown-menu-conge .modifier-item').forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.stopPropagation();
          const row = this.closest('tr');
          // Remplacement des cellules éditables par des inputs
          ['numEmp', 'motif', 'nbrjr', 'dateDemande', 'dateRetour'].forEach(field => {
            const cell = row.querySelector(`td[data-field="${field}"]`);
            const currentValue = cell.innerText.trim();
            let input = document.createElement('input');
            if (field === 'nbrjr') {
              input.type = 'number';
            } else if (field === 'dateDemande' || field === 'dateRetour') {
              input.type = 'date';
            } else {
              input.type = 'text';
            }
            input.value = currentValue;
            input.className = "form-conge-input"; // Vous pouvez définir un style supplémentaire ici
            cell.innerHTML = '';
            cell.appendChild(input);
          });
          // Mise à jour automatique de la date de retour dans l'édition inline
          const nbrInput = row.querySelector('td[data-field="nbrjr"] input');
          const dateDemandeInput = row.querySelector('td[data-field="dateDemande"] input');
          const dateRetourInput = row.querySelector('td[data-field="dateRetour"] input');
          function calculateInlineDateRetour() {
            const nbr = parseInt(nbrInput.value);
            const startDate = new Date(dateDemandeInput.value);
            if (!isNaN(nbr) && startDate instanceof Date && !isNaN(startDate)) {
              startDate.setDate(startDate.getDate() + nbr);
              dateRetourInput.value = startDate.toISOString().split('T')[0];
            }
          }
          nbrInput.addEventListener('input', calculateInlineDateRetour);
          dateDemandeInput.addEventListener('input', calculateInlineDateRetour);
          // Remplacement de la cellule Action par des boutons Enregistrer et Annuler
          const actionCell = row.querySelector('td.relative-conge');
          actionCell.innerHTML = `
            <button type="button" class="save-btn btn-conge btn-primary-conge">Enregistrer</button>
            <button type="button" class="cancel-btn btn-conge btn-secondary-conge">Annuler</button>
          `;
          actionCell.querySelector('.save-btn').addEventListener('click', function () {
            const form = document.createElement('form');
            form.method = "POST";
            form.action = "";
            const numConge = row.getAttribute('data-numconge');
            const fields = ['numEmp', 'motif', 'nbrjr', 'dateDemande', 'dateRetour'];
            form.innerHTML = `<input type="hidden" name="numConge" value="${numConge}">
                                <input type="hidden" name="action" value="modifier">`;
            fields.forEach(field => {
              const cell = row.querySelector(`td[data-field="${field}"]`);
              const inputVal = cell.querySelector('input').value;
              const hiddenInput = document.createElement('input');
              hiddenInput.type = "hidden";
              hiddenInput.name = field;
              hiddenInput.value = inputVal;
              form.appendChild(hiddenInput);
            });
            document.body.appendChild(form);
            form.submit();
          });
          actionCell.querySelector('.cancel-btn').addEventListener('click', function () {
       
                // À la place de location.reload()
          window.location.href = window.location.pathname + '?page=conge';


          });
        });
      });
    });





    document.getElementById('openJoursRestants').addEventListener('click', function () {
    document.getElementById('joursRestantsModal').classList.remove('hidden');
  });

  document.getElementById('closeJoursRestants').addEventListener('click', function () {
    document.getElementById('joursRestantsModal').classList.add('hidden');
  });



  </script>
</body>
</html>
