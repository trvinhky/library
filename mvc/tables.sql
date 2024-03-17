create database library;

use library;

-- bảng người dùng
create table users (
	userId varchar(13) not null primary key,
    userName varchar(150),
    userEmail varchar(150),
    userPhone varchar(10),
    userAddress varchar(255),
    userPassword varchar(70)
);

-- bảng quản trị viên
create table admin (
	adminId varchar(13) not null primary key,
    adminName varchar(150),
    adminEmail varchar(150),
    adminPhone varchar(10),
    adminAddress varchar(255),
    adminPassword varchar(70)
);

-- bảng loại sách
create table category (
	categoryId int not null auto_increment,
    categoryName varchar(150),
    primary key (categoryId)
);

-- bảng chủ đề sách
create table topic (
	topicId int not null auto_increment,
    topicName varchar(150),
    primary key (topicId)
);

-- bảng tác giả
create table author (
	authorId int not null auto_increment,
    authorName varchar(150),
    primary key (authorId)
);

-- bảng nhà xuất bản
create table publisher (
	publisherId int not null auto_increment,
    publisherName varchar(150),
    primary key (publisherId)
);

-- bảng sách
create table books (
	bookId varchar(13) not null primary key,
    title varchar(250),
    photoURL varchar(150),
    yearPublished year,
    pages int,
    authorId int not null,
    publisherId int not null,
	categoryId int not null,
    topicId int not null,
    foreign key (authorId) references author(authorId),
    foreign key (publisherId) references publisher(publisherId),
    foreign key (topicId) references topic(topicId),
    foreign key (categoryId) references category(categoryId)
);

-- bảng mượn trả sách
create table loans (
	loanId varchar(13) not null primary key,
    returned int check (returned = 1 OR returned = 0),
    loanDate timestamp,
    dueDate timestamp,
    userId varchar(13) not null,
    foreign key (userId) references users(userId),
    check (loanDate < dueDate)
);

-- bảng chi tiết phiếu mượn
create table detailLoan (
	loanId varchar(13) not null references loans(loanId),
    bookId varchar(13) not null references books(bookId),
    loanQuantity int,
    primary key (loanId, bookId)
);

-- bảng thư viện
create table library (
	libraryId int not null auto_increment,
    libraryName varchar(150),
    libraryLocation varchar(255),
    primary key (libraryId)
);

-- bảng vị trí kệ sách
create table bookshelf (
	bookshelfId int not null auto_increment,
    bookshelfLocation varchar(255),
    libraryId int not null,
    primary key (bookshelfId),
    foreign key (libraryId) references library(libraryId)
);

-- bảng vị trí và số lượng sách
create table location (
	bookId varchar(13) not null references books(bookId),
    bookshelfId int not null references bookshelf(bookshelfId),
    quantity int,
    primary key (bookId, bookshelfId)
);