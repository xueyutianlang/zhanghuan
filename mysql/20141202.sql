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
)ENGINE=InnoDB  DEFAULT CHARSET=UTF8;

