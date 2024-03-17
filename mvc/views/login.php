<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$data['title']?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="/css/dangnhap.css" />
</head>

<body>
    <header>
        <a href="/home">
            <img src="/images/logo.jpg" width="50px" alt="" class="header-logo" />
        </a>
    </header>
    <main id="content">
        <div class="body-dn">
            <div class="container">
                <div class="row">
                    <form class="form d-flex align-items-center justify-content-center flex-column" method="post">
                        <h1 class="login-btn">Đăng Nhập</h1>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required />
                        </div>
                        <div class="form-group">
                            <label for="password">Mật Khẩu:</label>
                            <input type="password" class="form-control" id="password" name="password" required />
                        </div>
                        <div class="form-check pb-4">
                            <input type="checkbox" class="form-check-input" id="check" checked />
                            <label class="form-check-label" for="check">Ghi nhớ cho lần đăng nhập sau.</label>
                        </div>
                        <button type="submit" class="btn btn-primary px-5">
                            đăng nhập
                        </button>
                        <?php 
                        if(!$data['isAdmin']) {
                            echo '
                            <p class="py-4">
                                Bạn chưa có tài khoản? <a href="/register">đăng ký ngay.</a>
                            </p>
                            ';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>