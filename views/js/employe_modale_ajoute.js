 // Récupération des éléments
 const openModalBtn = document.getElementById('openAddModal');
 const modal = document.getElementById('addModal');
 const closeModalElements = document.querySelectorAll('.close, .closeBtn');

 // Afficher la modale
 openModalBtn.addEventListener('click', () => {
   modal.classList.remove('hidden');
 });

 // Fermer la modale (via le "×" ou le bouton "Annuler")
 closeModalElements.forEach(element => {
   element.addEventListener('click', () => {
     modal.classList.add('hidden');
   });
 });

 // Fermer la modale en cliquant à l'extérieur du contenu
 window.addEventListener('click', (e) => {
   if (e.target === modal) {
     modal.classList.add('hidden');
   }
 });


 // Fermeture des modales via les boutons "close" ou "Annuler"
 document.querySelectorAll(".close, .closeBtn").forEach(el => {
    el.addEventListener("click", () => {
      addModal.classList.add("hidden");
      deleteModal.classList.add("hidden");
    });
  });

  // Fermeture en cliquant à l'extérieur de la modale
  window.addEventListener("click", (event) => {
    if (event.target === addModal) addModal.classList.add("hidden");
    if (event.target === deleteModal) deleteModal.classList.add("hidden");
  });