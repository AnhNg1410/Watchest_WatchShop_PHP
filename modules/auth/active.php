<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
$token = filter()["token"];
if(!empty($token)) {
    $tokenQuery = getOneRawCSDL("SELECT user_id FROM users WHERE activeToken = '$token'");
    if(!empty($tokenQuery)) {
        $user_id = $tokenQuery['user_id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null,
        ];
        $updateStatus = updateCSDL('users', $dataUpdate, "user_id=$user_id");
        if($updateStatus) {
            setFlashData("msg","Activation of account successful");
            setFlashData("msg_type","success");
        } else {
            setFlashData("msg","Activation of account failed");
            setFlashData("msg_type","danger");
        }
    redirect("?modules=auth&action=signIn");
    } else {
        getSmg('The link does not exist', 'danger');
    }
} else {
    getSmg('The link does not exist', 'danger');
}