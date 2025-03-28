<?php
require_once './models/database.php';

if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $file = $_FILES['file']['tmp_name'];
    $handle = fopen($file, "r");

    // Bỏ qua hai dòng đầu tiên (tên cột cơ sở dữ liệu và tiêu đề thân thiện)
    fgetcsv($handle);
    fgetcsv($handle);

    $data = [];
    $duplicates = 0;
    $batchSize = 1000; // Kích thước lô: 1000 dòng mỗi lần chèn
    $inserted = 0;

    while (($row = fgetcsv($handle)) !== false) {
        $code = $row[0]; // Giả sử cột đầu tiên là "Code"
        if (!codeExists($code)) {
            $data[] = $row;
            if (count($data) == $batchSize) {
                $result = batchInsert($data);
                $inserted += $result['inserted'];
                $data = []; // Xóa dữ liệu sau khi chèn
            }
        } else {
            $duplicates++;
        }
    }

    // Chèn dữ liệu còn lại (nếu có)
    if (!empty($data)) {
        $result = batchInsert($data);
        $inserted += $result['inserted'];
    }

    fclose($handle);

    // Báo cáo kết quả
    echo "Đã import thành công $inserted dòng dữ liệu.<br>";
    echo "Số dòng trùng lặp: $duplicates.<br>";
} else {
    echo "Lỗi upload file.";
}
?>