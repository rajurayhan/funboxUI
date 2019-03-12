<?php

	define( 'FORBIDDEN', TRUE );

	require_once( 'includes/init.php' );

	$adbox->redirectIfNoContentAndNoCategory();

	$content = $adbox->getContent( array(
	    'content_id' => $adbox->getRequestData( 'content' ),
	    'category_id' => $adbox->getRequestData( 'category' )
	) );

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Preview - Funbox</title>

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
  <section class="portfolio" id="portfolio" style="">
    <div class="container">
        <div class="row">
        	<?php if( $adbox->isLessThanDownloadLimit() ): ?>
	            <div class="col-lg-12 col-sm-6">
	                <h3 class="text-center text-uppercase text-secondary mb-0"><?php echo $content->title; ?></h3>
	                <img class="img img-responsive previewImg" src="<?php echo $content->thumb_url; ?>" alt="<?php echo $adbox->siteTitle; ?>">
	            </div>
	            <div class="col-lg-12 col-sm-6">
	                <a href="<?php echo $adbox->isSubscribed() ? $content->download_url : $content->subscribe_url; ?>">
	                    <button class="btn btn-success downloadBtn" type="button" style=""><i class="fa fa-download"></i> Download</button>
	                </a>
	            </div>
            <?php elseif( $adbox->isOperator( 'blink' ) ): ?>
	            <div class="col-lg-12 col-sm-6">
	                <h3 class="text-center text-uppercase text-secondary mb-0"><?php echo $content->title; ?></h3>
	                <img class="img img-responsive previewImg" src="<?php echo $content->thumb_url; ?>" alt="<?php echo $adbox->siteTitle; ?>">
	            </div>
	            <div class="col-lg-12 col-sm-6">
	                <a href="<?php echo $adbox->isSubscribed() ? $content->ondemand_url : $content->subscribe_url; ?>">
	                    <button class="btn btn-success downloadBtn" type="button" style=""><i class="fa fa-download"></i> Download</button>
	                </a>
	            </div>
            <?php else: ?>
	            <div class="col-lg-12 col-sm-6">
	                <p class="text-center">You have already downloaded 5 free contents for today. Come back again tomorrow to download 5 more free contents.</p>
	            </div>
            <?php endif; ?>
        </div>
    </div>
  </section>

  <!-- Buttons -->
  <!-- <div class="container" id="buttons">
    <div class="row">
      <div class="col-lg-12">
          <button class="btn btn-success" id="subscribeBtn">Subscribe</button> 
          <button class="btn btn-success" id="myAccountBtn">My Account</button>
      </div>
    </div>
  </div> -->

  <?php include './includes/footer.php';?>

</html>
