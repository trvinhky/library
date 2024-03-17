<link rel="stylesheet" href="/css/nguoidunng.css" />
<div class="row ml-0">
    <div class="col-md-3 group-heading">
        <div class="group-heading">
            <div class="d-flex align-items-center user">
                <div class="user_a">
                    <button class="user_btn">
                        <i class="fa-regular fa-user"></i>
                    </button>
                </div>
                <div class="d-flex flex-column justify-content-center name">
                    <?=$data['user']['userName'] ?>
                    <a href="/user/edit/<?=$data['user']['userId'] ?>" class="d-flex fix">
                        <i class="fa-solid fa-pencil"></i>
                        <span>Cập nhật hồ Sơ</span>
                    </a>
                </div>
            </div>
            <div class="account">
                <ul class="nav flex-column pl-4 heading">
                    <a href="/user/<?=$data['user']['userId'] ?>">
                        <li class="nav-item pb-3 active" data-index="0">
                            <i class="fa-solid fa-book"></i>
                            Hồ Sơ
                        </li>
                    </a>

                    <a href="/user/loans/<?=$data['user']['userId'] ?>">
                        <li class="nav-item pb-3" data-index="1">
                            <i class="fa-regular fa-note-sticky"></i>
                            Danh sách phiếu mượn
                        </li>
                    </a>
                    <a href="/user/dues/<?=$data['user']['userId'] ?>">
                        <li class="nav-item pb-3" data-index="2">
                            <i class="fa-regular fa-note-sticky"></i>

                            Danh sách phiếu trả
                        </li>
                    </a>
                    <span class="logout">
                        <li class="nav-item pb-3" data-index="3">
                            <i class="fa-solid fa-power-off"></i>
                            Đăng xuất
                        </li>
                    </span>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php
                require_once "../mvc/views/pages/".$data["child"].".php";
            ?>
    </div>
</div>