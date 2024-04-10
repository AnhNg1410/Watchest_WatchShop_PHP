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
isPermission(1);
?>

<?php
$filterAll = filter();
if(!empty($filterAll['product_id'])) {
    $product_id = $filterAll['product_id'];
    $productDetail = getRowCSDL("SELECT * FROM products WHERE product_id='$product_id'");
    if($productDetail > 0) {
        $product = getOneRawCSDL("SELECT * FROM products WHERE product_id='$product_id'");
        $image_id = $product['image_id'];
        $deleteProduct = deleteCSDL('products', "product_id='$product_id'");
        if($deleteProduct) {
            $deleteProductImage = deleteCSDL('images', "image_id='$image_id'");
            if($deleteProductImage) {
                setFlashData('smg', 'Successfully');
                setFlashData('smg_type','success');
            } else {
                setFlashData('smg', 'Error system ( image deletion failed )');
                setFlashData('smg_type','danger');
            }
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
redirect("?modules=product_manage&action=list");

?>