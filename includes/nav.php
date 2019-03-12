  <?php 
    $categoryName = $_GET["name"];
  ?>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary fixed-top text-uppercase" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="/club"><img class="img-responsive" src="/club/img/funbox.png"></a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase bg-funbox text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger <?php if($categoryName == 'Games') echo 'active' ?>" href="/club/category.php?name=Games&category=6">Games</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger <?php if($categoryName == 'Videos') echo 'active' ?>" href="/club/category.php?name=Videos&category=5">Videos</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger <?php if($categoryName == 'Music') echo 'active' ?>" href="/club/category.php?name=Music&category=3">Music</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger <?php if($categoryName == 'Animation') echo 'active' ?>" href="/club/category.php?name=Animation&category=2">Animation</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger <?php if($categoryName == 'Wallpaper') echo 'active' ?>" href="/club/category.php?name=Wallpaper&category=1">Wallpaper</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>