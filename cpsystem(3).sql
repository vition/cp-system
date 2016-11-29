-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-29 04:06:23
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cpsystem`
--

-- --------------------------------------------------------

--
-- 表的结构 `classif`
--

CREATE TABLE IF NOT EXISTS `classif` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `superiors` varchar(50) NOT NULL,
  `subordinate` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- 转存表中的数据 `classif`
--

INSERT INTO `classif` (`id`, `superiors`, `subordinate`) VALUES
(1, 'root', '线上 ONLINE'),
(2, 'root', '线下 OFFLINE'),
(3, '线上 ONLINE', '电视剧场'),
(4, '线上 ONLINE', '电视综艺'),
(5, '线上 ONLINE', '网络剧'),
(6, '线上 ONLINE', '网络综艺'),
(7, '线上 ONLINE', '网络大电影'),
(8, '线上 ONLINE', '院线电影'),
(9, '线下 OFFLINE', '音乐类'),
(10, '线下 OFFLINE', '舞台剧'),
(11, '线下 OFFLINE', '奔跑类'),
(12, '电视剧场', '现代都市情感'),
(13, '电视剧场', '年代剧'),
(14, '电视剧场', '战争剧'),
(15, '电视剧场', '谍战剧'),
(16, '电视剧场', '古装剧'),
(17, '电视剧场', '古装宫斗'),
(18, '电视剧场', '历史剧'),
(19, '电视综艺', '明星户外真人秀'),
(20, '电视综艺', '星素户外真人秀'),
(21, '电视综艺', '相亲类'),
(22, '电视综艺', '明星整蛊真人秀'),
(23, '电视综艺', '喜剧真人秀'),
(24, '电视综艺', '明星厨艺类真人秀'),
(25, '电视综艺', '明星音乐真人秀'),
(26, '电视综艺', '素人音乐选秀'),
(27, '电视综艺', '校园青春真人秀'),
(28, '电视综艺', '明星夫妻体验秀'),
(29, '电视综艺', '竞技真人秀'),
(30, '电视综艺', '文化纪录片'),
(31, '电视综艺', '脱口秀'),
(32, '电视综艺', '探险真人秀'),
(33, '电视综艺', '明星亲子秀'),
(34, '电视综艺', '跨年颁奖晚会类'),
(35, '网络剧', '现代都市情感'),
(36, '网络剧', '年代剧'),
(37, '网络剧', '战争剧'),
(38, '网络剧', '谍战剧'),
(39, '网络剧', '古装剧'),
(40, '网络剧', '古装宫斗'),
(41, '院线电影', '历史剧'),
(42, '网络综艺', '网台联播综艺'),
(43, '网络综艺', '自制播报类'),
(44, '网络综艺', '自制访谈类'),
(45, '网络综艺', '自制选秀类'),
(46, '网络综艺', '自制游戏类'),
(47, '网络综艺', '自制相亲类'),
(48, '网络综艺', '自制职场类'),
(49, '网络综艺', '自制脱口秀类'),
(50, '网络综艺', '自制真人秀类'),
(51, '网络综艺', '跨年颁奖晚会类'),
(52, '网络大电影', '爱情'),
(53, '网络大电影', '惊悚'),
(54, '网络大电影', '喜剧'),
(55, '网络大电影', '动作'),
(56, '网络大电影', '悬疑'),
(57, '网络大电影', '奇幻'),
(58, '网络大电影', '青春'),
(59, '院线电影', '爱情'),
(60, '院线电影', '惊悚'),
(61, '院线电影', '喜剧'),
(62, '院线电影', '动作'),
(63, '院线电影', '悬疑'),
(64, '院线电影', '奇幻'),
(65, '院线电影', '青春'),
(66, '音乐类', '音乐节'),
(67, '音乐类', '演唱会'),
(68, '电视综艺', '真人纪录片'),
(71, '线下 OFFLINE', '其它活动类'),
(72, '线下 OFFLINE', '其它活动类'),
(73, '电视综艺', '求职真人秀');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pid` int(10) NOT NULL COMMENT '项目id',
  `reply` int(10) NOT NULL COMMENT '回复本表的id',
  `username` varchar(50) NOT NULL COMMENT '用户名字',
  `comment` varchar(10000) NOT NULL COMMENT '评论',
  `date` datetime NOT NULL COMMENT '评论时间',
  `verify` int(1) NOT NULL DEFAULT '0' COMMENT '是否验证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `pid`, `reply`, `username`, `comment`, `date`, `verify`) VALUES
