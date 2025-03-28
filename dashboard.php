<?php
session_start();
// Kiểm tra quyền truy cập admin (giả định)
//if (!isset($_SESSION['admin_logged_in'])) {
//    header("Location: login.php");
//    exit();
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Quản lý hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
</head>
<body>
    <header>
    <?php include './includes/admin_header.php'; ?>
    </header>
    <main>
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar with Tabs -->
            <div class="col-md-2">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" data-tab="overview">Quản Lý Mã Kích Hoạt</a>
                    <a href="#" class="list-group-item list-group-item-action" data-tab="import_activation">Import Mã Kích Hoạt</a>
                    <a href="#" class="list-group-item list-group-item-action" data-tab="users">Quản Lý Thành Viên</a>
                    <a href="#" class="list-group-item list-group-item-action" data-tab="settings">Cài Đặt</a>
                </div>
            </div>
            <!-- Tab Content -->
            <div class="col-md-10">
                <div id="tab-content" class="card p-4">
                    <!-- Nội dung tab sẽ được load bằng AJAX -->
                </div>
            </div>
        </div>
    </div>
    </main>
    <footer>
        <?php include './includes/admin_footer.php'; ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/dashboard.js"></script>
</body>
</html>