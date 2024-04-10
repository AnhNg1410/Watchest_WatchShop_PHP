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
isPermission(2);
?>

<?php
$filterAll = filter();
if(!empty($filterAll['user_id'])) {
    $userId = $filterAll['user_id'];
    $userDetail = getRowCSDL("SELECT * FROM users WHERE user_id='$user_id'");
    if($userDetail > 0) {
        $deleteToken = deleteCSDL('logintoken', "user_id='$user_id'");
        if($deleteToken) {
            $deleteUser = deleteCSDL('users', "user_id='$user_id'");
            if($deleteUser) {
                setFlashData('smg', 'Successfully');
                setFlashData('smg_type','success');
            } else {
                setFlashData('smg', 'Error system');
                setFlashData('smg_type','danger');
            }
        } else {
        }
    } else {
        setFlashData('smg', 'User does not exist');
        setFlashData('smg_type','danger');
    }
} else {
    setFlashData('smg', 'Link does not exist');
    setFlashData('smg_type','danger');
}
redirect("?modules=user_manage&action=list");

?>