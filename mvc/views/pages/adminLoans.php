<h1 class="text-center pt-3 pb-2">Quản lý Phiếu</h1>
<div class="row justify-content-end">
    <div class="col-4">
        <form method="get" class="pr-4 py-3">
            <div class="fillter">
                <select name="returned" id="returned" class="form-control">
                    <option value="all" <?php echo $data['returned']=='all'?'selected':'' ?>>Tất cả</option>
                    <option value="0" <?php echo $data['returned']=='0'?'selected':'' ?>>Phiếu mượn</option>
                    <option value="1" <?php echo $data['returned']=='1'?'selected':'' ?>>Phiếu trả</option>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Mã Mượn</th>
            <th scope="col">Người Mượn</th>
            <th scope="col">Ngày Mượn</th>
            <th scope="col">Ngày Trả</th>
            <th scope="col">Trạng Thái</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($data['loans'])) {
            foreach($data['loans'] as $key => $loan) {
                echo '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td>'.$loan['loanId'].'</td>
                    <td>'.$loan['userName'].'</td>
                    <td>'.$loan['loanDate'].'</td>
                    <td>'.$loan['dueDate'].'</td>
                    <td>'.$loan['returned'].'</td>
                    <td>
                        <div class="d-flex">
                            <a href="/home/detailLoan/'.$loan['loanId'].'" class="btn btn-primary mr-1">Chi Tiết</a>
                ';
                if($loan['returned'] == 'Chưa trả') {
                    echo '
                        <a href="/admin/editDueDate/'.$loan['loanId'].'" class="btn btn-secondary mr-1">Gia Hạn</a>
                        <a href="/admin/editReturned/'.$loan['loanId'].'" class="btn btn-success mr-1">Trạng Thái</a>
                    ';
                }
                echo '   
                        </div>
                    </td>
                </tr>
                ';
            }
        }
        ?>
    </tbody>
</table>