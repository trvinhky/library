<?php
class Login extends Controller {
    public function admin() : void {
        $admin = $this->model("AdminModel");

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $data = [];
                $data['adminEmail'] = $_POST['email'];
                $data['adminPassword'] = $_POST['password'];
                $feedback = $admin->loginAccount($data);
                $_POST = array();
                if($feedback) {
                    redirect("/admin");
                } else {
                    echo "<script>alert('Đăng nhập thất bại vui lòng kiểm tra thông tin bạn đưa ra và thử lại sau :((')</script>";
                }
            }
        }

        $this->view('login', [
            'title' => 'Đăng nhập admin',
            'isAdmin' => true
        ]);
    }

    public function render() : void {
        $user = $this->model("UserModel");

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $data = [];
                $data['userEmail'] = $_POST['email'];
                $data['userPassword'] = $_POST['password'];
                $feedback = $user->loginAccount($data);
                $_POST = array();
                if($feedback) {
                    redirect("/");
                } else {
                    echo "<script>alert('Đăng nhập thất bại vui lòng kiểm tra thông tin bạn đưa ra và thử lại sau :((')</script>";
                }
            }
        }

        $this->view('login', [
            'title' => 'Đăng nhập',
            'isAdmin' => false
        ]);
    }
}
?>