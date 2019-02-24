<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Funbox</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css"> -->
  <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

  <!-- Plugin CSS -->
  <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/freelancer.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">


</head>

<body id="page-top">

<?php include './includes/nav.php';?>

  <!-- Header -->
  <!-- <header class="masthead bg-primary text-white text-center">
    <div class="container">
      <img class="img-fluid mb-5 d-block mx-auto" src="img/profile.png" alt="">
      <h1 class="text-uppercase mb-0">Start Bootstrap</h1>
      <hr class="star-light">
      <h2 class="font-weight-light mb-0">Web Developer - Graphic Artist - User Experience Designer</h2>
    </div>
  </header> -->

  <!-- Slider  -->

  <section id="slider">
    <div class="container">
      <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
          <li data-target="#demo" data-slide-to="0" class="active"></li>
          <li data-target="#demo" data-slide-to="1"></li>
          <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        
        <!-- The slideshow -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="http://www.funboxbd.com/club/assets/img/funbox-carousel-01.jpg" alt="Los Angeles" width="1100" height="500">
          </div>
          <div class="carousel-item">
            <img src="http://www.funboxbd.com/club/assets/img/funbox-carousel-08.jpg" alt="Chicago" width="1100" height="500">
          </div>
          <div class="carousel-item">
            <img src="http://www.funboxbd.com/club/assets/img/funbox-carousel-13.jpg" alt="New York" width="1100" height="500">
          </div>
        </div>
        
        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
    </div>
  </section>

  <!-- Buttons -->
  <div class="container" id="buttons">
    <div class="row">
      <div class="col-lg-12">
          <button class="btn btn-success" id="subscribeBtn">Subscribe</button> 
          <button class="btn btn-success" id="myAccountBtn">My Account</button>
      </div>
    </div>
  </div>

  <!-- Games -->
  <div class="container contentBlock" id="games">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/funboxui/category.php?name=Games">
          <div class="gameCol">
            <div class="centered gameTxt"><h4 class="text-center text-uppercase mb-0">Games</h4></div>
          </div>
      </a>
      </div>
  </div>

  <!-- Video -->
  <div class="container contentBlock" id="video">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/funboxui/category.php?name=Videos">
          <div class="videoCol">
            <div class="centered videoTxt"><h4 class="text-center text-uppercase mb-0">Videos</h4></div>
          </div>
      </a>
      </div>
  </div>

    <!-- MP3 -->
    <div class="container contentBlock" id="music">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/funboxui/category.php?name=Music">
          <div class="musicCol">
            <div class="centered musicTxt"><h4 class="text-center text-uppercase mb-0">Music</h4></div>
          </div>
      </a>
      </div>
  </div>

    <!-- Animation -->
    <div class="container contentBlock" id="animation">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/funboxui/category.php?name=Animation">
          <div class="animationCol">
            <div class="centered animationTxt"><h4 class="text-center text-uppercase mb-0">Animation</h4></div>
          </div>
      </a>
      </div>
  </div>

  <!-- Wallpaper -->
  <div class="container contentBlock" id="wallpaper">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/funboxui/category.php?name=Wallpaper">
          <div class="wallpaperCol">
            <div class="centered wallpaperTxt"><h4 class="text-center text-uppercase mb-0">Wallpaper</h4></div>
          </div>
      </a>
      </div>
  </div>





  <?php include './includes/footer.php';?>

</html>
