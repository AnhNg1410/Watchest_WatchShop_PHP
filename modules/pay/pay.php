<?php
//Kiem tra truy cap hop le
if (!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
if (!isLogin()) {
    redirect("?modules=home&action=dashboard");
}
isPermission(0);
?>

<?php
$user = getUserLogin();
$user_id = $user["user_id"];
$cart_id = getOneRawCSDL("SELECT cart_id FROM cart WHERE user_id='$user_id'")['cart_id'];
$cart_productList = getRawCSDL("SELECT * FROM cart_product WHERE cart_id='$cart_id'");

$total = 0;
?>

<?php
setLayout("headerPay");
?>
<div class="container-lg d-md-flex align-items-center">
    <div class="card box1 shadow-sm p-md-3 ">
        <div class="">
            <div class="d-flex align-items-center justify-content-between text">
                <div class="scrollable-div">
                <div style="display: flex;">
                    <div style="flex: 8;">Product</div>
                    <div style="flex: 10; text-align: right;"><?php echo "Amount * Price"; ?></div>
                </div>
                <hr>
                <?php
                foreach ($cart_productList as $cart_product) {
                    $product_id = $cart_product["product_id"];
                    $productDetail = getOneRawCSDL("SELECT * FROM products WHERE product_id='$product_id'");
                    $product_name = $productDetail["product_name"];
                    $product_price = $productDetail["price"];
                    $total += $product_price;
                    $cart_product_quantity = $cart_product["quantity"];
                ?>
                    <div style="flex: 8;"><?php echo $product_name; ?></div>
                    <div style="flex: 4; text-align: right;"><?php echo $cart_product_quantity.' * '.$product_price; ?></div>
                    <hr>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
        <a href="?modules=cart_manage&action=list" class="btnBack"> Back to cart</a>
    </div>
    <div class="card box2 shadow-sm">
        <div class="d-flex align-items-center justify-content-between p-md-5 p-4">
            <span class="h3 fw-bold m-0" style="color: black;">PAYMENT METHOD</span>
            <div class="btn btn-primary bar">
                <span class="fas fa-bars"></span>
            </div>
        </div>
        <ul class="nav nav-tabs mb-3 px-md-4 px-2">
            <li class="nav-item"> <a class="nav-link px-2 active" aria-current="page" href="#">Credit Card</a> </li>
            <li class="nav-item"> <a class="nav-link px-2" href="#">Mobile Payment</a> </li>
            <li class="nav-item ms-auto">
                <a class="nav-link px-2" href="#">+ More</a>
            </li>
        </ul>
        <div class="px-md-5 px-4 mb-4 d-flex align-items-center">
            <div class="btn btn-success me-4">
                <span class="fas fa-plus"></span>
            </div>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio1"><span class="pe-1">+</span>5949</label>
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2"><span class="lpe-1">+</span>3894</label>
            </div>
        </div>
        <form action="">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4">
                        <span>Credit Card</span>
                        <div class="inputWithIcon">
                            <input class="form-control input-text" type="text" placeholder="5136 1845 5468 3894">
                            <span class="">
                                <img src="https://www.freepnglogos.com/uploads/mastercard-png/mastercard-logo-logok-15.png" alt="">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column ps-md-5 px-md-0 px-4 mb-4">
                        <span>Expiration<span class="ps-1">Date</span></span>
                        <div class="inputWithIcon">
                            <input type="text" class="form-control" placeholder="05/20">
                            <span class="fas fa-calendar-alt"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column pe-md-5 px-md-0 px-4 mb-4">
                        <span>Code CVV</span>
                        <div class="inputWithIcon">
                            <input type="password" class="form-control" placeholder="123">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4">
                        <span>Name</span>
                        <div class="inputWithIcon">
                            <input class="form-control text-uppercase" type="text" placeholder="valdimir berezovkiy">
                            <span class="far fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 px-md-5 px-4 mt-3">
                    <div class="btn btn-primary w-100">Pay <?php echo $total; ?></div>
                </div>
            </div>
        </form>
    </div>
    <div class="card box1 shadow-sm p-md-5 p-md-5 p-4">
        <div class="fw-bolder mb-4">
            <!-- <span class="fas fa-dollar-sign"></span> -->
            <span class="ps-1" style="font-size: 35px; font-weight: 600;"><?php echo $total; ?></span>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between text">
                <span class="">Commission</span>
                <span class="fas fa-dollar-sign">
                    <span class="ps-1">1.99</span>
                </span>
            </div>
            <div class="d-flex align-items-center justify-content-between text mb-4">
                <span>Total</span>
                <span class="fas fa-dollar-sign">
                    <span class="ps-1">600.99</span>
                </span>
            </div>
            <div class="border-bottom mb-4">
            </div>
            <div class="d-flex flex-column mb-4">
                <span class="far fa-file-alt text">
                    <span class="ps-2">Invoice ID:</span>
                </span>
                <span class="ps-3"><?php echo 1; ?></span>
            </div>
            <div class="d-flex flex-column mb-5">
                <span class="far fa-calendar-alt text">
                    <span class="ps-2">Next payment:</span>
                </span>
                <span class="ps-3">22 july,2018</span>
            </div>
            <div class="d-flex align-items-center justify-content-between text mt-5">
                <div class="d-flex flex-column text">
                    <span>Customer Support:</span>
                    <span>online chat 24/7</span>
                </div>
                <div class="btn btn-primary rounded-circle">
                    <span class="fas fa-comment-alt"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
setLayout("footerPay");
?>