CREATE TABLE files(
    id int PRIMARY KEY AUTO_INCREMENT,
    filename varchar(255),
    title varchar(255) null,
    description varchar(255) null,
    category varchar(255) null,
    category_id int null
);


