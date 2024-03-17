<?php 
class CategoryModel extends DB {
    protected string $table = 'category';
    protected array $cols = [
        'categoryId', 'categoryName'
    ];

    /**
     * Thêm loại
     *
     * @param string $categoryName
     * @return boolean
     */
    public function createCategory(string $categoryName) : bool {
        $sql = "INSERT INTO $this->table (categoryName) VALUES (?)";
        return $this->insert($sql, [$categoryName]);
    }

    /**
     * Cập nhật loại
     *
     * @param array $post
     * @return integer|false
     */
    public function updateCategory(array $post) : int|false {
        if(!empty($post)) {
            $sql = "UPDATE $this->table SET categoryName=:categoryName WHERE categoryId=:categoryId";
            return $this->update($sql, $post);
        }
        return false;
    }

    /**
     * lấy tên loại theo id
     *
     * @param integer $categoryId
     * @return string
     */
    public function getCategoryName(int $categoryId) : string {
        $sql = "SELECT * FROM $this->table WHERE categoryId = ?";
        $category = $this->read($sql, [$categoryId], 'single');
        if(!empty($category)) {
            return $category['categoryName'];
        }
        return '';
    }

    /**
     * lấy số lượng sách của loại
     *
     * @param integer $categoryId
     * @return integer
     */
    public function getTotalBook(int $categoryId) : int {
        $sql = "SELECT * FROM $this->table a JOIN books b ON a.categoryId = b.categoryId WHERE b.categoryId = ?";
        return $this->read($sql, [$categoryId], "count");
    }
}
?>