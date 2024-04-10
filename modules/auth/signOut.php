<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
if(isLogin()) {
    $token = getSession('loginToken');
    deleteCSDL('logintoken', "token='$token'");
    removeSession("loginToken");
    removeSession("permission");
    redirect("?modules=auth&action=signIn");

}
?>