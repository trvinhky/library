<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$data['title'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/home.css" />
</head>

<body>
    <header id="header">
        <div class="container">
            <div class="header d-flex justify-content-between align-items-center">
                <div class="header-left d-flex align-items-center">
                    <a href="/home">
                        <img src="/images/logo.jpg" alt="" class="header-logo" />
                    </a>
                    <div class="header-left__title d-flex flex-column">
                        <div class="title d-flex flex-column">
                            <span>Trung Tâm Học Liệu</span>
                            <span>Trường Đại Học Cần Thơ</span>
                        </div>
                        <div class="link">www.ctu.edu.vn</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end header-right">
                    <?php 
                        if(isset($_COOKIE['userId'])) {
                            echo '
                            <a href="/user/'.$_COOKIE['userId'].'" class="header-user">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            ';
                        } else {
                            echo '
                            <a href="/login" class="btn btn-primary px-4">Đăng Nhập</a>
                            <a href="/register" class="btn btn-secondary px-4">Đăng Ký</a>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <?php
                require_once "../mvc/views/pages/".$data["content"].".php";
            ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="footer d-flex justify-content-between align-items-start">
                <div class="footer-address d-flex flex-column">
                    <span>© 2023 Trung Tâm Học liệu - Đại học Cần Thơ</span>
                    <span>Khu II - Đường 3/2 - Q.Ninh Kiều - TP.Cần Thơ</span>
                    <span>ĐT: 0292 383 1565 - Email: tthl@ctu.edu.vn</span>
                </div>
                <div class="footer-more d-flex">
                    <div><i class="fa-brands fa-facebook-f"></i></div>
                    <div><i class="fa-brands fa-twitter"></i></div>
                    <div><i class="fa-brands fa-youtube"></i></div>
                    <div><i class="fa-solid fa-envelope"></i></div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="/js/logout.js"></script>
</body>

</html>