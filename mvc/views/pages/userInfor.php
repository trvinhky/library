<div class="in4-content__item active frame">
    <div class="header_file">
        <h5>Hồ sơ của tôi</h5>
        <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
    </div>

    <div class="row justify-content-center pb-5 pt-4">
        <div class="col-md-10">
            <p><span class="font-weight-bold">Họ và tên: </span><?=$data['user']['userName'] ?></p>
            <p><span class="font-weight-bold">Email: </span><?=$data['user']['userEmail'] ?></p>
            <p><span class="font-weight-bold">Số điện thoại: </span><?=$data['user']['userPhone'] ?></p>
            <p><span class="font-weight-bold">Địa chỉ: </span><?=$data['user']['userAddress'] ?></p>
        </div>
    </div>
</div>