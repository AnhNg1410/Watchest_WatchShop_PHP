<?php
//Tao Session cho project
session_start();

// Goi cac file can thiet
require_once "config.php";
require_once "./includes/connect.php";
require_once './includes/phpmailer/Exception.php';
require_once './includes/phpmailer/PHPMailer.php';
require_once './includes/phpmailer/SMTP.php';
require_once "./includes/functions.php";
require_once "./includes/database.php";
require_once "./includes/session.php";
?>

<?php
// Xu li dieu huong trang modules va action
$modules = _MODULE;
$action = _ACTION;
if(!empty($_GET['modules']) && !empty($_GET['action'])) {
    if(is_string($_GET['modules']) && is_string($_GET['action'])) {
        $modules = trim($_GET['modules']);
        $action = trim($_GET['action']);
    }
}
$path = 'modules/'. $modules. '/'. $action .'.php';
if(file_exists($path)) {
    require_once $path;
} else {
    require_once 'modules/error/404.php';
}

?>