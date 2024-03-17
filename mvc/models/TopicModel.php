<?php 
class TopicModel extends DB {
    protected string $table = 'topic';
    protected array $cols = [
        'topicId', 'topicName'
    ];

    /**
     * Thêm chủ đề
     *
     * @param string $topicName
     * @return boolean
     */
    public function createTopic(string $topicName) : bool {
        $sql = "INSERT INTO $this->table (topicName) VALUES (?)";
        return $this->insert($sql, [$topicName]);
    }

    /**
     * Cập nhật chủ đề
     *
     * @param array $post
     * @return integer|false
     */
    public function updateTopic(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET topicName=:topicName WHERE topicId=:topicId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy tên chủ đề theo id
     *
     * @param integer $topicId
     * @return string
     */
    public function getTopicNameById(int $topicId) : string {
        $sql = "SELECT * FROM $this->table WHERE topicId = ?";
        $topic = $this->read($sql, [$topicId], 'single');
        if(!empty($topic)) {
            return $topic['topicName'];
        }
        return '';
    }

    /**
     * lấy số lượng sách của chủ đề
     *
     * @param integer $topicId
     * @return integer
     */
    public function getTotalBook(int $topicId) : int {
        $sql = "SELECT * FROM $this->table a JOIN books b ON a.topicId = b.topicId WHERE b.topicId = ?";
        return $this->read($sql, [$topicId], "count");
    }
}
?>