(1, 1, 0, 'feng', '你好', '2016-11-23 10:34:50', 0),
(2, 10, 0, 'joychan', '岂止是有点意思！', '2016-11-23 12:04:55', 0),
(3, 13, 0, 'fairy', '这个项目好！有时下流行的探秘元素，引人入胜，可以吸引消费者全程关注', '2016-11-25 15:47:13', 0),
(4, 14, 0, 'joychan', '岂止有点意思！', '2016-11-25 15:52:27', 0),
(5, 14, 0, 'kamchan', '你好', '2016-11-25 16:03:13', 0),
(6, 10, 0, 'vition', '可以客串电影么？', '2016-11-28 11:06:28', 0);

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `pid` int(10) NOT NULL COMMENT '项目id',
  `username` varchar(50) NOT NULL COMMENT '用户名字',
  `feedback` varchar(10000) NOT NULL COMMENT '反馈内容',
  `createdate` datetime NOT NULL COMMENT '创建',
  `prevdate` datetime NOT NULL COMMENT '上一次编辑时间',
  `lastdate` datetime NOT NULL COMMENT '最新编辑时间',
  `times` int(10) NOT NULL COMMENT '编辑次数',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `feedback`
--

INSERT INTO `feedback` (`id`, `pid`, `username`, `feedback`, `createdate`, `prevdate`, `lastdate`, `times`, `state`) VALUES
(1, 13, 'kamchan', '这是我们WTC 重磅推荐的IP      前策权限很强大', '2016-11-28 18:41:27', '2016-11-28 18:46:18', '2016-11-28 18:46:19', 16, 0);

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `type` varchar(50) NOT NULL COMMENT '类型',
  `tid` int(10) NOT NULL COMMENT '指定类型id',
  `from` varchar(50) NOT NULL COMMENT '来自谁',
  `to` varchar(50) NOT NULL COMMENT '发给谁',
  `content` varchar(1000) NOT NULL COMMENT '内容',
  `date` datetime NOT NULL COMMENT '时间',
  `state` int(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `time` datetime NOT NULL COMMENT '时间',
  `cover` varchar(500) DEFAULT NULL COMMENT '封面',
  `author` varchar(100) NOT NULL COMMENT '作者',
  `content` text NOT NULL COMMENT '内容',
  `tags` varchar(500) DEFAULT NULL COMMENT '标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `title`, `time`, `cover`, `author`, `content`, `tags`) VALUES
(6, '东风日产冠名《越野千里》', '2016-11-28 15:03:53', NULL, 'joychan', '东风日产冠名东方卫视2017年《越野千里》栏目。《越野千里》是自然探索类纪录片，公布参与的明星有：姚明、李彦宏、傅园慧、陈意涵、曾宝仪，节目将在中国和美国录制。', NULL),
(7, 'OPPO太TM有钱！', '2016-11-28 15:03:31', NULL, 'joychan', 'OPPO以5亿价格标得浙江卫视《中国新歌声2》冠名席位。', NULL),
(8, '广汽传祺签约《我们十七岁》栏目', '2016-11-28 15:03:25', NULL, 'joychan', '广汽传祺（GS8）通过上海一家广告公司签得浙江卫视2017年《我们十七岁》栏目指定用车席位。', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `item` varchar(100) NOT NULL COMMENT '项目',
  `value` varchar(1000) NOT NULL COMMENT '值',
  `value2` varchar(500) DEFAULT NULL,
  `value3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `option`
--

INSERT INTO `option` (`id`, `item`, `value`, `value2`, `value3`) VALUES
(1, 'weburl', 'http://oa.twoway.com.cn:8088/cp/', NULL, NULL),
(2, 'webname', '娱乐营销CP推进系统', NULL, NULL),
(3, 'logo', 'images/logo.png', NULL, NULL),
(4, 'keywords', '娱乐,营销,cp', NULL, NULL),
(5, 'description', '这是一个vition开发的cp系统', NULL, NULL),
(6, 'foothtml', '<p>COPYRIGHT © 2016 TWOWAY RIGHTS RESERVED</p>', NULL, NULL),
(7, 'tags', '古代传奇-2,真人秀-16,音乐真人秀-5,汽车旅行-5,探险真人秀-15,时尚美食-1,功夫明星选拔秀-1,明星养成-8,美食厨艺类-3,文化记录-4,家居装修类-1,综艺类-8,星素真人类-7,整蛊游戏综合-6,音乐类-6,科普类-1,医疗记录-1,脱口秀-5,生活服务-1,平安攻略-1,竞技真人秀-7,飞车-6,速度与激情-5,求职-1,校园青春-1,舞台竞演-1', NULL, NULL),
(8, 'banner-1', '央视5套、优酷《长江漂流》', 'images/upload/1480320468.0562.upload', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(9, 'banner-2', '红人研究院首期密训', 'http://origin1qn.moko.cc/2016-10-13/84a46c73-ef9c-490a-a671-2a6c19273b0a.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(10, 'banner-3', '《爱笑的眼睛》主题活动', 'http://origin1qn.moko.cc/2016-09-30/c9683e87-4b07-4e99-9ae4-59d5487dad33.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(11, 'banner-4', '暖蓝优惠券', 'http://origin1qn.moko.cc/2016-10-09/f90c941c-c104-460f-aa74-64dc265a23e5.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(12, 'banner-5', '美空模特培训', 'http://origin1qn.moko.cc/2016-10-08/5d6d5106-04b0-41a5-bde1-9cc1f71421eb.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(13, 'banner-6', '双十一来了，你的流量准备好了？', 'http://origin1qn.moko.cc/2016-09-22/b909a4da-37d6-4c89-a6ca-72a77d5182b7.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(14, 'banner-7', '有奖翻唱——水木年华为你写歌', 'http://origin1qn.moko.cc/2016-09-19/c2357530-aa40-41d2-af31-b5c9873efacb.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(15, 'banner-8', '杭模首站', 'http://origin1qn.moko.cc/2016-09-05/87819b8c-5bdf-4700-afee-e248d84032b2.jpg', 'http://oa.twoway.com.cn:8088/cp/page.php?id=9'),
(16, 'banner-9', '美空APP 花样秀美颜', 'http://img3.moko.cc/pics/guanggao/bf/img3_src_11215501.jpg', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `firstclass` varchar(50) DEFAULT NULL COMMENT '一级分类',
  `secondclass` varchar(50) NOT NULL COMMENT '二级分类',
  `threeclass` varchar(50) DEFAULT NULL COMMENT '三级分类',
  `title` varchar(100) NOT NULL COMMENT '项目名称',
  `platform` varchar(50) DEFAULT NULL COMMENT '平台',
  `datetime` varchar(100) DEFAULT NULL COMMENT '时间',
  `core` varchar(200) DEFAULT NULL COMMENT '核心',
  `date` datetime NOT NULL COMMENT '更新日期',
  `mode1` varchar(200) DEFAULT NULL COMMENT '合作形式',
  `price1` float DEFAULT NULL COMMENT '刊例价',
  `mode2` varchar(200) DEFAULT NULL,
  `price2` float DEFAULT NULL,
  `mode3` varchar(200) DEFAULT NULL,
  `price3` float DEFAULT NULL,
  `channel` varchar(50) DEFAULT NULL COMMENT '推荐客户/渠道',
  `director` varchar(50) DEFAULT NULL COMMENT '负责人',
  `feedback` varchar(500) DEFAULT NULL COMMENT '反馈',
  `deadline` varchar(50) DEFAULT NULL COMMENT '截止时间',
  `contact` varchar(50) DEFAULT NULL COMMENT 'CP方联系人',
  `telephone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `content` varchar(10000) DEFAULT NULL COMMENT '图文',
  `pdfname` varchar(200) DEFAULT NULL,
  `open_price` float DEFAULT NULL COMMENT '公开价格',
  `tags` varchar(500) DEFAULT NULL COMMENT '标签',
  `cover` varchar(500) DEFAULT NULL COMMENT '封面',
  `pushed` int(1) NOT NULL DEFAULT '0',
  `publisher` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `projects`
--

INSERT INTO `projects` (`id`, `firstclass`, `secondclass`, `threeclass`, `title`, `platform`, `datetime`, `core`, `date`, `mode1`, `price1`, `mode2`, `price2`, `mode3`, `price3`, `channel`, `director`, `feedback`, `deadline`, `contact`, `telephone`, `content`, `pdfname`, `open_price`, `tags`, `cover`, `pushed`, `publisher`) VALUES
(3, '线下', '音乐类', '音乐节', '广州《草莓音乐节》', '番禺长隆外围', '2016年12月31日-跨年', '国内外最具影响力的摇滚音乐节', '2016-11-28 15:59:15', '', 0, '', 0, '', 0, '全品牌 重点：MINI', '', '0621', '', '', '', '<br />', NULL, 9000000, '音乐真人秀', 'images/upload/1478157676.3806.jpeg', 0, ''),
(4, '线下', '音乐类', '演唱会', '2017《柏林爱乐》中国巡演', '', '2017年Q1', '高端艺术', '2016-11-28 15:56:12', '', 70000000, '', 0, '', 0, '各大车企', '', '除2017的重点项目外，还会有今年的一部分可合作项目，将在0612约见剧院活动部总监WING姐，', '', '', '', '', NULL, 0, '', 'images/upload/1478158366.39.jpeg', 0, ''),
(5, '线下 OFFLINE', '舞台剧', '', '2016 《蓝人秀》中国巡演', '广州大剧院', '', '', '2016-11-28 15:57:27', '', 8000000, '', 0, '', 0, '各种车型', '', '', '', '', '', '<h1>\n	<br />\n</h1>\n<a class=<{v2}>edit-lemma cmn-btn-hover-blue cmn-btn-28 j-edit-link<{v2}>><em class=<{v2}>cmn-icon wiki-lemma-icons wiki-lemma-icons_edit-lemma<{v2}>></em></a> \n<div class=<{v2}>lemma-summary<{v2}> align=<{v2}>left<{v2}>>\n	<div class=<{v2}>para<{v2}>>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>《蓝人秀》是由美国著名的娱乐公司，也是当今世界最受欢迎的文艺团体——美国蓝人演艺集团于1991年打造的演艺品牌。主要表演项目有：默剧、杂耍、多媒体装置、行动艺术等。目前，《蓝人秀》在纽约、拉斯维加斯、奥兰多、波士顿、芝加哥和柏林等国际都市都有自己的驻场演出，并在世界各国进行巡回演出。</span> \n		</p>\n		<p>\n			<br />\n		</p>\n		<p>\n			<br />\n		</p>\n	</div>\n	<div class=<{v2}>para<{v2}>>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>《蓝人秀》表演极具创意和舞台表现力，多次登上《America<{v1}>sGot\n Talent（全美达人）》和《The Tonight \nShow（今夜秀）》舞台，是美国家喻户晓的世界级演艺秀。《蓝人秀》上演至今，已有3500万观众观看过，被誉为拉斯维加斯的“三大名秀”，也是美国演艺界的“国宝”。</span> \n		</p>\n		<p>\n			<br />\n		</p>\n		<p>\n			<br />\n		</p>\n	</div>\n	<div class=<{v2}>para<{v2}>>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2016年7月，《蓝人秀》首次来京。</span> \n		</p>\n		<p align=<{v2}>center<{v2}>>\n			<img src=<{v2}>/cp/admin/editor/attached/image/20161104/20161104025538_96487.jpg<{v2}> alt=<{v2}><{v2}> /> \n		</p>\n		<p align=<{v2}>center<{v2}>>\n			<br />\n		</p>\n		<p align=<{v2}>left<{v2}>>\n			<br />\n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>新天地、K11、港汇广场等沪上知名地标出现了三个“怪人”！他们像阿凡达一样有着蓝色的皮肤，穿着黑衣服，不讲话但眼睛瞪得很大，好奇地打量着人们，并以各种脑洞大开的方式进行互动——翻外卖小哥的包裹、玩小朋友手上的风车、亲吻雕像，在地铁里找不到座位，他们索性坐在女孩子腿上！居然不怕被投诉性骚扰！</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><br />\n</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>这些蓝皮肤的怪人，来自蓝人组（Blue Man \nGroup）。美国蓝人演艺集团自1991年创立，以其独特的对科技、色彩、音乐、互动体验等元素的运用而被人们喜爱。不同于舞台戏剧和音乐演出，蓝人秀融合了默剧、音乐会、行为艺术等多种表现形式，带领观众踏上充满幽默、智慧与视觉震撼的旅程。目前《蓝人秀》在拉斯维加斯、纽约、奥兰多、波士顿、芝加哥和柏林等地有自己的驻场演出，并在北美和世界各国巡演。</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><br />\n</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 像阿凡达一样，蓝人对地球上的一切充满好奇；又像“蓝精灵”一样，所到之处充满快乐。7月14日下午的蓝人秀世界巡演上海站发布会上，蓝人三次“突袭”现场，带来了几段精彩的表演片段，为今年11月16日至12月4日在上汽·上海文化广场的《蓝人秀世界巡演上海站》先行预热。2016年是蓝人成立25周年庆，联合创始人克里斯·温克说：“能与中国的粉丝共同庆祝蓝人集团25周年的生日实在是太振奋人心了！”</span> \n		</p>\n		<p>\n			<br />\n		</p>\n		<div align=<{v2}>center<{v2}>>\n			<p>\n				<img src=<{v2}>/cp/admin/editor/attached/image/20161104/20161104025634_75846.jpg<{v2}> alt=<{v2}><{v2}> /> \n			</p>\n			<p>\n				<br />\n			</p>\n		</div>\n		<p>\n			<br />\n		</p>\n		<p align=<{v2}>left<{v2}>>\n			<br />\n		</p>\n		<p style=<{v2}>text-align:center;<{v2}>>\n			<em><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>《蓝人秀》演出包含诸多不断更新的时尚元素</span></em> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>line-height:2;<{v2}>>发布会现场，一阵动感音乐突然响起，三位蓝人不知从哪儿冒了出来。他们在人群中穿梭或驻足张望，两个蓝人往一只蓝色气球里打气，另一个蓝人手提播放着音乐的大型的磁带录音机。三人一路逛到舞台上，这时气球也飘到主持人的头上，“砰——”的一声巨响，观众惊吓之后又尖叫欢呼起来……在现场创造出充满快乐的派对气氛，已成为蓝人组演出的重要标签。联合创始人克里斯•温克表示：“虽然《蓝人秀》不同场次演出的内容各有不同，但所有蓝人秀的目标内核都是相同的，便是给予观众愉悦欣喜，生动舒展的感受。”蓝人以诙谐机智、无尽想象力与创新为基调，为观众带来惊艳的多感官体验。队长莫瑞迪安透露，他们要为前排观众准备雨衣，防止演出过程中台上的颜料、墨水等弄脏他们的衣服。</span></span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><br />\n</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>line-height:2;<{v2}>>为了让上海的《蓝人秀》的现场效果更加疯狂和热烈，主创团队将经典《蓝人秀》中深受喜爱的表演与全新的内容相结合，时下流行的音乐、新故事、特制的道具和充满艺术感的现代科技等都将出现在上海的《蓝人秀》现场。</span></span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><br />\n</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>line-height:2;<{v2}>>有人认为蓝人像外星人，也有人质疑蓝人一直呆呆的。主创回应称，他们希望人们能从蓝人身上发现自己的影子。他们试图探索我们的文化传统与常规生活，永远用如孩童般的眼睛与新鲜的视角来观察。</span></span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;line-height:2;<{v2}>>《蓝人秀》的表演不仅面向喜欢新鲜热闹的年轻人，各个年龄段的观众都可以找到属于自己的独特体验。在主创看来，蓝人与不同种族、语言与国籍的人都能产生共鸣。可以把蓝人看作是我们文化的异类，他们不断探索、质疑、评判我们身边这个已经熟悉到麻木的世界。</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><br />\n</span> \n		</p>\n		<p>\n			<span style=<{v2}>font-size:16px;<{v2}>><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=<{v2}>font-size:16px;line-height:2;<{v2}>>&nbsp; </span><span style=<{v2}>line-height:2;<{v2}>>蓝人们关注环保、手机依赖等社会热门话题。在他们的表演中，有用塑料水管作为打击乐器的音乐演奏，也有对现代人离不开手机甘做“低头族”的恶搞和讽刺，观众们开心放松之后，也会对社会现实多一点思考。</span></span> \n		</p>\n		<div align=<{v2}>center<{v2}>>\n			<img src=<{v2}>/cp/admin/editor/attached/image/20161104/20161104025720_35243.jpg<{v2}> alt=<{v2}><{v2}> /> \n		</div>\n		<p>\n			<br />\n		</p>\n	</div>\n</div>', NULL, 0, '', 'images/upload/1478167183.8164.jpeg', 0, ''),
(9, '线上', '电视综艺', '文化纪录片', '老祖宗说', '中央电视台/深圳卫视', '2017年', '一部关于中华姓氏文化传承和精神力量凝聚的史诗巨作', '2016-11-28 16:04:50', '', 0, '', 0, '', 0, '一汽红旗', '', '', '', '', '', '拍摄选址遍布中国各地，包括港澳台，走进全国各地名胜，宗祠，人文景观，探寻同姓名人故居、著名企业家，百年老字号等历史古迹和文化遗产。', '《老祖宗说》第一季方案', NULL, '', 'images/upload/1479717866.0812.png', 1, ''),
(10, '线上', '院线电影', '动作', '黄金七十二小时之友情岁月 -奥迪商务案', '各大影院', '2018年Q1', '古惑仔原班人马上演内地版速度与激情，飞车特技全面彰显汽车性能', '2016-11-23 12:25:18', '电影植入+主创见面会', 4000000, '', 0, '', 0, '各种车型', '待定', '', NULL, NULL, NULL, '<p>\n	导演：钱嘉乐\n</p>\n<p>\n	主演：钱嘉乐、郑伊健、陈小春、谢天华、林晓峰\n</p>\n<p>\n	合作方式：1、影片植入，包括主角使用车及镜头露出海报，可加入同品牌概念车的展示；\n</p>\n<p>\n	2、平面不少于5幅海报的使用授权；\n</p>\n<p>\n	3、宣传视频不少于2次使用授权；\n</p>\n<p>\n	4、全国首映礼上，客户可作为联合主办方出席，可安排客户代表上台致辞；\n</p>\n<p>\n	5、可在双方商定的区域原先内，由客户承担台灯声等成本，举行不少于8站主创见面会，有主创团队出席，客户可做额外的电影包场。\n</p>', '黄金七十二小时之友情岁月商务案_奧迪_20161005', NULL, '飞车,速度与激情', 'images/upload/1479788776.2852.png', 1, ''),
(11, '线上', '电视综艺', '校园青春真人秀', '崛起吧 练习生', '', '2017年', '韩国引进版权', '2016-11-28 16:03:54', '', 0, '', 0, '', 0, '', '', '', '', '', '', '传统曲艺与流行音乐的同台竞技，来自不同领域的天王级嘉宾亲自上阵<br />\n该项目由CP方提供，播出平台可控，制作团队可控，可从内容策划至播出包装全程参与。<br />\n汽车作为移动载体植入节目中，或可通过特殊包装摆放于棚内舞台上。<br />', '崛起吧练习生', NULL, '明星养成,真人秀,音乐真人秀,音乐类', 'images/upload/1479892070.3901.jpeg', 0, ''),
(12, '线上', '网络综艺', '自制播报类', '《楠道说》', '爱奇艺汽车频道', '2017年', '为大众呈现中国汽车历史的精彩', '2016-11-23 18:13:06', '', 0, '', 0, '', 0, '全车企', '', '', NULL, NULL, NULL, '爱奇艺汽车频道主编李楠，一个比高晓松更有颜值的网红，爱奇艺内部最神秘的存在，知晓关于汽车的一切知识。', '2016年爱奇艺汽车频道自制节目楠道说招商方案', NULL, '', 'images/upload/1479895986.1081.png', 0, ''),
(13, '线上 ONLINE', '电视综艺', '明星户外真人秀', '72层奇楼', '湖南卫视', '2017年Q2，周五黄金档，90分钟，12集', '南派三叔全新悬疑IP 诡秘奇观', '2016-11-28 15:50:17', '独家冠名', 0, '官方合作伙伴3家', 50000000, '指定产品', 33000000, '汽车类 快销品类', '', '', '', '', '', '<p>\n	这是一档不同于以往韩式真人秀的全新悬疑风格真人秀。\n</p>\n<p>\n	实景加虚拟打造视觉奇观，为观众带来极具冲击的视觉体验。六位MC受南派三叔的邀请为了寻找古籍——天公秘术，展开了一段新奇的历险之旅。每期他们将在奇景之中通过合作、竞争和博弈寻找失落的宝物以及离开的线索，成功者将瓜分“铜币”。与人、机关、怪兽斗智斗勇，谁能笑到最后？\n</p>', '《72层奇楼》（暂定名）招商方案探险版', NULL, '探险真人秀,探险真人秀,真人秀,综艺类', 'images/upload/1480044202.3934.png', 1, ''),
(14, '线上', '电视综艺', '星素户外真人秀', '真星话大冒险', '浙江卫视', '周日档', '聚焦热点事件和话题人物的星素互动综艺', '2016-11-28 15:52:50', '独家冠名', 60000000, '联合特约', 30000000, '话题互动支持', 22500000, '车企、约车软件、手机、食品类', '', '', '', '', '', '', '浙江卫视四季度周日晚《真星话大冒险》招商方案1010', NULL, '星素真人类,整蛊游戏综合,脱口秀', 'images/upload/1480045227.5492.png', 0, ''),
(15, '线上 ONLINE', '电视综艺', '文化纪录片', '一茶一世界', '江苏卫视、央视《探索发现》、爱奇艺', '2017年Q2，周五21：20时段（40分钟×13集）', '《纸牌屋》、《权力的游戏》等节目世界顶级团队摄制', '2016-11-28 18:22:21', '独家冠名', 28000000, '特约赞助', 16000000, '合作伙伴', 5000000, '茶饮料茶企、越野性能车等车企、化妆保健品、旅行社', '', NULL, '', '', '', '', '2017江苏卫视《一茶一世界》招商方案', NULL, '汽车旅行,文化记录', 'images/upload/1480322678.5343.png', 1, ''),
(16, '线上 ONLINE', '电视综艺', '求职真人秀', '非你莫属', '天津卫视', '周日、周一21：20（78分钟不少于100期）', '中国原创综艺，现象级的职场节目', '2016-11-28 17:04:32', '独家冠名', 16000000, '特约播映', 33000000, '唯一指定', 19800000, '', '', NULL, '', '', '', '', '天津卫视2016《非你莫属》栏目招商方案', NULL, '真人秀,脱口秀,求职', 'images/upload/1480323872.0456.png', 0, ''),
(17, '线上 ONLINE', '电视综艺', '明星厨艺类真人秀', '熟悉的味道第二季', '浙江卫视', '2017年Q2，周六22：00（90分钟×12期）', '走心，真实，悬念', '2016-11-28 17:54:49', '独家冠名', 120000000, '联合特约', 60000000, '互动合作', 45000000, '餐饮类、日用快消品、汽车、美食类APP', '', NULL, '', '', '', '', '2017浙江卫视《熟悉的味道》第二季招商方案', NULL, '美食厨艺类,星素真人类', 'images/upload/1480326889.5452.png', 0, 'chao'),
(18, '线上 ONLINE', '电视综艺', '跨年颁奖晚会类', '2017浙江卫视跨年演唱会', '浙江卫视', '2016年12月31日20：00', '顶级明星资源，全新跨界组合，科幻舞台设计', '2016-11-28 18:12:31', '独家冠名', 40000000, '特约合作', 20000000, '互动合作', 15000000, '', '', NULL, '', '', '', '', '浙江卫视2017跨年演唱会招商方案', NULL, '综艺类,音乐类', 'images/upload/1480327951.7043.png', 0, 'chao'),
(19, '线上 ONLINE', '电视综艺', '竞技真人秀', '王牌对王牌第二季', '浙江卫视', '2017年Q1，周五20：00', '浙江卫视一季度收视冠军', '2016-11-28 18:28:33', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017年浙江卫视《王牌对王牌》第二季节目方案', NULL, '竞技真人秀', 'images/upload/1480328913.2598.png', 0, 'chao'),
(20, '线上 ONLINE', '电视综艺', '竞技真人秀', '挑战者联盟3石头剪刀布', '浙江卫视', '2017年Q2，周六20：20（90分钟×12集）', '国内首档城际挑战真人秀', '2016-11-28 18:39:05', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《挑战者联盟》第三季节目方案', NULL, '竞技真人秀', 'images/upload/1480329545.8253.png', 0, 'chao'),
(21, '线上 ONLINE', '电视综艺', '素人音乐选秀', '中国新歌声第二季', '浙江卫视', '2017年Q3，周五21：10（15期）', '大型原创专业音乐节目', '2016-11-28 18:47:58', '', 0, '', 0, '', 0, '快消类、电子类厂商，车企', '', NULL, '', '', '', '', '2017浙江卫视《中国新歌声》第二季节目方案', NULL, '音乐真人秀,音乐类,星素真人类', 'images/upload/1480330078.9718.png', 0, 'chao'),
(22, '线上 ONLINE', '电视综艺', '明星厨艺类真人秀', '12道锋味', '浙江卫视', '2017年Q3，周六22：00', '国内美式综艺No.1', '2016-11-28 19:01:47', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《十二道锋味》第四季节目方案', NULL, '美食厨艺类', 'images/upload/1480330907.6619.png', 0, 'chao'),
(23, '线上 ONLINE', '电视综艺', '校园青春真人秀', '我去上学啦第三季', '浙江卫视、爱奇艺', '', '校园体验式真人秀', '2016-11-28 19:08:43', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《我去上学啦》第三季节目方案', NULL, '明星养成,真人秀,校园青春', 'images/upload/1480331323.3246.png', 0, 'chao'),
(24, '线上 ONLINE', '电视综艺', '真人纪录片', '在路上', '爱奇艺', '2016年9月开拍，10月上线（25分钟×12集）', '亚洲范围内最顶尖艺术家踏上巡礼之旅', '2016-11-28 19:27:49', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2016爱奇艺自制综艺《在路上》节目方案', NULL, '真人秀,汽车旅行,文化记录', 'images/upload/1480332469.5835.png', 0, 'chao'),
(25, '线上 ONLINE', '电视综艺', '竞技真人秀', '超能魔法团', '浙江卫视', '', '全国首档魔术真人秀，德国康斯坦丁娱乐公司技术支持，好莱坞舞美灯光团队', '2016-11-28 19:38:47', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《超能魔法团》节目方案', NULL, '竞技真人秀,舞台竞演', 'images/upload/1480333127.9056.png', 0, 'chao'),
(26, '线上 ONLINE', '电视综艺', '明星户外真人秀', '高能少年团', '浙江卫视', '2017年Q1，周六20：20', '中国荧屏最炙手可热小鲜肉首次成团', '2016-11-28 19:48:16', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《高能少年团》节目方案', NULL, '真人秀,明星养成,竞技真人秀,整蛊游戏综合', 'images/upload/1480333696.8854.png', 0, 'chao'),
(27, '线上 ONLINE', '电视综艺', '明星户外真人秀', '寻找美人鱼', '浙江卫视', '2017年Q2，周六22：00（80分钟×12期）', '华语电影喜剧之王周星驰综艺首秀，国内首档跨媒体叙事真人秀', '2016-11-28 20:08:48', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《寻找美人鱼》节目方案', NULL, '探险真人秀,竞技真人秀', 'images/upload/1480334928.6334.png', 0, 'chao'),
(28, '线上 ONLINE', '电视综艺', '素人音乐选秀', '寻找F4', '浙江卫视、爱奇艺', '2017年暑期档', '顶级豪华阵容再造经典“流行现象”', '2016-11-29 11:03:26', '', 0, '', 0, '', 0, '', '', NULL, '', '', '', '', '2017浙江卫视《寻找F4》节目方案', NULL, '音乐真人秀,星素真人类,明星养成', 'images/upload/1480388606.1219.png', 0, 'chao');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(40) NOT NULL COMMENT '密码',
  `group` varchar(20) NOT NULL COMMENT '组别',
  `grouplevel` int(1) NOT NULL DEFAULT '0',
  `state` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `group`, `grouplevel`, `state`) VALUES
(1, 'vition', 'd13149de00848eb013cad318d27829db64b965d7', '超级管理员', 4, 1),
(4, 'Joychan', '3488797227d51fb10365a1379bfb3eb09511e7c0', '管理员', 3, 1),
(5, 'kamchan', '7f5b8f00cba5b36b11e67c37db51d527d8c2bac2', '超级管理员', 4, 1),
(6, 'billy', '7c4a8d09ca3762af61e59520943dc26494f8941b', '营业员', 2, 1),
(7, 'wing', '6ad34f3b574d660ada8e86c0f667bd5c840dd320', '营业员', 2, 1),
(8, 'fairy', '7c4a8d09ca3762af61e59520943dc26494f8941b', '管理员', 3, 1),
(9, 'fairy2', '7c4a8d09ca3762af61e59520943dc26494f8941b', '营业员', 2, 1),
(10, 'chao', '048ab27836e54e815a07ad3e2ad43e4cd71efba2', '管理员', 3, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
