<?php 
class BookshelfModel extends DB {
    protected string $table = 'bookshelf';
    protected array $cols = [
        'bookshelfId', 'bookshelfLocation',
        'libraryId'
    ];

    /**
     * Thêm vị trí trong thư viện
     *
     * @param array $post
     * @return boolean
     */
    public function createBookshelf(array $post) : bool {
        if(!empty($post)) {
            $sql = "INSERT INTO $this->table (libraryId, bookshelfLocation) VALUES (:libraryId, :bookshelfLocation)";
            return $this->insert($sql, $post);
        }
        return false;
    }

    /**
     * lấy vị trí theo id thư viện
     *
     * @param integer $libraryId
     * @return array
     */
    public function getBookshelfAllByLibraryId(int $libraryId) : array {
        $sql = "SELECT * FROM $this->table WHERE libraryId = ?";
        return $this->read($sql, [$libraryId]);
    }

    /**
     * lấy tổng vị trí theo id thư viện
     *
     * @param integer $libraryId
     * @return integer
     */
    public function getRowCountByLibraryId(int $libraryId): int {
        $sql = "SELECT * FROM $this->table WHERE libraryId = ?";
        return $this->read($sql, [$libraryId], 'count');
    }

    /**
     * Cập nhật vị trí trong thư viện
     *
     * @param array $post
     * @return integer|false
     */
    public function updateBookshelf(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET bookshelfLocation=:bookshelfLocation WHERE bookshelfId=:bookshelfId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy vị trí trong thư viện theo id
     *
     * @param integer $bookshelfId
     * @return array
     */
    public function getBookshelfById(int $bookshelfId) : array {
        $sql = "SELECT * FROM $this->table WHERE bookshelfId = ?";
        return $this->read($sql, [$bookshelfId], "single");
    }

    /**
     * Lấy tên thư viện
     *
     * @param integer $bookshelfId
     * @return string
     */
    public function getLibraryNameById(int $bookshelfId) : string {
        $sql = "SELECT l.libraryName FROM $this->table b JOIN library l ON b.libraryId = l.libraryId WHERE bookshelfId = ?";
        $library = $this->read($sql, [$bookshelfId], "single");
        if(!empty($library)) {
            return $library['libraryName'];
        }
        return '';
    }

    /**
     * Xóa vị trí trong thư viện
     *
     * @param integer $bookshelfId
     * @return boolean
     */
    public function deleteBookshelf(int $bookshelfId) : bool {
        $this->db->beginTransaction();
        try {
            $sql = "DELETE FROM location WHERE bookshelfId = ?";
            $query = $this->db->prepare($sql);
            $query->execute([$bookshelfId]);

            $sql = "DELETE FROM $this->table WHERE bookshelfId = ?";
            $query = $this->db->prepare($sql);
            $query->execute([$bookshelfId]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Không thể xóa dữ liệu theo bookId: " . $e->getMessage();
            return false;
        }
    }
}
?>