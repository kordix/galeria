<div id="app">
  <nav class="navbar shadow-sm">
      <div class="container">
        <!-- <a id="navbar-brand" href="/">Galeria</a> -->

        
        <button id="hamburger" class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse">
      
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/">Galeria</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/views/dodaj.php">Dodawanie</a>
            </li> -->
            <li class="nav-item" @click="uploadbool = !uploadbool" style="cursor:pointer">
                Upload
            </li>
          </ul>

            <ul class="navbar-nav mb-2 mb-lg-0" style="margin-left:auto" v-if="adminmode">
              <li class="nav-item" @click="settingsbool = true">
                 <i class="bi bi-gear"></i>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                  data-bs-toggle="dropdown">
                  Admin
                </a>
                <ul class="dropdown-menu" id="navbardropdownmenu">
                  <li><a class="dropdown-item" href="#">Wyloguj</a></li>
                </ul>
              </li>
          
            </ul>
          </div>


      </div>
</nav>