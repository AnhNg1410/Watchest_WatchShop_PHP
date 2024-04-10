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
isPermission(1);
?>

<?php
if(isPost()) {
    // print_r($_FILES);
    // echo "<br>";
    // print_r($_POST);
    // die();
    $filterAll = filter();
    $error = [];

    if(empty($filterAll['product_code'])) {
        $error['product_code']['require'] = 'Product code cannot be empty';
    } else {
        $product_code = $filterAll['product_code'];
        $sql = "SELECT product_code FROM products WHERE product_code = '$product_code'";
        if(getRowCSDL($sql) > 0) {
        $error['product_code']['unique'] = 'Product already exist';
        }
    }
    if(empty($filterAll['product_name'])) {
        $error['product_name']['require'] = 'Product name cannot be empty';
    }
    if(($filterAll['quantity'])<0) {
        $error['quantity']['require'] = 'Quantity must be greater than or equal to 0';
    }

    $file = $_FILES["fileToUpload"]["tmp_name"];
    $data = file_get_contents($file);
    $type = $_FILES["fileToUpload"]["type"];
    $image_token = sha1(uniqid().time());
    $kq = insertImgCSDL($data, $type, $image_token);
    if($kq == 0) {
        $error['image']['error'] = 'Error upload file';
    }

    if(empty($error)) {
        $image_id = getOneRawCSDL("SELECT image_id FROM images WHERE image_token = '$image_token'")['image_id'];
        $dataInsert = [
            'product_code' => $filterAll['product_code'],
            'product_name' => $filterAll['product_name'],
            'quantity' => $filterAll['quantity'],
            'import_price' => $filterAll['import_price'],
            'tax' => $filterAll['tax'],
            'price' => $filterAll['price'],
            'image_id' => $image_id,
            'active' => $filterAll['active'],
            'import_at' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insertCSDL('products', $dataInsert);
        if($insertStatus) {
            setFlashData('smg', 'Successfully addition');
            setFlashData('smg_type', 'success');
            redirect('?modules=product_manage&action=list');
        } else {
            setFlashData('smg', 'System error');
            setFlashData('smg_type', 'danger');
            redirect('?modules=product_manage&action=add');
        }
    } else {
        setFlashData('smg', 'Please verify the data again!');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $error);
        setFlashData('old', $filterAll);
        redirect('?modules=product_manage&action=add');
    }
}
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<?php
setLayout('header_Product_manage');
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
    <div class="row"> 
        <h1 clas="text-center">Product addition</h1>
        <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Product code</label>
                        <input name="product_code" type="text" class="form-control" placeholder="Product code" value="<?php echo old('product_code', $old); ?>">
                        <?php echo form_error('product_code','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Product name</label>
                        <input name="product_name" type="text" class="form-control" placeholder="Product name" value="<?php echo old('product_name', $old); ?>">
                        <?php echo form_error('product_name','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input name="quantity" type="text" class="form-control" placeholder="Quantity" value="<?php echo old('quantity', $old); ?>">
                        <?php echo form_error('quantity','<span class="error">','</span>', $errors); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Import pirce</label>
                        <input name="import_price" type="decimal" class="form-control" placeholder="Import_price" value="<?php echo old('import_price', $old); ?>">
                        <?php echo form_error('import_price','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Tax</label>
                        <input name="tax" type="decimal" class="form-control" placeholder="Tax" value="<?php echo old('tax', $old); ?>">
                        <?php echo form_error('tax','<span class="error">','</span>', $errors); ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Price</label>
                        <input name="price" type="decimal" class="form-control" placeholder="Price" value="<?php echo old('price', $old); ?>">
                        <?php echo form_error('price','<span class="error">','</span>', $errors); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Active</label>
                        <select name="active" id="" class="form-control">
                            <option value="0" <?php echo old('active', $old) == 0 ? 'selected' : false ?>>Activated</option>
                            <option value="1" <?php echo old('active', $old) == 1 ? 'selected' : false ?>>Not activated</option>
                        </select>
                    </div>
                    <div class="form-group mg-form">
                        Select image to upload: 
                        <input type="file" accept=".jpg, .jpeg, .png, .gif, .webp" name="fileToUpload" id="fileToUpload" style="margin-top: 5px;">
                        <!-- <br> -->
                        <!-- <input type="submit" name="uploadImage" class="btn btn-success" style="margin-top: 10px;" placeholder="Upload image" value="Upload image"> -->
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px;">
                <button type="submit" class="btn-user mg-btn btn btn-primary btn-block">Add</button>
                <a href="?modules=product_manage&action=list" type="submit" class="mg-btn btn btn-success btn-block">Back</a>
            </div>
        </form>
    </div>
</div>
<?php
setLayout('footer_Product_manage');
?>