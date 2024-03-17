<?php 
class AuthorModel extends DB {
    protected string $table = 'author';
    protected array $cols = [
        'authorId', 'authorName'
    ];

    /**
     * Thêm tác giả
     *
     * @param string $authorName
     * @return boolean
     */
    public function createAuthor(string $authorName) : bool {
        $sql = "INSERT INTO $this->table (authorName) VALUES (?)";
        return $this->insert($sql, [$authorName]);
    }

    /**
     * lấy tên tác giả theo id
     *
     * @param integer $authorId
     * @return string
     */
    public function getAuthorName(int $authorId) : string {
        $sql = "SELECT * FROM $this->table WHERE authorId = ?";
        $author = $this->read($sql, [$authorId], 'single');
        if(!empty($author)) {
            return $author['authorName'];
        }
        return '';
    }

    /**
     * Cập nhật tác giả
     *
     * @param array $post
     * @return integer|false
     */
    public function updateAuthor(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET authorName=:authorName WHERE authorId=:authorId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy số lượng sách của tác giả
     *
     * @param integer $authorId
     * @return integer
     */
    public function getTotalBook(int $authorId) : int {
        $sql = "SELECT * FROM $this->table a JOIN books b ON a.authorId = b.authorId WHERE b.authorId = ?";
        return $this->read($sql, [$authorId], "count");
    }
}
?>