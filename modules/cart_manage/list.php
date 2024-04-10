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
isPermission(0);
?>

<?php
$user = getUserLogin();
$user_id = $user['user_id'];
$cart = getOneRawCSDL("SELECT * FROM cart WHERE user_id='$user_id'");
if(!empty($cart)) {
$cart_id = $cart["cart_id"];
$cart_product = getRawCSDL("SELECT * FROM cart_product WHERE cart_id='$cart_id'");
// echo'<pre>';
// print_r($cart_product);
// echo'</pre>';
// die();
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<?php
setLayout("header_Product_manage");
?>
<style>
    body {
        background-color: rgb(200, 200, 200);
    }
</style>
<div class="row">
    <div class="container-xxl onTopHome col-2">
        <a href="?modules=home&action=dashboard" class="btn btn-primary btn-sm onTopButton">Home</a>
    </div>
    <div class="container-xxl onTopShop col-2">
        <a href="?modules=home&action=product" class="btn btn-success btn-sm onTopButton">Continue shopping</a>
    </div>
</div>
<div class="container-xxl">
    <hr>
    <h2>My cart</h2>
    <br>
    <!-- <p>
        <a href="?modules=product_manage&action=add" class="btn btn-success btn-sm">Inventory Addition <i class="fa-solid fa-plus"></i></a>
    </p> -->
    <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
    ?>
    <table class="table table-bordered" style="font-size: 17px;">
        <thead>
            <th>Odr</th>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Total amount</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
        <?php
        if (!empty($cart_product)):
            $count = 0;
            $total = 0;
            foreach ($cart_product as $cart_product_detail):
                $count++;
                $product_id = $cart_product_detail['product_id'];
                $cart_quantity = $cart_product_detail['quantity'];
                $product = getOneRawCSDL("SELECT * FROM products WHERE product_id='$product_id'");
        ?>
            <tr>
                <td style="width: 5px;"><?php echo $count; ?></td>
                <td style="width: 100px;"><?php echo $product['product_code']; ?></td>
                <td style="width: 120px;"><?php echo $product['product_name']; ?></td>
                <td style="width: 30px;"><?php echo $product['price'] ?></td>
                <td style="width: 30px;"><?php echo $cart_quantity; ?></td>
                <td style="width: 100px; height: 50px;">
                    <div style="width: 0px; height: 70px; margin-top: 0; margin-bottom: 0; margin-right: 0; margin-left: 0;">
                        <?php $image_id = $product['image_id']; ?>
                        <?php $image_data = getImgCSDL($image_id); ?>
                        <?php if ($image_data): ?>
                            <a href="?modules=cart_manage&action=productImageHtml&image_id=<?php echo $image_id ?>"><img src="<?php echo $image_data; ?>" alt="" style="width: 150px; height: 70px;"></a>
                        <?php endif; ?>
                    </div>
                </td>
                <td style="width: 50px;"><?php echo $cart_quantity*$product['price']; ?></td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=cart_manage&action=edit&product_id=<?php echo $product['product_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=cart_manage&action=delete&product_id=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            <?php
                $total += $cart_quantity*$product['price']; 
                endforeach;
            ?>  
                <td></td><td></td><td></td><td></td><td></td><td style="font-size: 25px; font-weight: 600;">Total : </td>
                <td style="width: 100px; height: 50px; font-size: 25px; font-weight: 600;"><?php echo $total; ?></td>
                <td><td><a href="<?php echo _WEB_HOST; ?>?modules=cart_manage&action=deleteAll" onclick="return confirm('Are you sure you want to delete all products?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td></td>
            <?php
            else:
            ?>
                <tr>
                    <td colspan="10">
                        <div class="alert alert-danger text-center">Empty inventory</div>
                    </td>
                </tr>
            <?php
                endif;
            ?>
        </tbody>
    </table>
    <a href="?modules=pay&action=pay" class="btn btn-primary col-3" style="position: absolute; right: 80px; font-size: 30px; font-weight: 600;">Pay</a>
</div>
<?php
setLayout("footer_Product_manage");
?>