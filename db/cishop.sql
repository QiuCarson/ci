-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 12 月 14 日 01:24
-- 服务器版本: 5.5.25a
-- PHP 版本: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cishop`
--

-- --------------------------------------------------------

--
-- 表的结构 `sw_admin`
--

CREATE TABLE IF NOT EXISTS `sw_admin` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `expire` int(10) NOT NULL COMMENT '过期时间',
  `role_id` int(8) NOT NULL COMMENT '角色ID',
  `towns_id` int(8) NOT NULL COMMENT '镇街id',
  `real_name` varchar(200) NOT NULL COMMENT '真实名字',
  `teach_id` int(8) NOT NULL COMMENT '职位',
  `show` int(1) NOT NULL COMMENT '前台是否显示1-显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sw_admin`
--

INSERT INTO `sw_admin` (`id`, `username`, `password`, `status`, `create_time`, `expire`, `role_id`, `towns_id`, `real_name`, `teach_id`, `show`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '0000-00-00 00:00:00', 0, 1, 2, '', 1, 1),
(2, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 1, '0000-00-00 00:00:00', 0, 1, 3, 'user1', 2, 1),
(4, 'user2', '123456', 1, '2014-11-15 01:32:40', 0, 4, 3, 'user2', 2, 0),
(5, 'user3', 'e10adc3949ba59abbe56e057f20f883e', 1, '2014-11-15 02:35:32', 0, 4, 2, 'user3', 1, 0),
(6, 'user4', 'e10adc3949ba59abbe56e057f20f883e', 1, '2014-11-15 02:42:58', 0, 4, 3, 'user4', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `sw_ducha`
--

CREATE TABLE IF NOT EXISTS `sw_ducha` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `ducha_file_name` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `zhenggai_file_name` varchar(200) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(200) NOT NULL,
  `ducha_show_name` varchar(200) NOT NULL,
  `zhenggai_show_name` varchar(200) NOT NULL,
  `author_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `sw_ducha`
--

INSERT INTO `sw_ducha` (`id`, `ducha_file_name`, `status`, `zhenggai_file_name`, `create_time`, `author`, `ducha_show_name`, `zhenggai_show_name`, `author_id`) VALUES
(4, '', 0, '81f05f6b4a30c8b5645e34dbae251e76.gz', '2014-11-15 05:51:55', '', '20141115督查情况', '20141115整改情况', 1),
(3, '6a9e48c62c00bbcd110e4881a83eb412.gz', 0, '6a9e48c62c00bbcd110e4881a83eb412.gz', '2014-11-15 05:49:18', '', '20141115督查情况', '20141115整改情况', 1),
(5, '08f7c0065925ef0c2e8bf928a9ebe806.gz', 0, '08f7c0065925ef0c2e8bf928a9ebe806.gz', '2014-11-15 05:55:03', '', '20141115督查情况', '20141115整改情况', 1),
(6, '9588f9ce2da56be5f38d23323202a63e.gz', 0, '9588f9ce2da56be5f38d23323202a63e.gz', '2014-11-15 06:38:13', '', '20141115督查情况', '20141115整改情况', 1),
(7, '70f959dee78377b3aa25d2b91dee2333.gz', 0, '70f959dee78377b3aa25d2b91dee2333.gz', '2014-11-15 06:45:00', '', '20141115督查情况', '20141115整改情况', 1),
(18, '', 0, '56f550eabd679bfae8bba0db04b42aaa.gz', '2014-11-15 10:42:05', '', '', '20141115整改情况', 1),
(19, 'ae91e1b6f3568b447c6392d6b8d49ecf.gz', 0, '', '2014-11-15 10:42:21', '', '20141115督查情况', '', 1),
(9, 'd9a6177c940aba0dba1174e7bb59ba66.gz', 0, 'd9a6177c940aba0dba1174e7bb59ba66.gz', '2014-11-15 06:56:15', '', '20141115督查情况', '20141115整改情况', 1),
(10, '', 0, '', '2014-11-15 07:20:50', '', '', '', 1),
(11, 'dd8e3da21eac5ef2bbdd270badddcc85.gz', 0, 'dd8e3da21eac5ef2bbdd270badddcc85.gz', '2014-11-15 10:14:04', '', '20141115督查情况', '20141115整改情况', 1),
(12, 'fdab0fa68ea0852285df15d235991210.gz', 0, 'fdab0fa68ea0852285df15d235991210.gz', '2014-11-15 10:14:37', '', '20141115督查情况', '20141115整改情况', 1),
(13, '5f38f9f49d5e9717bd8af34a1cc63ac9.gz', 0, '5f38f9f49d5e9717bd8af34a1cc63ac9.gz', '2014-11-15 10:15:53', '', '20141115督查情况', '20141115整改情况', 1),
(14, 'e3bccb30587ac4abb965e67a774c7c3d.gz', 0, 'e3bccb30587ac4abb965e67a774c7c3d.gz', '2014-11-15 10:17:12', '', '20141115督查情况', '20141115整改情况', 1),
(15, '8a8afc811562d193efe9244123ccf1a1.gz', 0, '', '2014-11-15 10:18:42', '', '20141115督查情况', '', 1),
(16, '516b5de01949ca5e5955b4950b52b490.gz', 0, '', '2014-11-15 10:19:23', '', '20141115督查情况', '', 1),
(17, '', 0, '189f1240a8e6510986c4b1554cd2e11d.gz', '2014-11-15 10:19:38', '', '', '20141115整改情况', 1),
(20, '', 0, 'b17bd661dbfcbcd537ca34ba4a760df8.gz', '2014-11-15 11:35:04', '', '', '20141115整改情况', 1),
(21, '', 0, 'fa5fecbf5d1bc2d2504a6126b1d42503.gz', '2014-11-15 11:35:18', '', '', '20141115整改情况', 1),
(22, '', 0, '19a71277a0de75877eb251d04bc1b985.gz', '2014-11-15 11:35:25', '', '', '20141115整改情况', 1),
(23, '539c2f318cb44ce705ea2b62748320ad.gz', 0, '', '2014-11-16 01:34:45', 'user4', '20141116督查情况', '', 6),
(24, 'admin/20141126督查情况.doc', 0, 'admin/20141126整改情况.jpg', '2014-11-26 09:38:18', '', '20141126督查情况', '20141126整改情况', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sw_menu`
--

CREATE TABLE IF NOT EXISTS `sw_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT '栏目名称',
  `menu_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-显示 0-隐藏',
  `menu_pid` int(3) NOT NULL COMMENT '父id',
  `menu_sort` int(4) NOT NULL COMMENT '数字越大越显示到上面',
  `menu_url` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT '连接地址',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf16 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `sw_menu`
--

INSERT INTO `sw_menu` (`id`, `menu_name`, `menu_status`, `menu_pid`, `menu_sort`, `menu_url`, `create_time`) VALUES
(23, '我的督查', 1, 3, 0, 'myducha/show/', '2014-11-13 10:06:40'),
(24, '删除督促', 1, 4, 0, 'ducha/do_del/', '2014-11-13 10:09:49'),
(3, '督促管理', 1, 0, 1, '', '2014-10-29 12:21:29'),
(4, '督促列表', 1, 3, 2, 'ducha/show/', '2014-10-29 12:22:01'),
(5, '督促添加', 1, 4, 0, 'ducha/add/', '2014-10-29 12:27:56'),
(8, '督促编辑', 1, 4, 0, 'ducha/edit/', '2014-10-29 12:46:46'),
(9, '后台管理', 1, 0, 0, '', '2014-10-29 12:48:09'),
(10, '角色列表', 1, 9, 0, 'role/show/', '2014-10-29 12:53:37'),
(11, '角色添加', 1, 10, 0, 'role/add/', '2014-10-29 12:54:24'),
(12, '角色修改', 1, 10, 0, 'role/edit/', '2014-10-29 12:54:35'),
(13, '节点管理', 1, 9, 0, 'menu/show', '2014-10-29 13:26:10'),
(14, '节点修改', 1, 13, 0, 'menu/edit/', '2014-10-29 13:26:28'),
(15, '节点添加', 1, 13, 0, 'menu/add/', '2014-10-29 13:26:39'),
(16, '后台用户', 1, 9, 0, 'user/show', '2014-10-29 13:27:24'),
(17, '添加用户', 1, 16, 0, 'user/add/', '2014-10-29 13:27:38'),
(18, '用户修改', 1, 16, 0, 'user/edit/', '2014-10-29 13:27:55'),
(19, '角色删除', 1, 10, 0, 'role/do_del/', '2014-10-29 13:28:27'),
(20, '节点删除', 1, 13, 0, 'menu/do_del/', '2014-10-29 13:28:49'),
(21, '用户删除', 1, 16, 0, 'user/do_del/', '2014-10-29 13:29:05'),
(22, '赋权节点', 1, 10, 0, 'role/role_add_menu_show/', '2014-10-31 12:37:58'),
(25, '删除督促', 1, 23, 0, 'myducha/do_del/', '2014-11-14 11:17:05'),
(26, '督促编辑', 1, 23, 0, 'myducha/edit/', '2014-11-14 11:17:43'),
(27, '督促添加', 1, 23, 0, 'myducha/add/', '2014-11-14 11:18:04'),
(28, '镇街列表', 1, 9, 0, 'towns/show/', '2014-11-14 12:17:24'),
(29, '添加镇街', 1, 28, 0, 'towns/add/', '2014-11-14 12:24:02'),
(30, '修改镇街', 1, 28, 0, 'towns/edit/', '2014-11-14 12:24:40'),
(31, '删除镇街', 1, 28, 0, 'towns/do_del/', '2014-11-14 12:25:06');

-- --------------------------------------------------------

--
-- 表的结构 `sw_menu_to_role`
--

CREATE TABLE IF NOT EXISTS `sw_menu_to_role` (
  `menu_id` int(10) NOT NULL COMMENT '节点id',
  `role_id` int(10) NOT NULL COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sw_menu_to_role`
--

INSERT INTO `sw_menu_to_role` (`menu_id`, `role_id`) VALUES
(19, 5),
(22, 5),
(10, 5),
(9, 5),
(14, 6),
(15, 6),
(20, 6),
(13, 6),
(9, 6),
(17, 7),
(18, 7),
(21, 7),
(16, 7),
(9, 7),
(12, 5),
(11, 5),
(4, 1),
(25, 1),
(26, 1),
(27, 1),
(23, 1),
(3, 1),
(11, 1),
(12, 1),
(19, 1),
(22, 1),
(10, 1),
(14, 1),
(15, 1),
(20, 1),
(13, 1),
(17, 1),
(18, 1),
(21, 1),
(16, 1),
(29, 1),
(30, 1),
(31, 1),
(28, 1),
(9, 1),
(24, 1),
(8, 1),
(5, 1),
(3, 4),
(23, 4),
(27, 4),
(26, 4),
(25, 4);

-- --------------------------------------------------------

--
-- 表的结构 `sw_role`
--

CREATE TABLE IF NOT EXISTS `sw_role` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(200) NOT NULL COMMENT '角色名字',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1-可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `sw_role`
--

INSERT INTO `sw_role` (`id`, `role_name`, `create_time`, `status`) VALUES
(1, '超级管理员', '2014-10-19 16:00:00', 1),
(4, '上传权限', '2014-10-28 09:47:48', 1),
(8, '查看权限', '2014-11-13 09:49:11', 1);

-- --------------------------------------------------------

--
-- 表的结构 `sw_towns`
--

CREATE TABLE IF NOT EXISTS `sw_towns` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `orderby` int(8) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `sw_towns`
--

INSERT INTO `sw_towns` (`id`, `name`, `orderby`) VALUES
(2, '上海', 0),
(3, '普陀', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
