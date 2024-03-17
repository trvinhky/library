<h1 class="text-center pt-3">Quản lý thư viện</h1>
<div class="d-flex justify-content-end py-4 mr-2">
    <a href="/admin/addLibrary" class="btn btn-primary px-5" style="font-size: 20px;"><i
            class="fa-solid fa-plus"></i></a>
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên Thư Viện</th>
            <th scope="col">Vị Trí Thư Viện</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!empty($data['libraries'])) {
                foreach($data['libraries'] as $key => $library) {
                    echo '
                    <tr>
                        <td>'.($key + 1).'</td>
                        <td>
                            <p class="card-title">'.$library['libraryName'].'</p>
                        </td>
                        <td>'.$library['libraryLocation'].'</td>
                        <td>
                            <div class="d-flex">
                                <a href="/admin/editLibrary/'.$library['libraryId'].'" class="btn btn-secondary mr-1">Cập Nhật</a>
                                <a href="/admin/bookshelfs/'.$library['libraryId'].'" class="btn btn-primary mr-1">Kệ Sách</a>
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