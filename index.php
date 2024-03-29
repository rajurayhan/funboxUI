<?php 
  define( 'FORBIDDEN', TRUE );
  require_once( 'includes/init.php' );
  // mob1k = tiger (Airtel)  funboxbd.com?chanel=mob1k&ta={ta}
  // mob1h = tiger (Blink) funboxbd.com?chanel=mob1h&ta={ta}
  // mob1p = tiger (Robi) funboxbd.com?chanel=mob1p&ta={ta}

  // mob1n = bs (Airtel) funboxbd.com?chanel=mob1n&hash={hash}
  // mob1o = bs (Blink) funboxbd.com?chanel=mob1o&hash={hash}
  // mob1q = bs (Robi) funboxbd.com?chanel=mob1q&hash={hash}
  $bitterStrawberry = array(
    'airtel'  => 'mob1n' , 
    'robi'    => 'mob1q' , 
    'blink'   => 'mob1o' , 
  );

  $tiger = array(
    'airtel'  => 'mob1k' , 
    'robi'    => 'mob1p' , 
    'blink'   => 'mob1h' , 
  );

  //exit(var_dump($tiger));
  try{
      if(!isset($_GET['chanel'])){throw new Exception('Channel not found.');}
      $chanel=$_GET['chanel'];
      if(!in_array($chanel,array('mob1n','mob1o', 'mob1k', 'mob1q', 'mob1p', 'mob1h'))){throw new Exception('Channel not matched.');}

      if(in_array($chanel, $bitterStrawberry)&&!isset($_GET['hash'])){throw new Exception('Track ID not found.');} // BitterStrawberry
      if(in_array($chanel, $tiger)&&!isset($_GET['ta'])){throw new Exception('Track ID not found.');} // Tiger

      $chanel_base='http://funboxbd.com/online/bn/'.$chanel;

      if(in_array($chanel, $bitterStrawberry)){
          $data=array('hash'=>$_GET['hash']);
          // exit('Found in BS');
      }
      elseif(in_array($chanel, $tiger)){
          $data=array('ta'=>$_GET['ta']);
          // exit('Found in Tiger');
      }
      $chanel_query = http_build_query($data);
      $chanel_url=$chanel_base.'?'.$chanel_query;
      header('refresh: 3; url='.$chanel_url);//exit;
  }catch(Exception $e) {
      //header('location: http://funboxbd.com/club');//exit;
  }

  ?>

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
          <li data-target="#demo" data-slide-to="3"></li>
          <li data-target="#demo" data-slide-to="4"></li>
          <li data-target="#demo" data-slide-to="5"></li>
        </ul>
        
        <!-- The slideshow -->
        <div class="carousel-inner">
          <?php foreach( $carousels as $i => $ca ): ?>          
            <div class="carousel-item <?php echo $i === 0 ? ' active' : ''; ?>">
              <!-- <img src="http://www.funboxbd.com/club/assets/img/funbox-carousel-01.jpg" alt="Los Angeles" width="1100" height="500"> -->
              <img src="/club/assets/img/<?php echo $ca; ?>" alt="<?php echo $adbox->siteTitle; ?>" />
            </div>
          <?php endforeach; ?>
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

  <!-- Games -->
  <div class="container contentBlock" id="games">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/club/category.php?name=Games&category=6">
          <div class="gameCol">
            <div class="centered gameTxt"><h4 class="text-center text-uppercase mb-0">Games</h4></div>
          </div>
      </a>
      </div>
  </div>

  <!-- Video -->
  <div class="container contentBlock" id="video">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/club/category.php?name=Videos&category=5">
          <div class="videoCol">
            <div class="centered videoTxt"><h4 class="text-center text-uppercase mb-0">Videos</h4></div>
          </div>
      </a>
      </div>
  </div>

    <!-- MP3 -->
    <div class="container contentBlock" id="music">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/club/category.php?name=Music&category=3">
          <div class="musicCol">
            <div class="centered musicTxt"><h4 class="text-center text-uppercase mb-0">Music</h4></div>
          </div>
      </a>
      </div>
  </div>

    <!-- Animation -->
    <div class="container contentBlock" id="animation">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/club/category.php?name=Animation&category=2">
          <div class="animationCol">
            <div class="centered animationTxt"><h4 class="text-center text-uppercase mb-0">Animation</h4></div>
          </div>
      </a>
      </div>
  </div>

  <!-- Wallpaper -->
  <div class="container contentBlock" id="wallpaper">
      <div class="row banner">
      <a class="col-xs-12 col-sm-12 column" href="/club/category.php?name=Wallpaper&category=1">
          <div class="wallpaperCol">
            <div class="centered wallpaperTxt"><h4 class="text-center text-uppercase mb-0">Wallpaper</h4></div>
          </div>
      </a>
      </div>
  </div>





  <?php include './includes/footer.php';?>

</html>
