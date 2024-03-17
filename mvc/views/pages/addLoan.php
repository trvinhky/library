<div class="row py-4 px-4">
    <div class="col-12">
        <h1 class="text-center">Tạo Phiếu Mượn</h1>
        <div class="book d-flex justify-content-between py-3" style="gap: 20px;">
            <div class="book-left" style="flex: 1">
                <p><span class="font-weight-bold">Tên sách: </span> <?=$data['book']['title'] ?></p>
                <p><span class="font-weight-bold">NXB: </span> <?=$data['book']['yearPublished'] ?></p>
                <p><span class="font-weight-bold">Số trang: </span> <?=$data['book']['pages'] ?></p>
            </div>
            <div class="book-right" style="flex: 1">
                <p><span class="font-weight-bold">Tên thư viện: </span> <?=$data['library']['libraryName'] ?></p>
                <p><span class="font-weight-bold">Vị Trí: </span> <?=$data['library']['libraryLocation'] ?></p>
            </div>
        </div>
        <form method="post">
            <div class="form-row">
                <div class="col-4">
                    <label for="loanDate">Ngày Mượn:</label>
                    <input type="date" class="form-control" id="loanDate" name="loanDate">
                </div>
                <div class="col-4">
                    <label for="dueDate">Ngày Trả:</label>
                    <input type="date" class="form-control" id="dueDate" name="dueDate">
                </div>
                <div class="col-4">
                    <label for="loanQuantity">Số lượng:</label>
                    <input type="number" class="form-control" id="loanQuantity" name="loanQuantity" value="1" min="1"
                        max="<?=$data['library']['quantity'] ?>">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-5">Tạo</button>
            </div>
        </form>
    </div>
</div>