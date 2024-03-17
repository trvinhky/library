<div class="row justify-content-center py-4">
    <div class="col-8">
        <h1 class="text-center">Chi Tiết Phiếu Mượn</h1>
        <?php 
        if(!empty($data['detail'])) {
            foreach($data['detail'] as $detail) {
                echo '
                <div class="loan-item border border-primary p-2">
                    <p><span class="font-weight-bold">Tên sách: </span>'.$detail['title'].'</p>
                    <p><span class="font-weight-bold">Loại sách: </span>'.$detail['categoryName'].'</p>
                    <p><span class="font-weight-bold">Chủ đề: </span>'.$detail['topicName'].'</p>
                    <p><span class="font-weight-bold">Tên tác giả: </span>'.$detail['authorName'].'</p>
                    <p><span class="font-weight-bold">Tên nhà xuất bản: </span>'.$detail['publisherName'].'</p>
                    <p><span class="font-weight-bold">Năm xuất bản: </span>'.$detail['yearPublished'].'</p>
                    <p><span class="font-weight-bold">Số trang: </span>'.$detail['pages'].'</p>
                    <p><span class="font-weight-bold">Vị trí kệ: </span>'.$detail['bookshelfLocation'].'</p>
                    <p><span class="font-weight-bold">Tên thư viện: </span>'.$detail['libraryName'].'</p>
                    <p><span class="font-weight-bold">Vị trí thư viện: </span>'.$detail['libraryLocation'].'</p>
                    <p><span class="font-weight-bold">Số lượng: </span>'.$detail['loanQuantity'].'</p>
                </div>
                ';
            }
        }
        ?>

        <p><span class="font-weight-bold">Ngày mượn: </span><?=$data['loan']['loanDate'] ?></p>
        <p><span class="font-weight-bold">Ngày trả: </span><?=$data['loan']['dueDate'] ?></p>
        <p><span class="font-weight-bold">Người mượn: </span><?=$data['loan']['userName'] ?></p>
        <p><span class="font-weight-bold">Trạng Thái: </span><?=$data['loan']['returned'] ?></p>
    </div>
</div>