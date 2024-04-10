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

$listUsers= getRawCSDL("SELECT * FROM users ORDER BY update_at");
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<?php
setLayout("header_User_manage");
?>
<style>
    body {
        background-color: rgb(200, 200, 200);
    }
</style>
<div class="container onTop">
    <a href="?modules=home&action=dashboard" class="btn btn-primary btn-sm onTopButton">Home</a>
</div>
<div class="container">
    <hr>
    <h2>User management</h2>
    <!-- <p>
        <a href="?modules=users&action=add" class="btn btn-success btn-sm">Them nguoi dung <i class="fa-solid fa-plus"></i></a>
    </p> -->
    <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
    ?>
    <table class="table table-bordered">
        <thead>
            <th>Order</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Position</th>
            <th>State</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
        <?php
        if(!empty($listUsers)):
            $count = 0;
            foreach($listUsers as $user):
                $count++;
        ?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $user['fullname']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td><?php echo $user['permission']; ?></td>
                <td><?php echo $user['status'] == 1 ? '<btn class="btn btn-success btn-sm">Activated</button>' : '<btn class="btn btn-danger btn-sm">Not activated</button>'; ?></td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=user_manage&action=edit&user_id=<?php echo $user['user_id']; ?>" class="btn btn-warning-btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=user_manage&action=delete&user_id=<?php echo $user['user_id']; ?>" onclick = "return confirm('Are you sure you want to delete <?php echo $user['fullname'] ?>?')" class="btn btn-danger-btn-sm"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
        <?php
                endforeach;
            else:
        ?>
        <tr>
            <td colspan="7">
                <div class="alert alert-danger text-center">Khong co nguoi dung</div>
            </td>
        </tr>
        <?php
            endif;
        ?>
        </tbody>
    </table>
</div>

<?php
setLayout("footer_User_manage");
?>