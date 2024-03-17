<div class="row">
    <div class="col">
        <img class="w-100" src="/images/home.jpg" alt="" />
    </div>
</div>
<div class="row">
    <div class="col d-flex justify-content-center">
        <form action="/home/search/" class="main-form" method="get">
            <h3 class="text-center mt-4 mb-4">Thư Viện Trường</h3>
            <input class="form-control form-search" type="search" name="search" placeholder="Nhập vào tên sách"
                required />
            <input class="btn btn-primary" type="submit" value="Tìm Kiếm" />
            <input class="btn btn-danger" type="reset" value="Hủy" />
        </form>
    </div>
</div>
<h3 class="text-center">Sách Mới Nhất</h3>
<div class="row">
    <?php 
    if(!empty($data['books'])) {
        foreach($data['books'] as $book) {
            echo '
            <div class="col-sm-4 py-4">
                <div class="card">
                    <img class="card-img-top" src="'.$book['photoURL'].'" alt="'.$book['title'].'" />
                    <div class="card-body text-center">
                        <a href="/home/detail/'.$book['bookId'].'" class="card-title">
                            '.$book['title'].' - '.$book['authorName'].'
                        </a>
                        <p class="card-text">Nhà xuất bản: '.$book['publisherName'].'</p>
                        <p class="card-text">Năm xuất bản: '.$book['yearPublished'].'</p>
                    </div>
                </div>
            </div>
            ';
        }
    }
    ?>
</div>