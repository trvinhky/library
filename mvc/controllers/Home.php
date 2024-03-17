<?php
define('LENGTH', 6);
class Home extends Controller {
    public function search() : void {
        if(!array_key_exists('search', $_GET)) {
            redirect('/');
        }
        if(strlen($_GET['search']) < 3) {
            redirect('/');
        }
        $bookModel = $this->model('BookModel');
        $books = $bookModel->findBookByTitle($_GET['search']);
        $count = $bookModel->findBookCountByTitle($_GET['search']);
        $results = [];
        if(empty($books)) {
            $count = 0;
        } else {
            foreach($books as $book) {
                $bookInfor = $bookModel->getBookById($book['@bookId']);
                $bookInfor['authorName'] = $book['@authorName'];
                $bookInfor['publisherName'] = $book['@publisherName'];
                $results[] = $bookInfor;
            }
        }
        // loại
        $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->readAll();
        $listCategories = [];
        if(!empty($categories)) {
            foreach($categories as $category) {
                $category['quantity'] = $categoryModel->getTotalBook($category['categoryId']);
                $listCategories[] = $category;
            }
        }

        // tác giả
        $authorModel = $this->model('AuthorModel');
        $authors = $authorModel->readAll();
        $listAuthors = [];
        if(!empty($authors)) {
            foreach($authors as $author) {
                $author['quantity'] = $authorModel->getTotalBook($author['authorId']);
                $listAuthors[] = $author;
            }
        }

        // chủ đề
        $topicModel = $this->model('TopicModel');
        $topics = $topicModel->readAll();
        $listTopics = [];
        if(!empty($topics)) {
            foreach($topics as $topic) {
                $topic['quantity'] = $topicModel->getTotalBook($topic['topicId']);
                $listTopics[] = $topic;
            }
        }

        // nhà xuất bản
        $publisherModel = $this->model('PublisherModel');
        $publishers = $publisherModel->readAll();
        $listPublishers = [];
        if(!empty($publishers)) {
            foreach($publishers as $publisher) {
                $publisher['quantity'] = $publisherModel->getTotalBook($publisher['publisherId']);
                $listPublishers[] = $publisher;
            }
        }
        
        $sumBooks = $bookModel->getRowCount();

        $this->view('index', [
            'title' => 'Tìm kiếm - '.$_GET['search'],
            'content' => 'search',
            'categories' => $listCategories,
            'authors' => $listAuthors,
            'publishers' => $listPublishers,
            'topics' => $listTopics,
            'total' => $sumBooks,
            'count' => $count,
            'books' => $results
        ]);
    }

    public function addLoan(string $libraryId, string $bookId) : void {
        if(!isset($_COOKIE['userId'])) {
            redirect('/login');
        }
        if(!(strlen($bookId) > 0 && is_numeric($libraryId))) {
            redirect('/');
        }
        $loanModel = $this->model('LoanModel');
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['userId'] = $_COOKIE['userId'];
                $_POST['bookId'] = $bookId;
                $feedback = $loanModel->createLoan($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/");
                } else {
                    echo "<script>alert('Thêm phiếu thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $bookModel = $this->model("BookModel");
        $book = $bookModel->getBookById($bookId);
        $library = ($this->model('LibraryModel'))->getLibraryById($libraryId);
        if(!empty($library)) {
            $listQuantity = ($this->model('LocationModel'))->getQuantityByLibraryId($library['libraryId']);
            $total = 0;
            if(!empty($listQuantity)) {
                foreach($listQuantity as $quantity) {
                    $total += $quantity['quantity'];
                }
            }
            $library['quantity'] = $total;
        }

        $this->view('index', [
            'title' => 'Tạo Phiếu Mượn',
            'content' => 'addLoan',
            'book' => $book,
            'library' => $library
        ]);
    }

    // chi tiết phiếu mượn/trả
    public function detailLoan(string $id) : void {
        if(strlen($id) == 0) {
            redirect('/');
        }

        $loan = ($this->model("LoanModel"))->getLoanById($id);
        $detailLoan = [];
        if(!empty($loan)) {
            $loan['returned'] = $loan['returned'] == 1 ? 'Đã trả' : 'Chưa trả';
            $detailLoan =  ($this->model("DetailLoanModel"))->getLoanQuantityByLoan($loan['loanId']);
        }

        $detail = [];
        if(!empty($detailLoan)) {
            foreach($detailLoan as $det) {
                $book = ($this->model('BookModel'))->getBookInfor($det['bookId']);
                $det['authorName'] = $book['@authorName'];
                $det['publisherName'] = $book['@publisherName'];
                $det['topicName'] = ($this->model('TopicModel'))->getTopicNameById($det['topicId']);
                $det['categoryName'] = ($this->model('CategoryModel'))->getCategoryName($det['categoryId']);
                $location = ($this->model('LocationModel'))->getInforLocationForDetail($det['bookId']);
                $det['libraryName'] = $location[0]['libraryName'];
                $det['libraryLocation'] = $location[0]['libraryLocation'];
                $det['bookshelfLocation'] = $location[0]['bookshelfLocation'];
                $detail[] = $det;
            }
        }
        $this->view('index', [
            'title' => 'Trang Chi Tiết phiếu',
            'content' => 'detailLoan',
            'loan' => $loan,
            'detail' => $detail
        ]);
    }

    // chi tiết sách
    public function detail(string $id) :void {
        if(strlen($id) == 0) {
            redirect('/');
        }

        $bookModel = $this->model("BookModel");
        $book = $bookModel->getBookInfor($id);
        $libraries = [];
        if(!empty($book)) {
            $bookInfor = $bookModel->getBookById($book['@bookId']);
            $book['authorName'] = ($this->model('AuthorModel'))->getAuthorName($bookInfor['authorId']);
            $book['publisherName'] = ($this->model('PublisherModel'))->getPublisherName($bookInfor['publisherId']);
            $book['categoryName'] = ($this->model('CategoryModel'))->getCategoryName($bookInfor['categoryId']);
            $book['topicName'] = ($this->model('TopicModel'))->getTopicNameById($bookInfor['topicId']);

            $locationModel = $this->model('LocationModel');
            $book['quantity'] = $locationModel->getQuantityByBookId($book['@bookId']);
            $loanQuantity = ($this->model('DetailLoanModel'))->getLoanQuantity($book['@bookId']);
            $book['ready'] = $book['quantity'] - $loanQuantity;
            $book['infor'] = $bookInfor;
            $locations = $locationModel->getLocationShelf($book['@bookId']);
            $str = "";
            if(!empty($locations)) {
                foreach($locations as $key => $location) {
                    if($key > 0) {
                        $str .= ", ";
                    }
                    $str .= $location['bookshelfLocation'];
                }
            }
            $book['locations'] = $str;
            $libraries = $locationModel->getInforLocationForDetail($book['@bookId']);
        }
        
        $this->view('index', [
            'title' => 'Trang Chi Tiết - '.$book['infor']['title'],
            'content' => 'detailBook',
            'book' => $book,
            'libraries' => $libraries
        ]);
    }

    public function render() :void {
        $books = ($this->model("BookModel"))->getAllBooks([LENGTH]);
        $results = [];
        if(!empty($books)) {
            foreach($books as $book) {
                $book['authorName'] = ($this->model('AuthorModel'))->getAuthorName($book['authorId']);
                $book['publisherName'] = ($this->model('PublisherModel'))->getPublisherName($book['publisherId']);
                $results[] = $book;
            }
        }

        $this->view('index', [
            'title' => 'Trang Chủ',
            'content' => 'home',
            'books' => $results
        ]);
    }
}
?>