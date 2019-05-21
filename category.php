<?php 
  define( 'FORBIDDEN', TRUE );
  require_once( 'includes/init.php' );

  $category_id      = $_GET["category"];
  $sub_category_id  = '8, 12, 22, 25, 30, 31, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 85, 86, 87';

  $contents = $adbox->getContents( array(
      'category_id'       => $category_id,
      'limit'             => 10,
      'sub_category_id'   => $sub_category_id
  ) );

  //var_dump($contents);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $_GET["name"]  ?> - Funbox</title>

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
      <h5 class="text-center text-uppercase text-secondary mb-0"><?php echo $_GET["name"]  ?></h5>
      <hr class="">
      <div class="row">
        <?php if( $contents ): ?>
            <?php foreach( $contents as $c ): ?>
                <div class="gameBlock">
                  <a class="" href="<?php echo $c->preview_url; ?>">
                    <!-- <div class="portfolio-item-caption d-flex position-absolute h-100 w-100">
                      <div class="portfolio-item-caption-content my-auto w-100 text-center text-white">
                        <i class="fas fa-search-plus fa-3x"></i>
                      </div>
                    </div> -->
                    <img class="img img-responsive contenImg" style="width: 100%" src="<?php echo $c->thumb_url; ?>" alt="<?php echo $adbox->siteTitle; ?>">
                  </a>
                  <a class="" href="<?php echo $c->preview_url; ?>">
                    <p class="text-center" style="color: #FFF; margin-top: 5px; text-transform: uppercase; background-color: rgba(243, 57, 2, 0.9); border-radius: 5px;"><?php echo $c->title; ?></p>
                  </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h4 class="text-center">No content found.</h4>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Buttons -->
  <div class="container" id="buttons">
    <div class="row">
      <div class="col-lg-12">
          <?php if( $adbox->isNotSubscribed() ): ?>
              <a href="/club/subscribe.php"><button class="btn btn-success" id="subscribeBtn">Subscribe</button></a>
          <?php endif; ?>

          <?php if( $adbox->isSubscribed() ): ?>
              <a href="/club/unsubscribe.php"><button class="btn btn-success" id="subscribeBtn">Unsubscribe</button></a>
          <?php endif; ?>
          <button class="btn btn-success" id="myAccountBtn">My Account</button>
      </div>
    </div>
  </div>

  <?php include './includes/footer.php';?>

</html>
