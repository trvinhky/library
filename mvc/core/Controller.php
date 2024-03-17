<?php
class Controller {
    public function model($model) {
        require_once "../mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]) : void {
        require_once "../mvc/views/".$view.".php";
    }

    public function addCart(array $post) : void {
        if(!empty($post)) {
            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            } 
            if(empty($_SESSION['cart'])) {
                array_push($_SESSION['cart'], $post); 
            } else {
                $check = false;
                foreach($_SESSION['cart'] as $value) {
                    if($value['id'] == $post['id']) {
                        $check = true;
                        break;
                    }
                }
    
                if(!$check) {
                    array_push($_SESSION['cart'], $post); 
                }
            }
        }
    }
}
?>