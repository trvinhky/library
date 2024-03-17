<?php 
    $book = $data['book'];
?>

<h1 class="w-100 text-center text-info py-3">Cập Nhật Sách</h1>
<form method="post" class="px-2 w-100">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">tên sách</span>
        </div>
        <input type="text" class="form-control" required placeholder="tên sách" aria-label="Username"
            aria-describedby="basic-addon1" name="title" value="<?=$book['title'] ?>" />
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">năm xuất bản</span>
        </div>
        <input type="text" class="form-control" required placeholder="năm xuất bản" aria-label="Username"
            aria-describedby="basic-addon1" name="yearPublished" value="<?=$book['yearPublished'] ?>" />
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">số trang</span>
        </div>
        <input type="text" class="form-control" required placeholder="số trang" aria-label="Username"
            aria-describedby="basic-addon1" name="pages" value="<?=$book['pages'] ?>" />
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="sle1">tên tác giả</label>
                <select name="authorId" class="form-control mb-4" id="sle1">
                    <?php 
                        if(!empty($data['authors'])) {
                            foreach($data['authors'] as $author) {
                                $param = '';
                                if($author['authorId'] == $book['authorId']) {
                                    $param .= "selected";
                                }
                                echo '
                                <option value="'.$author['authorId'].'" '.$param.'>'.$author['authorName'].'</option>
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
                                $param = '';
                                if($publisher['publisherId'] == $book['publisherId']) {
                                    $param .= "selected";
                                }
                                echo '
                                <option value="'.$publisher['publisherId'].'" '.$param.'>'.$publisher['publisherName'].'</option>
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
                                $param = '';
                                if($category['categoryId'] == $book['categoryId']) {
                                    $param .= "selected";
                                }
                                echo '
                                <option value="'.$category['categoryId'].'" '.$param.'>'.$category['categoryName'].'</option>
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
                                $param = '';
                                if($topic['topicId'] == $book['topicId']) {
                                    $param .= "selected";
                                }
                                echo '
                                <option value="'.$topic['topicId'].'" '.$param.'>'.$topic['topicName'].'</option>
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
            aria-describedby="basic-addon1" value="<?=$book['photoURL'] ?>" />
    </div>
    <div class="button-addbook w-100 text-center">
        <button type="submit" class="btn btn-primary px-5">cập nhật sách</button>
    </div>
</form>