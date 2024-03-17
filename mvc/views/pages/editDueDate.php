<div class="row justify-content-center">
    <div class="col-8">
        <h1 class="w-100 text-center text-info py-3">Gia hạn thời gian trả</h1>
        <form method="post">
            <div class="form-row">
                <div class="col-6">
                    <label for="loanDate">Ngày Mượn:</label>
                    <input type="date" class="form-control" id="loanDate" value="<?=$data['due']['loanDate'] ?>"
                        readonly>
                </div>
                <div class="col-6">
                    <label for="dueDate">Ngày Trả:</label>
                    <input type="date" class="form-control" id="dueDate" name="dueDate"
                        value="<?=$data['due']['dueDate'] ?>">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-5">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>