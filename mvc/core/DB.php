<?php 
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_DATABASE', 'library');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Hao020402@');

class DB {
    protected $db;
    protected string $table;
    protected array $cols;
    
    public function __construct() {
        try {
            $dsn = "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_DATABASE;
            $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * hàm thêm dữ liệu
     *
     * @param string $sql
     * @param array $data
     * @return boolean
     */
    public function insert(string $sql, array $data) : bool {
        try {
            if(!empty($data)) {
                $query = $this->db->prepare($sql);
                return $query->execute($data); 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Không thể thêm dữ liệu: " . $e->getMessage();
            return false;
        }
    }

    /**
     * hàm thêm dữ liệu không cần truyền câu truy vấn
     *
     * @param string $sql câu lệnh truy vấn
     * @param array $data dữ liệu cần thêm vào có dạng ["key" => "value"]
     * @return bool trả về true nếu thêm thành công ngược lại nếu lỗi hoặc không thêm được sẽ trả về false
     */
    public function insertData(array $data) : bool {
        try {
            if(!empty($data)) {
                $sql = "INSERT INTO $this->table (".implode(",", $this->cols).") VALUES (:".implode(", :", $this->cols).")";
                $query = $this->db->prepare($sql);
                return $query->execute($data); 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Không thể thêm dữ liệu: " . $e->getMessage();
            return false;
        }
    }

    /**
     * thêm dữ liệu tùy cột
     *
     * @param array $data
     * @param array $cols
     * @return boolean
     */
    public function insertCustom(array $data, array $cols) : bool {
        try {
            if(!empty($data)) {
                $sql = "INSERT INTO $this->table (".implode(",", $cols).") VALUES (:".implode(", :", $cols).")";
                $query = $this->db->prepare($sql);
                return $query->execute($data); 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Không thể thêm dữ liệu: " . $e->getMessage();
            return false;
        }
    }

    /**
     * hàm lấy dữ liệu
     *
     * @param string $sql câu lệnh truy vấn
     * @param string $type chuỗi có thể là all(lấy tất cả, mặc định), count(lấy số lượng), single(lấy 1 hàng).
     * @param array $data mảng chứa giá trị điều kiện
     * @return array|int trả về mảng khi type là all, single và số khi là count
     */
    public function read(string $sql, array $data = [], string $type = 'all') : array|int {
        try {
            $query = $this->db->prepare($sql);
            if(!empty($data)) {
                $query->execute($data);
            } else {
                $query->execute();
            }
            // trả ra tùy theo type nhận vào
            switch($type) {
                case "count":
                    return $query->rowCount();
                case "single":
                    $row = $query->fetch(PDO::FETCH_ASSOC);
                    $result = [];
                    if(!empty($row)) {
                        foreach($row as $key => $value) {
                            $result[$key] = $value;
                        }
                        
                        return $result;
                    }
                    return $result;
                default:
                    if($query->rowCount() > 0){ 
                        $res = $query->fetchAll(PDO::FETCH_ASSOC); 
                        if(!empty($res)) {
                            $result = [];
                            foreach($res as $row) {
                                $el = [];
                                foreach($row as $key => $value) {
                                    if(is_string($key)) {
                                        $el[$key] = $value;
                                    }
                                }
                                $result[] = $el;
                            }
                            
                            return $result;
                        }
                        return [];
                    }
                    return [];
            }
        } catch (PDOException $e) {
            echo "Không thể đọc dữ liệu: " . $e->getMessage();
            return [];
        }
    }

    /**
     * lấy tất cả dữ liệu
     *
     * @return array
     */
    public function readAll() : array {
        $sql = "SELECT * FROM $this->table";
        return $this->read($sql);
    }

    /**
     * lấy tổng số hàng trong bảng
     *
     * @return integer
     */
    public function getRowCount() : int {
        $sql = "SELECT * FROM $this->table";
        return $this->read($sql, [], "count");
    }

    /**
     * Lấy giới hạn phần tử
     *
     * @param string $sql
     * @param integer $length số phần tử cần lấy
     * @param integer $offset vị trí hàng bắt đầu lấy
     * @return array
     */
    public function readLimit(string $sql, int $length, int $offset) : array {
        try {
            $query = $this->db->prepare($sql);
            $query->bindParam(':length', $length, \PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $query->execute();

            $res = $query->fetchAll(PDO::FETCH_ASSOC); 
            if(!empty($res)) {
                $result = [];
                foreach($res as $row) {
                    $el = [];
                    foreach($row as $key => $value) {
                        if(is_string($key)) {
                            $el[$key] = $value;
                        }
                    }
                    $result[] = $el;
                }

                return $result;
            }
            return [];
        } catch (PDOException $e) {
            echo "Không thể đọc dữ liệu: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Lấy tất cả (có giới hạn lấy)
     *
     * @param array $limitOptions [length, offset]
     * @return array
     */
    public function readAllLimit(array $limitOptions = []) : array {
        $sql = "SELECT * FROM $this->table";
        if(!empty($limitOptions)) {
            $sql .= " LIMIT :length OFFSET :offset";
            $offset = 0;
            if(count($limitOptions) > 1) {
                $offset += $limitOptions[1];
            }

            if(is_numeric($offset) && is_numeric($limitOptions[0])) {
                return $this->readLimit($sql, +$limitOptions[0], +$offset);
            }
            return [];
        } else {
            return $this->read($sql);
        }
    }
 
    /**
     * hàm cập nhật dữ liệu
     *
     * @param string $table tên của bảng cần truy xuất
     * @param array $data (mảng giá trị cần cập nhật có dạng ["key" => "value"])
     * @param array $con (mảng chứ các giá trị điều kiện có dạng ["key" => "value"])
     * @return int|false trả ra số hàng khi cập nhật thành công và ngược lại trả ra false
     */
    public function update(string $sql, array $data) : int|false {
        try {
            if(!empty($data)) {
                $query = $this->db->prepare($sql); 
                $update = $query->execute($data); 
                return $update ? $query->rowCount() : false; 
            } else return false;
        } catch (PDOException $e) {
            echo "Không thể cập nhật dữ liệu: " . $e->getMessage();
            return false;
        } 
    }

    /**
     * hàm xóa dữ liệu
     *
     * @param string $table tên của bảng cần truy xuất
     * @param array $con (mảng chứ các giá trị điều kiện có dạng ["key" => "value"])
     * @return bool trả về số lượng hàng xóa hoặc không thể xóa sẽ trả ra false
     */
    public function delete(string $sql, array $data) : bool { 
        try {
            if(!empty($data)){ 
                $query = $this->db->prepare($sql);
                return $query->execute($data); 
            } 
            return false;
        } catch (PDOException $e) {
            echo "Không thể xóa dữ liệu: " . $e->getMessage();
            return false;
        } 
    } 

    /**
     * hàm lọc ra các phần tử dư thừa
     *
     * @param array $keys mảng chứ các key cần xóa khỏi mảng
     * @param array $data mảng cần lọc key
     * @return array mảng sau khi lọc
     */
    public function filter(array $keys, array $data) : array {
        $result = $data;
        if(!empty($keys) && !empty($result)) {
            foreach($keys as $key) {
                if(array_key_exists($key, $result)) {
                    unset($result[$key]);
                }
            }
        } 
        return $result;
    }

    /**
     * lọc mảng theo giá trị
     *
     * @param array $values
     * @param array $data
     * @return void
     */
    public function filterValue(array $values, array $data) {
        $result = $data;
        if(!empty($values) && !empty($result)) {
            foreach($values as $value) {
                $result = array_filter($result, function($val) use ($value) {
                    return $val != $value;
                });
                
                $result = array_values($result);
            }
        }
        return $result;
    }
}