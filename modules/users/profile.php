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
?>

<?php
$userDetail = getUserLogin();
$firstSpacePos = strpos($userDetail['fullname'], ' '); // Tìm vị trí của dấu cách đầu tiên trong chuỗi
if ($firstSpacePos !== false) {
    $fisrtName = strstr($userDetail['fullname'], ' ', true); // Lấy phần tử từ đầu đến vị trí dấu cách đầu tiên
    $lastName = substr(strstr($userDetail['fullname'], ' '), 1); // Lấy phần tử từ vị trí dấu cách đầu tiên đến hết chuỗi
} else {}
$errorOnTop = [];
if(empty($userDetail['address'])) {
    $errorOnTop['address']['required'] = "   ( *Please enter your address )";
}
if(empty($userDetail["phone"])) {
    $errorOnTop['phone']['required'] = "   ( *Please enter your phone number )";
}
$birth = $userDetail['birth'];

if(isPost()) {
    $user_id = getUserLogin()['user_id'];
    $filterAll = filter();
    $error = [];
    if(empty($filterAll['fisrtName'])) {
        $error['fisrtName']['require'] = 'First name cannot be empty';
    } else {
        if(strlen($filterAll['fisrtName']) < 2) {
            $error['fisrtName']['min'] = 'First name must be at least 2 characters long';
        }
    }
    if(empty($filterAll['lastName'])) {
        $error['lastName']['require'] = 'Last name cannot be empty';
    } else {
        if(strlen($filterAll['lastName']) < 3) {
            $error['lastName']['min'] = 'Last name must be at least 3 characters long';
        }
    }
    if(!empty($filterAll['phone'])) {
        if(!isPhone($filterAll['phone'])) {
            $error['phone']['format'] = 'The phone number is invalid';
        }
    }
    if(empty($error)) {
        $fullname = test_input($filterAll['fisrtName'])." ".test_input($filterAll['lastName']);
        $address = test_input($filterAll['address']);
        $phone = test_input($filterAll['phone']);
        $birth = test_input($filterAll['birth']);
        $activeToken = sha1(uniqid().time());
        $dataInsert = [
            'fullname' => $fullname,
            'address' => $address,
            'phone' => $phone,
            'birth' => $birth,
            'update_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = updateCSDL('users', $dataInsert, "user_id = '$user_id'");
        if($insertStatus) {
            setFlashData('smg', 'Information updated successfully');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'The system encountered an issue');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Please verify the data again!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
    }
    redirect('?modules=users&action=profile');
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<?php
    setLayout("header_Profile");
?>
<?php
if(!empty($smg)) {
    getSmg($smg, $smg_type);
}
?>
<div class="container-xl px-4 mt-4">
<!-- Account page navigation-->
    <nav id="navBar" class="nav nav-borders">
        <a class="nav-link active ms-0" href="?modules=users&action=profile" >Profile</a>
        <a class="nav-link" href="?modules=users&action=billing" >Billing</a>
        <a class="nav-link" href="?modules=users&action=security" >Security</a>
        <a class="nav-link" href="?modules=users&action=notifycation" >Notifications</a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link" href="" ></a>
        <a class="nav-link nav-link-home" href="?modules=home&action=dashboard">Home</a>
    </nav>
    <hr class="mt-0 mb-4">
</div>
<div class="container-xl px-4 mt-4">
    
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button">Upload new image</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details
                <?php if(!empty($errorOnTop['address'])) { echo form_error('address','<span class="errorDetail">','</span>', $errorOnTop); } else { echo form_error('phone','<span class="errorDetail">','</span>', $errorOnTop); } ?>
                </div> 
                <div class="card-body">
                    <form action="" method="post">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="<?php echo $userDetail['fullname'] ?>" readonly>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">First name</label>
                                <input class="form-control" id="inputFirstName" type="text" name="fisrtName" placeholder="Enter your first name" value="<?php echo $fisrtName ?>">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Last name</label>
                                <input class="form-control" id="inputLastName" type="text" name="lastName" placeholder="Enter your last name" value="<?php echo $lastName ?>">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <!-- <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Organization name</label>
                                <input class="form-control" id="inputOrgName" type="text" placeholder="Enter your organization name" value="Start Bootstrap">
                            </div> -->
                            <!-- Form Group (location)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="inputLocation">Address</label>
                                <input class="form-control" id="inputLocation" type="text" name="address" placeholder="Enter your address" value="<?php echo $userDetail['address']; ?>">
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                            <input class="form-control" id="inputEmailAddress" type="email" name="email" placeholder="Enter your email address" value="<?php echo $userDetail['email']; ?>" readonly>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                <input class="form-control" id="inputPhone" type="tel" name="phone" placeholder="Enter your phone number" value="<?php echo $userDetail['phone']; ?>">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input class="form-control" id="inputBirthday" type="date" name="birth" placeholder="Enter your birthday" value="<?php echo date($birth); ?>">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    setLayout("footer_Profile");
?>