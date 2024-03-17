<?php

class LocationModel extends DB {
    protected string $table = 'location';
    protected array $cols = [
        'bookId', 'bookshelfId', 'quantity'
    ];
    
    /**
     * tạo vị trí sách
     *
     * @param array $post
     * @return boolean
     */
    public function createLocation(array $post) : bool {
        if(!empty($post)) {
            return $this->insertData($post);
        }
        return false;
    }

    /**
     * Lấy tất cả số lượng sách theo id
     *
     * @param string $bookId
     * @return array
     */
    public function getAllByBookId(string $bookId) : array {
        $sql = "SELECT * FROM $this->table WHERE bookId = ?";
        return $this->read($sql, [$bookId]);
    }

    /**
     * Tổng tất cả số lượng sách theo id
     *
     * @return integer
     */
    public function getRowCountByBookId(string $bookId): int {
        $sql = "SELECT * FROM $this->table WHERE bookId = ?";
        return $this->read($sql, [$bookId], 'count');
    }

    /**
     * Cập nhật số lượng sách theo id sách
     *
     * @param array $post
     * @return boolean
     */
    public function updateQuantityByBookId(array $post) : bool {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET quantity=:quantity WHERE bookId=:bookId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * Cập nhật số lượng sách theo khóa chính
     *
     * @param array $post
     * @return boolean
     */
    public function updateQuantity(array $post) : bool {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET quantity=:quantity WHERE bookId=:bookId AND bookshelfId=:bookshelfId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy thông tin theo khóa chính
     *
     * @param string $bookId
     * @param integer $bookshelfId
     * @return array
     */
    public function getInforLocation(string $bookId, int $bookshelfId) : array {
        $sql = "SELECT * FROM $this->table WHERE bookId = ? AND bookshelfId = ?";
        return $this->read($sql, [$bookId, $bookshelfId], 'single');
    }

    /**
     * Cập nhật số lượng sách theo id thư viện cho id sách
     *
     * @param array $post
     * @return boolean
     */
    public function updateQuantityByLibraryId(array $post) : bool {
        if(!empty($post)) {
            $sql = "CALL UPDATE_QUANTITY_LIBRARYID(:libraryId, :bookId, :quantity)";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy số lượng sách theo bookId
     *
     * @param string $bookId
     * @return integer
     */
    public function getQuantityByBookId(string $bookId) : int {
        $sql = "SELECT quantity FROM $this->table WHERE bookId = ?";
        $location = $this->read($sql, [$bookId], 'single');
        if(!empty($location)) {
            return $location['quantity'];
        }
        return 0;
    }

    /**
     * Lấy thông tin thư viện kèm số lượng sách theo bookId
     *
     * @param string $bookId
     * @return array
     */
    public function getInforLocationForDetail(string $bookId) : array {
        $sql = "SELECT lb.*, lc.quantity, bf.bookshelfLocation FROM $this->table lc JOIN bookshelf bf ON lc.bookshelfId = bf.bookshelfId JOIN library lb ON lb.libraryId = bf.libraryId WHERE lc.bookId = ?";
        return $this->read($sql, [$bookId]);
    }

    /**
     * lấy số lượng sách theo id thư viện
     *
     * @param integer $libraryId
     * @return array
     */
    public function getQuantityByLibraryId(int $libraryId) : array {
        $sql = "SELECT lc.quantity FROM $this->table lc JOIN bookshelf bf ON lc.bookshelfId = bf.bookshelfId WHERE bf.libraryId = ?";
        return $this->read($sql, [$libraryId]);
    }

    /**
     * Lấy vị trí sách trên kệ
     *
     * @param string $bookId
     * @return array
     */
    public function getLocationShelf(string $bookId) : array {
        $sql = "SELECT bf.* FROM $this->table lc JOIN bookshelf bf ON lc.bookshelfId = bf.bookshelfId WHERE lc.bookId = ?";
        return $this->read($sql, [$bookId]);
    }
}
?>