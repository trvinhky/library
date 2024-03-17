<?php 
class PublisherModel extends DB {
    protected string $table = 'publisher';
    protected array $cols = [
        'publisherId', 'publisherName'
    ];

    /**
     * Thêm nhà xuất bản
     *
     * @param string $publisherName
     * @return boolean
     */
    public function createPublisher(string $publisherName) : bool {
        $sql = "INSERT INTO $this->table (publisherName) VALUES (?)";
        return $this->insert($sql, [$publisherName]);
    }

    /**
     * Cập nhật nhà xuất bản
     *
     * @param array $post
     * @return integer|false
     */
    public function updatePublisher(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET publisherName=:publisherName WHERE publisherId=:publisherId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy tên nhà xuất bản theo id
     *
     * @param integer $publisherId
     * @return string
     */
    public function getPublisherName(int $publisherId) : string {
        $sql = "SELECT * FROM $this->table WHERE publisherId = ?";
        $publisher = $this->read($sql, [$publisherId], 'single');
        if(!empty($publisher)) {
            return $publisher['publisherName'];
        }
        return '';
    }

   /**
     * lấy số lượng sách của nhà xuất bản
     *
     * @param integer $authorId
     * @return integer
     */
    public function getTotalBook(int $publisherId) : int {
        $sql = "SELECT * FROM $this->table a JOIN books b ON a.publisherId = b.publisherId WHERE b.publisherId = ?";
        return $this->read($sql, [$publisherId], "count");
    }
}
?>