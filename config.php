<?php
//Gia tri truy cap
const _ACCESS_CODE = true;

// Gia tri mac dinh duong dan trang web
const _MODULE = "home";
const _ACTION = "dashboard";
//Kiem tra truy cap hop le
const _CODE = true;

// $_SERVER['HTTP_HOST'] : host hien tai : localhost:8080
// http://localhost:8080
define("_WEB_HOST", "http://".$_SERVER['HTTP_HOST']. "/PHP/Project/website");
// __DIR__ : duong dan toi thu muc cha cua file hien tai
// d://XAMPP/htdocs/PHP/Project/website
define("_WEB_PATH", __DIR__);

define("_WEB_HOST_TEMPLATES", _WEB_HOST. "/templates");
define("_WEB_PATH_TEMPLATES", _WEB_PATH."/templates");

//Thong tin ket noi CSDL
const _HOST = "localhost";
const _DB = "watchest";
const _USER = "root";
const _PASS = "";

?>