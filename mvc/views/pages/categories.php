<h1 class="text-center pt-3">Quản lý loại</h1>
<div class="d-flex justify-content-end py-4 mr-2">
    <a href="/admin/addCategory" class="btn btn-primary px-5" style="font-size: 20px;"><i
            class="fa-solid fa-plus"></i></a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên Loại</th>
            <th scope="col">Số lượng sách</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!empty($data['categories'])) {
                foreach($data['categories'] as $key => $category) {
                    echo '
                    <tr>
                        <td>'.($key + 1).'</td>
                        <td>
                            <p class="card-title">'.$category['categoryName'].'</p>
                        </td>
                        <td>'.$category['quantity'].'</td>
                        <td>
                            <div class="d-flex">
                                <a href="/admin/editCategory/'.$category['categoryId'].'" class="btn btn-secondary mr-1">Cập Nhật</a>
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