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
$filterAll = filter();
if(!empty($filterAll['product_id'])) {
    $product_id = $filterAll['product_id'];
    $productDetail = getRowCSDL("SELECT * FROM cart_product WHERE product_id='$product_id'");
    if($productDetail > 0) {
        $deleteProduct = deleteCSDL('cart_product', "product_id='$product_id'");
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
} else {
    setFlashData('smg', 'Link does not exist');
    setFlashData('smg_type','danger');
}
redirect("?modules=cart_manage&action=list");

?>