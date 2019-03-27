-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: mariadb-002.wc1:3306
-- Generation Time: Feb 21, 2019 at 09:30 AM
-- Server version: 10.1.34-MariaDB-1~jessie
-- PHP Version: 7.2.7-1+0~20180622080852.23+jessie~1.gbpfd8e2e

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2021327_usplydev`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_submissions`
--

DROP TABLE IF EXISTS `form_submissions`;
CREATE TABLE IF NOT EXISTS `form_submissions` (
`ID` bigint(20) unsigned NOT NULL,
  `form` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `metadata` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_submission_notes`
--

DROP TABLE IF EXISTS `form_submission_notes`;
CREATE TABLE IF NOT EXISTS `form_submission_notes` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `formName` varchar(100) NOT NULL,
  `formID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ply_commentmeta`
--

DROP TABLE IF EXISTS `ply_commentmeta`;
CREATE TABLE IF NOT EXISTS `ply_commentmeta` (
`meta_id` bigint(20) unsigned NOT NULL,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_comments`
--

DROP TABLE IF EXISTS `ply_comments`;
CREATE TABLE IF NOT EXISTS `ply_comments` (
`comment_ID` bigint(20) unsigned NOT NULL,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_ewwwio_images`
--

DROP TABLE IF EXISTS `ply_ewwwio_images`;
CREATE TABLE IF NOT EXISTS `ply_ewwwio_images` (
`id` int(14) unsigned NOT NULL,
  `attachment_id` bigint(20) unsigned DEFAULT NULL,
  `gallery` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resize` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `converted` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `results` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int(10) unsigned DEFAULT NULL,
  `orig_size` int(10) unsigned DEFAULT NULL,
  `backup` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(5) unsigned DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `updates` int(5) unsigned DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT '1971-01-01 06:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `trace` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_ewwwio_queue`
--

DROP TABLE IF EXISTS `ply_ewwwio_queue`;
CREATE TABLE IF NOT EXISTS `ply_ewwwio_queue` (
  `attachment_id` bigint(20) unsigned DEFAULT NULL,
  `gallery` varchar(10) DEFAULT NULL,
  `scanned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ply_links`
--

DROP TABLE IF EXISTS `ply_links`;
CREATE TABLE IF NOT EXISTS `ply_links` (
`link_id` bigint(20) unsigned NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_options`
--

DROP TABLE IF EXISTS `ply_options`;
CREATE TABLE IF NOT EXISTS `ply_options` (
`option_id` bigint(20) unsigned NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_options`
--

INSERT INTO `ply_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://dev.usply.net', 'yes'),
(2, 'home', 'http://dev.usply.net', 'yes'),
(3, 'blogname', 'USply', 'yes'),
(4, 'blogdescription', 'Just another WordPress site', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'webdept@mdgadvertising.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '1', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:91:{s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:27:"comment-page-([0-9]{1,})/?$";s:39:"index.php?&page_id=30&cpage=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:58:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:68:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:88:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:64:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:53:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$";s:91:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$";s:85:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1";s:77:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:65:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]";s:61:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]";s:47:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:57:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:77:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:53:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]";s:51:"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]";s:38:"([0-9]{4})/comment-page-([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&cpage=$matches[2]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:3:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;s:43:"all-in-one-seo-pack/all_in_one_seo_pack.php";i:2;s:45:"ewww-image-optimizer/ewww-image-optimizer.php";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'usply', 'yes'),
(41, 'stylesheet', 'usply', 'yes'),
(42, 'comment_whitelist', '1', 'yes'),
(43, 'blacklist_keys', '', 'no'),
(44, 'comment_registration', '0', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '43764', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '1', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'page', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', 'none', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '0', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '1', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '0', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(79, 'widget_text', 'a:0:{}', 'yes'),
(80, 'widget_rss', 'a:0:{}', 'yes'),
(81, 'uninstall_plugins', 'a:1:{s:45:"ewww-image-optimizer/ewww-image-optimizer.php";s:30:"ewww_image_optimizer_uninstall";}', 'no'),
(82, 'timezone_string', '', 'yes'),
(83, 'page_for_posts', '0', 'yes'),
(84, 'page_on_front', '30', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '0', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'wp_page_for_privacy_policy', '3', 'yes'),
(92, 'show_comments_cookies_opt_in', '0', 'yes'),
(93, 'initial_db_version', '43764', 'yes'),
(94, 'ply_user_roles', 'a:6:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:63:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:16:"aiosp_manage_seo";b:1;s:23:"manage_form_submissions";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}s:12:"form_manager";a:2:{s:4:"name";s:12:"Form Manager";s:12:"capabilities";a:3:{s:4:"read";b:1;s:23:"manage_form_submissions";b:1;s:15:"unfiltered_html";b:1;}}}', 'yes'),
(95, 'fresh_site', '0', 'yes'),
(96, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(97, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(98, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(99, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(100, 'widget_meta', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(101, 'sidebars_widgets', 'a:2:{s:19:"wp_inactive_widgets";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:13:"array_version";i:3;}', 'yes'),
(102, 'widget_pages', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(103, 'widget_calendar', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(104, 'widget_media_audio', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(105, 'widget_media_image', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(106, 'widget_media_gallery', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(107, 'widget_media_video', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(108, 'widget_tag_cloud', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(109, 'widget_nav_menu', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(110, 'widget_custom_html', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(111, 'cron', 'a:5:{i:1550761398;a:1:{s:34:"wp_privacy_delete_old_export_files";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1550772198;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1550772267;a:2:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}s:25:"delete_expired_transients";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1550787709;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}s:7:"version";i:2;}', 'yes'),
(112, 'theme_mods_twentynineteen', 'a:3:{s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1549910708;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}s:18:"nav_menu_locations";a:0:{}}', 'yes'),
(114, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-5.0.3.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-5.0.3.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-5.0.3-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-5.0.3-new-bundled.zip";s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:5:"5.0.3";s:7:"version";s:5:"5.0.3";s:11:"php_version";s:5:"5.2.4";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"5.0";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1550754790;s:15:"version_checked";s:5:"5.0.3";s:12:"translations";a:0:{}}', 'no'),
(119, '_site_transient_update_themes', 'O:8:"stdClass":4:{s:12:"last_checked";i:1550754795;s:7:"checked";a:1:{s:5:"usply";s:0:"";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}', 'no'),
(136, 'can_compress_scripts', '1', 'no'),
(137, 'current_theme', 'USply', 'yes'),
(138, 'theme_mods_usply', 'a:4:{i:0;b:0;s:18:"nav_menu_locations";a:0:{}s:16:"sidebars_widgets";a:2:{s:4:"time";i:1549910438;s:4:"data";a:1:{s:19:"wp_inactive_widgets";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}s:18:"custom_css_post_id";i:-1;}', 'yes'),
(139, 'theme_switched', '', 'yes'),
(146, 'recently_activated', 'a:0:{}', 'yes'),
(147, 'acf_version', '5.7.12', 'yes'),
(150, 'aioseop_options', 'a:80:{s:16:"aiosp_home_title";N;s:22:"aiosp_home_description";s:0:"";s:20:"aiosp_togglekeywords";i:1;s:19:"aiosp_home_keywords";N;s:26:"aiosp_use_static_home_info";i:0;s:9:"aiosp_can";i:1;s:30:"aiosp_no_paged_canonical_links";i:0;s:31:"aiosp_customize_canonical_links";i:0;s:20:"aiosp_rewrite_titles";i:1;s:20:"aiosp_force_rewrites";i:1;s:24:"aiosp_use_original_title";i:0;s:28:"aiosp_home_page_title_format";s:12:"%page_title%";s:23:"aiosp_page_title_format";s:27:"%page_title% | %blog_title%";s:23:"aiosp_post_title_format";s:27:"%post_title% | %blog_title%";s:27:"aiosp_category_title_format";s:31:"%category_title% | %blog_title%";s:26:"aiosp_archive_title_format";s:30:"%archive_title% | %blog_title%";s:23:"aiosp_date_title_format";s:21:"%date% | %blog_title%";s:25:"aiosp_author_title_format";s:23:"%author% | %blog_title%";s:22:"aiosp_tag_title_format";s:20:"%tag% | %blog_title%";s:25:"aiosp_search_title_format";s:23:"%search% | %blog_title%";s:24:"aiosp_description_format";s:13:"%description%";s:22:"aiosp_404_title_format";s:33:"Nothing found for %request_words%";s:18:"aiosp_paged_format";s:14:" - Part %page%";s:17:"aiosp_enablecpost";s:2:"on";s:17:"aiosp_cpostactive";a:2:{i:0;s:4:"post";i:1;s:4:"page";}s:19:"aiosp_cpostadvanced";i:0;s:18:"aiosp_cpostnoindex";a:0:{}s:19:"aiosp_cpostnofollow";a:0:{}s:17:"aiosp_cposttitles";i:0;s:21:"aiosp_posttypecolumns";a:2:{i:0;s:4:"post";i:1;s:4:"page";}s:19:"aiosp_google_verify";s:0:"";s:17:"aiosp_bing_verify";s:0:"";s:22:"aiosp_pinterest_verify";s:0:"";s:22:"aiosp_google_publisher";s:0:"";s:28:"aiosp_google_disable_profile";i:0;s:29:"aiosp_google_sitelinks_search";N;s:26:"aiosp_google_set_site_name";N;s:30:"aiosp_google_specify_site_name";N;s:28:"aiosp_google_author_advanced";i:0;s:28:"aiosp_google_author_location";a:1:{i:0;s:3:"all";}s:29:"aiosp_google_enable_publisher";s:2:"on";s:30:"aiosp_google_specify_publisher";N;s:25:"aiosp_google_analytics_id";N;s:25:"aiosp_ga_advanced_options";s:2:"on";s:15:"aiosp_ga_domain";N;s:21:"aiosp_ga_multi_domain";i:0;s:21:"aiosp_ga_addl_domains";N;s:21:"aiosp_ga_anonymize_ip";N;s:28:"aiosp_ga_display_advertising";N;s:22:"aiosp_ga_exclude_users";N;s:29:"aiosp_ga_track_outbound_links";i:0;s:25:"aiosp_ga_link_attribution";i:0;s:27:"aiosp_ga_enhanced_ecommerce";i:0;s:20:"aiosp_use_categories";i:0;s:26:"aiosp_use_tags_as_keywords";i:1;s:32:"aiosp_dynamic_postspage_keywords";i:1;s:22:"aiosp_category_noindex";i:1;s:26:"aiosp_archive_date_noindex";i:1;s:28:"aiosp_archive_author_noindex";i:1;s:18:"aiosp_tags_noindex";i:0;s:20:"aiosp_search_noindex";i:0;s:17:"aiosp_404_noindex";i:0;s:17:"aiosp_tax_noindex";a:0:{}s:23:"aiosp_paginated_noindex";i:0;s:24:"aiosp_paginated_nofollow";i:0;s:27:"aiosp_generate_descriptions";i:0;s:18:"aiosp_skip_excerpt";i:0;s:20:"aiosp_run_shortcodes";i:0;s:33:"aiosp_hide_paginated_descriptions";i:0;s:32:"aiosp_dont_truncate_descriptions";i:0;s:19:"aiosp_schema_markup";i:1;s:20:"aiosp_unprotect_meta";i:0;s:33:"aiosp_redirect_attachement_parent";i:0;s:14:"aiosp_ex_pages";s:0:"";s:20:"aiosp_post_meta_tags";s:0:"";s:20:"aiosp_page_meta_tags";s:0:"";s:21:"aiosp_front_meta_tags";s:0:"";s:20:"aiosp_home_meta_tags";s:0:"";s:12:"aiosp_do_log";N;s:19:"last_active_version";s:4:"2.12";}', 'yes'),
(161, 'acf_pro_license', 'YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5TlRFM05qUjhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMUxUQXpMVEV4SURFeU9qTTJPakF4IjtzOjM6InVybCI7czoyMDoiaHR0cDovL2Rldi51c3BseS5uZXQiO30=', 'yes'),
(165, '__website_cache_website_settings', 'O:17:"SiteSettingsClass":28:{s:7:"favicon";N;s:5:"logos";O:8:"stdClass":0:{}s:12:"social_media";O:8:"stdClass":0:{}s:9:"recaptcha";O:8:"stdClass":2:{s:8:"site_key";b:0;s:10:"secret_key";b:0;}s:18:"google_tag_manager";O:8:"stdClass":1:{s:12:"container_id";b:0;}s:9:"corporate";O:8:"stdClass":10:{s:4:"name";b:0;s:10:"legal_name";b:0;s:7:"address";b:0;s:8:"address2";b:0;s:4:"city";b:0;s:5:"state";b:0;s:3:"zip";b:0;s:5:"phone";b:0;s:3:"fax";b:0;s:15:"toll_free_phone";b:0;}s:4:"_404";O:8:"stdClass":4:{s:6:"line_1";b:0;s:6:"line_2";b:0;s:7:"content";b:0;s:5:"image";N;}s:10:"page_about";i:0;s:20:"page_annual_meetings";i:0;s:19:"page_annual_reports";i:0;s:34:"page_available_executive_positions";i:0;s:20:"page_board_directors";i:0;s:21:"page_brand_guidelines";i:0;s:26:"page_calling_all_canadians";i:0;s:12:"page_careers";i:0;s:16:"page_consultants";i:0;s:28:"page_executive_opportunities";i:0;s:14:"page_expertise";i:0;s:21:"page_functional_roles";i:0;s:15:"page_industries";i:0;s:13:"page_insights";i:0;s:23:"page_investor_relations";i:0;s:14:"page_locations";i:0;s:20:"page_management_team";i:0;s:13:"page_programs";i:0;s:22:"page_quarterly_reports";i:0;s:17:"page_testimonials";i:0;s:3:"___";N;}', 'yes'),
(226, '_transient_timeout_acf_plugin_updates', '1550787415', 'no'),
(227, '_transient_acf_plugin_updates', 'a:4:{s:7:"plugins";a:0:{}s:10:"expiration";i:86400;s:6:"status";i:1;s:7:"checked";a:1:{s:34:"advanced-custom-fields-pro/acf.php";s:6:"5.7.12";}}', 'no'),
(233, '_site_transient_timeout_browser_352e84f01e246b1e722c1621ec324313', '1551305774', 'no'),
(234, '_site_transient_browser_352e84f01e246b1e722c1621ec324313', 'a:10:{s:4:"name";s:6:"Chrome";s:7:"version";s:13:"72.0.3626.109";s:8:"platform";s:7:"Windows";s:10:"update_url";s:29:"https://www.google.com/chrome";s:7:"img_src";s:43:"http://s.w.org/images/browsers/chrome.png?1";s:11:"img_src_ssl";s:44:"https://s.w.org/images/browsers/chrome.png?1";s:15:"current_version";s:2:"18";s:7:"upgrade";b:0;s:8:"insecure";b:0;s:6:"mobile";b:0;}', 'no'),
(235, '_transient_timeout_plugin_slugs', '1550788593', 'no'),
(236, '_transient_plugin_slugs', 'a:3:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;s:43:"all-in-one-seo-pack/all_in_one_seo_pack.php";i:2;s:45:"ewww-image-optimizer/ewww-image-optimizer.php";}', 'no'),
(241, '_site_transient_update_plugins', 'O:8:"stdClass":5:{s:12:"last_checked";i:1550754795;s:7:"checked";a:3:{s:34:"advanced-custom-fields-pro/acf.php";s:6:"5.7.12";s:43:"all-in-one-seo-pack/all_in_one_seo_pack.php";s:4:"2.12";s:45:"ewww-image-optimizer/ewww-image-optimizer.php";s:5:"4.6.3";}s:8:"response";a:0:{}s:12:"translations";a:0:{}s:9:"no_update";a:2:{s:43:"all-in-one-seo-pack/all_in_one_seo_pack.php";O:8:"stdClass":9:{s:2:"id";s:33:"w.org/plugins/all-in-one-seo-pack";s:4:"slug";s:19:"all-in-one-seo-pack";s:6:"plugin";s:43:"all-in-one-seo-pack/all_in_one_seo_pack.php";s:11:"new_version";s:4:"2.12";s:3:"url";s:50:"https://wordpress.org/plugins/all-in-one-seo-pack/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/all-in-one-seo-pack.2.12.zip";s:5:"icons";a:2:{s:2:"2x";s:71:"https://ps.w.org/all-in-one-seo-pack/assets/icon-256x256.png?rev=979908";s:2:"1x";s:71:"https://ps.w.org/all-in-one-seo-pack/assets/icon-128x128.png?rev=979908";}s:7:"banners";a:2:{s:2:"2x";s:75:"https://ps.w.org/all-in-one-seo-pack/assets/banner-1544x500.png?rev=1354894";s:2:"1x";s:74:"https://ps.w.org/all-in-one-seo-pack/assets/banner-772x250.png?rev=1354894";}s:11:"banners_rtl";a:0:{}}s:45:"ewww-image-optimizer/ewww-image-optimizer.php";O:8:"stdClass":9:{s:2:"id";s:34:"w.org/plugins/ewww-image-optimizer";s:4:"slug";s:20:"ewww-image-optimizer";s:6:"plugin";s:45:"ewww-image-optimizer/ewww-image-optimizer.php";s:11:"new_version";s:5:"4.6.3";s:3:"url";s:51:"https://wordpress.org/plugins/ewww-image-optimizer/";s:7:"package";s:69:"https://downloads.wordpress.org/plugin/ewww-image-optimizer.4.6.3.zip";s:5:"icons";a:2:{s:2:"2x";s:73:"https://ps.w.org/ewww-image-optimizer/assets/icon-256x256.png?rev=1582276";s:2:"1x";s:73:"https://ps.w.org/ewww-image-optimizer/assets/icon-128x128.png?rev=1582276";}s:7:"banners";a:2:{s:2:"2x";s:76:"https://ps.w.org/ewww-image-optimizer/assets/banner-1544x500.jpg?rev=1582276";s:2:"1x";s:75:"https://ps.w.org/ewww-image-optimizer/assets/banner-772x250.jpg?rev=1582276";}s:11:"banners_rtl";a:0:{}}}}', 'no'),
(243, 'ewww_image_optimizer_relative_migration_status', 'done', 'yes'),
(245, 'ewww_image_optimizer_flag_attachments', '', 'no'),
(246, 'ewww_image_optimizer_ngg_attachments', '', 'no'),
(247, 'ewww_image_optimizer_disable_pngout', '1', 'no'),
(248, 'ewww_image_optimizer_optipng_level', '2', 'no'),
(249, 'ewww_image_optimizer_pngout_level', '2', 'no'),
(250, 'ewww_image_optimizer_metadata_remove', '1', 'no'),
(251, 'ewww_image_optimizer_jpg_level', '10', 'no'),
(252, 'ewww_image_optimizer_png_level', '10', 'no'),
(253, 'ewww_image_optimizer_gif_level', '10', 'no'),
(254, 'ewww_image_optimizer_pdf_level', '0', 'no'),
(255, 'exactdn_lossy', '1', 'no'),
(256, 'ewww_image_optimizer_background_optimization', '1', 'yes'),
(257, 'exactdn_all_the_things', '1', 'no'),
(258, 'ewww_image_optimizer_bulk_resume', '', 'yes'),
(259, 'ewww_image_optimizer_aux_resume', '', 'yes'),
(260, 'ewww_image_optimizer_version', '463.0', 'yes'),
(261, 'ewww_image_optimizer_tracking_notice', '1', 'yes'),
(269, '_site_transient_timeout_aioseop_update_check_time', '1550776394', 'no'),
(270, '_site_transient_aioseop_update_check_time', '1550754794', 'no'),
(271, '_site_transient_timeout_theme_roots', '1550756595', 'no'),
(272, '_site_transient_theme_roots', 'a:1:{s:5:"usply";s:7:"/themes";}', 'no'),
(273, '_transient_timeout_ewww_image_optimizer_images_reoptimized', '1550760891', 'no'),
(274, '_transient_ewww_image_optimizer_images_reoptimized', 'zero', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `ply_postmeta`
--

DROP TABLE IF EXISTS `ply_postmeta`;
CREATE TABLE IF NOT EXISTS `ply_postmeta` (
`meta_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_postmeta`
--

INSERT INTO `ply_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(3, 3, '_edit_lock', '1550701230:1'),
(8, 3, '_wp_trash_meta_status', 'draft'),
(9, 3, '_wp_trash_meta_time', '1550701296'),
(10, 3, '_wp_desired_post_slug', 'privacy-policy'),
(11, 2, '_wp_trash_meta_status', 'publish'),
(12, 2, '_wp_trash_meta_time', '1550701300'),
(13, 2, '_wp_desired_post_slug', 'sample-page'),
(14, 8, '_edit_lock', '1550701310:1'),
(15, 9, '_edit_lock', '1550701326:1'),
(16, 10, '_edit_lock', '1550701480:1'),
(17, 11, '_edit_lock', '1550701745:1'),
(18, 12, '_edit_lock', '1550701751:1'),
(19, 13, '_edit_lock', '1550701774:1'),
(20, 14, '_edit_lock', '1550701841:1'),
(21, 15, '_edit_lock', '1550701920:1'),
(22, 16, '_edit_lock', '1550701950:1'),
(23, 17, '_edit_lock', '1550701894:1'),
(24, 18, '_edit_lock', '1550702042:1'),
(25, 19, '_edit_lock', '1550702069:1'),
(26, 20, '_edit_lock', '1550702106:1'),
(27, 21, '_edit_lock', '1550702158:1'),
(28, 22, '_edit_lock', '1550702237:1'),
(29, 23, '_edit_lock', '1550702143:1'),
(30, 24, '_edit_lock', '1550702292:1'),
(31, 25, '_edit_lock', '1550702206:1'),
(32, 26, '_edit_lock', '1550702227:1'),
(33, 27, '_edit_lock', '1550702376:1'),
(34, 28, '_edit_lock', '1550702318:1'),
(35, 29, '_edit_lock', '1550702334:1'),
(36, 30, '_edit_lock', '1550757952:1'),
(37, 30, '_edit_last', '1'),
(38, 30, 'page_trademark_footer', '0'),
(39, 30, '_page_trademark_footer', 'page_trademark_footer'),
(40, 31, 'page_trademark_footer', '0'),
(41, 31, '_page_trademark_footer', 'page_trademark_footer'),
(42, 32, '_edit_lock', '1550702961:1'),
(43, 33, '_edit_lock', '1550702994:1'),
(44, 34, '_edit_lock', '1550703034:1'),
(45, 35, '_edit_lock', '1550703077:1'),
(46, 36, '_edit_lock', '1550703100:1'),
(47, 37, '_edit_lock', '1550703249:1'),
(48, 38, '_edit_lock', '1550703165:1'),
(49, 30, '_wp_page_template', 'templates/home.php'),
(50, 30, 'homepage_slide_heading', ''),
(51, 30, '_homepage_slide_heading', 'homepage_slide_heading'),
(52, 30, 'homepage_slide_expertise_image', ''),
(53, 30, '_homepage_slide_expertise_image', 'homepage_slide_expertise_image'),
(54, 30, 'homepage_slide_functional_roles_image', ''),
(55, 30, '_homepage_slide_functional_roles_image', 'homepage_slide_functional_roles_image'),
(56, 30, 'homepage_slide_copy_0_slide_heading', ''),
(57, 30, '_homepage_slide_copy_0_slide_heading', 'slide_heading'),
(58, 30, 'homepage_slide_copy_0_slide_content', ''),
(59, 30, '_homepage_slide_copy_0_slide_content', 'slide_content'),
(60, 30, 'homepage_slide_copy_0_slide_cta_page', ''),
(61, 30, '_homepage_slide_copy_0_slide_cta_page', 'slide_cta_page'),
(62, 30, 'homepage_slide_copy_0_slide_cta_text', ''),
(63, 30, '_homepage_slide_copy_0_slide_cta_text', 'slide_cta_text'),
(64, 30, 'homepage_slide_copy_1_slide_heading', ''),
(65, 30, '_homepage_slide_copy_1_slide_heading', 'slide_heading'),
(66, 30, 'homepage_slide_copy_1_slide_content', ''),
(67, 30, '_homepage_slide_copy_1_slide_content', 'slide_content'),
(68, 30, 'homepage_slide_copy_1_slide_cta_page', ''),
(69, 30, '_homepage_slide_copy_1_slide_cta_page', 'slide_cta_page'),
(70, 30, 'homepage_slide_copy_1_slide_cta_text', ''),
(71, 30, '_homepage_slide_copy_1_slide_cta_text', 'slide_cta_text'),
(72, 30, 'homepage_slide_copy_2_slide_heading', ''),
(73, 30, '_homepage_slide_copy_2_slide_heading', 'slide_heading'),
(74, 30, 'homepage_slide_copy_2_slide_content', ''),
(75, 30, '_homepage_slide_copy_2_slide_content', 'slide_content'),
(76, 30, 'homepage_slide_copy_2_slide_cta_page', ''),
(77, 30, '_homepage_slide_copy_2_slide_cta_page', 'slide_cta_page'),
(78, 30, 'homepage_slide_copy_2_slide_cta_text', ''),
(79, 30, '_homepage_slide_copy_2_slide_cta_text', 'slide_cta_text'),
(80, 30, 'homepage_slide_copy_3_slide_heading', ''),
(81, 30, '_homepage_slide_copy_3_slide_heading', 'slide_heading'),
(82, 30, 'homepage_slide_copy_3_slide_content', ''),
(83, 30, '_homepage_slide_copy_3_slide_content', 'slide_content'),
(84, 30, 'homepage_slide_copy_3_slide_cta_page', ''),
(85, 30, '_homepage_slide_copy_3_slide_cta_page', 'slide_cta_page'),
(86, 30, 'homepage_slide_copy_3_slide_cta_text', ''),
(87, 30, '_homepage_slide_copy_3_slide_cta_text', 'slide_cta_text'),
(88, 30, 'homepage_slide_copy', '4'),
(89, 30, '_homepage_slide_copy', 'homepage_slide_copy'),
(90, 30, 'homepage_candidate_background_image', ''),
(91, 30, '_homepage_candidate_background_image', 'homepage_candidate_background_image'),
(92, 30, 'homepage_candidate_heading', ''),
(93, 30, '_homepage_candidate_heading', 'homepage_candidate_heading'),
(94, 30, 'homepage_candidate_content', ''),
(95, 30, '_homepage_candidate_content', 'homepage_candidate_content'),
(96, 30, 'homepage_candidate_cta_page', ''),
(97, 30, '_homepage_candidate_cta_page', 'homepage_candidate_cta_page'),
(98, 30, 'homepage_candidate_cta_text', '');

-- --------------------------------------------------------

--
-- Table structure for table `ply_posts`
--

DROP TABLE IF EXISTS `ply_posts`;
CREATE TABLE IF NOT EXISTS `ply_posts` (
`ID` bigint(20) unsigned NOT NULL,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_posts`
--

INSERT INTO `ply_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(2, 1, '2019-02-11 18:03:13', '2019-02-11 18:03:14', '<!-- wp:paragraph -->\n<p>This is an example page. It''s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>Hi there! I''m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin'' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href="http://dev.usply.net/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'trash', 'closed', 'open', '', 'sample-page__trashed', '', '', '2019-02-20 22:21:41', '2019-02-20 22:21:41', '', 0, 'http://dev.usply.net/?page_id=2', 0, 'page', '', 0),
(3, 1, '2019-02-11 18:03:13', '2019-02-11 18:03:14', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Our website address is: http://dev.usply.net.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What personal data we collect and why we collect it</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Comments</h3><!-- /wp:heading --><!-- wp:paragraph --><p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Media</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Contact forms</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you have an account and you log in to this site, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Embedded content from other websites</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Analytics</h3><!-- /wp:heading --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Your contact information</h2><!-- /wp:heading --><!-- wp:heading --><h2>Additional information</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>How we protect your data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What data breach procedures we have in place</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What third parties we receive data from</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What automated decision making and/or profiling we do with user data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Industry regulatory disclosure requirements</h3><!-- /wp:heading -->', 'Privacy Policy', '', 'trash', 'closed', 'open', '', 'privacy-policy__trashed', '', '', '2019-02-20 22:21:37', '2019-02-20 22:21:37', '', 0, 'http://dev.usply.net/?page_id=3', 0, 'page', '', 0),
(6, 1, '2019-02-20 22:21:37', '2019-02-20 22:21:37', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Our website address is: http://dev.usply.net.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What personal data we collect and why we collect it</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Comments</h3><!-- /wp:heading --><!-- wp:paragraph --><p>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Media</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Contact forms</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Cookies</h3><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you have an account and you log in to this site, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Embedded content from other websites</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Analytics</h3><!-- /wp:heading --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Your contact information</h2><!-- /wp:heading --><!-- wp:heading --><h2>Additional information</h2><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>How we protect your data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What data breach procedures we have in place</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What third parties we receive data from</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>What automated decision making and/or profiling we do with user data</h3><!-- /wp:heading --><!-- wp:heading {"level":3} --><h3>Industry regulatory disclosure requirements</h3><!-- /wp:heading -->', 'Privacy Policy', '', 'inherit', 'closed', 'closed', '', '3-revision-v1', '', '', '2019-02-20 22:21:37', '2019-02-20 22:21:37', '', 3, 'http://dev.usply.net/2019/02/20/3-revision-v1/', 0, 'revision', '', 0),
(7, 1, '2019-02-20 22:21:41', '2019-02-20 22:21:41', '<!-- wp:paragraph -->\n<p>This is an example page. It''s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>Hi there! I''m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin'' caught in the rain.)</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>...or something like this:</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class="wp-block-quote"><p>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p>As a new WordPress user, you should go to <a href="http://dev.usply.net/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>\n<!-- /wp:paragraph -->', 'Sample Page', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2019-02-20 22:21:41', '2019-02-20 22:21:41', '', 2, 'http://dev.usply.net/2019/02/20/2-revision-v1/', 0, 'revision', '', 0),
(8, 1, '2019-02-20 22:21:50', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:21:50', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=8', 0, 'page', '', 0),
(9, 1, '2019-02-20 22:22:06', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:22:06', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=9', 0, 'page', '', 0),
(10, 1, '2019-02-20 22:24:39', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:24:39', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=10', 0, 'page', '', 0),
(11, 1, '2019-02-20 22:26:31', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:26:31', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=11', 0, 'page', '', 0),
(12, 1, '2019-02-20 22:29:11', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:29:11', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=12', 0, 'page', '', 0),
(13, 1, '2019-02-20 22:29:33', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:29:33', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=13', 0, 'page', '', 0),
(14, 1, '2019-02-20 22:30:41', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:30:41', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=14', 0, 'page', '', 0),
(15, 1, '2019-02-20 22:31:59', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:31:59', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=15', 0, 'page', '', 0),
(16, 1, '2019-02-20 22:32:30', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:32:30', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=16', 0, 'page', '', 0),
(17, 1, '2019-02-20 22:33:08', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:33:08', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=17', 0, 'page', '', 0),
(18, 1, '2019-02-20 22:34:02', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:34:02', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=18', 0, 'page', '', 0),
(19, 1, '2019-02-20 22:34:28', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:34:28', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=19', 0, 'page', '', 0),
(20, 1, '2019-02-20 22:35:06', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:35:06', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=20', 0, 'page', '', 0),
(21, 1, '2019-02-20 22:35:58', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:35:58', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=21', 0, 'page', '', 0),
(22, 1, '2019-02-20 22:37:16', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:37:16', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=22', 0, 'page', '', 0),
(23, 1, '2019-02-20 22:37:47', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:37:47', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=23', 0, 'page', '', 0),
(24, 1, '2019-02-20 22:38:11', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:38:11', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=24', 0, 'page', '', 0),
(25, 1, '2019-02-20 22:38:53', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:38:53', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=25', 0, 'page', '', 0),
(26, 1, '2019-02-20 22:39:14', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:39:14', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=26', 0, 'page', '', 0),
(27, 1, '2019-02-20 22:39:35', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:39:35', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=27', 0, 'page', '', 0),
(28, 1, '2019-02-20 22:39:53', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:39:53', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=28', 0, 'page', '', 0),
(29, 1, '2019-02-20 22:41:06', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:41:06', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=29', 0, 'page', '', 0),
(30, 1, '2019-02-20 22:42:07', '2019-02-20 22:42:07', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2019-02-20 22:57:12', '2019-02-20 22:57:12', '', 0, 'http://dev.usply.net/?page_id=30', 0, 'page', '', 0),
(31, 1, '2019-02-20 22:42:07', '2019-02-20 22:42:07', '', 'Home', '', 'inherit', 'closed', 'closed', '', '30-revision-v1', '', '', '2019-02-20 22:42:07', '2019-02-20 22:42:07', '', 30, 'http://dev.usply.net/2019/02/20/30-revision-v1/', 0, 'revision', '', 0),
(32, 1, '2019-02-20 22:51:27', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:51:27', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=32', 0, 'page', '', 0),
(33, 1, '2019-02-20 22:51:49', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:51:49', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=33', 0, 'page', '', 0),
(34, 1, '2019-02-20 22:52:23', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:52:23', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=34', 0, 'page', '', 0),
(35, 1, '2019-02-20 22:53:02', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:53:02', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=35', 0, 'page', '', 0),
(36, 1, '2019-02-20 22:53:46', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:53:46', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=36', 0, 'page', '', 0),
(37, 1, '2019-02-20 22:54:08', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:54:08', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=37', 0, 'page', '', 0),
(38, 1, '2019-02-20 22:54:32', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2019-02-20 22:54:32', '0000-00-00 00:00:00', '', 0, 'http://dev.usply.net/?page_id=38', 0, 'page', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ply_termmeta`
--

DROP TABLE IF EXISTS `ply_termmeta`;
CREATE TABLE IF NOT EXISTS `ply_termmeta` (
`meta_id` bigint(20) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_terms`
--

DROP TABLE IF EXISTS `ply_terms`;
CREATE TABLE IF NOT EXISTS `ply_terms` (
`term_id` bigint(20) unsigned NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_terms`
--

INSERT INTO `ply_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ply_term_relationships`
--

DROP TABLE IF EXISTS `ply_term_relationships`;
CREATE TABLE IF NOT EXISTS `ply_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ply_term_taxonomy`
--

DROP TABLE IF EXISTS `ply_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `ply_term_taxonomy` (
`term_taxonomy_id` bigint(20) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_term_taxonomy`
--

INSERT INTO `ply_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ply_usermeta`
--

DROP TABLE IF EXISTS `ply_usermeta`;
CREATE TABLE IF NOT EXISTS `ply_usermeta` (
`umeta_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_usermeta`
--

INSERT INTO `ply_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'usply-mdg'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'ply_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
(13, 1, 'ply_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', 'wp496_privacy'),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:"33fd17f2bba553e6d2a8146e707b8f97c0c2702f51ba70025da4c774cf5f0588";a:4:{s:10:"expiration";i:1550873770;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:115:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36";s:5:"login";i:1550700970;}}'),
(17, 1, 'ply_dashboard_quick_press_last_post_id', '4'),
(18, 1, 'community-events-location', 'a:1:{s:2:"ip";s:9:"127.0.0.0";}'),
(19, 1, 'aioseop_seen_about_page', '2.12');

-- --------------------------------------------------------

--
-- Table structure for table `ply_users`
--

DROP TABLE IF EXISTS `ply_users`;
CREATE TABLE IF NOT EXISTS `ply_users` (
`ID` bigint(20) unsigned NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ply_users`
--

INSERT INTO `ply_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'usply$mdg', '$P$BzuQLhT/8fm6swY6EEgBBO3NBqhs4m.', 'usply-mdg', 'webdept@mdgadvertising.com', '', '2019-02-11 18:03:11', '', 0, 'usply-mdg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_submissions`
--
ALTER TABLE `form_submissions`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ply_commentmeta`
--
ALTER TABLE `ply_commentmeta`
 ADD PRIMARY KEY (`meta_id`), ADD KEY `comment_id` (`comment_id`), ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `ply_comments`
--
ALTER TABLE `ply_comments`
 ADD PRIMARY KEY (`comment_ID`), ADD KEY `comment_post_ID` (`comment_post_ID`), ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`), ADD KEY `comment_date_gmt` (`comment_date_gmt`), ADD KEY `comment_parent` (`comment_parent`), ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `ply_ewwwio_images`
--
ALTER TABLE `ply_ewwwio_images`
 ADD UNIQUE KEY `id` (`id`), ADD KEY `path` (`path`(191)), ADD KEY `attachment_info` (`gallery`(3),`attachment_id`);

--
-- Indexes for table `ply_ewwwio_queue`
--
ALTER TABLE `ply_ewwwio_queue`
 ADD KEY `attachment_info` (`gallery`(3),`attachment_id`);

--
-- Indexes for table `ply_links`
--
ALTER TABLE `ply_links`
 ADD PRIMARY KEY (`link_id`), ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `ply_options`
--
ALTER TABLE `ply_options`
 ADD PRIMARY KEY (`option_id`), ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `ply_postmeta`
--
ALTER TABLE `ply_postmeta`
 ADD PRIMARY KEY (`meta_id`), ADD KEY `post_id` (`post_id`), ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `ply_posts`
--
ALTER TABLE `ply_posts`
 ADD PRIMARY KEY (`ID`), ADD KEY `post_name` (`post_name`(191)), ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`), ADD KEY `post_parent` (`post_parent`), ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `ply_termmeta`
--
ALTER TABLE `ply_termmeta`
 ADD PRIMARY KEY (`meta_id`), ADD KEY `term_id` (`term_id`), ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `ply_terms`
--
ALTER TABLE `ply_terms`
 ADD PRIMARY KEY (`term_id`), ADD KEY `slug` (`slug`(191)), ADD KEY `name` (`name`(191));

--
-- Indexes for table `ply_term_relationships`
--
ALTER TABLE `ply_term_relationships`
 ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`), ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `ply_term_taxonomy`
--
ALTER TABLE `ply_term_taxonomy`
 ADD PRIMARY KEY (`term_taxonomy_id`), ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`), ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `ply_usermeta`
--
ALTER TABLE `ply_usermeta`
 ADD PRIMARY KEY (`umeta_id`), ADD KEY `user_id` (`user_id`), ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `ply_users`
--
ALTER TABLE `ply_users`
 ADD PRIMARY KEY (`ID`), ADD KEY `user_login_key` (`user_login`), ADD KEY `user_nicename` (`user_nicename`), ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_submissions`
--
ALTER TABLE `form_submissions`
MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT for table `ply_commentmeta`
--
ALTER TABLE `ply_commentmeta`
MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ply_comments`
--
ALTER TABLE `ply_comments`
MODIFY `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ply_ewwwio_images`
--
ALTER TABLE `ply_ewwwio_images`
MODIFY `id` int(14) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ply_links`
--
ALTER TABLE `ply_links`
MODIFY `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ply_options`
--
ALTER TABLE `ply_options`
MODIFY `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=276;
--
-- AUTO_INCREMENT for table `ply_postmeta`
--
ALTER TABLE `ply_postmeta`
MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `ply_posts`
--
ALTER TABLE `ply_posts`
MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `ply_termmeta`
--
ALTER TABLE `ply_termmeta`
MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ply_terms`
--
ALTER TABLE `ply_terms`
MODIFY `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ply_term_taxonomy`
--
ALTER TABLE `ply_term_taxonomy`
MODIFY `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ply_usermeta`
--
ALTER TABLE `ply_usermeta`
MODIFY `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `ply_users`
--
ALTER TABLE `ply_users`
MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
