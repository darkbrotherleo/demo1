<?php
session_start();
// Initialize variables
$verificationStatus = $_SESSION['verification_status'] ?? '';
$verificationMessage = $_SESSION['verification_message'] ?? '';
$customerName = '';
$customerPhone = '';
$customerEmail = '';
$purchaseLocation = '';
$customerProvince = '';
$customerDistrict = '';
$productCode = '';

// Clear session data after use
unset($_SESSION['verification_status']);
unset($_SESSION['verification_message']);

// Include view
include '../views/check.php';
?>