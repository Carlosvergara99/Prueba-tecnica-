<template >
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <!-- <a class="navbar-brand" href="#">Prueba</a> -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <router-link to="/"> <a class="nav-link" > Marcas </a></router-link> 
      </li>
      <li class="nav-item">
        <router-link to="/product"> <a class="nav-link" >Porductos  </a></router-link> 
      </li>
    </ul>
  </div>
</nav>
</template>