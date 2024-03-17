<?php 
class LoanModel extends DB {
    protected string $table = 'loans';
    protected array $cols = [
        'loanId', 'returned', 'loanDate', 
        'dueDate', 'userId'
    ];

    /**
     * thêm phiếu mượn/trả
     *
     * @param array $post
     * @return boolean
     */
    public function createLoan(array $post) : bool {
        if(!empty($post)) {
            $this->db->beginTransaction();

            // create loans
            $loan = [];
            $loan['userId'] = $post['userId'];
            $loan['loanDate'] = strtotime($post['loanDate']);
            $loan['dueDate'] = strtotime($post['dueDate']);
            $loan["loanId"] = uniqid();
            $loan["returned"] = 0;

            
            $current = time();
            if($loan['loanDate'] < $current) {
                return false;
            }
            
            // create detailLoan
            $detail = [];
            $detail['bookId'] = $post['bookId'];
            $detail['loanQuantity'] = +$post['loanQuantity'];
            $detail['loanId'] = $loan['loanId'];
            $cols = [
                'loanId', 'bookId', 'loanQuantity'
            ];

            try {
                $sql = "INSERT INTO $this->table (".implode(",", $this->cols).") VALUES  (:loanId, :returned, FROM_UNIXTIME(:loanDate), FROM_UNIXTIME(:dueDate), :userId)";
                $query = $this->db->prepare($sql);
                $query->execute($loan);
                
                $sql = "INSERT INTO detailLoan (".implode(",", $cols).") VALUES (:".implode(", :", $cols).")";
                $query = $this->db->prepare($sql);
                $query->execute($detail);

                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                $this->db->rollBack();
                echo "Không thể tạo phiếu mượn: " . $e->getMessage();
                return false;
            } 
            $this->db->commit();
            return true;
        }
        return false;
    }

    /**
     * Lấy phiếu theo trang thái
     *
     * @param integer $returned 0 - phiếu mượn, 1 - phiếu trả
     * @return array
     */
    public function getLoanByReturned(int $returned) : array {
        $sql = "SELECT * FROM $this->table WHERE returned = ? ORDER BY dueDate DESC";
        return $this->read($sql, [$returned]);
    }

    /**
     * lấy tất cả các phiếu mượn trả
     * @param array $limitOptions
     * @return array
     */
    public function getAllLoans(array $limitOptions = [], int|string $returned = 'all') : array {
        $sql = "SELECT * FROM $this->table";
        if(is_numeric($returned) && ($returned == 0 || $returned == 1)) {
            $sql .= " WHERE returned=:returned";
        }
        if(!empty($limitOptions)) {
            $sql .= " ORDER BY dueDate DESC LIMIT :length OFFSET :offset";
            $offset = 0;
            if(count($limitOptions) > 1) {
                $offset += $limitOptions[1];
            }

            if(is_numeric($offset) && is_numeric($limitOptions[0])) {
                if(is_numeric($returned) && ($returned == 0 || $returned == 1)) {
                    return $this->readLimitLoans($sql, +$limitOptions[0], +$offset, $returned);
                }
                return $this->readLimitLoans($sql, +$limitOptions[0], +$offset);
            }
            return [];
        } else {
            $sql .= " ORDER BY dueDate DESC";
            if(is_numeric($returned) && ($returned == 0 || $returned == 1)) {
                return $this->read($sql, ['returned' => $returned]);
            }
            return $this->read($sql);
        }
    }

    /**
     * Lấy giới hạn phần tử
     *
     * @param string $sql
     * @param integer $length số phần tử cần lấy
     * @param integer $offset vị trí hàng bắt đầu lấy
     * @param int|string $returned trang thái phiếu
     * @return array
     */
    public function readLimitLoans(string $sql, int $length, int $offset, int|string $returned = 'all') : array {
        try {
            $query = $this->db->prepare($sql);
            if(is_numeric($returned) && ($returned == 0 || $returned == 1)) {
                $query->bindParam(':returned', $returned, \PDO::PARAM_INT);
            }
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
     * lấy phiếu theo id
     *
     * @param string $loanId
     * @return array
     */
    public function getLoanById(string $loanId) : array {
        $sql = "SELECT l.*, u.userName FROM $this->table l JOIN users u ON l.userId = u.userId WHERE l.loanId = ?";
        return $this->read($sql, [$loanId], 'single');
    }

    /**
     * lấy số lượng theo trạng thái
     *
     * @param integer $returned 0 - phiếu mượn, 1 - phiếu trả
     * @return integer
     */
    public function getCountLoan(int $returned) : int {
        $sql = "SELECT * FROM $this->table WHERE returned = ?";
        return $this->read($sql, [$returned], "count");
    }

    /**
     * lấy số lượng theo userId và trạng thái
     *
     * @param integer $returned 0 - phiếu mượn, 1 - phiếu trả
     * @return integer
     */
    public function getCountLoanByUserId(string $userId, int $returned) : int {
        $sql = "SELECT * FROM $this->table WHERE returned = ? AND userId = ?";
        return $this->read($sql, [$returned, $userId], "count");
    }

    /**
     * Lấy tất cả phiếu theo userId và trang thái có giới hạn
     *
     * @param string $userId
     * @param integer $returned
     * @param array $limitOptions
     * @return array
     */
    public function getLoanByUserId(string $userId, int $returned, array $limitOptions = []) : array {
        $sql = "SELECT * FROM $this->table l join detailLoan d on l.loanId = d.loanId WHERE l.userId=:userId AND l.returned=:returned ORDER BY l.dueDate DESC";
        if(!empty($limitOptions)) {
            $sql .= " LIMIT :length OFFSET :offset";
            $offset = 0;
            if(count($limitOptions) > 1) {
                $offset += $limitOptions[1];
            }

            if(is_numeric($offset) && is_numeric($limitOptions[0])) {
                try {
                    $query = $this->db->prepare($sql);
                    $query->bindParam(':userId', $userId);
                    $query->bindParam(':returned', $returned, \PDO::PARAM_INT);
                    $query->bindParam(':length', $limitOptions[0], \PDO::PARAM_INT);
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
            return [];
        } else {
            return $this->read($sql, [$userId, $returned]);
        }
    }

    /**
     * Cập nhật trạng thái phiếu
     *
     * @param string $loanId
     * @return integer|false
     */
    public function updateReturned(string $loanId) : int|false {
        $sql = "UPDATE $this->table SET returned = 1 WHERE loanId=?";
        return $this->update($sql, [$loanId]);
    }

    /**
     * cập nhật ngày trả
     *
     * @param array $post
     * @return integer|false
     */
    public function updateDueDate(array $post) : int|false {
        if(!empty($post)) {
            $post['dueDate'] = strtotime($post['dueDate']);
            $current = time();
            if($post['dueDate'] < $current) {
                return false;
            }
            $sql = "UPDATE $this->table SET dueDate=FROM_UNIXTIME(:dueDate) WHERE loanId=:loanId";
            return $this->update($sql, $post);
        }
        return false;
    }
}
?>