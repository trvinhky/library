<?php

class AdminModel extends DB {
    protected string $table = 'admin';
    protected array $cols = [
        'adminId', 'adminName', 'adminPassword', 
        'adminPhone', 'adminAddress', 'adminEmail'
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
            $data["adminPassword"] = password_hash($data["adminPassword"], PASSWORD_BCRYPT);
            $data["adminId"] = uniqid();

            return $this->insertData($data);
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
            $sql = "SELECT * FROM $this->table WHERE adminEmail=?";
            $admin = $this->read($sql, [$data["adminEmail"]], "single");
            
            if(!empty($admin) && password_verify($data["adminPassword"], $admin["adminPassword"])) {
                setcookie("adminId", $admin["adminId"], time() + (86400 * 30), "/"); 
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * lấy thông tin tài khoản
     *
     * @param string $adminId
     * @return array
     */
    public function getAdminInfor(string $adminId) : array {
        $sql = "SELECT * FROM $this->table WHERE adminId=?";
        $admin = $this->read($sql, [$adminId], "single");

        if(!empty($admin)) {
            unset($admin["adminPassword"]);
            return $admin;
        }
        return [];
    }

    /**
     * cập nhật thông tin tài khoản
     *
     * @param array $post gồm adminName, adminPhone, adminAddress.
     * @return integer|false
     */
    public function updateAdminInfor(array $post) : int|false {
        if(!empty($post)) {
            $keys = [];
            $params = [];
            if(array_key_exists("adminName", $post)) {
                $keys[] = "adminName=?";
                $params[] = $post["adminName"];
            }
    
            if(array_key_exists("adminPhone", $post)) {
                $keys[] = "adminPhone=?";
                $params[] = $post["adminPhone"];
            }
    
            if(array_key_exists("adminAddress", $post)) {
                $keys[] = "adminAddress=?";
                $params[] = $post["adminAddress"];
            }
    
            $sql = "UPDATE $this->table SET ".implode(", ", $keys)." WHERE id=?";
            $params[] = $post['adminId'];
            return $this->update($sql, $params);
        }
        return false;
    }
    
}
?>