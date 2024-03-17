<h1 class="text-center pt-3">Quản lý sách</h1>
<div class="d-flex justify-content-end py-4 mr-2">
    <a href="/admin/addBook" class="btn btn-primary px-5" style="font-size: 20px;"><i class="fa-solid fa-plus"></i></a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên sách</th>
            <th scope="col">Tác Giả</th>
            <th scope="col">Số Lượng</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($data['books'])) {
            foreach($data['books'] as $key => $book) {
                echo '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td>
                        <p class="card-title">'.$book['title'].'</p>
                    </td>
                    <td>
                        <p>'.$book['authorName'].'</p>
                    </td>
                    <td>'.$book['quantity'].'</td>
                    <td>
                        <div class="d-flex">
                            <a href="/home/detail/'.$book['bookId'].'" class="btn btn-primary mr-1">Chi Tiết</a>
                            <a href="/admin/editBook/'.$book['bookId'].'" class="btn btn-secondary mr-1">Cập Nhật</a>
                            <a href="/admin/locations/'.$book['bookId'].'" class="btn btn-success mr-1">Số Lượng</a>
                            <a href="/admin/deleteBook/'.$book['bookId'].'" class="btn btn-danger">Xóa</a>
                        </div>
                    </td>
                </tr>
                ';
            }
        }
        ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <ul class="pagination">
        <?php 
        if(isset($data['cols']) && $data['cols'] > 1) {
            $cols = $data['cols'];
            for($i = 1; $i <= $cols; $i++) {
                echo '<li class="page-item"><a class="page-link" href="/admin/books/'.$cols[$i].'">'.$cols[$i].'</a></li>';
            }
        }
    ?>
    </ul>
</div>