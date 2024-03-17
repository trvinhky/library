<form method="post" class="productForm">
    <h3 class="text-center h3">
        Chọn Tên Thư Viện
    </h3>
    <div class="form-group">
        <label for="name">Tên Thư Viện:</label>
        <select name="libraryId" class="form-control mb-4" id="name">
            <?php 
                if(!empty($data['libraries'])) {
                    foreach($data['libraries'] as $library) {
                        echo '
                        <option value="'.$library['libraryId'].'">'.$library['libraryName'].'</option>
                        ';
                    }
                }
            ?>
        </select>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-5">
            Chọn
        </button>
    </div>
</form>