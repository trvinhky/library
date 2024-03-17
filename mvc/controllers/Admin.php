<?php
define('LENGTH', 10);
class Admin extends Controller {
    public function __construct() {
        if(!isset($_COOKIE['adminId'])) {
            redirect('/login/admin');
        } else {
            $admin = $this->model("AdminModel");
            $infor = $admin->getAdminInfor($_COOKIE['adminId']);
            if(empty($infor)) {
                redirect('/login/admin');
            }
        }
    }
    // location
    public function addLocation(string $id, string $libId) : void {
        if(!(strlen($id) > 0 && is_numeric($libId))) {
            redirect('/admin/books');
        }
        $locationModel = $this->model('LocationModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['bookId'] = $id;
                $_POST['bookshelfId'] = +$_POST['bookshelfId'];
                $feedback = $locationModel->createLocation($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/locations/$id");
                } else {
                    echo "<script>alert('Thêm vị trí và số lượng sách thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $bookshelfs = ($this->model('BookshelfModel'))->getBookshelfAllByLibraryId(+$libId);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm vị trí và số lượng',
            'content' => 'formLocation',
            'adminName' => $adminName,
            'bookshelfs' => $bookshelfs,
            'subTitle' => 'Thêm vị trí và số lượng'
        ]);
    }

