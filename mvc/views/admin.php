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
    <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
    <header class="header-admin">
        <a class="go-home" href="/home"><img src="/images/logo.jpg" /></a>
        <div class="group-admin-right">
            <h1 class="text-center title-admin">
                Hello
                <?=$data['adminName']?>
            </h1>
            <button class="btn btn-primary logout logout-admin">Đăng xuất</button>
        </div>
    </header>
    <main>
        <div class="row d-flex">
            <div class="col-3 d-flex flex-column list-left">
                <a href="/admin" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Người Dùng
                </a>
                <a href="/admin/books" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Sách
                </a>
                <a href="/admin/loans" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Phiếu
                </a>
                <a href="/admin/libraries" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Thư Viện
                </a>
                <a href="/admin/authors" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Tác Giả
                </a>
                <a href="/admin/topics" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Chủ Đề
                </a>
                <a href="/admin/publishers" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Nhà Xuất Bản
                </a>
                <a href="/admin/categories" id="navbar-admin" type="button" class="btn btn-primary">
                    Quản Lý Loại
                </a>
                <a href="/admin/addAdmin" id="navbar-admin" type="button" class="btn btn-primary">
                    Thêm Admin
                </a>
            </div>
            <div class="col-9">
                <div class="content-admin">
                    <?php
                        require_once "../mvc/views/pages/".$data["content"].".php";
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="/js/logoutAdmin.js"></script>
</body>

</html>