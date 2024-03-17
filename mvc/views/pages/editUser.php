<div class="in4-content__item active frame">
    <div class="header_file">
        <h5>Hồ sơ của tôi</h5>
        <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
    </div>

    <div class="row justify-content-center pb-5 pt-4">
        <div class="col-md-10">
            <form class="user-form" method="post">
                <div class="form-group row">
                    <label for="userName" class="col-sm-2 col-form-label text-nowrap">Họ và tên</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="userName" name="userName"
                            placeholder="Vui lòng nhập họ và tên" value="<?=$data['user']['userName'] ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="userPhone" class="col-sm-2 col-form-label text-nowrap">Số điện thoại</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="userPhone" id="userPhone"
                            placeholder="Vui lòng nhập họ và tên" value="<?=$data['user']['userPhone'] ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="userAddress" class="col-sm-2 col-form-label text-nowrap">Địa chỉ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="userAddress" id="userAddress"
                            placeholder="Vui lòng nhập họ và tên" value="<?=$data['user']['userAddress'] ?>" />
                    </div>
                </div>
                <div class="form-group row fa-pull-right buttons">
                    <button type="submit" class="btn btn-success px-4">Cập nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>