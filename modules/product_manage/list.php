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

$listProduct = getRawCSDL("SELECT * FROM products ORDER BY product_code");
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
?>

<?php
setLayout("header_Product_manage");
?>
<style>
    body {
        background-color: rgb(200, 200, 200);
    }
</style>
<div class="container-xxl onTop">
    <a href="?modules=home&action=dashboard" class="btn btn-primary btn-sm onTopButton">Home</a>
</div>
<div class="container-xxl">
    <hr>
    <h2>Inventory management</h2>
    <p>
        <a href="?modules=product_manage&action=add" class="btn btn-success btn-sm">Inventory Addition <i class="fa-solid fa-plus"></i></a>
    </p>
    <?php
        if(!empty($smg)) {
            getSmg($smg, $smg_type);
        }
    ?>
    <table class="table table-bordered" style="font-size: 17px;">
        <thead>
            <th>Odr</th>
            <th>Code</th>
            <th>Name</th>
            <th>Import Price</th>
            <th>Tax</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Active</th>
            <th>Image</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </thead>
        <tbody>
        <?php
        if (!empty($listProduct)):
            $count = 0;
            foreach ($listProduct as $product):
                $count++;
        ?>
            <tr>
                <td style="width: 5px;"><?php echo $count; ?></td>
                <td style="width: 100px;"><?php echo $product['product_code']; ?></td>
                <td style="width: 120px;"><?php echo $product['product_name']; ?></td>
                <td style="width: 30px;"><?php echo $product['import_price']; ?></td>
                <td style="width: 30px;"><?php echo $product['tax']; ?></td>
                <td style="width: 30px;"><?php echo $product['price'] ?></td>
                <td style="width: 30px;"><?php echo $product['quantity']; ?></td>
                <td style="width: 20px;"><?php echo $product['active'] == 1 ? '<btn class="btn btn-success btn-sm">Activated</button>' : '<btn class="btn btn-danger btn-sm">Not activated</button>'; ?></td>
                <td style="width: 100px; height: 50px;">
                    <div style="width: 0px; height: 70px; margin-top: 0; margin-bottom: 0; margin-right: 0; margin-left: 0;">
                        <?php $image_id = $product['image_id']; ?>
                        <?php $image_data = getImgCSDL($image_id); ?>
                        <?php if ($image_data): ?>
                            <a href="?modules=product_manage&action=productImageHtml&image_id=<?php echo $image_id ?>"><img src="<?php echo $image_data; ?>" alt="" style="width: 150px; height: 70px;"></a>
                        <?php endif; ?>
                    </div>
                </td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=product_manage&action=edit&product_id=<?php echo $product['product_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <td><a href="<?php echo _WEB_HOST; ?>?modules=product_manage&action=delete&product_id=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            <?php
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="10">
                        <div class="alert alert-danger text-center">Empty inventory</div>
                    </td>
                </tr>
            <?php
                endif;
            ?>
        </tbody>
    </table>
</div>
<?php
setLayout("footer_Product_manage");
?>