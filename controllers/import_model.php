<?php
require_once 'database.php'; // Kết nối cơ sở dữ liệu

function codeExists($code) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM activation_codes WHERE Code = :code");
    $stmt->execute(['code' => $code]);
    return $stmt->fetchColumn() > 0;
}

function batchInsert($data) {
    global $pdo;
    $sql = "INSERT INTO activation_codes (Code, SerialNumber, created_at) VALUES ";
    $values = [];
    $params = [];

    foreach ($data as $row) {
        $code = $row[0]; // Cột đầu tiên: Code
        $serialNumber = $row[1]; // Cột thứ hai: SerialNumber
        $createdAt = date('Y/m/d H:i:s'); // Thời gian hiện tại
        $values[] = "(?, ?, ?)";
        $params[] = $code;
        $params[] = $serialNumber;
        $params[] = $createdAt;
    }

    $sql .= implode(', ', $values);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return ['inserted' => count($data)];
}
?>