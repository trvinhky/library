<?php

class BookModel extends DB {
    protected string $table = 'books';
    protected array $cols = [
        'bookId', 'title', 'photoURL', 
        'yearPublished', 'pages', 'authorId',
        'publisherId', 'categoryId', 'topicId'
    ];
    
    /**
     * tạo sách
     *
     * @param array $post
     * @return boolean
     */
    public function createBook(array $post) : bool {
        if(!empty($post)) {
            $data = $post;
            $data['yearPublished'] = +$data['yearPublished'];
            $data['pages'] = +$data['pages'];
            $data['authorId'] = +$data['authorId'];
            $data['publisherId'] = +$data['publisherId'];
            $data['categoryId'] = +$data['categoryId'];
            $data['topicId'] = +$data['topicId'];
            $data["bookId"] = uniqid();
            $data['photoURL'] = "/images/".$data['photoURL'];

            $sql = "CALL ADD_BOOK(:".implode(", :", $this->cols).")";
            return $this->insert($sql, $data);
        }
        return false;
    }

    /**
     * lấy thông tin sách
     *
     * @param string $bookId
     * @return array
     */
    public function getBookInfor(string $bookId) : array {
        $sql = "CALL GET_BOOK(:bookId, @bookId, @authorName, @publisherName)";
        $query = $this->db->prepare($sql);
        $query->execute(['bookId' => $bookId]);

        $sql = "SELECT @bookId, @authorName, @publisherName";
        return $this->read($sql, [], "single");
    }

    /**
     * lấy thông tin sách theo id
     *
     * @param string $bookId
     * @return array
     */
    public function getBookById(string $bookId) : array {
        $sql = "SELECT * FROM $this->table WHERE bookId = ?";
        return $this->read($sql, [$bookId], 'single');
    }

    /**
     * Lấy tất cả sách
     *
     * @param array $limitOptions [length, offset]
     * @return array
     */
    public function getAllBooks(array $limitOptions = []) : array {
        $sql = "SELECT * FROM $this->table";
        if(!empty($limitOptions)) {
            $sql .= " ORDER BY yearPublished DESC LIMIT :length OFFSET :offset";
            $offset = 0;
            if(count($limitOptions) > 1) {
                $offset += $limitOptions[1];
            }

            if(is_numeric($offset) && is_numeric($limitOptions[0])) {
                return $this->readLimit($sql, +$limitOptions[0], +$offset);
            }
            return [];
        } else {
            $sql .= " ORDER BY yearPublished DESC";
            return $this->read($sql);
        }
    }

    /**
     * lấy số lượng sách theo id của 1 thư viện
     *
     * @param string $bookId
     * @param integer $libraryId
     * @return integer
     */
    public function getQuantityBookInLibrary(string $bookId, int $libraryId) : int {
        $sql = "SELECT GET_QUANTITY(:bookId, :libraryId) quantity FROM $this->table WHERE bookId=:bookId";
        $quantity = $this->read($sql, ["bookId" => $bookId, "libraryId" => $libraryId]);

        if(!empty($quantity)) return $quantity['quantity'];
        return 0;
    }

    /**
     * cập nhật thông tin sách
     *
     * @param array $post
     * @return integer|false
     */
    public function updateBookInfor(array $post) : int|false {
        if(!empty($post)) {
            $data = $post;
            $data['yearPublished'] = +$data['yearPublished'];
            $data['pages'] = +$data['pages'];
            $data['authorId'] = +$data['authorId'];
            $data['publisherId'] = +$data['publisherId'];
            $data['categoryId'] = +$data['categoryId'];
            $data['topicId'] = +$data['topicId'];
            $keys = [];
            foreach($this->cols as $key) {
                if($key == 'bookId') {
                    continue;
                }
                $str = "$key=:$key";
                $keys[] = $str;
            }
            $sql = "UPDATE $this->table SET ".implode(", ", $keys)." WHERE bookId=:bookId";
            return $this->update($sql, $data);
        }
        return false;
    }

    /**
     * lọc sách
     *
     * @param int $id
     * @param string $name (author, publisher, topic, category)
     * @return array
     */
    
    public function fillterBook(int $id, string $name) : array {
        $sql = "SELECT * FROM $this->table WHERE ";
        if($name == 'author') {
            $sql .= "authorId = ?";
        } else if($name = "publisher") {
            $sql .= "publisherId = ?";
        }else if($name = "topic") {
            $sql .= "topicId = ?";
        }else if($name = "category") {
            $sql .= "categoryId = ?";
        } else {
            return [];
        }
        return $this->read($sql, [$id]);
    }

    /**
     * tìm kiếm theo tên sách
     *
     * @param string $title
     * @return array
     */
    public function findBookByTitle(string $title) : array {
        $sql = "CALL FIND_BOOK_TITLE(:title, @bookId, @authorName, @publisherName)";
        $query = $this->db->prepare($sql);
        $query->execute(['title' => $title]);

        $sql = "SELECT @bookId, @authorName, @publisherName";
        $books = $this->read($sql);
        $check = false;
        foreach($books as $book) {
            if($book['@bookId'] == null) {
                $check = true;
                break;
            }
        }
        if($check) return [];
        return $books;
    }

    /**
     * số lượng tìm thấy
     *
     * @param string $title
     * @return int
     */
    public function findBookCountByTitle(string $title) : int {
        $sql = "CALL FIND_BOOK_TITLE(:title, @bookId, @authorName, @publisherName)";
        $query = $this->db->prepare($sql);
        $query->execute(['title' => $title]);

        $sql = "SELECT @bookId, @authorName, @publisherName";
        return $this->read($sql, [], 'count');
    }

    /**
     * Xóa sách
     *
     * @param string $bookId
     * @return boolean
     */
    public function deleteBook(string $bookId) : bool {
        $this->db->beginTransaction();
        try {
            $sql = "DELETE FROM location WHERE bookId = ?";
            $query = $this->db->prepare($sql);
            $query->execute([$bookId]);

            $sql = "DELETE FROM $this->table WHERE bookId = ?";
            $query = $this->db->prepare($sql);
            $query->execute([$bookId]);
            
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