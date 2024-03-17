<link rel="stylesheet" href="/css/chitietsach.css">
<?php 
    $book = []; 
    if(!empty($data['book'])) {
        $book = $data['book']['infor'];
    } 
?>
<div class="row py-4">
    <div class="col-12">
        <div class="title px-4 pb-2">
            <i class="fa-solid fa-bookmark mt-3"></i>
            <h2><?=$book['title'] ?></h2>
        </div>
        <ul class="box-nav p-3">
            <li>
                <button id="active" class="button-detail">Tổng Quan</button>
            </li>
            <li><button class="button-detail">Vị trí tài liệu</button></li>
        </ul>
        <div class="noidung-book">
            <div class="row p-3">
                <div class="col-3">
                    <img class="w-100" src="<?=$book['photoURL'] ?>" alt="<?=$book['title'] ?>" />
                </div>
                <div class="col-9">
                    <ul class="pl-0">
                        <li class="content-li-book">
                            <h4>
                                Loại CSDL<span id="badge"
                                    class="badge badge-secondary m-1"><?=$data['book']['categoryName'] ?></span>
                            </h4>
                        </li>
                        <li class="content-li-book">
                            Tác giả:<span> <?=$data['book']['authorName'] ?></span>
                        </li>
                        <li class="content-li-book">
                            Thông tin xb:<span><?=$data['book']['publisherName'] ?>, <?=$book['yearPublished'] ?></span>
                        </li>
                        <li class="content-li-book">
                            STT trên kệ sách:<span> <?=$data['book']['locations'] ?></span>
                        </li>
                        <li class="content-li-book">
                            Mô tả vật lý:<span> <?=$book['pages'] ?>tr</span>
                        </li>
                        <li class="content-li-book">
                            Chủ đề:<span> <?=$data['book']['topicName'] ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row p-3">
                <div class="col-8">
                    <p class="location-p">Trong kho sẵn sàng: <span><?=$data['book']['ready'] ?></span></p>
                </div>
                <div class="col-4">
                    <p class="location-p">Tổng: <span><?=$data['book']['quantity'] ?></span></p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Điểm lưu thông</th>
                            <th scope="col">Số lượng Trong Kho</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(!empty($data['libraries'])) {
                            foreach($data['libraries'] as $key => $library) {
                                echo '
                                <tr>
                                    <th scope="row">'.($key + 1).'</th>
                                    <td class="d-flex flex-column">
                                        <span>'.$library['libraryName'].'</span>
                                        <span class="color-span">
                                            ('.$library['libraryLocation'].')
                                        </span>
                                    </td>
                                    <td>'.$library['quantity'].'</td>
                                    <td>
                                        <a href="/home/addLoan/'.$library['libraryId'].'/'.$book['bookId'].'" class="operation px-3">
                                            <i class="fa fa-edit"></i>
                                            <span> ĐK mượn </span>
                                        </a>
                                    </td>
                                </tr>
                                ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>