    public function chooseLibrary(string $id) : void {
        if(strlen($id) == 0) redirect("/admin/books");

        $libraryModel = $this->model('LibraryModel');
        $libraries = $libraryModel->readAll();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                redirect("/admin/addLocation/$id/".$_POST['libraryId']);
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Chọn thư viện',
            'content' => 'chooseLibraries',
            'adminName' => $adminName,
            'libraries' => $libraries
        ]);
    }

    public function editLocation(string $bookId, string $bookshelfId) : void {
        if(!(strlen($bookId) > 0 && is_numeric($bookshelfId))) redirect('/admin/locations');
        $locationModel = $this->model('LocationModel');
        $bookshelfId = +$bookshelfId;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['bookshelfId'] = +$bookshelfId;
                $_POST['bookId'] = $bookId;
                $feedback = $locationModel->updateQuantity($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/locations/".$bookId);
                } else {
                    echo "<script>alert('Cập nhật số lượng sách theo id sách thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        $location = $locationModel->getInforLocation($bookId, $bookshelfId);
        $bookshelfModel = $this->model('BookshelfModel');
        $bookshelf = $bookshelfModel->getBookshelfById($location['bookshelfId']);
        $bookshelfs = ($this->model('BookshelfModel'))->getBookshelfAllByLibraryId($bookshelf['libraryId']);
        $this->view('admin', [
            'title' => 'Cập nhật vị trí và số lượng',
            'content' => 'formLocation',
            'adminName' => $adminName,
            'bookshelfs' => $bookshelfs,
            'subTitle' => 'Cập nhật vị trí và số lượng',
            'values' => $location
        ]);
    }

    public function locations(string $id) : void {
        if(strlen($id) == 0) {
            redirect('/admin/books');
        }
        $locationModel = $this->model('LocationModel');
        $locations = $locationModel->getAllByBookId($id);
        $count = $locationModel->getRowCountByBookId($id);

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        $results = [];
        if(!empty($locations)) {
            foreach($locations as $location) {
                $bookshelfModel = $this->model('BookshelfModel');
                $bookshelf = $bookshelfModel->getBookshelfById($location['bookshelfId']);
                $bookshelfLocation = $bookshelf['bookshelfLocation'];
                $location['bookshelfLocation'] = $bookshelfLocation;
                $libraryName = $bookshelfModel->getLibraryNameById($location['bookshelfId']);
                $location['libraryName'] = $libraryName;
                $results[] = $location;
            }
        }

        $this->view('admin', [
            'title' => 'Quản lý số lượng sách',
            'content' => 'locations',
            'count' => $count,
            'adminName' => $adminName,
            'locations' => $results,
            'id' => $id
        ]);

    }

    // admin
    public function addAdmin() : void {
        $admin = $this->model("AdminModel");

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $admin->registerAccount($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin");
                } else {
                    echo "<script>alert('Đăng ký thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        $this->view('admin', [
            'title' => 'Tạo quản trị viên',
            'content' => 'addAdmin',
            'adminName' => $adminName
        ]);
    }

    // nhà xuất bản
    public function editPublisher(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/publishers');

        $publisherModel = $this->model('PublisherModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['publisherId'] = $id;
                $feedback = $publisherModel->updatePublisher($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/publishers");
                } else {
                    echo "<script>alert('Cập nhật nhà xuất bản thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $publisherName = $publisherModel->getPublisherName($id);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm nhà xuất bản',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'publisherName',
            'text' => 'Nhập vào tên nhà xuất bản',
            'label' => 'Tên Nhà Xuất Bản',
            'value' => $publisherName
        ]);
    }

    public function addPublisher() : void {
        $publisherModel = $this->model('PublisherModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $publisherModel->createPublisher($_POST['publisherName']);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/publishers");
                } else {
                    echo "<script>alert('Thêm nhà xuất bản thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm nhà xuất bản',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'publisherName',
            'text' => 'Nhập vào tên nhà xuất bản',
            'label' => 'Tên Nhà Xuất Bản'
        ]);
    }

    public function publishers() : void {
        $publisherModel = $this->model('PublisherModel');
        $publishers = $publisherModel->readAll();
        $count = $publisherModel->getRowCount();
        $results = [];
        if(!empty($publishers)) {
            foreach($publishers as $publisher) {
                $quantity = $publisherModel->getTotalBook($publisher['publisherId']);
                $publisher['quantity'] = $quantity;
                $results[] = $publisher;
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý nhà xuất bản',
            'content' => 'publishers',
            'count' => $count,
            'adminName' => $adminName,
            'publishers' => $results
        ]);
    }

    // chủ đề
    public function editTopic(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/topics');

        $topicModel = $this->model('TopicModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['topicId'] = $id;
                $feedback = $topicModel->updateTopic($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/topics");
                } else {
                    echo "<script>alert('Cập nhật chủ đề thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $topicName = $topicModel->getTopicNameById($id);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Cập nhật chủ đề',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'topicName',
            'text' => 'Nhập vào tên chủ đề',
            'label' => 'Tên Chủ Đề',
            'value' => $topicName
        ]);
    }

    public function addTopic() : void {
        $topicModel = $this->model('TopicModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $topicModel->createTopic($_POST['topicName']);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/topics");
                } else {
                    echo "<script>alert('Thêm chủ đề thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm chủ đề',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'topicName',
            'text' => 'Nhập vào tên chủ đề',
            'label' => 'Tên Chủ Đề'
        ]);
    }

    public function topics() : void {
        $topicModel = $this->model('TopicModel');
        $topics = $topicModel->readAll();
        $count = $topicModel->getRowCount();
        $results = [];
        if(!empty($topics)) {
            foreach($topics as $topic) {
                $quantity = $topicModel->getTotalBook($topic['topicId']);
                $topic['quantity'] = $quantity;
                $results[] = $topic;
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý chủ đề',
            'content' => 'topics',
            'count' => $count,
            'adminName' => $adminName,
            'topics' => $results
        ]);
    }

    // thể loại
    public function editCategory(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/categories');

        $categoryModel = $this->model('CategoryModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['categoryId'] = $id;
                $feedback = $categoryModel->updateCategory($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/categories");
                } else {
                    echo "<script>alert('Cập nhật loại thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $categoryName = $categoryModel->getCategoryName($id);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Cập Nhật loại',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'categoryName',
            'text' => 'Nhập vào tên loại',
            'label' => 'Tên Loại',
            'value' => $categoryName
        ]);
    }

    public function addCategory() : void {
        $categoryModel = $this->model('CategoryModel');
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $categoryModel->createCategory($_POST['categoryName']);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/categories");
                } else {
                    echo "<script>alert('Thêm loại thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm loại',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'categoryName',
            'text' => 'Nhập vào tên loại',
            'label' => 'Tên Loại'
        ]);
    }

    public function categories() : void {
        $categoryModel = $this->model('CategoryModel');
        $categories = $categoryModel->readAll();
        $count = $categoryModel->getRowCount();
        $results = [];
        if(!empty($categories)) {
            foreach($categories as $category) {
                $quantity = $categoryModel->getTotalBook($category['categoryId']);
                $category['quantity'] = $quantity;
                $results[] = $category;
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý loại',
            'content' => 'categories',
            'count' => $count,
            'adminName' => $adminName,
            'categories' => $results
        ]);
    }

    // vị trí trong thư viện
    public function deleteBookshelf(string $libId, string $id) : void {
        if(!(strlen($id) > 0 && strlen($libId) > 0) || !(is_numeric($id) && is_numeric($libId))) redirect('/admin/libraries');

        $bookshelfModel = $this->model('BookshelfModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedback = $bookshelfModel->deleteBookshelf($id);
            if($feedback) {
                redirect("/admin/bookshelfs/$libId");
            } else {
                echo "<script>alert('Xóa vị trí trong thư viện thất bại vui lòng thử lại sau :((')</script>";
            }
        }

        $bookshelf = $bookshelfModel->getBookshelfById(+$id);
        $bookshelfLocation = '';
        if(!empty($bookshelf)) {
            $bookshelfLocation = $bookshelf['bookshelfLocation'];
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Xóa vị trí kệ sách',
            'content' => 'delete',
            'adminName' => $adminName,
            'subtitle' => " vị trí kệ sách $bookshelfLocation",
            'link' => "bookshelfs/$libId"
        ]);
    }

    public function editBookshelf(string $libId, string $id) : void {
        if(!(strlen($id) > 0 && strlen($libId) > 0) || !(is_numeric($id) && is_numeric($libId))) redirect('/admin/libraries');

        $bookshelfModel = $this->model('BookshelfModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['bookshelfId'] = +$id;
                $feedback = $bookshelfModel->updateBookshelf($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/bookshelfs/$libId");
                } else {
                    echo "<script>alert('Cập nhật vị trí trong thư viện thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }
        $bookshelf = ($bookshelfModel->getBookshelfById(+$id))['bookshelfLocation'];
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Cập nhật vị trí kệ sách',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'bookshelfLocation',
            'text' => 'Nhập vào vị trí kệ sách',
            'label' => 'Vị Trí Kệ Sách',
            'value' => $bookshelf
        ]);
    }

    public function addBookshelf(string $id) : void {
        if(strlen($id) == 0 || !is_numeric($id)) {
            redirect('/admin/libraries');
        }
        
        $bookshelfModel = $this->model('BookshelfModel');
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['libraryId'] = +$id;
                $feedback = $bookshelfModel->createBookshelf($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/bookshelfs/$id");
                } else {
                    echo "<script>alert('Thêm vị trí trong thư viện thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm vị trí kệ sách',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'bookshelfLocation',
            'text' => 'Nhập vào vị trí kệ sách',
            'label' => 'Vị Trí Kệ Sách'
        ]);
    }

    public function bookshelfs(string $id) : void {
        if(strlen($id) == 0 || !is_numeric($id)) {
            redirect('/admin/libraries');
        }
        $bookshelfModel = $this->model('BookshelfModel');
        $bookshelfs = $bookshelfModel->getBookshelfAllByLibraryId($id);
        $count = $bookshelfModel->getRowCountByLibraryId($id);

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý vị trí kệ sách',
            'content' => 'bookshelfs',
            'count' => $count,
            'adminName' => $adminName,
            'bookshelfs' => $bookshelfs,
            'id' => $id
        ]);
    }

    // phiếu mượn/trả sách
    public function editDueDate(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/loans');

        $loanModel = $this->model('LoanModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['loanId'] = $id;
                $feedback = $loanModel->updateDueDate($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/loans");
                } else {
                    echo "<script>alert('Gia hạn thời gian thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $due = $loanModel->getLoanById($id);
        if(!empty($due)) {
            $due['dueDate'] = substr($due['dueDate'], 0, 10);
            $due['loanDate'] = substr($due['loanDate'], 0, 10);
        }
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Gia hạn thời gian trả',
            'content' => 'editDueDate',
            'adminName' => $adminName,
            'due' => $due
        ]);
    }

    public function editReturned(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/loans');

        $loanModel = $this->model('LoanModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedback = $loanModel->updateReturned($id);
            if($feedback) {
                redirect("/admin/loans");
            } else {
                echo "<script>alert('Cập nhật trạng thái phiếu thất bại vui lòng thử lại sau :((')</script>";
            }
        }

        $loan = $loanModel->getLoanById($id);
        $check = strtotime($loan['dueDate']) < time() ? 'Quá hạn' : 'Còn hạn';
        if(!empty($loan)) {
            $loan['dueDate'] = substr($loan['dueDate'], 0, 10);
            $loan['loanDate'] = substr($loan['loanDate'], 0, 10);
        }
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Cập nhật trạng thái mượn',
            'content' => 'editReturned',
            'adminName' => $adminName,
            'loan' => $loan,
            'check' => $check
        ]);

    }

    public function loans(string $page, string $returned = 'all') : void {
        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/admin');
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(!empty($_GET) && isset($_GET['returned'])) {
                $returned = $_GET['returned'];
            }
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $loanModel = $this->model('LoanModel');
        $loans = $loanModel->getAllLoans([LENGTH, $offset], $returned);
        $count = 0;
        if($returned != 'all' && is_numeric($returned) && ($returned == 0 || $returned == 1)) {
            $count = $loanModel->getCountLoan($returned);
        } else {
            $count = $loanModel->getRowCount();
        }
        $cols = ceil($count / LENGTH);
        $loan = $loanModel->getCountLoan(0);
        $due = $loanModel->getCountLoan(1);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        $results = [];
        if(!empty($loans)) {
            foreach($loans as $loan) {
                $user = ($this->model('UserModel'))->getUserInfor($loan['userId']);
                $loan['userName'] = $user['userName'];
                $loan['returned'] = $loan['returned'] == 1 ? 'Đã trả' : 'Chưa trả' ;
                $results[] = $loan;
            }
        }

        $this->view('admin', [
            'title' => 'Quản lý phiếu',
            'content' => 'adminLoans',
            'loans' => $results,
            'cols' => $cols,
            'count' => $count,
            'adminName' => $adminName,
            'loan' => $loan,
            'due' => $due,
            'returned' => $returned
        ]);
    }

    // thư viện
    public function editLibrary(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/libraries');
        $libraryModel = $this->model('LibraryModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['libraryId'] = $id;
                $feedback = $libraryModel->updateLibrary($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/libraries");
                } else {
                    echo "<script>alert('Cập nhật thư viện thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }
        $library = $libraryModel->getLibraryById($id);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Cập nhật thư viện',
            'content' => 'formLibrary',
            'adminName' => $adminName,
            'subTitle' => 'Thêm Thư Viện',
            'values' => $library
        ]);
    }

    public function addLibrary() : void {
        $libraryModel = $this->model('LibraryModel');
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $libraryModel->createLibrary($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/libraries");
                } else {
                    echo "<script>alert('Thêm thư viện thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm thư viện',
            'content' => 'formLibrary',
            'adminName' => $adminName,
            'subTitle' => 'Thêm Thư Viện'
        ]);
    }

    public function libraries() : void {
        $libraryModel = $this->model('LibraryModel');
        $libraries = $libraryModel->readAll();
        $count = $libraryModel->getRowCount();

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý thư viện',
            'content' => 'libraries',
            'count' => $count,
            'adminName' => $adminName,
            'libraries' => $libraries
        ]);
    }

    // tác giả
    public function editAuthor(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/authors');
        $authorModel = $this->model('AuthorModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['authorId'] = $id;
                $feedback = $authorModel->updateAuthor($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/authors");
                } else {
                    echo "<script>alert('Cập nhật tác giả thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $authorName = $authorModel->getAuthorName($id);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Cập nhật tác giả',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'authorName',
            'text' => 'Nhập vào tên tác giả',
            'label' => 'Tên Tác Giả',
            'value' => $authorName
        ]);
    }

    public function addAuthor() : void {
        $authorModel = $this->model('AuthorModel');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $authorModel->createAuthor($_POST['authorName']);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/authors");
                } else {
                    echo "<script>alert('Thêm tác giả thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm tác giả',
            'content' => 'simpleForm',
            'adminName' => $adminName,
            'name' => 'authorName',
            'text' => 'Nhập vào tên tác giả',
            'label' => 'Tên Tác Giả'
        ]);
    }

    public function authors() : void {
        $authorModel = $this->model('AuthorModel');
        $authors = $authorModel->readAll();
        $count = $authorModel->getRowCount();
        $results = [];
        if(!empty($authors)) {
            foreach($authors as $author) {
                $quantity = $authorModel->getTotalBook($author['authorId']);
                $author['quantity'] = $quantity;
                $results[] = $author;
            }
        }
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý tác giả',
            'content' => 'authors',
            'count' => $count,
            'adminName' => $adminName,
            'authors' => $results
        ]);
    }

    // sách
    public function editBook(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/books');
        $bookModel = $this->model("BookModel");
        $book = $bookModel->getBookById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $_POST['bookId'] = $id;
                $feedback = $bookModel->updateBookInfor($_POST);
                $_POST = [];
                if($feedback) {
                    redirect("/admin/books");
                } else {
                    echo "<script>alert('Cập nhật sách thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $authors = ($this->model('AuthorModel'))->readAll();
        $publishers = ($this->model('PublisherModel'))->readAll();
        $topics = ($this->model('TopicModel'))->readAll();
        $categories = ($this->model('CategoryModel'))->readAll();
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Cập nhật sách',
            'content' => 'editBook',
            'adminName' => $adminName,
            'authors' => $authors,
            'publishers' => $publishers,
            'categories' => $categories,
            'topics' => $topics,
            'book' => $book
        ]);
    }

    public function deleteBook(string $id) : void {
        if(strlen($id) == 0) redirect('/admin/books');
        $bookModel = $this->model('BookModel');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedback = $bookModel->deleteBook($id);
            if($feedback) {
                redirect("/admin/books");
            } else {
                echo "<script>alert('Xóa sách thất bại vui lòng thử lại sau :((')</script>";
            }
        }

        $book = $bookModel->getBookById($id);
        $bookTitle = '';
        if(!empty($book)) {
            $bookTitle = $book['title'];
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Xóa sách',
            'content' => 'delete',
            'subtitle' => "sách $bookTitle",
            'adminName' => $adminName,
            'link' => 'books'
        ]);
    }

    public function addBook() : void {
        $book = $this->model("BookModel");

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST)) {
                $feedback = $book->createBook($_POST);
                $_POST = array();
                if($feedback) {
                    redirect("/admin/books");
                } else {
                    echo "<script>alert('Thêm sách thất bại vui lòng thử lại sau :((')</script>";
                }
            }
        }

        $authors = ($this->model('AuthorModel'))->readAll();
        $publishers = ($this->model('PublisherModel'))->readAll();
        $topics = ($this->model('TopicModel'))->readAll();
        $categories = ($this->model('CategoryModel'))->readAll();
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Thêm sách',
            'content' => 'addBook',
            'adminName' => $adminName,
            'authors' => $authors,
            'publishers' => $publishers,
            'categories' => $categories,
            'topics' => $topics
        ]);
    }

    public function books(string $page) : void {
        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/admin');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $bookModel = $this->model('BookModel');
        $books = $bookModel->getAllBooks([LENGTH, $offset]);
        $count = $bookModel->getRowCount();
        $cols = ceil($count / LENGTH);
        $results = [];
        if(!empty($books)) {
            foreach($books as $book) {
                $quantity = ($this->model('LocationModel'))->getQuantityByBookId($book['bookId']);
                $book['quantity'] = $quantity;
                $authorName = ($this->model('AuthorModel'))->getAuthorName($book['authorId']);
                $book['authorName'] = $authorName;
                $results[] = $book;
            }
        }

        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];
        
        $this->view('admin', [
            'title' => 'Quản lý sách',
            'content' => 'adminBooks',
            'books' => $results,
            'cols' => $cols,
            'count' => $count,
            'adminName' => $adminName
        ]);
    }

    // người dùng
    public function dueOfUser(string $id, string $page = "1") : void {
        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/admin');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $loanModel = $this->model('LoanModel');
        $loans = $loanModel->getLoanByUserId($id, 1, [LENGTH, $offset]);
        $count = $loanModel->getCountLoanByUserId($id, 1);
        $cols = ceil($count / LENGTH);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $results = [];
        if(!empty($loans)) {
            foreach($loans as $loan) {
                $book = ($this->model('BookModel'))->getBookById($loan['bookId']);
                $loan['bookName'] = $book['title'];
                $results[] = $loan;
            }
        }

        $this->view('admin', [
            'title' => 'Danh sách phiếu trả của người dùng',
            'content' => 'loanUser',
            'loans' => $results,
            'cols' => $cols,
            'count' => $count,
            'adminName' => $adminName
        ]);
    }

    public function loanOfUser(string $id, string $page = "1") : void {
        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/admin');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $loanModel = $this->model('LoanModel');
        $loans = $loanModel->getLoanByUserId($id, 0, [LENGTH, $offset]);
        $count = $loanModel->getCountLoanByUserId($id, 0);
        $cols = ceil($count / LENGTH);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $results = [];
        if(!empty($loans)) {
            foreach($loans as $loan) {
                $book = ($this->model('BookModel'))->getBookById($loan['bookId']);
                $loan['bookName'] = $book['title'];
                $results[] = $loan;
            }
        }

        $this->view('admin', [
            'title' => 'Danh sách phiếu mượn của người dùng',
            'content' => 'loanUser',
            'loans' => $results,
            'cols' => $cols,
            'count' => $count,
            'adminName' => $adminName
        ]);
    }

    public function render(string $page) :void {
        if(strlen($page) == 0) $page = '1';
        
        if(!is_numeric(trim($page))) {
            redirect('/');
        }

        $pageCurrent = +$page;
        $offset = 0;
        if($pageCurrent > 1) {
            $offset = LENGTH * $pageCurrent - LENGTH;
        }

        $userModel = $this->model('UserModel');
        $users = $userModel->readAllLimit([LENGTH, $offset]);
        $count = $userModel->getRowCount();
        $cols = ceil($count / LENGTH);
        $adminName = ($this->model('AdminModel'))->getAdminInfor($_COOKIE['adminId'])['adminName'];

        $this->view('admin', [
            'title' => 'Quản lý người dùng',
            'content' => 'users',
            'users' => $users,
            'cols' => $cols,
            'count' => $count,
            'adminName' => $adminName
        ]);
    }
}
?>