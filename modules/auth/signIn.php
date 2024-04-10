<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
if(isLogin()) {
    redirect("?modules=home&action=dashboard");
}

if(isPost()) {
    $filterAll = filter();
	$errors = [];
    if(!empty(trim($filterAll['email']))) {
		if(!empty(trim($filterAll['password']))) {
			$email = ($filterAll['email']);
			$password = ($filterAll['password']);
			$userQuery = getOneRawCSDL("SELECT * FROM users WHERE email = '$email'");
			if(!empty($userQuery)) {
				$passwordHash = $userQuery['password'];
				$user_id = $userQuery['user_id'];
				$permission = $userQuery['permission'];
				if(password_verify($password, $passwordHash)) {
					$tokenLogin = sha1(uniqid().time());
					$dataInsert = [
						'user_id' => $user_id,
						'token' => $tokenLogin,
						'create_at' => date('Y-m-d H:i:s'),
					];
					$insertStatus = insertCSDL('logintoken', $dataInsert);
					if($insertStatus) {
						setSession('loginToken', $tokenLogin);
						setSession('permission', $permission);
					} else {
						setFlashData('msg','Unable to log in');
						setFlashData('msg_type','danger');
					}
					redirect('?modules=home&action=dashboard');
				} else {
					$errors['password']['wrong'] = 'Incorrect password';
					// setFlashData('msg','Incorrect password');
					// setFlashData('msg_type','danger');
				}
			} else {
				$errors['email']['exist'] = 'Email does not exist';
				// setFlashData('msg','Email does not exist');
				// setFlashData('msg_type','danger');
			}
		} else {
			$errors['password']['require'] = 'Password cannot be empty';
		}
    } else {
		$errors['email']['require'] = 'Email cannot be empty';
        // setFlashData('msg','Enter email and password');
        // setFlashData('msg_type','danger');
    }
	if(empty($errors)) {
    	redirect('?modules=auth&action=signIn');
	} else {
		setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
	}
}
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$error = getFlashData('errors');
$old = getFlashData('old');
?>

<?php
	setLayout("header_Sign");
?>
<?php 
if(!empty($msg)) { 
	getSmg($msg, $msg_type); 
} 
?>
<div class="container" id="container">
	<div id="divSignIn" class="form-container sign-in-container">
		<form action="" method="POST">
			<h1 class="h1TextSignIn">Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your account</span>
			<input type="email" name="email" placeholder="Email" value="<?php echo old('email', $old); ?>"/>
			<input type="password" name="password" placeholder="Password" />
			<?php if(!empty($error['email'])) { 
				echo form_error('email','<span class="errorSignIn">','</span>', $error); 
			} else {
				echo form_error('password','<span class="errorSignIn">','</span>', $error);
			}?>
			<a class="linkForgot" href="#">Forgot your password?</a>
			<button type="submit" class="buttonSignIn">Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp" onclick="goSignUp()">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<div class="container-button" id="container">
<button class="buttonHome" id="buttonHome" onclick="homeBack()">Home</button>
</div>
<?php
	setLayout("footer_Sign");
?>
