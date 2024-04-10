<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
if(!isLogin()) {
    redirect("?modules=home&action=dashboard");
}
?>

<?php
$product_id = isset($_GET["product_id"]) ? $_GET["product_id"] : 0;
$product = getOneRawCSDL("SELECT * FROM products WHERE product_id='$product_id'");
if(!$product || $product_id===0 || $product['active']===0) {
  setFlashData('smg','This product is not active');
  setFlashData('smg_type','danger');
  redirect('?modules=home&action=product');
}
$image_id = $product['image_id'];

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<?php
setLayout("header");
?>
<body>
  <main id="main">
    <?php
    if(!empty($smg)) {
      getSmg($smg, $smg_type);
    }
    ?>
    <!-- ======= Our Portfolio Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Product details</h2>
          <ol>
            <li><a href="?modules=home&action=dashboard">Home</a></li>
            <li><a href="?modules=home&action=product">Portfolio</a></li>
            <li>Product details</li>
          </ol>
        </div>
      </div>
    </section><!-- End Our Portfolio Section -->
    <!-- ======= Portfolio Details Section ======= -->
    <!-- <section id="portfolio-details" class="portfolio-details">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide">
                  <img src="" alt="">
                </div>
                <div class="swiper-slide">
                  <img src="" alt="">
                </div>
                <div class="swiper-slide">
                  <img src="" alt="">
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="portfolio-info" style="color: darkgreen;">
              <h3>Product information <br>Watch</h3>
              <ul>
                <li><strong>Category</strong>: Web design</li>
                <li><strong>Made in</strong>: ASU Company</li>
                <li><hr></li>
                <li><strong>Watch type</strong>: 01 March, 2020</li>
                <li><strong>Watch movements</strong>: ASU Company</li>
                <li><strong>Strap material</strong>: 01 March, 2020</li>
                <li><strong>Surface material</strong>: www.example.com</li>
                <li><strong>Frame material</strong>: Web design</li>
                <li><hr></li>
                <li><h2 style="color: black;"><strong>9999999</strong></h2></li>
                <li><hr></li>
                <div class="row">
                  <div class="col-lg-6"><button class="btn btn-secondary">Add to cart</button></div>
                  <div class="col-lg-6"><button class="btn btn-secondary">Buy</button></div>
                </div>
              </ul>
            </div>
          </div>
          <div class="portfolio-description">
              <h2>This is an example of portfolio detail</h2>
              <p>
                Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur dignissimos. Sequi nulla at esse enim cum deserunt eius.
              </p>
            </div>
        </div>
      </div>
    </section>
    End Portfolio Details Section -->
    <?php insertOneProductIntoProductsDetails($product); ?>
  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
    <div class="footer-newsletter">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
          </div>
          <div class="col-lg-6">
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br><br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>
          </div>
          <div class="col-lg-3 col-md-6 footer-info">
            <h3>About Moderna</h3>
            <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Moderna</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
<?php
setLayout("footer")
?>
</html>