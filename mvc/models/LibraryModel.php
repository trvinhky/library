<?php 
class LibraryModel extends DB {
    protected string $table = 'library';
    protected array $cols = [
        'libraryId', 'libraryName',
        'libraryLocation'
    ];

    /**
     * Thêm thư viện
     *
     * @param array $post
     * @return boolean
     */
    public function createLibrary(array $post) : bool {
        if(!empty($post)) {
            $sql = "INSERT INTO $this->table (libraryName, libraryLocation) VALUES (:libraryName, :libraryLocation)";
            return $this->insert($sql, $post);
        }
        return false;
    }

    /**
     * Cập nhật thư viện
     *
     * @param array $post
     * @return integer|false
     */
    public function updateLibrary(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET libraryName=:libraryName, libraryLocation=:libraryLocation WHERE libraryId=:libraryId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy thông tin thư viện
     *
     * @param integer $libraryId
     * @return array
     */
    public function getLibraryById(int $libraryId) : array {
        $sql = "SELECT * FROM $this->table WHERE libraryId = ?";
        return $this->read($sql, [$libraryId], "single");
    }
}
?>