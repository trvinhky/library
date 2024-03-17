use library;

-- Thêm mới người dùng
delimiter $$
create procedure ADD_USER (
	in userId varchar(13),
    in userName varchar(150),
    in userEmail varchar(150),
    in userPhone varchar(10),
    in userAddress varchar(255),
    in userPassword varchar(70)
)
begin 
	insert into users (userId, userName, userEmail, userPhone, userAddress, userPassword)
    values (userId, userName, userEmail, userPhone, userAddress, userPassword);
end $$
delimiter ;

-- Thêm mới sách
delimiter $$
create procedure ADD_BOOK (
	in bookId varchar(13),
    in title varchar(250),
    in photoURL varchar(150),
    in yearPublished year,
    in pages int,
    in authorId int,
    in publisherId int,
	in categoryId int,
    in topicId int
)
begin 
	insert into books (bookId, title, photoURL, yearPublished, pages, authorId, publisherId, categoryId, topicId)
    values (bookId, title, photoURL, yearPublished, pages, authorId, publisherId, categoryId, topicId);
end $$
delimiter ;

-- lấy số lượng sách trong 1 thư viện
delimiter $$
create function GET_QUANTITY (bookId varchar(13), libraryId int)
returns int
deterministic
begin 
	declare quantity int default 0;
    
    select quantity into quantity
    from location where bookId = bookId;
    
    if quantity <= 0 then return quantity;
    else 
		select quantity into quantity 
        from location l join bookshelf b
        on l.bookshelfId = b.bookshelfId
        where b.libraryId = libraryId and l.bookId = bookId;
        return quantity;
    end if;
end $$
delimiter ;

-- tạo index cho title của books
CREATE INDEX title_idx ON books(title);

-- tìm kiếm sách theo title
delimiter $$
create procedure FIND_BOOK_TITLE (
    in title varchar(250),
    out bookId varchar(13),
    out authorName varchar(150),
    out publisherName varchar(150)
)
begin 
    select b.bookId, a.authorName, p.publisherName 
    into bookId, authorName, publisherName
    from books b use index (title_idx) join author a 
    on b.authorId = a.authorId
    join publisher p 
    on b.publisherId = p.publisherId
    where b.title like concat('%', title, '%');
end $$
delimiter ;

-- lấy thông tin sách
delimiter $$
create procedure GET_BOOK (
    in input_bookId varchar(13),
    out out_bookId varchar(13),
    out authorName varchar(150),
    out publisherName varchar(150)
)
begin 
    select b.bookId, a.authorName, p.publisherName 
    into out_bookId, authorName, publisherName
    from books b join author a 
    on b.authorId = a.authorId
    join publisher p 
    on b.publisherId = p.publisherId
    where b.bookId = input_bookId;
end $$
delimiter ;

-- tạo trigger kiểm tra số lượng sách khi thêm vào
delimiter $$
create trigger CHECK_QUANTITY
before insert on location
for each row
begin 
    if new.quantity <= 0 then
		signal sqlstate '45000'
        set message_text = 'số lượng không thể nhỏ hơn 0';
	end if;
end $$
delimiter ;

-- cập nhật số lượng sách 
delimiter $$
create procedure UPDATE_QUANTITY_LIBRARYID (
    in libraryId int, in bookId varchar(13), in quantity int
)
begin 
    update location l join bookshelf b
    on l.bookshelfId = b.bookshelfId
    set l.quantity = quantity
    where b.libraryId = libraryId and l.bookId = bookId;
end $$
delimiter ;