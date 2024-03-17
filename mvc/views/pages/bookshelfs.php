<h1 class="text-center pt-3">Quản lý vị trí kệ sách</h1>
<div class="d-flex justify-content-end py-4 mr-2">
    <a href="/admin/addBookshelf/<?=$data['id'] ?>" class="btn btn-primary px-5" style="font-size: 20px;"><i
            class="fa-solid fa-plus"></i></a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Vị Trí Kệ</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!empty($data['bookshelfs'])) {
                foreach($data['bookshelfs'] as $key => $bookshelf) {
                    echo '
                    <tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$bookshelf['bookshelfLocation'].'</td>
                        <td>
                            <div class="d-flex">
                                <a href="/admin/editBookshelf/'.$data['id'].'/'.$bookshelf['bookshelfId'].'" class="btn btn-secondary mr-1">Cập Nhật</a>
                                <a href="/admin/deleteBookshelf/'.$data['id'].'/'.$bookshelf['bookshelfId'].'" class="btn btn-danger">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    ';
                }
            }
        ?>
    </tbody>
</table>