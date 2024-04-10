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
isPermission(0);
?>
<?php
$conn = new PDO("mysql:host=localhost;dbname=watchest", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$image_id = $_GET['image_id'];
$stmt = $conn->prepare("SELECT image_data, image_type FROM images WHERE image_id = :imageId");
$stmt->bindParam(":imageId", $image_id); // Gán giá trị của imageId vào tham số :imageId
$kq = $stmt->execute();
$image = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($image);

// Thiết lập tiêu đề và loại nội dung của phản hồi HTTP
header("Content-Type: " . $image['image_type']);

// Xuất dữ liệu hình ảnh ra phản hồi HTTP
echo $image['image_data'];
?>