-- 用户表：记录用户登录数据
create table user(
    id int primary key auto_increment,
    username varchar(20),
    password tinyint,
    phone tinyint
    );

-- 视频信息
mysql> create table video(
    -> id int primary key auto_increment,
    ->  name varchar(50),
    -> description varchar(500),
    -> author varchar(10)
    -> );