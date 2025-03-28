<?php
include './models/database.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="nonactivated_codes.csv"');

$output = fopen('php://output', 'w');
// Thêm BOM cho UTF-8
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
$query = "SELECT * FROM checkproduct WHERE IsChecked = 0";
$stmt = $pdo->prepare($query);
$stmt->execute();

$fp = fopen('php://output', 'w');
fputcsv($fp, array('Code', 'SerialNumber', 'CustomerName', 'PhoneNumber', 'Email', 'PurchaseLocation', 'CityProvince', 'IsChecked', 'CheckIP', 'CheckTime', 'created_at', 'updated_at', 'DistrictProvide', 'updated_at'));

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($fp, $row);
}

fclose($fp);
?>