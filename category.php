<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Games - Funbox</title>

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

  <!-- Portfolio Grid Section -->
  <section class="portfolio" id="portfolio">
    <div class="container">
      <h2 class="text-center text-uppercase text-secondary mb-0"><?php echo $_GET["name"]  ?></h2>
      <hr class="star-dark mb-5">
      <div class="row">
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-1">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/cabin.png" alt="">
          </a>
        </div>
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-2">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/cake.png" alt="">
          </a>
        </div>
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-3">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/circus.png" alt="">
          </a>
        </div>
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-4">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/game.png" alt="">
          </a>
        </div>
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-5">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/safe.png" alt="">
          </a>
        </div>
        <div class="gameBlock">
          <a class="portfolio-item d-block mx-auto" href="#portfolio-modal-6">
            <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
              <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                <i class="fas fa-search-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/portfolio/submarine.png" alt="">
          </a>
        </div>
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

  <?php include './includes/footer.php';?>

</html>
