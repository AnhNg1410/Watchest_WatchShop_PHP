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
    $userDetail = getOneRawCSDL("SELECT quantity FROM cart_product WHERE product_id='$product_id'");
    if(!empty($userDetail)) {
        setFlashData('user-detail', $userDetail);
    } else {
    redirect("?modules=cart_manage&action=list");
   }
}

if(isPost()) {
    $filterAll = filter();
    $error = [];
    if($filterAll['quantity'] <= 0) {
        $error['quantity']['require'] = 'Quantity must be greater than or equal to 0';
    }
    if(empty($error)) {
        $dataUpdate = [
            'quantity' => $filterAll['quantity'],
            'update_at' => date('Y-m-d H:i:s'),
        ];
        $condition = "product_id = '$product_id'";
        $updateStatus = updateCSDL('cart_product', $dataUpdate, $condition);
        if($updateStatus) {
            setFlashData('smg', 'Information updated successfully');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'System error');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Please check your data again');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
    }
    redirect('?modules=cart_manage&action=edit&product_id='. $product_id);
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$userDetailll = getFlashData('user-detail');
if(!empty($userDetailll)) {
    $old = $userDetailll;
}
?>

<?php
setLayout('header_User_manage');
?>
<style>
    body {
        background-color: rgb(200, 200, 200);
    }
</style>
<div class="container">
    <div class="container onTop">
        <a href="?modules=home&action=dashboard" class="btn btn-primary btn-sm onTopButton">Home</a>
    </div>
    <hr>
    <div class="row" > 
        <h1 clas="text-center">Edit user information</h1>
        <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="form-group mg-form">
                    <label for="">Quantity</label>
                    <input name="quantity" type="number" class="form-control" placeholder="Quantity" value="<?php echo old('quantity', $old); ?>">
                    <?php echo form_error('quantity','<span class="error">','</span>', $errors); ?>
                </div>
            </div>
            <br>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <button type="submit" class="btn-user mg-btn btn btn-primary btn-block">Save</button>
            <a href="?modules=cart_manage&action=list" type="submit" class="mg-btn btn btn-success btn-block">Back</a>
            <hr>
        </form>
    </div>
</div>
<?php
setLayout('footer_User_manage');
?>