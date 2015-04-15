-- HOST:127.0.01  
--
-- github: https://github.com/xueyutianlang/zhanghuan/tree/master/MYSQL
-- author: zhanghuan<xueyutianlang@163.com
-- date  : 2015-04-15

-- NOTICE : 如有转载或其他使用途径，请尊重原作者 

--
-- Database structure for database `zhanghuan`
-- `张欢`数据库的建库语句
   CREATE DATABASE IF NOT EXISTS `zhanghuan` DEFAULT CHARSET=UTF8;
-- 如果`张欢`数据库存在就进行删除,不能放开下面这条否则建立的数据库会被删除
--   DROP DATABASE IF EXISTS `zhanghuan`;

-- select database zhanghuan
   USE zhanghuan
-- create tables for zhanghuan database;
-- zhanghuan数据库建表语句

-- 
-- Table structure for table 'user'
--
   DROP TABLE IF EXISTS `T_User`;
   CREATE TABLE IF NOT EXISTS `T_User`(
     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     `name` varchar(255) NOT NULL DEFAULT '',
     `age` tinyint(3) unsigned NOT NULL DEFAULT 0,
     PRIMARY KEY (`id`)
    )ENGINE=InnoDB  DEFAULT CHARSET=UTF8;

--
-- CREATE PROCEDURE sql 
-- 创建存储过程语句
-- 注意：MySQL默认以";"为分隔符，如果我们没有声明分割符，那么编译器会把存储过程当成SQL语句进行处理，则存储过程的编译过程会报错。所有必须修改mysql默认的结束分割符号变为 ；//
   Delimiter ;//

--
-- 如果存储过程存在就删除
--
   DROP PROCEDURE IF EXISTS `BatchAdd` ;//
--
-- 创建存储过程
--

   CREATE PROCEDURE BatchAdd(IN init INT, IN create_time INT)
       BEGIN
       DECLARE STAR INT;
       DECLARE ID INT;
       SET STAR = 0;
       SET ID = init;
       WHILE STAR < create_time DO
       INSERT INTO T_User(id,name,age) VALUES(ID, 'xueyutianlang',10);
       SET ID = ID + 1;
       SET STAR = STAR + 1;
       END WHILE;
       END;//
--
-- 调用存储过程
--
   call BatchAdd(1, 10);//
--
-- 修改回mysql的结束分割符号
--
   Delimiter ;



