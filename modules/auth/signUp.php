<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
// echo $_SERVER['REQUEST_METHOD'];
// echo'<pre>';
// print_r($_POST);
// echo'</pre>';
?>

<?php
if(isPost()) {
    $filterAll = filter();
    $error = [];
    if(empty($filterAll['fullname'])) {
        $error['fullname']['require'] = 'Name cannot be empty';
    } else {
        if(strlen($filterAll['name']) < 5) {
            $error['fullname']['min'] = 'Name must be at least 5 characters long';
        }
    }
    if(empty($filterAll['email'])) {
        $error['email']['require'] = 'Email cannot be empty';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT user_id FROM users WHERE email = '$email'";
        if(getRowCSDL($sql) > 0) {
        $error['email']['unique'] = 'Email already exists';
        }
    }
    if(empty($filterAll['password'])) {
        $error['password']['require'] = 'Password cannot be empty';
    } else {
        if(strlen($filterAll['password']) < 8) {
            $error['password']['min'] = 'Password must be at least 8 characters long';
        }
    }
    if(empty($filterAll['rePassword'])) {
        $error['rePassword']['require'] = 'Wrong re-password';
    } else {
        if($filterAll['rePassword'] != $filterAll['password']) {
            $error['rePassword']['min'] = 'Wrong re-password';
        }
    }
    if(empty($error)) {
        $fullname = test_input($filterAll['fullname']);
        $email = test_input($filterAll['email']);
        $phone = test_input($filterAll['phone']);
        $password = test_input($filterAll['password']);
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insertCSDL('users', $dataInsert);
        if($insertStatus) {
            $linkActive = _WEB_HOST. '?modules=auth&action=active&token='. $activeToken;
            $subject = $filterAll['name']. ' vui long kich hoat tai khoan';
            $content = 'Chao '. $filterAll['fullname']. '</>';
            $content .= 'Nhap link de kich hoat tai khoan </br>';
            $content .= $linkActive. '</br>';
            $content .= 'Xin cam on';
            
            $sendMail = sendMail($filterAll['email'], $subject, $content);
            if($sendMail) {
                setFlashData('smg', 'Registration successful, please check your email for activation');
                setFlashData('smg_type', 'success');
            } else {
                setFlashData('smg', 'The system encountered an issue');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Unable to sign up');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Please verify the data again!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
    }
    redirect('?modules=auth&action=signUp');
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<?php
setLayout("header_Sign");
?>
<?php
if(!empty($smg)) {
    getSmg($smg, $smg_type);
}
?>
<div class="container" id="container">
	<div id="divSignUp" class="form-container sign-up-container">
		<form action="" method="POST">
			<h1 class="h1TextSignUp">Sign Up</h1>
			<input type="text" name="fullname" placeholder="Name" value="<?php echo old('fullname', $old); ?>"/>
            <?php echo form_error('fullname','<span class="warningSignUp">','</span>', $errors); ?>
			<input type="email" name="email" placeholder="Email" value="<?php echo old('email', $old); ?>"/>
			<?php echo form_error('email','<span class="warningSignUp">','</span>', $errors); ?>
			<input type="password" name="password" placeholder="Password" />
			<?php echo form_error('password','<span class="warningSignUp">','</span>', $errors); ?>
			<input type="password" name="rePassword" placeholder="Re-Password" />
			<?php echo form_error('rePassword','<span class="warningSignUp">','</span>', $errors); ?>
			<button type="submit" class="buttonSignUp">Sign Up</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn" onclick="goSignIn()">Sign In</button>
			</div>
		</div>
	</div>
</div>
<div class="container-button" id="container">
<button class="buttonHome" id="buttonHome" onclick="homeBack()">Home</button>
</div>''
<?php
setLayout("footer_Sign");
?>
