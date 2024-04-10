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
if(isPost()) {
    $filterAll = filter();
    $error = [];

    if(empty($filterAll['fullname'])) {
        $error['fullname']['require'] = 'Ho ten khong duoc de trong';
    } else {
        if(strlen($filterAll['fullname']) < 5) {
            $error['fullname']['min'] = 'Ho ten phai co it nhat 5 ki tu';
        }
    }
    if(empty($filterAll['email'])) {
        $error['email']['require'] = 'Email khong duoc de trong';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email'";
        if(getRowCSDL($sql) > 0) {
        $error['email']['unique'] = 'Email da ton tai';
        }
    }
    if(empty($filterAll['phone'])) {
        $error['phone']['require'] = 'SDT khong duoc de trong';
    } else {
        if(!isPhone($filterAll['phone'])) {
            $error['phone']['isPhone'] = 'SDT khong hop le';
        }
    }
    if(empty($filterAll['password'])) {
        $error['password']['require'] = 'Mat khau khong duoc de trong';
    } else {
        if(strlen($filterAll['password']) < 8) {
            $error['password']['min'] = 'Mat khau phai lon hon 8 ki tu';
        }
    }
    if(empty($filterAll['password_confirm'])) {
        $error['password_confirm']['require'] = 'Mat khau khong duoc de trong';
    } else {
        if($filterAll['password_confirm'] != $filterAll['password']) {
            $error['password_confirm']['min'] = 'Mat khau phai giong nhau';
        }
    }

    if(empty($error)) {
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'status' => $filterAll['status'],
            'create_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insertCSDL('users', $dataInsert);

        if($insertStatus) {
            setFlashData('smg', 'Dang ki thanh cong, kiem tra email de kich hoat tai khoan');
            setFlashData('smg_type', 'success');
            redirect('?modules=users&action=list');
        } else {
            setFlashData('smg', 'Loi he thong');
            setFlashData('smg_type', 'danger');
            redirect('?modules=users&action=add');
        }
    } else {
        setFlashData('smg', 'Vui long kiem tra lai du lieu!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
        redirect('?modules=users&action=add');
    }
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<?php
layout('header-login');
?>

<div class="container">
    <div class="row" style="margin: 50px auto;"> 
        <h1 clas="text-center">Them nguoi dung</h1>
        <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group mg-form">
                    <label for="">Ho ten</label>
                    <input name="fullname" type="text" class="form-control" placeholder="Ho ten" value="<?php echo old('fullname', $old); ?>">
                    <?php echo form_error('fullname','<span class="error">','</span>', $errors); ?>
                </div>
                <div class="form-group mg-form">
                    <label for="">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="Dia chi email" value="<?php echo old('email', $old); ?>">
                    <?php echo form_error('email','<span class="error">','</span>', $errors); ?>
                </div>
                <div class="form-group mg-form">
                    <label for="">So dien thoai</label>
                    <input name="phone" type="number" class="form-control" placeholder="So dien thoai" value="<?php echo old('phone', $old); ?>">
                    <?php echo form_error('phone','<span class="error">','</span>', $errors); ?>
                </div>
            </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Password</label>
                        <input name="password" type="text" class="form-control" placeholder="Mat khau" value="<?php echo old('password', $old); ?>">
                        <?php echo form_error('password','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Nhap lai Password</label>
                        <input name="password_confirm" type="text" class="form-control" placeholder="Mat khau" value="<?php echo old('password_confirm', $old); ?>">
                        <?php echo form_error('password_confirm','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group">
                        <label for="">Trang thai</label>
                        <select name="status" id="" class="form-control">
                            <option value="0" <?php echo old('status', $old) == 0 ? 'selected' : false ?>>Activated</option>
                            <option value="1" <?php echo old('status', $old) == 1 ? 'selected' : false ?>>Not activated</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-user mg-btn btn btn-primary btn-block">Them</button>
            <a href="?modules=users&action=list" type="submit" class="mg-btn btn btn-success btn-block">Quay lai</a>
            <hr>
        </form>
    </div>

</div>


<?php
layout('footer-login');
?>