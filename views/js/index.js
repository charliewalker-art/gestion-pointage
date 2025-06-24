//resposive menu
const btn = document.getElementById('btn-menu');
    const menu = document.getElementById('menu-mobile');
    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });