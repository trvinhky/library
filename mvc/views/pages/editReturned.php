<div class="row justify-content-center">
    <div class="col-8">
        <h1 class="w-100 text-center text-info py-3">Cập nhật trạng thái phiếu</h1>
        <form method="post">
            <div class="form-row">
                <div class="col-6">
                    <label for="loanDate">Ngày Mượn:</label>
                    <input type="date" class="form-control" id="loanDate" value="<?=$data['loan']['loanDate'] ?>"
                        readonly>
                </div>
                <div class="col-6">
                    <label for="dueDate">Ngày Trả:</label>
                    <input type="date" class="form-control" id="dueDate" value="<?=$data['loan']['dueDate'] ?>"
                        readonly>
                </div>
            </div>
            <p class="py-2">
                Cập nhật trạng thái phiếu sang đã trả? <span class="text-primary"
                    style="font-weight: 500;"><?=$data['check'] ?></span>.
            </p>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary px-5">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>