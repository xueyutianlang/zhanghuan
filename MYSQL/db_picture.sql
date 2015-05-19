/*
 * 建表测试
 *
 * @author  : zhanghuan<xueyutianlang@163.com>
 * @date    : 2014-12-02
 * Database : db_test
 */

-- CY-01 建表测试
--
-- @author: zhanghuan
-- @date: 2014-12-02
-- Database: db_test
-- ------------------------------------------------------

use db_test;

set names utf8;

--
-- 轮转广告表
-- Table structure for table `db_info_pic`
--
CREATE TABLE db_info_testpic(
 `id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
 `url`    varchar(100) NOT NULL DEFAULT '',
 `link`	  varchar(100) NOT NULL DEFAULT '', 
 `alt`	  varchar(50) NOT NULL DEFAULT '',
 PRIMARY KEY (pic_id)
 INDEX Alt (alt)
)ENGINE=InnoDB  DEFAULT CHARSET=UTF8;
alter table db_info_testpic add sort tinyint(3) unsigned not null default 0 comment '轮播图排序' after alt;

-- 以下是快速添加索引的方法

-- 添加PRIMARY KEY（主键索引）
ALTER TABLE `table_name` ADD PRIMARY KEY (`column`);

-- 添加UNIQUE(唯一索引)
ALTER TABLE `table_name` ADD UNIQUE (`column`);

-- 添加INDEX(普通索引)
ALTER TABLE `table_name` ADD INDEX index_name (`column`);

-- 添加FULLTEXT(全文索引)
ALTER TABLE `table_name` ADD FULLTEXT (`column`);

-- 建立联合索引
ALTER TABLE `table_name` ADD INDEX index_name (`column1`, `column2`, `column3`);

