<?php
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
if(!isLogin()) {
    redirect("?modules=home&action=dashboard");
}
isPermission(0);


$filterAll = filter();
if(!empty($filterAll['product_id'])) {
    $user = getUserLogin();
    $user_id = $user['user_id'];
    $product_id = $filterAll['product_id'];
    $cartUserRow = getRowCSDL("SELECT cart_id FROM cart WHERE user_id='$user_id'");
    $updateStatus = 0;
    $insertCartStatus = 0;
    if($cartUserRow == 0) {
        $dataInsertCart = [
            'user_id' => $user_id,
        ];
        insertCSDL('cart', $dataInsertCart);
    }
    $cart_id = getOneRawCSDL("SELECT cart_id FROM cart WHERE user_id='$user_id'")['cart_id'];
    $productRow = getRowCSDL("SELECT product_id FROM cart_product WHERE cart_id='$cart_id' AND product_id='$product_id'");
    if($productRow > 0) {
        $cart_product_quantity = getOneRawCSDL("SELECT quantity FROM cart_product WHERE product_id='$product_id' AND cart_id='$cart_id'")['quantity'];
        $dataUpdate = [
            'quantity' => $cart_product_quantity + 1,
            'update_at' => date('Y-m-d H:i:s'),
        ];
        $condition = "product_id = '$product_id'";
        $updateStatus = updateCSDL('cart_product', $dataUpdate, $condition);
    } else {
        $dataInsertCart = [
            'cart_id' => $cart_id,
            'product_id' => $product_id,
            'create_at' => date('Y-m-d H:i:s'),
        ];
        $insertCartStatus = insertCSDL('cart_product', $dataInsertCart);
    }
    if($updateStatus || $insertCartStatus) {
        setFlashData("smg","Product addition successful");
        setFlashData("smg_type","success");
    } else {
        setFlashData("smg","Product addition failed");
        setFlashData("smg_type","danger");
    }
} else {
    setFlashData("smg","Product addition failed");
    setFlashData("smg_type","danger");
}
// $smg = getFlashData('smg');
// $smg_type = getFlashData('smg_type');
// getSmg($smg, $smg_type);
redirect("?modules=home&action=product_details&product_id=" . urlencode($product_id));
?>