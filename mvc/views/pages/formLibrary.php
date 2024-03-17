<form method="post" class="productForm" enctype="application/x-www-form-urlencoded">
    <h3 class="text-center h3"><?=$data['subTitle'] ?></h3>
    <div class="form-group">
        <label for="libraryName">Tên Thư Viện:</label>
        <?php 
        echo '
            <input type="text" class="form-control" name="libraryName" required title="Nhập vào tên thư viện"
            id="libraryName"
        ';
            if(isset($data['values'])) {
                echo ' value="'.$data['values']['libraryName'].'" />';
            } else {
                echo '/>';
            }
        ?>
    </div>
    <div class="form-group">
        <label for="libraryLocation">Vị Trí Thư Viện:</label>
        <?php 
        echo '
        <input type="text" class="form-control" name="libraryLocation" required
        title="Nhập vào vị trí thư viện" name="libraryLocation" id="libraryLocation"
        ';
            if(isset($data['values'])) {
                echo ' value="'.$data['values']['libraryLocation'].'" />';
            } else {
                echo '/>';
            }
        ?>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-5">
            <?php echo isset($data['values']) ? 'Cập Nhật' : 'Thêm' ?>
        </button>
    </div>
</form>