<!-- Footer -->
<footer class="footer text-justify">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>
          Download 5 free attractive contents everyday by subscribing to Funbox service only @ BDT 2.44 including (VAT+SD+SC) per day. To subscribe please click the subscribe button. Thank You!
          </p>
          <p class="text-center">
            <i class="fa fa-phone-square" aria-hidden="true"></i>  01977733255
          </p>
          <small>&copy; Adbox Bangladesh <?php echo date('Y'); ?></small>
        </div>
      </div>
    </div>
  </footer>

  <!-- <div class="copyright py-4 text-center text-white">
    <div class="container">
      <small>&copy; Adbox Bangladesh <?php echo date('Y'); ?></small>
    </div>
  </div> -->

  <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
  <div class="scroll-to-top d-lg-none position-fixed ">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
      <i class="fa fa-chevron-up"></i>
    </a>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/freelancer.min.js"></script>

</body>

<script>
   $(document).ready(function () {
      $(document).click(function (event) {
          var clickover = $(event.target);
          var _opened = $(".navbar-collapse").hasClass("show");
          if (_opened === true && !clickover.hasClass("navbar-toggler")) {
              $(".navbar-toggler").click();
          }
      });
  });
</script>