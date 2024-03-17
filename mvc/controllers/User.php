<?php
define('LENGTH', 6);
class User extends Controller {
    public function __construct() {
        if(!isset($_COOKIE['userId'])) {
            redirect('/login');
        }
    }

    // phiếu trả
    public function dues(string $id, string $page = '1') :void {
        if(strlen($id) == 0) {
            redirect('/login');
        }

        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/user');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $loanModel = $this->model('LoanModel');
        $loans = $loanModel->getLoanByUserId($id, 1, [LENGTH, $offset]);
        $count = $loanModel->getCountLoanByUserId($id, 1);
        $cols = ceil($count / LENGTH);
        $user = ($this->model('UserModel'))->getUserInfor($_COOKIE['userId']);
        $reults = [];
        if(!empty($loans)) {
            foreach($loans as $loan) {
                $quantity = ($this->model('DetailLoanModel'))->getLoanQuantityByLoanId($loan['loanId'], 1);
                $total = 0;
                $titles = [];
                foreach($quantity as $value) {
                    $total += $value['loanQuantity'];
                    $titles[] = $value['title']; 
                }
                $loan['quantity'] = $total;
                $loan['bookTitle'] = implode(', ', $titles);
                $reults[] = $loan;
            }
        }

        $this->view('index', [
            'title' => 'Người dùng - Danh sách phiếu trả',
            'content' => 'user',
            'user' => $user,
            'child' => 'listLoans',
            'subTitle' => 'Danh sách phiếu trả',
            'loans' => $reults,
            'cols' => $cols,
            'count' => $count
        ]);
    }

    // phiếu mượn
    public function loans(string $id, string $page = '1') :void {
        if(strlen($id) == 0) {
            redirect('/login');
        }

        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/user');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $loanModel = $this->model('LoanModel');
        $loans = $loanModel->getLoanByUserId($id, 0, [LENGTH, $offset]);
        $count = $loanModel->getCountLoanByUserId($id, 0);
        $cols = ceil($count / LENGTH);
        $user = ($this->model('UserModel'))->getUserInfor($_COOKIE['userId']);
        $reults = [];
        if(!empty($loans)) {
            foreach($loans as $loan) {
                $quantity = ($this->model('DetailLoanModel'))->getLoanQuantityByLoanId($loan['loanId'], 0);
                $total = 0;
                $titles = [];
                foreach($quantity as $value) {
                    $total += $value['loanQuantity'];
                    $titles[] = $value['title']; 
                }
                $loan['quantity'] = $total;
                $loan['bookTitle'] = implode(', ', $titles);
                $reults[] = $loan;
            }
        }

        $this->view('index', [
            'title' => 'Người dùng - Danh sách phiếu mượn',
            'content' => 'user',
            'user' => $user,
            'child' => 'listLoans',
            'subTitle' => 'Danh sách phiếu mượn',
            'loans' => $reults,
            'cols' => $cols,
            'count' => $count
        ]);
    }

    // cập nhật
    public function edit(string $id) :void {
        if(strlen($id) == 0) {
            redirect('/login');
        }

        $user = ($this->model('UserModel'))->getUserInfor($id);

        if(empty($user)) {
            redirect('/login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['userId'] = $user['userId'];
                $feedback = ($this->model('UserModel'))->updateUserInfor($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/user/".$user['userId']);
                } else {
                    echo "<script>alert(Cập nhập thất bại vui lòng kiểm tra thông tin bạn đưa ra và thử lại sau :((')</script>";
                }
            }
        }
        
        $this->view('index', [
            'title' => 'Người dùng',
            'content' => 'user',
            'user' => $user,
            'child' => 'editUser'
        ]);
    }

    public function render() :void {
        $user = ($this->model('UserModel'))->getUserInfor($_COOKIE['userId']);
        if(empty($user)) {
            redirect('/login');
        }
        
        $this->view('index', [
            'title' => 'Người dùng',
            'content' => 'user',
            'user' => $user,
            'child' => 'userInfor'
        ]);
    }
}
?>