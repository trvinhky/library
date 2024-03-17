<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$data['title'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="/css/dangky.css" />
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
                        <h1 class="login-btn pb-3">Đăng ký</h1>
                        <input type="text" name="userName" required placeholder="Họ và Tên" />
                        <input type="email" name="userEmail" required placeholder="email" />
                        <input type="text" name="userPhone" required placeholder="SDT" />
                        <input type="text" name="userAddress" required placeholder="địa chỉ" />
                        <input type="password" name="userPassword" required placeholder="mật khẩu" />
                        <input type="password" name="passwordConform" required placeholder="nhập lại mật khẩu" />
                        <button type="submit" class="btn btn-primary submit px-5 mt-2">
                            Đăng ký
                        </button>
                        <p class="py-4">
                            Bạn đã có tài khoản? <a href="/login">đăng nhập ngay.</a>
                        </p>
                    </form>
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
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
</body>

</html>