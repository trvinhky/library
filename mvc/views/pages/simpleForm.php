<form method="post" class="productForm">
    <h3 class="text-center h3"><?=$data['title'] ?></h3>
    <div class="form-group">
        <label for="name"><?=$data['label'] ?>:</label>
        <?php 
            echo '<input type="text" class="form-control" name="'.$data['name'].'" required id="name"
            title="'.$data['text'].'"';
            if(isset($data['value'])) {
                echo ' value="'.$data['value'].'"/>';
            } else {
                echo '/>';
            }
        ?>

    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary px-5">
            <?php echo isset($data['value']) ? 'Cập Nhật' : 'Thêm' ?>
        </button>
    </div>
</form>