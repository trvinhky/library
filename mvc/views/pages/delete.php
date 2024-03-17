<link rel="stylesheet" href="/css/xoasach.css">

<div class="d-flex justify-content-center pt-4">
    <div class="delete-book py-4">
        <h1 class="text-center text-danger">
            bạn có chắc muốn xóa <?=$data['subtitle'] ?>
        </h1>
        <div class="group-delete">
            <a class="form-close" href="/admin/<?=$data['link'] ?>"><button class="btn btn-close">Hủy</button></a>
            <form method="post" class="form-delete">
                <button type="submit" class="btn btn-danger btn-delete">
                    Xóa
                </button>
            </form>
        </div>
    </div>
</div>