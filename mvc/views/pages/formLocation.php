<form method="post" class="productForm" enctype="application/x-www-form-urlencoded">
    <h3 class="text-center h3 pb-3"><?=$data['subTitle'] ?></h3>
    <div class="form-group">
        <label for="bookshelfId">Vị Trí Kệ Sách:</label>
        <select <?php echo !isset($data['values']) ? "name='bookshelfId'" : "readonly" ?> class="form-control mb-4"
            id="name">
            <?php 
                if(!empty($data['bookshelfs'])) {
                    foreach($data['bookshelfs'] as $bookshelf) {
                        $param = "";
                        if(isset($data['values']) && $bookshelf['bookshelfId'] == $data['values']['bookshelfId']) {
                            $param = "selected";
                        }
                        echo '
                        <option value="'.$bookshelf['bookshelfId'].'" '.$param.'>'.$bookshelf['bookshelfLocation'].'</option>
                        ';
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="quantity">Số Lượng:</label>
        <?php 
        echo '
        <input type="text" class="form-control" name="quantity" required
        title="Nhập vào số lượng sách" name="quantity" id="quantity"
        ';
            if(isset($data['values'])) {
                echo ' value="'.$data['values']['quantity'].'" />';
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