<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
//Ket noi CSDL
try {
    if(class_exists("PDO")) {
        $dsn = "mysql:dbname="._DB.';host='._HOST;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        $con = new PDO($dsn, _USER, _PASS, $options);
    }
} catch (Exception $exception) {
    //throw $th;
    echo '<div style="color:red; padding: 5px 15px; border: 1px solid red;">';
    echo "". $exception->getMessage() ."";
    echo '</div>';
    die();
}
?>