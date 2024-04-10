<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
//Ham gan session
function setSession($key, $value) {
    return $_SESSION[$key] = $value;
}

//Ham doc session
function getSession($key='') {
    if(!empty($key)) {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    } else {
        return $_SESSION;
    }
}

//Ham xoa session
function removeSession($key='') {
    if(!empty($key)) {
        if(isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    } else {
        session_destroy();
        return true;
    }
}

//Ham gan flash data
function setFlashData($key, $value) {
    $key = 'flash_'. $key;
    return setSession($key, $value);
}

//Ham doc flash data
function getFlashData($key) {
    $key = 'flash_'. $key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}

?>