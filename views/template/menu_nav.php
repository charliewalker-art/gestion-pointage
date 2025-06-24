<!-- NAVBAR -->
<nav class="bg-white bg-opacity-60 backdrop-blur-md fixed w-full z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
    <!-- Logo -->
    <a href="#" class="flex items-center">
        <img src="image/logo.png" alt="Logo" class="h-10 w-10 mr-2"/>
        <span class="titre-logo">Gestion Pointage</span>
    </a>
        
        
        

        <!-- Liens -->
<div class="menu-liens">
  <a href="?page=employe" class="menu-item">Employé</a>
  <a href="?page=conge" class="menu-item">Congé</a>
  <a href="?page=pointage" class="menu-item">Pointage</a>
</div>

       
       
        <!--  mobile -->
        <button id="btn-menu" class="md:hidden focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
    
    
    <!-- Menu mobile -->
    <div id="menu-mobile" class="hidden md:hidden px-4 pb-4">
      <a href="?page=employe" class="block py-2 text-blue-700">Employé</a>
      <a href="?page=conge" class="block py-2 text-blue-700">Congé</a>
      <a href="?page=pointage" class="block py-2 text-blue-700 ">Pointage</a>
    </div>
  </nav>

  