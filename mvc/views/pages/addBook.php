<h1 class="w-100 text-center text-info py-3">Thêm Sách</h1>
<form method="post" class="px-2 w-100">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">tên sách</span>
        </div>
        <input type="text" class="form-control" required placeholder="tên sách" aria-label="Username"
            aria-describedby="basic-addon1" name="title" />
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">năm xuất bản</span>
        </div>
        <input type="text" class="form-control" required placeholder="năm xuất bản" aria-label="Username"
            aria-describedby="basic-addon1" name="yearPublished" />
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">số trang</span>
        </div>
        <input type="text" class="form-control" required placeholder="số trang" aria-label="Username"
            aria-describedby="basic-addon1" name="pages" />
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="sle1">tên tác giả</label>
                <select name="authorId" class="form-control mb-4" id="sle1">
                    <?php 
                        if(!empty($data['authors'])) {
                            foreach($data['authors'] as $author) {
                                echo '
                                <option value="'.$author['authorId'].'">'.$author['authorName'].'</option>
                                ';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="sle2">nhà xuất bản</label>
                <select name="publisherId" class="form-control mb-4" id="sle2">
                    <?php 
                        if(!empty($data['publishers'])) {
                            foreach($data['publishers'] as $publisher) {
                                echo '
                                <option value="'.$publisher['publisherId'].'">'.$publisher['publisherName'].'</option>
                                ';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="sle3">loại</label>
                <select name="categoryId" class="form-control mb-4" id="sle3">
                    <?php 
                        if(!empty($data['categories'])) {
                            foreach($data['categories'] as $category) {
                                echo '
                                <option value="'.$category['categoryId'].'">'.$category['categoryName'].'</option>
                                ';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="sle5">chủ đề</label>
                <select name="topicId" class="form-control mb-4" id="sle5">
                    <?php 
                        if(!empty($data['topics'])) {
                            foreach($data['topics'] as $topic) {
                                echo '
                                <option value="'.$topic['topicId'].'">'.$topic['topicName'].'</option>
                                ';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">hình ảnh</span>
        </div>
        <input name="photoURL" type="text" class="form-control" required placeholder="hình ảnh" aria-label="Username"
            aria-describedby="basic-addon1" />
    </div>
    <div class="button-addbook w-100 text-center">
        <button type="submit" class="btn btn-primary px-5">thêm sách</button>
    </div>
</form>