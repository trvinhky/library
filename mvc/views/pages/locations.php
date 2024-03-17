<h1 class="text-center pt-3">Quản lý số lượng sách</h1>
<div class="d-flex justify-content-end py-4 mr-2">
    <a href="/admin/chooseLibrary/<?=$data['id'] ?>" class="btn btn-primary px-5" style="font-size: 20px;"><i
            class="fa-solid fa-plus"></i></a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên Thư Viện</th>
            <th scope="col">Vị Trí Kệ</th>
            <th scope="col">Số Lượng</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!empty($data['locations'])) {
                foreach($data['locations'] as $key => $location) {
                    echo '
                    <tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$location['libraryName'].'</td>
                        <td>'.$location['bookshelfLocation'].'</td>
                        <td>'.$location['quantity'].'</td>
                        <td>
                            <div class="d-flex">
                                <a href="/admin/editLocation/'.$data['id'].'/'.$location['bookshelfId'].'" class="btn btn-secondary mr-1">Cập Nhật</a>
                                <a href="#" class="btn btn-danger">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    ';
                }
            }
        ?>
    </tbody>
</table>