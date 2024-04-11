<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
function setLayout($layout) {
    if(file_exists(_WEB_PATH_TEMPLATES."/layout/".$layout.".php")) {
        return require_once(_WEB_PATH_TEMPLATES."/layout/".$layout.".php");
    }
}

function setTitlePage($title = "Watches") {
    //
}

//Kiem tra phuong thuc Get
function isGet() {
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    } return false;
}
//Kiem tra phuong thuc Post
function isPost() {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    } return false;
}

//Ham Filter loc du lieu
function filter() {
    $filterArr = [];
    if(isGet()) {
        //Xu li truoc khi hien thi
        if(!empty($_GET)) {
            foreach($_GET as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    } elseif(isPost()) {
        //Xu li truoc khi hien thi
        if(!empty($_POST)) {
            foreach($_POST as $key => $value) {
                $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }
    return $filterArr;
}
function isEmail($email) {
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}
//Kiem tra so nguyen Int
function isNumberInt($number) {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
}
//Kiem tra so nguyen Float
function isNumberFloat($number) {
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}
function isPhone($phone) {
    $checkZero = false;
    $checkNumber = false;
    if($phone[0] == '0') {
        $checkZero = true;
        $phone = substr($phone,1);
    }
    if(isNumberInt($phone) && strlen($phone)==9) {
        $checkNumber = true;
    }
    if($checkNumber && $checkZero) {
        return true;
    } return false;
}
function getSmg($smg, $type) {
    echo '
    <style>
        .popupAlert {
            padding: 20px;
            opacity: 0.95;
            position: fixed;
            top: 0;
            left: 2.5%;
            width: 95%;
            z-index: 9999;
            display: none;
            font-size: lager;
            font-weight: 600;
            color: darkgreen;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("popupAlert").style.display = "block";
        setTimeout(function(){
            document.getElementById("popupAlert").style.display = "none";
        }, 3000);
    });
    </script>';
    echo '<div id="popupAlert" class="alert popupAlert alert-'.$type.'">';
    echo $smg;
    echo '</div>';
}
function redirect($path='index.php') {
    header("Location: $path");
    exit;
}
function form_warning($fileName, $beforeHtml='', $afterHtml='', $errors) {
    return (!empty($errors[$fileName])) ? '<span class="warningSignUp">'.reset($errors[$fileName]).'</span>' : null;
}
function form_error($fileName, $beforeHtml='', $afterHtml='', $errors) {
    return (!empty($errors[$fileName])) ? $beforeHtml.reset($errors[$fileName]).$afterHtml : null;
}
function old($fileName, $oldData, $default=null) {
    return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;

}
function isLogin() {
    $checkLogin = false;
    if(getSession('loginToken')) {
        $tokenLogin = getSession('loginToken');
        $queryToken = getOneRawCSDL("SELECT user_id FROM logintoken WHERE token = '$tokenLogin'");
        if(!empty($queryToken)) {
            $checkLogin = true;
        } else {
            removeSession("loginToken");
        }
    }
    // removeSession("loginToken");
    return $checkLogin;
}

function isPermission($required) {
    if(getSession('loginToken')) {
        $tokenLogin = getSession('loginToken');
        $queryToken = getOneRawCSDL("SELECT user_id FROM logintoken WHERE token = '$tokenLogin'");
        $userId = $queryToken['user_id'];
        $queryUser = getOneRawCSDL("SELECT permission FROM users WHERE user_id = '$userId'");
        if($queryUser['permission'] < $required) { 
            redirect("?modules=home&action=dashboard"); 
        }
    } else {
        removeSession("loginToken");
    }
}

function getUserLogin() {
    if(!empty(getSession('loginToken'))) {
        $tokenLogin = getSession('loginToken');
        $user_idLoginToken = getOneRawCSDL("SELECT user_id FROM logintoken WHERE token = '$tokenLogin'");
        $user_idLoginToken = $user_idLoginToken['user_id'];
        $user = getOneRawCSDL("SELECT * FROM users WHERE user_id = '$user_idLoginToken'");
        return $user;
    } else {
        removeSession("loginToken");
    }
}

function permissionUser() {
    return getSession('permission');
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getImageInCSDL($product) {
    $image_id = $product['image_id'];
    $image_data = getImgCSDL($image_id);
    if ($image_data):
        echo $image_data;
    endif;
}

function insertOneProductIntoProducts($product) {
    $product_name = $product['product_name'];
    $image_data = getImgCSDL($product['image_id']);
    $product_price = $product['price'];
    $product_id = $product['product_id'];
    echo 
    '<div class="col-lg-4 col-md-6 portfolio-wrap filter-app">
        <div class="portfolio-item">
            <img src="'.$image_data.'" class="img-fluid" alt="" style="border-radius: 5px;">
            <div class="portfolio-info">
                <h3>'.$product_name.'</h3>
                <div>
                    <a href="?modules=home&action=product_details&product_id='.$product_id.'" title="Portfolio Details"><i class="bx bx-link"></i></a>
                </div>
            </div>
                <h5 class="portfolio-price">'.$product_price.'</h5>
        </div>
    </div>';
}

function insertOneProductIntoProductsDetails($product, $infomation = []) {
    $infomation['category'] = 'a';
    $infomation['madein'] = 'a';
    $infomation['type'] = 'a';
    $infomation['movement'] = 'a';
    $infomation['strap'] = 'a';
    $infomation['surface'] = 'a';
    $infomation['frame'] = 'a';
    $infomation['fullDetail'] = 'a';
    $product_name = $product['product_name'];
    $image_data = getImgCSDL($product['image_id']);
    $product_price = $product['price'];
    $product_id = $product['product_id'];
    echo 
    '<section id="portfolio-details" class="portfolio-details">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                <div class="swiper-slide">
                  <img src="'.$image_data.'" alt="">
                </div>
                <div class="swiper-slide">
                  <img src="'.$image_data.'" alt="">
                </div>
                <div class="swiper-slide">
                  <img src="'.$image_data.'" alt="">
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="portfolio-info" style="color: darkgreen;">
              <h3>'.$product_name.'<br>'.$product['product_code'].'</h3>
              <ul>
                <li><strong>Category</strong>: '.$infomation['category'].'</li>
                <li><strong>Made in</strong>: '.$infomation['madein'].'</li>
                <li><hr></li>
                <li><strong>Watch type</strong>: '.$infomation['type'].'</li>
                <li><strong>Watch movements</strong>: '.$infomation['movement'].'</li>
                <li><strong>Strap material</strong>: '.$infomation['strap'].'</li>
                <li><strong>Surface material</strong>: '.$infomation['surface'].'</li>
                <li><strong>Frame material</strong>: '.$infomation['frame'].'</li>
                <li><hr></li>
                <li><h2 style="color: black;"><strong>'.$product_price.'</strong></h2></li>
                <li><hr></li>
                <div class="row">
                  <div class="col-lg-6"><a href="?modules=pay&action=addToCart&product_id='.$product_id.'" class="btn btn-secondary">Add to cart</a></div>
                  <div class="col-lg-6"><a href="?modules=pay&action=pay&product_id='.$product_id.'" class="btn btn-secondary">Buy</a></div>
                </div>
              </ul>
            </div>
          </div>
          <div class="portfolio-description">
              <h2>Details</h2>
              <p>'.$infomation['fullDetail'].'</p>
            </div>
        </div>
      </div>
    </section>';
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Ham gui mail
function sendMail($to, $subject, $content) {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'test@gmail.com';                     //SMTP username
        $mail->Password   = 'testToken###';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('test@gmail.com', 'Mailer');
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->SMTPOptions = array(
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        );
        $sendMail = $mail->send();
        if($sendMail) {
            return $sendMail;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    return false;
}
?>