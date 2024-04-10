<?php
//Kiem tra truy cap hop le
if(!defined('_ACCESS_CODE')) {
    die("Access denied! ...");
}
?>

<?php
function queryCSDL($sql, $data=[], $check = false) {
    global $con;
    $ketqua = false;
    try {
        $statement = $con->prepare($sql);
        if(!empty($data)) {
            $ketqua = $statement->execute($data);
        } else {
            $ketqua = $statement->execute();
        }
    } catch (Exception $exception) {
        echo "". $exception->getMessage() ."<br>";
        echo "File: ". $exception->getFile()."<br>";
        echo "Line: ". $exception->getLine()."<br>";
        die();
    }
    if($check) { return $statement; }
    return $ketqua;
}
function insertCSDL($table, $data) {
    $key = array_keys($data);
    $truong = implode(',', $key);
    $valuetb = ':'. implode(',:', $key);

    $sql = 'INSERT INTO '. $table. ' ( '. $truong. ' ) '. 'VALUES ( '. $valuetb. ' ) ';
    $kq = queryCSDL($sql, $data);
    return $kq;
}

function insertImgCSDL($data, $type, $token) {
    global $con;
    $ketqua = false;
    try {
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Lấy thông tin về file tải lên
        // $file = $_FILES["fileToUpload"]["tmp_name"];
        // $content = file_get_contents($file);
        // $type = $_FILES["fileToUpload"]["type"];
        // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào cơ sở dữ liệu
        $statement = $con->prepare("INSERT INTO images (image_data, image_type, image_token) VALUES (:image_data, :image_type, :image_token)");
        $statement->bindParam(":image_data", $data, PDO::PARAM_LOB);
        $statement->bindParam(":image_type", $type);
        $statement->bindParam(":image_token", $token);
        // Thực thi câu lệnh SQL
        $ketqua = $statement->execute();
    } catch (Exception $exception) {
        echo "". $exception->getMessage() ."<br>";
        echo "File: ". $exception->getFile()."<br>";
        echo "Line: ". $exception->getLine()."<br>";
        die();
    }
    return $ketqua;
}

function getImgCSDL($image_id) {
    global $con;
    try {
        // Kết nối đến cơ sở dữ liệu
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $con->prepare("SELECT image_data, image_type FROM images WHERE image_id = :image_id");
        $stmt->bindParam(":image_id", $image_id); // Gán giá trị của imageId vào tham số :imageId
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($image) {
            // Trả về dữ liệu hình ảnh dưới dạng base64
            return "data:" . $image['image_type'] . ";base64," . base64_encode($image['image_data']);
        } else {
            return ""; // Trả về chuỗi rỗng nếu không có dữ liệu hình ảnh
        }
    } catch (Exception $exception) {
        echo "". $exception->getMessage() ."<br>";
        echo "File: ". $exception->getFile()."<br>";
        echo "Line: ". $exception->getLine()."<br>";
        die();
    }
}
function getImgCSDLHtml($image_id) {
    global $con;
    try {
        // Kết nối đến cơ sở dữ liệu
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $con->prepare("SELECT image_data, image_type FROM images WHERE image_id = :image_id");
        $stmt->bindParam(":image_id", $image_id); // Gán giá trị của imageId vào tham số :imageId
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        // Thiết lập tiêu đề và loại nội dung của phản hồi HTTP
        header("Content-Type: " . $image['image_type']);
        // Xuất dữ liệu hình ảnh ra phản hồi HTTP
        echo $image['image_data'];
    } catch (Exception $exception) {
        echo "". $exception->getMessage() ."<br>";
        echo "File: ". $exception->getFile()."<br>";
        echo "Line: ". $exception->getLine()."<br>";
        die();
    }
}

function updateCSDL($table, $data, $condition='') {
    $update = '';
    foreach ($data as $key => $value) {
        $update .= $key .'= :'. $key. ',';
    }
    $update = trim( $update,',');
    if(!empty($condition)) {
        $sql = 'UPDATE '. $table. ' SET '. $update. ' WHERE '. $condition;
    } else {
        $sql = 'UPDATE '. $table. ' SET '. $update;
    }
    $kq = queryCSDL($sql, $data);
    return $kq;
}

function deleteCSDL($table, $condition= '') {
    if(!empty($condition)) {
        $sql = 'DELETE FROM '. $table. ' WHERE '. $condition;
    } else {
        $sql = 'DELETE FROM '. $table;
    }
    $kq = queryCSDL($sql);
    return $kq;
}

function getRawCSDL($sql) {
    $kq = queryCSDL($sql,'', true);
    if(is_object( $kq )) {
        $dataFetch = $kq->fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}
function getOneRawCSDL($sql) {
    $kq = queryCSDL($sql,'', true);
    if(is_object($kq)) {
        $dataFetch = $kq->fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

function getRowCSDL($sql) {
    $kq = queryCSDL($sql,'', true);
    if(!empty($kq)) {
        return $kq->rowCount();
    }
}
?>
