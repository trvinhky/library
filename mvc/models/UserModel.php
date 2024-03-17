<?php

class UserModel extends DB {
    protected string $table = 'users';
    protected array $cols = [
        'userId', 'userName', 'userEmail', 
        'userPhone', 'userAddress', 'userPassword'
    ];
    
    /**
     * đăng ký tài khoản
     *
     * @param array $post
     * @return boolean
     */
    public function registerAccount(array $post) : bool {
        if(!empty($post)) {
            $data = $this->filter(["passwordConform", "apcept"], $post);
            $data["userPassword"] = password_hash($data["userPassword"], PASSWORD_BCRYPT);
            $data["userId"] = uniqid();

            $sql = "CALL ADD_USER(:".implode(", :", $this->cols).")"; 
            return $this->insert($sql, $data);
        }
        return false;
    }

    /**
     * đăng nhập tài khoản
     *
     * @param array $post
     * @return boolean
     */
    public function loginAccount(array $post) : bool {
        if(!empty($post)) {
            $data = $post;

            // câu truy vấn
            $sql = "SELECT * FROM $this->table WHERE userEmail=?";
            $user = $this->read($sql, [$data["userEmail"]], "single");
            
            if(!empty($user) && password_verify($data["userPassword"], $user["userPassword"])) {
                setcookie("userId", $user["userId"], time() + (86400 * 30), "/"); 
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * lấy thông tin tài khoản
     *
     * @param string $userId
     * @return array
     */
    public function getUserInfor(string $userId) : array {
        $sql = "SELECT * FROM $this->table WHERE userId=?";
        $user = $this->read($sql, [$userId], "single");

        if(!empty($user)) {
            unset($user["userPassword"]);
            return $user;
        }
        return [];
    }

    /**
     * cập nhật thông tin tài khoản
     *
     * @param array $post gồm userName, userPhone, userAddress.
     * @return integer|false
     */
    public function updateUserInfor(array $post) : int|false {
        if(!empty($post)) {
            $keys = [];
            $params = [];
            if(array_key_exists("userName", $post)) {
                $keys[] = "userName=?";
                $params[] = $post["userName"];
            }
    
            if(array_key_exists("userPhone", $post)) {
                $keys[] = "userPhone=?";
                $params[] = $post["userPhone"];
            }
    
            if(array_key_exists("userAddress", $post)) {
                $keys[] = "userAddress=?";
                $params[] = $post["userAddress"];
            }
    
            $sql = "UPDATE $this->table SET ".implode(", ", $keys)." WHERE userId=?";
            $params[] = $post['userId'];
            return $this->update($sql, $params);
        }
        return false;
    }
}
?>