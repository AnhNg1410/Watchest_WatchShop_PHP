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
$user_id = getUserLogin()['user_id'];
$cart_id = getOneRawCSDL("SELECT * FROM cart WHERE user_id='$user_id'")["cart_id"];
$productDetail = getRowCSDL("SELECT * FROM cart_product WHERE cart_id='$cart_id'");
if($productDetail > 0) {
    $deleteProduct = deleteCSDL('cart_product', "cart_id='$cart_id'");
    if($deleteProduct) {
        setFlashData('smg', 'Successfully');
        setFlashData('smg_type','success');
    } else {
        setFlashData('smg', 'Error system ( product deletion failed )');
        setFlashData('smg_type','danger');
    }
} else {
    setFlashData('smg', 'Product does not exist');
    setFlashData('smg_type','danger');
}
redirect("?modules=cart_manage&action=list");

?>