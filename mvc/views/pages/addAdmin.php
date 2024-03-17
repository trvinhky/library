<form method="post" class="productForm">
    <h3 class="text-center h3">Add Admin</h3>
    <div class="form-group">
        <label for="adminName">Tên:</label>
        <input type="text" class="form-control" name="adminName" id="adminName" required title="Nhập vào adminName" />
    </div>
    <div class="form-group">
        <label for="adminEmail">Email:</label>
        <input type="text" class="form-control" name="adminEmail" required title="Nhập vào adminEmail"
            id="adminEmail" />
    </div>
    <div class="form-group">
        <label for="adminPassword">Mật Khẩu:</label>
        <input type="password" class="form-control" name="adminPassword" required title="Nhập vào adminPassword"
            id="adminPassword" />
    </div>
    <div class="form-group">
        <label for="adminPhone">Số Điện Thoại:</label>
        <input type="text" class="form-control" required name="adminPhone" title="Nhập vào adminPhone"
            id="adminPhone" />
    </div>
    <div class="form-group">
        <label for="adminAddress">Địa Chỉ:</label>
        <input type="text" class="form-control" id="adminAddress" name="adminAddress" required
            title="Nhập vào adminAddress" />
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-5">Thêm</button>
    </div>
</form>