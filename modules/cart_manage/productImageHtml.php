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
$image_id = $_GET['image_id'];
$image_data = getImgCSDL($image_id); 
?>

<?php
setLayout('header_Product_manage');
?>
<img src="<?php echo $image_data; ?>" alt="Picture" style="height: 40%; width: 70%; margin-top: 10px; margin-left: 10px">
<a href="?modules=cart_manage&action=list" class="mg-btn btn btn-success btn-block" style="margin-left: 50px;">Back</a>