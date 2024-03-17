<link rel="stylesheet" href="/css/loan.css">

<div class="panel panel-primary frame">
    <div class="header_file">
        <h5>Danh sách phiếu mượn</h5>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Ngày mượn</th>
                <th>Ngày trả</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(!empty($data['loans'])) {
                    foreach($data['loans'] as $key => $loan) {
                        echo '<tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$loan['bookName'].'</td>
                        <td>'.$loan['loanDate'].'</td>
                        <td>'.$loan['dueDate'].'</td>
                        <td>
                        <a href="/home/detailLoan/'.$loan['loanId'].'" class="btn btn-primary">Chi Tiết</a>
                        </td>
                        </tr>
                        ';
                    }
                }
            ?>
        </tbody>
    </table>
</div>