<div class="container">
    <h2>Import Mã Kích Hoạt</h2>
    <ul class="nav nav-tabs" id="importTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="new-tab" data-bs-toggle="tab" href="#new" role="tab">Import Mã Mới</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="update-tab" data-bs-toggle="tab" href="#update" role="tab">Update Mã Kích Hoạt</a>
        </li>
    </ul>
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="new" role="tabpanel">
            <h3>Import Mã Mới</h3>
            <p>Form hoặc nội dung cho Import Mã Mới sẽ được thêm vào đây.</p>
            <form action="./controllers/import_controller.php" method="post" enctype="multipart/form-data">
                <label for="file">Chọn file CSV:</label>
                <input type="file" class="form-control" name="file" id="file" accept=".csv" required>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <a href="./uploads/template/Template_CSV_Import_Code_HPS.csv" class="btn btn-info">Tải File Import</a>
                </div>
            </form>
            <!-- Có thể thêm form upload file ở đây nếu cần -->
        </div>
        <div class="tab-pane fade" id="update" role="tabpanel">
            <h3>Update Mã Kích Hoạt</h3>
            <p>Form hoặc nội dung cho Update Mã Kích Hoạt sẽ được thêm vào đây.</p>
            <!-- Có thể thêm form upload file ở đây nếu cần -->
        </div>
    </div>
</div>