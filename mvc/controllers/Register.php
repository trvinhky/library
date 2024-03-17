<?php
class Register extends Controller {
    public function render() :void {
        $user = $this->model("UserModel");

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $user->registerAccount($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/login");
                } else {
                    echo "<script>alert('Đăng ký thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $this->view('register', [
            'title' => 'Đăng ký'
        ]);
    }
}
?>