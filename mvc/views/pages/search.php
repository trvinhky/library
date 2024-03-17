<link rel="stylesheet" href="/css/timkiem.css" />
<div class="frame_search">
    <div class="row">
        <div class="col-md-3">
            <div class="control_group" style="margin-bottom: 5px">
                <div class="control">
                    <div class="control_heading">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            <h4 class="control_title">
                                <i class="fa-solid fa-circle-plus"></i>
                                Loại Tài Liệu
                            </h4>
                        </a>
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <ul class="list-group">
                        <?php 
                            if(!empty($data['categories'])) {
                                foreach($data['categories'] as $category) {
                                    echo '
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="check">
                                            <input type="checkbox" aria-label="Checkbox for following text input" />
                                            '.$category['categoryName'].'
                                        </div>
                                        <span>'.$category['quantity'].'</span>
                                    </li>
                                    ';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="control_group" style="margin-bottom: 5px">
                <div class="control">
                    <div class="control_heading">
                        <a data-toggle="collapse" href="#collapseAuthor" aria-expanded="false"
                            aria-controls="collapseAuthor">
                            <h4 class="control_title">
                                <i class="fa-solid fa-circle-plus"></i>
                                Tác giả
                            </h4>
                        </a>
                    </div>
                </div>
                <div class="collapse" id="collapseAuthor">
                    <ul class="list-group">
                        <?php 
                            if(!empty($data['authors'])) {
                                foreach($data['authors'] as $author) {
                                    echo '
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="check">
                                            <input type="checkbox" aria-label="Checkbox for following text input" />
                                            '.$author['authorName'].'
                                        </div>
                                        <span>'.$author['quantity'].'</span>
                                    </li>
                                    ';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="control_group" style="margin-bottom: 5px">
                <div class="control">
                    <div class="control_heading">
                        <a data-toggle="collapse" href="#collapseYear" aria-expanded="false"
                            aria-controls="collapseYear">
                            <h4 class="control_title">
                                <i class="fa-solid fa-circle-plus"></i>
                                Nhà xuất bản
                            </h4>
                        </a>
                    </div>
                </div>
                <div class="collapse" id="collapseYear">
                    <ul class="list-group">
                        <?php 
                            if(!empty($data['publishers'])) {
                                foreach($data['publishers'] as $publisher) {
                                    echo '
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="check">
                                            <input type="checkbox" aria-label="Checkbox for following text input" />
                                            '.$publisher['publisherName'].'
                                        </div>
                                        <span>'.$publisher['quantity'].'</span>
                                    </li>
                                    ';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="control_group" style="margin-bottom: 5px">
                <div class="control">
                    <div class="control_heading">
                        <a data-toggle="collapse" href="#collapseTopic" aria-expanded="false"
                            aria-controls="collapseTopic">
                            <h4 class="control_title">
                                <i class="fa-solid fa-circle-plus"></i>
                                Chủ đề
                            </h4>
                        </a>
                    </div>
                </div>
                <div class="collapse" id="collapseTopic">
                    <ul class="list-group">
                        <?php 
                            if(!empty($data['topics'])) {
                                foreach($data['topics'] as $topic) {
                                    echo '
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="check">
                                            <input type="checkbox" aria-label="Checkbox for following text input" />
                                            '.$topic['topicName'].'
                                        </div>
                                        <span>'.$topic['quantity'].'</span>
                                    </li>
                                    ';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="margin-left: 35px">
            <div class="group">
                <div class="group_search">
                    <form class="form-inline my-2 my-lg-0" method="get">
                        <div id="search" class="input-group">
                            <input type="text" name="search" value placeholder="Tìm kiếm" class="form-control"
                                required />
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="group_view">
                    <div id="searchInfo" class="search-results alert alert-info">
                        <p>
                            Tìm thấy
                            <ins><?=$data['count']?></ins>
                            <span>Kết quả</span>
                            <span class="fa-pull-right">Tổng số <?=$data['total']?></span>
                        </p>
                    </div>
                </div>

                <div class="group_filter">
                    <input type="checkbox" aria-label="Checkbox for following text input" />
                    <p class="d-inline-block tablet-none">Xắp xếp:</p>
                    <form class="d-inline-block woocommerce-ordering" method="get">
                        <select name="fil" id="fil">
                            <option value="menu_order" selected="selected">
                                Thích hợp
                            </option>
                            <option value="popularity">Tài liệu (A - Z)</option>
                            <option value="ascending">Xuất bản tăng dần</option>
                            <option value="decrease">Xuất bản giảm dần</option>
                        </select>
                        <select name="view" id="view">
                            <option value="menu_order" selected="selected">
                                Hiển thị
                            </option>
                            <option value="small">10</option>
                            <option value="fit">50</option>
                            <option value="big">100</option>
                            <option value="veryBig">200</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="box">
                <div class="row">
                    <?php 
                    if(!empty($data['books'])) {
                        foreach($data['books'] as $book) {
                            echo '
                            <div class="col-sm-6 py-4">
                                <div class="card">
                                    <img class="card-img-top" src="'.$book['photoURL'].'" alt="Card image cap" />
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
            </div>
        </div>
    </div>
</div>