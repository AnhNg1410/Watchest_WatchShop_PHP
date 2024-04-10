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
    $user_id = $filterAll['user_id'];
    $userDetail = getOneRawCSDL("SELECT * FROM users WHERE user_id='$user_id'");
    if(!empty($userDetail)) {
        setFlashData('user-detail', $userDetail);
    } else {
    redirect("?modules=user_manage&action=list");
   }
}

if(isPost()) {
    $filterAll = filter();
    $error = [];
    if(empty($filterAll['fullname'])) {
        $error['fullname']['require'] = 'Name cannot be empty';
    } else {
        if(strlen($filterAll['fullname']) < 5) {
            $error['fullname']['min'] = 'Name must be at least 5 characters long';
        }
    }
    if(empty($filterAll['email'])) {
        $error['email']['require'] = 'Email cannot be empty';
    } else {
        // $email = $filterAll['email'];
        // $sql = "SELECT user_id FROM users WHERE email = '$email' AND user_id <> '$user_id'";
        // if(getRowCSDL($sql) > 0) {
        // $error['email']['unique'] = 'Email already exists';
        // }
    }
    if(empty($filterAll['phone'])) {
        $error['phone']['require'] = 'Phone number cannot be empty';
    } else {
        if(!isPhone($filterAll['phone'])) {
            $error['phone']['isPhone'] = 'Invalid phone number';
        }
    }
    if(!empty($filterAll['password'])) {
        if(strlen($filterAll['password']) < 8) {
            $error['password']['min'] = 'Password must be at least 8 characters long';
        }
        if($filterAll['password_confirm'] != $filterAll['password']) {
            $error['password_confirm']['min'] = 'Wrong re-password';
        }
    }
    if(empty($error)) {
        $dataUpdate = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'status' => $filterAll['status'],
            'birth' => $filterAll['birth'],
            'address' => $filterAll['address'] ,
            'permission' => $filterAll['permission'],
            'create_at' => date('Y-m-d H:i:s'),
        ];
        if(!empty($filterAll['password'])) {
            $dataUpdate['password']  = password_hash($filterAll['password'], PASSWORD_DEFAULT);
        }
        $condition = "user_id = '$user_id'";
        $updateStatus = updateCSDL('users', $dataUpdate, $condition);

        if($updateStatus) {
            setFlashData('smg', 'Information updated successfully');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'System error');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Please check your data again');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
    }
    redirect('?modules=user_manage&action=edit&user_id='. $user_id);
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$userDetailll = getFlashData('user-detail');
if(!empty($userDetailll)) {
    $old = $userDetailll;
}
?>

<?php
setLayout('header_User_manage');
?>
<style>
    body {
        background-color: rgb(200, 200, 200);
    }
</style>
<div class="container">
    <div class="container onTop">
        <a href="?modules=home&action=dashboard" class="btn btn-primary btn-sm onTopButton">Home</a>
    </div>
    <hr>
    <div class="row" > 
        <h1 clas="text-center">Edit user information</h1>
        <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group mg-form">
                    <label for="">Full name</label>
                    <input name="fullname" type="text" class="form-control" placeholder="Full name" value="<?php echo old('fullname', $old); ?>">
                    <?php echo form_error('fullname','<span class="error">','</span>', $errors); ?>
                </div>
                <div class="form-group mg-form">
                    <label for="">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo old('email', $old); ?>">
                    <?php echo form_error('email','<span class="error">','</span>', $errors); ?>
                </div>
                <div class="form-group mg-form">
                    <label for="">Phone number</label>
                    <input name="phone" type="number" class="form-control" placeholder="Phone number" value="<?php echo old('phone', $old); ?>">
                    <?php echo form_error('phone','<span class="error">','</span>', $errors); ?>
                </div>
            </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Password</label>
                        <input name="password" type="text" class="form-control" placeholder="Password">
                        <?php echo form_error('password','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Re-Password</label>
                        <input name="password_confirm" type="text" class="form-control" placeholder="Re-Password">
                        <?php echo form_error('password_confirm','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group">
                        <label for="">State</label>
                        <select name="status" id="" class="form-control">
                            <option value="0" <?php echo old('status', $old) == 0 ? 'selected' : false ?>>Not activated</option>
                            <option value="1" <?php echo old('status', $old) == 1 ? 'selected' : false ?>>Activated</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Address</label>
                        <input name="address" type="text" class="form-control" placeholder="Address" value="<?php echo old('address', $old); ?>">
                        <?php echo form_error('fullname','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Birthday</label>
                        <input name="birth" type="date" class="form-control" placeholder="Birthday" value="<?php echo old('birth', $old); ?>">
                        <?php echo form_error('email','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Position</label>
                        <input name="permission" type="number" class="form-control" placeholder="Position" value="<?php echo old('permission', $old); ?>">
                        <?php echo form_error('phone','<span class="error">','</span>', $errors); ?>
                    </div>
                </div>
            </div>
            <br>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit" class="btn-user mg-btn btn btn-primary btn-block">Save</button>
            <a href="?modules=user_manage&action=list" type="submit" class="mg-btn btn btn-success btn-block">Back</a>
            <hr>
        </form>
    </div>

</div>


<?php
setLayout('footer_User_manage');
?>