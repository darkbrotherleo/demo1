<?php
include '../models/database.php';

// Default values
$type = isset($_GET['type']) ? $_GET['type'] : 'all';
$rows_per_page = isset($_GET['rows_per_page']) ? intval($_GET['rows_per_page']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if ($type == 'activated') {
    $where = "WHERE IsChecked = 1";
} elseif ($type == 'nonactivated') {
    $where = "WHERE IsChecked = 0";
} else {
    $where = "";
}

// Get total rows
$query_total = "SELECT COUNT(*) FROM checkproduct $where";
$total_rows = $pdo->query($query_total)->fetchColumn();
$total_pages = ceil($total_rows / $rows_per_page);

// Get current page data
$offset = ($page - 1) * $rows_per_page;
$query = "SELECT * FROM checkproduct $where ORDER BY created_at DESC LIMIT $rows_per_page OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div>
    <div class="mb-3">
        <label for="type-select">Kiểu hiển thị:</label>
        <select id="type-select" class="form-select">
            <option value="all" <?php echo $type == 'all' ? 'selected' : ''; ?>>Toàn bộ code</option>
            <option value="activated" <?php echo $type == 'activated' ? 'selected' : ''; ?>>Mã đã kích hoạt</option>
            <option value="nonactivated" <?php echo $type == 'nonactivated' ? 'selected' : ''; ?>>Mã chưa kích hoạt</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="rows-per-page">Số dòng mỗi trang:</label>
        <select id="rows-per-page" class="form-select">
            <option value="10" <?php echo $rows_per_page == 10 ? 'selected' : ''; ?>>10</option>
            <option value="20" <?php echo $rows_per_page == 20 ? 'selected' : ''; ?>>20</option>
            <option value="30" <?php echo $rows_per_page == 30 ? 'selected' : ''; ?>>30</option>
        </select>
    </div>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã Kích Hoạt</th>
                <th>Số Seri</th>
                <th>Tên Khách</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Nơi Mua</th>
                <th>Tỉnh/Thành Cư Trú</th>
                <th>Quận/Huyện Cư Trú</th>
                <th>Trạng Thái</th>
                <th>IP Kiểm Tra</th>
                <th>Thời Gian Kiểm Tra</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Code']); ?></td>
                <td><?php echo htmlspecialchars($row['SerialNumber']); ?></td>
                <td><?php echo htmlspecialchars($row['CustomerName']); ?></td>
                <td><?php echo htmlspecialchars($row['PhoneNumber']); ?></td>
                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                <td><?php echo htmlspecialchars($row['PurchaseLocation']); ?></td>
                <td><?php echo htmlspecialchars($row['CityProvince']); ?></td>
                <td><?php echo htmlspecialchars($row['DistrictProvide']); ?></td>
                <td><?php echo $row['IsChecked'] ? 'Yes' : 'No'; ?></td>
                <td><?php echo htmlspecialchars($row['CheckIP']); ?></td>
                <td><?php echo htmlspecialchars($row['CheckTime']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $range = 2;

    echo '<ul class="pagination">';
    if ($current_page > 1) {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="1"><<</a></li>';
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($current_page - 1) . '"><</a></li>';
    }

    for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
        echo '<li class="page-item ' . ($i == $current_page ? 'active' : '') . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
    }

    if ($current_page + $range < $total_pages) {
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
    }

    if ($current_page < $total_pages) {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . ($current_page + 1) . '">></a></li>';
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">>></a></li>';
    }
    echo '</ul>';
?>
    <div class="mt-3">
        <a href="./includes/download_all.php" class="btn btn-primary">Download All Code</a>
        <a href="./includes/download_activated.php" class="btn btn-success">Download Activate Code</a>
        <a href="./includes/download_nonactivated.php" class="btn btn-warning">Download Inactivate Code</a>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#type-select, #rows-per-page').change(function() {
        var type = $('#type-select').val();
        var rows_per_page = $('#rows-per-page').val();
        loadTabContent(type, rows_per_page, 1);
    });

    $('.pagination a').click(function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        var type = $('#type-select').val();
        var rows_per_page = $('#rows-per-page').val();
        loadTabContent(type, rows_per_page, page);
    });

    function loadTabContent(type, rows_per_page, page) {
        $.ajax({
            url: 'ajax/overview.php',
            type: 'GET',
            data: { type: type, rows_per_page: rows_per_page, page: page },
            success: function(data) {
                $('#tab-content').html(data);
            },
            error: function() {
                $('#tab-content').html('<p>Lỗi khi tải dữ liệu.</p>');
            }
        });
    }
});
</script>