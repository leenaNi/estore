-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2018 at 08:49 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_additional_charges`
--

CREATE TABLE IF NOT EXISTS `tblprfx_additional_charges` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `label` varchar(250) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `min_order_amt` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
  
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



INSERT INTO `tblprfx_additional_charges` (`id`, `name`, `label`, `type`, `rate`, `status`, `min_order_amt`) VALUES
(1, 'Service Charges', 'Service Charges', 2, 10, 0, 1000),
(2, 'Transportation Charges', 'Transportation Charges', 1, 100, 0, 500);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_attributes`
--


CREATE TABLE IF NOT EXISTS `tblprfx_attributes` (
  `id` bigint(20) unsigned NOT NULL,
  `attr` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `attr_type` bigint(20) NOT NULL,
  `is_filterable` tinyint(4) NOT NULL,
  `placeholder` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `att_sort_order` int(2) DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_attribute_sets`
--

CREATE TABLE IF NOT EXISTS `tblprfx_attribute_sets` (
  `id` bigint(20) unsigned NOT NULL,
  `attr_set` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_attribute_sets`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_attribute_types`
--

CREATE TABLE IF NOT EXISTS `tblprfx_attribute_types` (
  `id` bigint(20) unsigned NOT NULL,
  `attr_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_attribute_types`
--

INSERT INTO `tblprfx_attribute_types` (`id`, `attr_type`) VALUES
(1, 'Dropdown'),
(2, 'Multiselect Dropdown'),
-- (3, 'Textbox'),
(4, 'Radio Button'),
(5, 'Checkbox');
-- (6, 'Date'),
-- (7, 'Time'),
-- (8, 'Date Time'),
-- (9, 'Date Range'),
-- (10, 'File'),
-- (11, 'Image'),
-- (12, 'WYSIWYG'),
-- (13, 'Textarea'),
-- (14, 'Number'),
-- (15, 'Yes/No'),
-- (16, 'File Multiple'),
-- (17, 'Image Multiple');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_attribute_values`
--

CREATE TABLE IF NOT EXISTS `tblprfx_attribute_values` (
  `id` bigint(20) NOT NULL,
  `attr_id` bigint(20) NOT NULL,
  `option_name` varchar(200) NOT NULL,
  `option_value` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_catalog_images`
--

CREATE TABLE IF NOT EXISTS `tblprfx_catalog_images` (
  `id` bigint(20) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `alt_text` varchar(100) NOT NULL,
  `image_type` int(11) NOT NULL,
  `image_mode` int(50) NOT NULL,
  `catalog_id` bigint(20) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `image_path` varchar(180) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `tblprfx_catalog_images` (`id`, `filename`, `alt_text`, `image_type`, `image_mode`, `catalog_id`, `sort_order`,image_path) VALUES
(1, 'prod-20180623103707.jpg', 'Product Image', 1, 1, 1, 1,null),
(2, 'prod-120180623103750.jpg', 'Product Image', 1, 1, 1, 2,null),
(3, 'prod-420180623103751.jpg', 'Product Image', 1, 1, 1, 3,null),
(4, 'prod-320180623103752.jpg', 'Product Image', 1, 1, 1, 4,null),
(5, 'prod-220180623103753.jpg', 'Product Image', 1, 1, 1, 5,null);
-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_categories`
--

CREATE TABLE IF NOT EXISTS `tblprfx_categories` (
  `id` bigint(20) unsigned NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `is_home` tinyint(1) NOT NULL,
  `is_nav` tinyint(1) NOT NULL,
  `url_key` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keys` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` bigint(20) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `size_chart_id` int(11) NOT NULL,
  `brandmake` bigint(20) NOT NULL,
  `brand_address` text COLLATE utf8_unicode_ci NOT NULL,
  `premiumness` bigint(20) NOT NULL,
  `vat` float NOT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `meta_robot` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_meta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_cities`
--

CREATE TABLE IF NOT EXISTS `tblprfx_cities` (
  `id` bigint(20) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_name` text NOT NULL,
  `delivary_status` int(11) NOT NULL,
  `cod_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_cities`
--

INSERT INTO `tblprfx_cities` (`id`, `state_id`, `city_name`, `delivary_status`, `cod_status`, `status`) VALUES
(1, 1, 'Mumbai', 1, 1, 0),
(2, 2, 'Ahemdabad', 1, 0, 1),
(3, 1, 'Navi Mumbai', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_comments`
--

--
-- Table structure for table `couriers`
--

DROP TABLE IF EXISTS `tblprfx_couriers`;
CREATE TABLE IF NOT EXISTS `tblprfx_couriers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url_key` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `pref` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `couriers`
--

INSERT INTO `tblprfx_couriers` (`id`, `name`, `url_key`, `details`, `pref`, `status`) VALUES
(1, 'Fedex India', 'fedex', '{\"key\":\"sdfsdf\",\"password\":\"sdfsdfsdf\",\"shipaccount\":\"sdfdfsdfsdf\",\"billaccount\":\"erwr\",\"dutyaccount\":\"dsdfsdf\",\"meter\":\"123456\",\"account_username\":\"test\",\"account_password\":\"7894566\"}', 1, 1),
(2, 'Delhivery India', 'delhivery', '', 2, 1),
(3, 'Blue Dart India', 'blue-dart', '', 3, 1),
(4, 'Go Fetch Bangladesh', 'go-fetch', '', 3, 1);

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tblprfx_comments` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `status_id` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `notify` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Order History';

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_contacts`
--


CREATE TABLE IF NOT EXISTS `tblprfx_contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_name` text COLLATE utf8_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `address2` text COLLATE utf8_unicode_ci NOT NULL,
  `state` smallint(6) NOT NULL,
  `country` smallint(6) NOT NULL,
  `pincode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `map_url` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_key` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
--
-- Dumping data for table `tblprfx_contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_countries`
--

CREATE TABLE IF NOT EXISTS `tblprfx_countries` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=252 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_countries`
--

INSERT INTO `tblprfx_countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 0),
(2, 'Albania', 'AL', 'ALB', '', 0, 0),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 0),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 0),
(5, 'Andorra', 'AD', 'AND', '', 0, 0),
(6, 'Angola', 'AO', 'AGO', '', 0, 0),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 0),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 0),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 0),
(10, 'Argentina', 'AR', 'ARG', '', 0, 0),
(11, 'Armenia', 'AM', 'ARM', '', 0, 0),
(12, 'Aruba', 'AW', 'ABW', '', 0, 0),
(13, 'Australia', 'AU', 'AUS', '', 0, 0),
(14, 'Austria', 'AT', 'AUT', '', 0, 0),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 0),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 0),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 0),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 1),
(19, 'Barbados', 'BB', 'BRB', '', 0, 0),
(20, 'Belarus', 'BY', 'BLR', '', 0, 0),
(21, 'Belgium', 'BE', 'BEL', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 0, 0),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 0),
(23, 'Benin', 'BJ', 'BEN', '', 0, 0),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 0),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 0),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 0),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', '', 0, 0),
(28, 'Botswana', 'BW', 'BWA', '', 0, 0),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 0),
(30, 'Brazil', 'BR', 'BRA', '', 0, 0),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 0),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 0),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 0),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 0),
(35, 'Burundi', 'BI', 'BDI', '', 0, 0),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 0),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 0),
(38, 'Canada', 'CA', 'CAN', '', 0, 0),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 0),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 0),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 0),
(42, 'Chad', 'TD', 'TCD', '', 0, 0),
(43, 'Chile', 'CL', 'CHL', '', 0, 0),
(44, 'China', 'CN', 'CHN', '', 0, 0),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 0),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 0),
(47, 'Colombia', 'CO', 'COL', '', 0, 0),
(48, 'Comoros', 'KM', 'COM', '', 0, 0),
(49, 'Congo', 'CG', 'COG', '', 0, 0),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 0),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 0),
(52, 'Cote D''Ivoire', 'CI', 'CIV', '', 0, 0),
(53, 'Croatia', 'HR', 'HRV', '', 0, 0),
(54, 'Cuba', 'CU', 'CUB', '', 0, 0),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 0),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 0),
(57, 'Denmark', 'DK', 'DNK', '', 0, 0),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 0),
(59, 'Dominica', 'DM', 'DMA', '', 0, 0),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 0),
(61, 'East Timor', 'TL', 'TLS', '', 0, 0),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 0),
(63, 'Egypt', 'EG', 'EGY', '', 0, 0),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 0),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 0),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 0),
(67, 'Estonia', 'EE', 'EST', '', 0, 0),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 0),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 0),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 0),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 0),
(72, 'Finland', 'FI', 'FIN', '', 0, 0),
(74, 'France, Metropolitan', 'FR', 'FRA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 0),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 0),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 0),
(78, 'Gabon', 'GA', 'GAB', '', 0, 0),
(79, 'Gambia', 'GM', 'GMB', '', 0, 0),
(80, 'Georgia', 'GE', 'GEO', '', 0, 0),
(81, 'Germany', 'DE', 'DEU', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
(82, 'Ghana', 'GH', 'GHA', '', 0, 0),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 0),
(84, 'Greece', 'GR', 'GRC', '', 0, 0),
(85, 'Greenland', 'GL', 'GRL', '', 0, 0),
(86, 'Grenada', 'GD', 'GRD', '', 0, 0),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 0),
(88, 'Guam', 'GU', 'GUM', '', 0, 0),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 0),
(90, 'Guinea', 'GN', 'GIN', '', 0, 0),
(91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 0),
(92, 'Guyana', 'GY', 'GUY', '', 0, 0),
(93, 'Haiti', 'HT', 'HTI', '', 0, 0),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 0),
(95, 'Honduras', 'HN', 'HND', '', 0, 0),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 0),
(97, 'Hungary', 'HU', 'HUN', '', 0, 0),
(98, 'Iceland', 'IS', 'ISL', '', 0, 0),
(99, 'India', 'IN', 'IND', '', 0, 1),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 0),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 0, 0),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 0),
(103, 'Ireland', 'IE', 'IRL', '', 0, 0),
(104, 'Israel', 'IL', 'ISR', '', 0, 0),
(105, 'Italy', 'IT', 'ITA', '', 0, 0),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 0),
(107, 'Japan', 'JP', 'JPN', '', 0, 0),
(108, 'Jordan', 'JO', 'JOR', '', 0, 0),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 0),
(110, 'Kenya', 'KE', 'KEN', '', 0, 0),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 0),
(112, 'North Korea', 'KP', 'PRK', '', 0, 0),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 0),
(114, 'Kuwait', 'KW', 'KWT', '', 0, 0),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 0),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 0, 0),
(117, 'Latvia', 'LV', 'LVA', '', 0, 0),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 0),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 0),
(120, 'Liberia', 'LR', 'LBR', '', 0, 0),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 0),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 0),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 0),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 0),
(125, 'Macau', 'MO', 'MAC', '', 0, 0),
(126, 'FYROM', 'MK', 'MKD', '', 0, 0),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 0),
(128, 'Malawi', 'MW', 'MWI', '', 0, 0),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 0),
(130, 'Maldives', 'MV', 'MDV', '', 0, 0),
(131, 'Mali', 'ML', 'MLI', '', 0, 0),
(132, 'Malta', 'MT', 'MLT', '', 0, 0),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 0),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 0),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 0),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 0),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 0),
(138, 'Mexico', 'MX', 'MEX', '', 0, 0),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 0),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 0),
(141, 'Monaco', 'MC', 'MCO', '', 0, 0),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 0),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 0),
(144, 'Morocco', 'MA', 'MAR', '', 0, 0),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 0),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 0),
(147, 'Namibia', 'NA', 'NAM', '', 0, 0),
(148, 'Nauru', 'NR', 'NRU', '', 0, 0),
(149, 'Nepal', 'NP', 'NPL', '', 0, 0),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 0),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 0),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 0),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 0),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 0),
(155, 'Niger', 'NE', 'NER', '', 0, 0),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 0),
(157, 'Niue', 'NU', 'NIU', '', 0, 0),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 0),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 0),
(160, 'Norway', 'NO', 'NOR', '', 0, 0),
(161, 'Oman', 'OM', 'OMN', '', 0, 0),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 0),
(163, 'Palau', 'PW', 'PLW', '', 0, 0),
(164, 'Panama', 'PA', 'PAN', '', 0, 0),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 0),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 0),
(167, 'Peru', 'PE', 'PER', '', 0, 0),
(168, 'Philippines', 'PH', 'PHL', '', 0, 0),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 0),
(170, 'Poland', 'PL', 'POL', '', 0, 0),
(171, 'Portugal', 'PT', 'PRT', '', 0, 0),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 0),
(173, 'Qatar', 'QA', 'QAT', '', 0, 0),
(174, 'Reunion', 'RE', 'REU', '', 0, 0),
(175, 'Romania', 'RO', 'ROM', '', 0, 0),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 0),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 0),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 0),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 0),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 0),
(181, 'Samoa', 'WS', 'WSM', '', 0, 0),
(182, 'San Marino', 'SM', 'SMR', '', 0, 0),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 0),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 0),
(185, 'Senegal', 'SN', 'SEN', '', 0, 0),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 0),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 0),
(188, 'Singapore', 'SG', 'SGP', '', 0, 0),
(189, 'Slovak Republic', 'SK', 'SVK', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{zone}\r\n{country}', 0, 0),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 0),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 0),
(192, 'Somalia', 'SO', 'SOM', '', 0, 0),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 0),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 0),
(195, 'Spain', 'ES', 'ESP', '', 0, 0),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 0),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 0),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 0),
(199, 'Sudan', 'SD', 'SDN', '', 0, 0),
(200, 'Suriname', 'SR', 'SUR', '', 0, 0),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 0),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 0),
(203, 'Sweden', 'SE', 'SWE', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 0),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 0),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 0),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 0),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 0),
(209, 'Thailand', 'TH', 'THA', '', 0, 0),
(210, 'Togo', 'TG', 'TGO', '', 0, 0),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 0),
(212, 'Tonga', 'TO', 'TON', '', 0, 0),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 0),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 0),
(215, 'Turkey', 'TR', 'TUR', '', 0, 0),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 0),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 0),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 0),
(219, 'Uganda', 'UG', 'UGA', '', 0, 0),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 0),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 0),
(222, 'United Kingdom', 'GB', 'GBR', '', 1, 0),
(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}', 0, 0),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 0),
(225, 'Uruguay', 'UY', 'URY', '', 0, 0),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 0),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 0),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 0),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 0),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 0),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 0),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 0),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 0),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 0),
(235, 'Yemen', 'YE', 'YEM', '', 0, 0),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 0),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 0),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 0),
(240, 'Jersey', 'JE', 'JEY', '', 0, 0),
(241, 'Guernsey', 'GG', 'GGY', '', 0, 0),
(242, 'Montenegro', 'ME', 'MNE', '', 0, 0),
(243, 'Serbia', 'RS', 'SRB', '', 0, 0),
(244, 'Aaland Islands', 'AX', 'ALA', '', 0, 0),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 0),
(246, 'Curacao', 'CW', 'CUW', '', 0, 0),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 0),
(248, 'South Sudan', 'SS', 'SSD', '', 0, 0),
(249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 0),
(250, 'St. Martin (French part)', 'MF', 'MAF', '', 0, 0),
(251, 'Canary Islands', 'IC', 'ICA', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_coupons`
--

CREATE TABLE IF NOT EXISTS `tblprfx_coupons` (
  `id` bigint(20) NOT NULL,
  `coupon_name` varchar(111) NOT NULL,
  `coupon_code` varchar(111) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `coupon_value` int(11) NOT NULL,
  `initial_coupon_val` int(11) NOT NULL DEFAULT '0',
  `min_order_amt` int(11) NOT NULL,
  `coupon_type` int(11) NOT NULL,
  `coupon_image` text NOT NULL,
  `coupon_desc` varchar(111) NOT NULL,
  `no_times_allowed` int(11) NOT NULL,
  `no_times_used` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_specific` int(11) NOT NULL,
  `allowed_per_user` int(11) NOT NULL,
  `restrict_to` int(11) NOT NULL COMMENT 'any => 1,category_specific =>2, product_specific =>3',
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tblprfx_coupons` (`id`, `coupon_name`, `coupon_code`, `discount_type`, `coupon_value`, `initial_coupon_val`, `min_order_amt`, `coupon_type`, `coupon_image`, `coupon_desc`, `no_times_allowed`, `no_times_used`, `start_date`, `end_date`, `user_specific`, `allowed_per_user`, `restrict_to`, `status`, `created_by`, `updated_by`) VALUES
(33, 'New Store 50 Off', 'NEW50', 2, 50, 0, 500, 1, '', 'Use coupon code NEW50 to get 50 off on total cart value. Minimum order amount should be 500.', 1000, 20, '2018-01-01 00:00:00', '2020-12-31 00:00:00', 0, 0, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_coupons_categories`
--

CREATE TABLE IF NOT EXISTS `tblprfx_coupons_categories` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_coupons_products`
--

CREATE TABLE IF NOT EXISTS `tblprfx_coupons_products` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_coupons_users`
--

CREATE TABLE IF NOT EXISTS `tblprfx_coupons_users` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_currencies`
--

CREATE TABLE IF NOT EXISTS `tblprfx_currencies` (
  `id` int(11) NOT NULL,
  `cname` varchar(3) NOT NULL,
  `crate` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_currencies`
--

INSERT INTO `tblprfx_currencies` (`id`, `cname`, `crate`) VALUES
(1, 'INR', 1),
(2, 'USD', 60),
(3, 'GBP', 100),
(4, 'EUR', 80);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_downlodable_prods`
--

CREATE TABLE IF NOT EXISTS `tblprfx_downlodable_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `image_d` varchar(255) NOT NULL,
  `sort_order_d` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
 `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_downlodable_prods`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_dynamic_layout`
--

CREATE TABLE IF NOT EXISTS `tblprfx_dynamic_layout` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `alignment` varchar(100) NOT NULL,
  `image` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_email_template`
--

CREATE TABLE IF NOT EXISTS `tblprfx_email_template` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_email_template`
--
INSERT INTO `tblprfx_email_template` (`id`, `name`, `subject`, `content`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Register template', 'Registered Successfully', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n<h2>You are registered successfully!</h2>\r\n<h4 style=\"font-weight: normal;\">Welcome to the [storeName]! Now that you have created your account, you will be able to edit your account details, view your order history and discover vintage just by logging into your account. <br />[referralCode]</h4>\r\n</div>\r\n</div>\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: Arial Black, Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 1, '2016-07-11 17:59:04', 1, '2018-07-27 06:53:24'),
(2, 'Success template', 'Order has been placed successfully', '<div style="max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;"><table style="padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];" border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td align="left"><h1 style="color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;">Dear [firstName],</h1></td><td align="right"><a href="[web_url]" target="_blank" rel="noopener"><img src="[logoPath]" /></a></td></tr></tbody></table><div style="padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;"><div style="width: 98%; display: table; margin: 0 auto;"><div style="font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;"><h2>Thank you for placing order!</h2><h4 style="font-weight: normal;">Your order has been placed successfully!<br /><br /></h4></div></div><div style="font-family: sans-serif; color: #333333; text-align: center; font-size: 13px;"><h2 style="font: Arial Black,Gadget,sans-serif;">Order Details</h2></div><table style="font-family: arial,sans-serif; border-collapse: collapse; width: 98%; text-align: left; border: solid 2px #d2d2d2; margin: 0 auto 15px auto;"><tbody><tr style="text-align: center; padding: 8px; border-bottom: solid 1px #d2d2d2;"><th style="padding: 10px;">Order ID</th><th style="padding: 10px;">Order Date</th></tr><tr style="background: rgba(210,210,210,0.42); border-bottom: solid 1px #d2d2d2;"><td style="padding: 10px;" align="center" valign="top">[order_id]</td><td style="padding: 10px;" align="center" valign="top">[created_at]</td></tr></tbody></table>[invoice]<div style="padding: 20px 0px 0px 0px; width: 98%; margin: 0 auto;"><strong style="font-family: Source Sans Pro,Geneva,sans-serif;">Regards,</strong><br /><strong style="font-family: Source Sans Pro,Geneva,sans-serif;">[storeName]</strong></div><br /><div style="font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;"><span style="font: \'Arial Black\', Gadget, sans-serif;">Visit Us <a style="color: #222;" href="[web_url]" target="_blank" rel="noopener">[web_url]</a></span></div></div></div>', 1, 0, '2018-07-26 07:32:32', 0, '2018-07-26 07:32:32'),
(3, 'Forgot Password', 'Forgot Password', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n<h4 style=\"font-weight: normal;\">We have received a request from you to reset your account password.</h4>\r\n<div style=\"padding: 0px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\"><a href=\"[newlink]\" target=\"_blank\" rel=\"noopener\">Click here</a></strong> to reset your password.</div>\r\n</div>\r\n</div>\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-05 00:00:00', 0, '2018-07-26 07:57:38'),
(4, 'Order Partially Shipped', 'Order Partially Shipped', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This email is to inform you that we are facing a slight delay in shipping out your complete order due to a slight operational glitch at our end. Your order has been partially shipped and we will be shipping theremaining order out in 2-3 days. You will be notified once your complete order has been shipped.  </span>\r\n	<br /><br />\r\n	<span> We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.  </span>\r\n</div>\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 1, '2018-02-13 00:00:00', 0, '2018-02-13 12:14:31'),
(5, 'Unelivered Order', 'Order Not Delivered', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is regarding the order you placed with us. This is to inform you that your package was shipped out by us but could not be delivered by our courier partners. Please let us know if you would like us to ship your order out again.  </span>\r\n	<br /><br />\r\n	<span> We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.   </span>\r\n</div>\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 00:00:00', 0, '2018-02-13 12:13:12'),
(6, 'Return Order', 'Order Return Request Processed', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is to inform you that your order return request has been processed. Your refund will be credited to your store account as Reward Points which you can use for future purchases. </span>\r\n	<br /><br />\r\n	<span>We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels. </span>\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 00:00:00', 0, '2018-03-07 10:05:42'),
(7, 'Order Exchange', 'Order Exchange Request Processed', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is to inform you that your order exchange request has been processed and your order has been dispatched from our warehouse. </span>\r\n	<br /><br />\r\n	<span>Orders within India are delivered within 7 - 8 working days, and International orders are delivered within 10 to 15 working days. Delivery time may vary depending upon the shipping address. Please note that this is the maximum time for delivery.</span>\r\n	<br /><br />\r\n	<span>\r\n	We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.</span>\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 00:00:00', 0, '2018-02-13 12:10:03'),
(8, 'Order Cancelled', 'Your Order Has Been Cancelled', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is to inform you that your request for order cancellation has been processed. If you have paid using a Credit/ Debit Card or Net Banking, your payment has been reversed and the amount should reflect in your account within 10 working days. </span>\r\n	<br /><br />\r\n	<span>We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.</span>\r\n	\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 06:00:00', 0, '2018-02-13 11:45:33'),
(9, 'Order refund', 'Order Refund Request', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is to inform you that your order refund request has been processed and the amount will reflect in your account within 10 working days. </span>\r\n	<br /><br />\r\n	<span>We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.</span>\r\n	\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 12:00:00', 0, '2018-02-13 11:43:08'),
(10, 'Order Delivered', 'Your Order Has Been Delivered', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span>This is to confirm that your order has been delivered. We hope you had a wonderful shopping experience and we hope to see you in the future.</span>\r\n	<br /><br />\r\n	<span>We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow.</span>\r\n	\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 00:16:00', 0, '2018-02-13 11:45:54'),
(11, 'Order Shipped', 'Your Order Has Been Shipped', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n     <span>This is to inform you that your order has been dispatched from our warehouse. Below is a table with the summary of your order.</span>\r\n	\r\n	\r\n</div>\r\n<br /><br />\r\n[invoice]\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 00:24:00', 0, '2018-02-13 00:00:00'),
(12, 'Order Shipped Delay', 'Delay in Order Shipment', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n	<h4 style=\"font-weight: normal;\"> Your Order  id:  [orderId] </h4>\r\n    <span> This email is to inform you that we are facing a slight delay in shipping out your order due to a slight operational glitch at our end. We will be shipping your order out in 2-3 days and you will be notified once your order has been shipped. </span>\r\n	<br /><br />\r\n	<span> We are always striving to improve our services and make the whole experience of shopping with us even better. Any feedback from you would be extremely valuable to us and help us grow. Please feel free to drop us an email, call us, or get in touch with us on our various social media channels.  </span>\r\n</div>\r\n</div>\r\n<br />\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 0, '2018-02-13 08:25:00', 0, '2018-02-13 12:31:24'),
(13, 'contact Us', 'Contact Us ', '<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td style=\"width: 100%;\">\r\n<p>Dear Admin.&nbsp;</p>\r\n<p>New User [userName]&nbsp; trying to contact you</p>\r\n<p>Users Details are</p>\r\n<p>Email :&nbsp; [userEmail]</p>\r\n<p>Phone&nbsp; :&nbsp; [telephone]</p>\r\n<p>Meaasge : [message]</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, 0, '2018-02-14 00:00:00', 0, '2018-02-14 09:04:32'),
(14, 'Save Reset Password!', 'Save Reset Password!', '<div style=\"max-width: 700px; min-width: 270px; margin: 0 auto; border: solid 2px #fff;\">\r\n<table style=\"padding: 15px; background-color: #[primary_color]; border-bottom: solid 5px #[secondary_color];\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\">\r\n<h1 style=\"color: #222; font-size: 23px; font-weight: 400; margin: 11px 13px 11px;\">Dear [firstName],</h1>\r\n</td>\r\n<td align=\"right\"><a href=\"[web_url]\" target=\"_blank\" rel=\"noopener\"><img src=\"[logoPath]\" /></a></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div style=\"padding: 0px; font-family: Arial, Helvetica, sans-serif; color: #484848; font-size: 12px; line-height: 19px; height: auto;\">\r\n<div style=\"width: 100%; display: table;\">\r\n<div style=\"font-family: sans-serif; color: #333333; text-align: left; font-size: 13px;\">\r\n<h4 style=\"font-weight: normal;\">Your new password for the&nbsp; [email] has been set.</h4>\r\n</div>\r\n</div>\r\n<div style=\"padding: 20px 0px 0px 0px;\"><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">Regards,</strong><br /><strong style=\"font-family: Source Sans Pro,Geneva,sans-serif;\">[storeName]</strong></div>\r\n<br />\r\n<div style=\"font-family: sans-serif; color: #222; background: #ececec; padding: 12px; text-align: center; font-size: 13px; border-top: solid 1px #6b6b6b;\"><span style=\"font: \'Arial Black\', Gadget, sans-serif;\">Visit Us <a style=\"color: #222;\" href=\"[web_url]\" target=\"_blank\" rel=\"noopener\">[web_url]</a></span></div>\r\n</div>\r\n</div>', 1, 1, '2018-07-26 00:00:00', 1, '2018-07-26 08:26:12');



-- Table structure for table `tblprfx_flags`
--

CREATE TABLE IF NOT EXISTS `tblprfx_flags` (
  `id` int(11) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `value` varchar(30) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_flags`
--

INSERT INTO `tblprfx_flags` (`id`, `flag`, `value`, `desc`, `status`) VALUES
(1, 'Pending', '#3D4FFF', 'Orders marked blue are pending', 1),
(2, 'Important', '#FF0000', 'Orders marked red are important', 1),
(3, 'Closed', '#1EB800', 'Orders marked Green are important', 1);


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_general_setting`
--

CREATE TABLE IF NOT EXISTS `tblprfx_general_setting` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `details` text NOT NULL,
  `url_key` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `is_question` tinyint(4) NOT NULL DEFAULT '0',
`question_category_id` int(11) NOT NULL,
 `info`  text NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_general_setting`
--

INSERT INTO `tblprfx_general_setting` (`id`, `name`, `status`, `details`, `url_key`, `type`, `sort_order`, `is_active`, `is_question`, `question_category_id`,`info`) VALUES
(1, 'Would you like to offer "Loyalty Program"?', 1, '', 'loyalty', 1, 89, 1, 1, 1,'This feature allows you to create multiple loyalty groups. To each group you can assign the percentage of Loyalty Points you wish to every time they shop. Also, it allows you to set the limit for the days after which the discount will be applied and showed to the customer in their account. After which these points can be used by the customer in future shopping giving them benefit of discount. More they more discounts they can get.'),
(2, 'Would you like to offer "Referral Program"?', 1, '{"activate_duration_in_days":"10","bonous_to_referee":"2","discount_on_order":"5"}', 'referral', 3, 88, 1, 0, 1,'This feature allows sending the Referral code to the customer while registering on the website for the first time. The cod is sent via SMS and email to their registered Mobile and Email id. Customers can share this code with their friends. The shared code can be used by their friends while placing the order to get the benefit of the Referral discount. Also, it allows you to choose the number of days after which the referral points will get activated. It also allows you to set the percentage of discount which will be received by the Referral (one who shares the code) and the Referee (one who applies the code).'),
(3, 'Do you want to use "System Users"? Multiple admins with different roles can be created', 1, '', 'acl', 1, 3, 1, 0, 2,'This feature helps you to create multiple users for accessing the store admin. This access can be restricted by assigning the user their specific roles or the information that they can access.'),
(4, 'Ebs', 0, '{"mode":"TEST","account_id":"5880","key":"ebskey"}', 'ebs', 2, NULL, 0, 0, 0,''),
(5, 'Paypal', 1, '{"mode":"sandbox","api_username":"madhuriy411_api1.gmail.com","api_password":"LJ9D7PANGH7L2AVH","api_signature":"AkqgSqqB.3FWMu7CCj7GPtu6rrpoAmIk.o5xX2JhImzD58jQ4BesOpc0","currency_code":"USD","logo_url":"sdfsdfdfgfdg"}', 'paypal', 2, NULL, 0, 0, 0,''),
(6, 'PayUmoney', 1, '{"merchant_id":"gtKFFx","salt":"eCwWELxi"}', 'pay-u-money', 2, NULL, 0, 0, 0,''),
(7, 'Razorpay', 1, '{ 	"merchant_name": "Test", 	"key": "rzp_test_su8bbxUKo3wHYG", 	  "logo":"" }', 'razorpay', 2, NULL, 0, 0, 0,''),
(8, 'Citrus Pay', 1, '{"post_url":"https:\\/\\/sandbox.citruspay.com\\/sslperf\\/o0c4dxl6ck","secret_key":"beeef7dae541c87a6497ec5e5843b359c1f7eb66","vanity_url":"o0c4dxl6ck"}', 'citrus', 2, NULL, 0, 0, 0,''),
(9, 'Do you offer "Cash on Delivery" option?', 1, '{"charges":"25"}', 'cod', 1, 90, 1, 1, 3,'The Cash on Delivery (COD) feature allows the customer to pay for the goods at the time of delivery at their footstep. You can charge extra amount in COD, if needed. If you do not wish to charge extra to your customers for COD facility write ‘0’ (zero) in the popup.'),
(10, 'Would you like to use "Coupons" codes to offer discounts?', 1, '', 'coupon', 1, 7, 1, 1, 1,'This feature allows you to create Coupons/discount codes. You can also create coupon codes specific to a user. Coupon codes can be fixed or in percentage.'),
(11, 'Mandrill', 1, '{"key":"vdFj0shlhNQZnXSQdIsU-A","from":"noreply@cartini.com","name":"Cartini"}', 'mandrill', 4, NULL, 0, 0, 0,''),
(12, 'SMTP', 1, '{"host":"smtp.gmail.com","port":"587","from":"madhuri@infiniteit.biz","name":"cartini","encryption":"tls","username":"support@infiniteit.biz","password":"asdf1234"}', 'smtp', 4, NULL, 0, 0, 0,''),
(13, 'Would you like to send Push Notification to the Customers for any Sales Promotion, etc?', 0, '', 'notification', 1, 2, 0, 0, 2,'This feature allows you send push notifications to the customers using the mobile app.'),
(14, 'Register Template', 1, '', 'register-template', 5, NULL, 0, 0, 0,''),
(15, 'Success Template', 1, '', 'success-template', 5, NULL, 0, 0, 0,''),
(18, 'Do you want to use product marked "Barcodes" OR "System Generated Barcode" in product detail? ', 0, '', 'barcode', 1, 9, 1, 1, 2,'This feature allows you to use barcodes that product already has or even the system can generate unique barcodes for every product.'),
(21, 'Product Return Days after it is delivered', 1, '5', 'product-return-days', 6, NULL, 0, 0, 0,''),
(22, 'Do you want to send Invoice details to the customers via email automatically?', 0, '{"storename":"cartini"}', 'invoice', 1, 2, 0, 0, 2,'This feature sends invoice copy to customers automatically when an order is placed on their registered email id.'),
(23, 'Stock', 1, '{"stock_limit":"10"}', 'stock-old', 7, NULL, 0, 0, 0,''),
(24, 'Do you want to avail Pincode based option of enabling/disabling deliveries + applying Shipping Charges as per Pincodes?', 0, '', 'pincode', 1, 11, 1, 0, 2,'This feature helps to store owner to restrict users from marked Pincodes to place the order. System will accept only orders which pincodes are enabled in Pincodes under Settings tab in left menu.'),
(25, 'Do you want to maintain purchase records on the platform?', 0, '', 'purchase', 1, 12, 0, 0, 4,'This feature allows you to capture your purchase information.'),
(26, 'Do you want to manage "Inventory"?', 0, '{"stocklimit":"10"}', 'stock', 1, 13, 1, 0, 4,'This feature helps you to maintain the Inventory of the products. It helps to edit/update the stock of the product. Even the minimum stock limit can be set here so that if the stock goes beyond that number it shows in Running Short or Out of Stock section.'),
(27, 'Do you want this Admin panel in multi language?', 0, '', 'multi-language', 0, 14, 0, 0, 2,'This feature helps to have the admin in multi-language. For this to work the owner has to define the language and then has to add all the translated word in that language in the Language Translation in the left menu.'),
(28, 'Do you want to use "Taxes"? Does any of your product have one or more tax (inclusive/exclusive of the price) applicable?', 0, '', 'tax', 1, 15, 1, 1, 2,'This feature allows you to add Taxes. Here you can define the Taxes and their percentage of charge on the order. Also, it allows the product to be tax specific or not. Taxes is under Products in the left menu.'),
(29, 'set_popup', 1, '', '', 0, NULL, 1, 0, 0,'This feature is for developers of the platform to identity the bugs/error occurred.'),
(30, 'Do you have products with Variants? ', 0, '', 'products-with-variants', 1, 16, 1, 1, 5,'This feature allows you to have configurable products/products with variants on the website. Variants are the for example color, sizes etc. Every Variant has multiple Attributes. For example Color variant will have attributes Red, Yellow, and Blue etc. and Size variant will have attributes like Small, Medium, Large etc.'),
(31, 'Do you want to use table management facility?', 1, '', 'do-you-want-to-use-table-management-facility', 1, 16, 1, 1, 2,''),
(32, 'Do you want to capture your "Raw Material" information?', 0, '', 'row-material', 1, 16, 0, 0, 2,'This feature allows you to capture your raw material information. Raw Materials is under Products tab in the left menu'),
(33, 'Would you like to use "Flags" under orders?', 1, '', 'flag', 0, 17, 1, 0, 2,'This feature allows you to flag/mark the orders for internal references. Orders can be flagged and marked by assigning the colors like Red, Blue, Green, Yellow etc. or assigning the statuses like Important, Pending etc. to it.'),
(35, 'Is this a Marketplace?', 0, '', 'market-place', 0, 24, 0, 0, 2,'A marketplace (or online e-commerce marketplace) is a type of e-commerce website where products are provided by multiple third parties, whereas transactions are processed by the marketplace owner. It gives option to add vendors and products that they offer.'),
(36, 'Do you want to show "Additional Description" in product detail?', 0, '', 'des', 0, 50, 1, 0, 5,'This feature allows you to show additional detailed description against every product on the product detail page.'),
(37, 'Do you want to show "Testimonials"?', 1, '', 'testimonial', 1, 27, 1, 0, 2,'This feature allows you to show the Testimonials (feedback of your customers) on the website. It has options to add picture, name, comment etc. of the customer.'),
(38, 'Do you want to show "Related Products" on product detail?', 1, '', 'related-products', 1, 28, 1, 1, 5,'This feature allows you to mark products under ‘Related Products’ section on the product detail page of the website. You can mark the products which are similar to the product or the products that you would like to cross-sell. You can mark the related products according to the category/ variant/attributes etc.'),
(39, 'Do you want to show "You may also like" products on product detail?', 0, '', 'like-product', 1, 31, 1, 0, 5,'This feature allows you to mark products under ‘You may also like’ section on the product detail page of the website. You can mark the products which are similar to the product or the products that you would like to cross-sell.'),
(40, 'Do you want to use Email facility?', 1, '', 'email-facility', 1, 0, 1, 0, 1,'This feature allows system to send emails to customers on their registered email ids for order placed, order dispatched, order cancelled/returned etc'),
(41, 'Do you want to set debug option true?', 0, '', 'debug-option', 0, 70, 0, 0, 1,''),
(43, 'Would you want to add discount manually while placing order on the app?', 0, '', 'manual-discount', 1, 32, 1, 1, 2,'This feature allows the users and store owner to add manual discount while placing the order on the checkout page.'),
(44, 'Would you like to use the Return Order facility?', 0, '', 'return-product', 1, 34, 1, 1, 2,'This feature allows the customer to return their delivered order by mentioning the reason why they wish to return the order. They can only return if this feature is marked Yes'),
(45, 'Do you want to use Courier Service to deliver products to the customers?', 0, 'courier services like fedex deliveru blue dart', 'courier-services', 1, NULL, 0, 0, 2,'Mark this features ‘Yes’ if you wish to use the courier service synced with the platform. Mark it ‘No’ if you wish to courier goods by yourself.'),
(46, 'question_category_id', 1, '', 'question_category_id', 1, 21, 1, 0, 0,''),
(47, 'Would you like to use "Additional Charges" feature?', 0, '', 'additional-charge', 0, 95, 1, 0, 2,'The Additional Charges feature allows you to create your own custom charges which will be applied against every order. For example: Transport Charges, Handling Charges etc. These charges can be fixed or in percentage. Additional Charges feature is under Orders in the left menu.'),
(48, 'Would you like to use "Dimention Details" in product detail?', 0, '', 'product-daimention', 1, 21, 1, 0, 0,'This feature allows you to add dimentions of the product on product detail page. Dimensions here can be Length, Width, Height and Weight.'),
(49, 'Would you like to use "Minimum Order Quantity"?', 0, '', 'minimum-order', 0, 25, 0, 0, 5,''),
(50, 'Would you like to use "SEO (Search Engine Optimization)"?', '0', '', 'sco', '1', '12', '1', '0', '1','SEO (Search Engine Optimization) helps to increase the online visibility of a website and its products in the web search engines like Google'),
(52, 'Would you like to use "Guest Checkout" feature?', 1, '', 'guest-checkout', 1, 23, 1, 0, 0,'This feature allows customer to checkout without logging in/registering on the website. Only email is asked from the customer for future communication.'),
(53, 'Bank Account Details', '1', '{\"bank_name\":\"bank_name \",\"branch_name\":\"branch_name\",\"ifsc\":\"ifsc\",\"bank_address\":\"asdf sdff sdf asdfa sdfa dfa dasd asdf asdfa dfad asdf asdfa dfa sda d\",\"city\":\"mum\",\"state\":\"1504\",\"country\":\"99\",\"acc_type\":\"1\",\"acc_no\":\"123123123123123123123\"}', 'bank_acc_details', '8', '1', '1', '0', '3', 'Bank account information.'),
(54,'would you like to use default courier services provided by veestores', 1,'', 'default-courier', 1, 12, 1, 1, 2, 'Only when VeeStores Logistic Partner service is used, delivery of the Order and COD (Cash On Delivery) will be managed by VeeStores. These payments will be settled to the Merchant’s bank account within Transaction + 2 working days. The amount transferred will be Amount Transferred = Transaction Amount - Shipping Charges - VeeStores Commission. If Merchant uses his/her own logistic partner, the Merchant will be responsible for delivery of the Order and COD (Cash On Delivery)');
 
-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_gifts`
--

CREATE TABLE IF NOT EXISTS `tblprfx_gifts` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(200) NOT NULL,
  `receiver_email` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `coupon` varchar(200) NOT NULL,
  `limit` smallint(4) NOT NULL,
  `valid_upto` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_attributes`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_attributes` (
  `id` bigint(20) unsigned NOT NULL,
  `attr_id` bigint(20) NOT NULL,
  `attr_set` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_has_attributes`
--



-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_attribute_values`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_attribute_values` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_type_id` int(11) NOT NULL,
  `value` text NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_categories`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_categories` (
  `id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_combo_prods`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_combo_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `combo_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_currency`
--


CREATE TABLE IF NOT EXISTS `tblprfx_has_currency` (
  `id` int(11) NOT NULL,
  `iso_code` varchar(3) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_name` varchar(100) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `currency_val` decimal(11,10) NOT NULL,
  `css_code` varchar(20) NOT NULL,
  `currency_status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_has_currency`
--
INSERT INTO `tblprfx_has_currency` (`id`, `iso_code`, `currency_code`, `currency_name`, `currency`, `currency_val`, `css_code`, `currency_status`) VALUES
(1, '', 'AUD', 'Australian Dollar', 'usd', '0.0405460000', '$', 0),
(2, '', 'BGN', '', '', '0.0267770000', '৳', 0),
(3, '', 'BRL', '', '', '0.0563750000', '', 0),
(4, '', 'CAD', '', '', '0.0202860000', '', 0),
(5, '', 'CHF', '', '', '0.0147940000', '', 0),
(6, '', 'CNY', '', '', '0.0964050000', '', 0),
(7, '', 'CZK', '', '', '0.3699400000', '', 0),
(8, '', 'DKK', '', '', '0.1021500000', '', 0),
(9, 'GBR', 'GBP', 'British Pound', 'gbp', '0.0099053000', '', 1),
(10, '', 'HKD', '', '', '0.1161200000', '', 0),
(11, '', 'HRK', '', '', '0.1044500000', '', 0),
(12, '', 'HUF', '', '', '4.3347000000', '', 0),
(13, '', 'IDR', '', '', '9.9999999999', '', 0),
(14, '', 'ILS', '', '', '0.0579260000', '', 0),
(15, '', 'JPY', '', '', '1.8205000000', '', 0),
(16, '', 'KRW', '', '', '9.9999999999', '', 0),
(17, '', 'MXN', '', '', '0.2556500000', '', 0),
(18, '', 'MYR', '', '', '0.0637980000', '', 0),
(19, '', 'NOK', '', '', '0.1292000000', '', 0),
(20, '', 'NZD', '', '', '0.0221670000', '', 0),
(21, '', 'PHP', '', '', '0.7076500000', '', 0),
(22, '', 'PLN', '', '', '0.0594030000', '', 0),
(23, '', 'RON', '', '', '0.0616500000', '', 0),
(24, '', 'RUB', '', '', '1.0321000000', '', 0),
(25, '', 'SEK', '', '', '0.1270000000', '', 0),
(26, '', 'SGD', 'Singapore Dollar', 'usd', '0.0209990000', '$', 0),
(27, '', 'THB', '', '', '0.5397200000', '', 0),
(28, '', 'TRY', '', '', '0.0437290000', '', 0),
(29, 'USA', 'USD', 'United States Dollar', 'usd', '0.0149820000', '$', 1),
(30, '', 'ZAR', '', '', '0.2288300000', '', 0),
(31, 'BEL', 'EUR', 'Euro', 'euro', '0.0136910000', '€ ', 1),
(32, 'IND', 'INR', 'Indian Rupee', 'inr', '1.0000000000', '₹', 1),
(33, 'BGD', 'BDT', 'Bangladeshi taka', 'bdt', '1.1700000000', '৳', 1),
(34, 'VNM', 'VND', 'vietnamese dong', 'bdt', '9.9999999999', '₫', 1),
(35, 'LKA', 'LKR', 'Sri Lankan Rupaya', 'lkr', '2.2500000000', '₨', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_layouts`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_layouts` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `link` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `banner_text` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_options`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_options` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `attr_id` bigint(20) NOT NULL,
  `attr_type_id` bigint(20) NOT NULL,
  `attr_val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tblprfx_has_industries` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `general_setting_id` bigint(20) NOT NULL,
  `industry_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=288 ;


--
-- Dumping data for table `has_industries`
--

INSERT INTO `tblprfx_has_industries` (`general_setting_id`, `industry_id`) VALUES
(1,1),
(1,4),
(1,5),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12),
(1,13),
(1,14),
(1,15),
(1,16),
(2,1),
(2,4),
(2,5),
(2,7),
(2,8),
(2,9),
(2,10),
(2,11),
(2,12),
(2,13),
(2,14),(2,15),(2,16),(3,1),(3,4),(3,5),(3,7),(3,8),(3,9),(3,10),(3,11),(3,12),
(3,13),(3,14),(3,15),(3,16),(3,1),(3,4),(3,5),(3,7),(3,8),(3,9),(3,10),(3,11),
(3,12),(3,13),(3,14),(3,15),(3,16),(9,1),(9,4),(9,5),(9,7),(9,8),(9,9),(9,10),
(9,11),(9,12),(9,13),(9,14),(9,15),(9,16),(10,1),(10,4),(10,5),(10,7),(10,8),(10,9),(10,10),(10,11),(10,12),(10,13),(10,14),(10,15),(10,16),(48,4),(48,1),(18,1),(18,4),(18,7),(18,8),(18,9),(18,10),(18,11),(18,12),(18,13),(18,14),(18,15),(18,16),(47,1),(47,4),(47,5),(47,7),(47,8),(47,9),(47,10),(47,11),(47,12),(47,13),(47,14),(47,15),(47,16),(22,1),(22,4),(22,5),(22,7),(22,8),(22,9),(22,10),(22,11),(22,12),(22,13),(22,14),(22,15),(22,16),(24,1),(24,4),(24,5),(24,7),(24,8),(24,9),(24,10),(24,11),(24,12),(24,13),(24,14),(24,15),(24,16),(45,1),(45,4),(45,5),(45,7),(45,8),(45,9),(45,10),(45,11),(45,12),(45,13),(45,14),(45,15),(45,16),(26,1),(26,4),(26,7),(26,8),(26,9),(26,10),(26,11),(26,12),(26,13),(26,14),(26,15),(26,16),(44,1),(44,4),(44,5),(44,7),(44,8),(44,9),(44,10),(44,11),(44,12),(44,13),(44,14),(44,15),(44,16),(43,1),(43,4),(43,5),(43,7),(43,8),(43,9),(43,10),(43,11),(43,12),(43,13),(43,14),(43,15),(43,16),(28,1),(28,4),(28,5),(28,7),(28,8),(28,9),(28,10),(28,11),(28,12),(28,13),(28,14),(28,15),(28,16),(30,1),(30,4),(30,5),(30,7),(30,8),(30,9),(30,10),(30,11),(30,12),(30,13),(30,14),(30,15),(30,16),(40,1),(40,4),(40,5),(40,7),(40,8),(40,9),(40,10),(40,11),(40,12),(40,13),(40,14),(40,15),(40,16),(36,1),(36,4),(36,5),(36,7),(36,8),(36,9),(36,10),(36,11),(36,12),(36,13),(36,14),(36,15),(36,16),(37,1),(37,4),(37,5),(37,7),(37,8),(37,9),(37,10),(37,11),(37,12),(37,13),(37,14),(37,15),(37,16),(38,1),(38,4),(38,5),(38,7),(38,8),(38,9),(38,10),(38,11),(38,12),(38,13),(38,14),(38,15),(38,16),(39,1),(39,4),(39,5),(39,7),(39,8),(39,9),(39,10),(39,11),(39,12),(39,13),(39,14),(39,15),(39,16),(54,1),(54,4),(54,5),(54,7),(54,8),(54,9),(54,10),(54,11),(54,12),(54,13),(54,14),(54,15),(54,16);



-- --------------------------------------------------------

--
-- Table structure for table `has_layouts`
--

--
-- Table structure for table `tblprfx_has_products`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_has_products` (
--   `id` bigint(20) NOT NULL,
--   `order_id` bigint(20) NOT NULL,
--   `kot` bigint(20) NOT NULL,
--   `prod_id` bigint(20) NOT NULL,
--   `sub_prod_id` text NOT NULL,
--   `qty` bigint(20) NOT NULL,
--   `price` double NOT NULL,
--    `pay_amt` double NOT NULL,
--   `amt_after_discount` float(10,2) NOT NULL,
--   `disc` double NOT NULL,
--   `wallet_disc` double NOT NULL,
--   `voucher_disc` double NOT NULL,
--   `referral_disc` double NOT NULL,
--   `user_disc` double NOT NULL,
--   `product_details` text NOT NULL,
--   `qty_returned` int(10) NOT NULL,
--   `eCount` int(11) NOT NULL,
--   `eTillDownload` date NOT NULL,
--   `prod_type` int(11) DEFAULT '0',
--   `remark` text NOT NULL,
--   `tax` text,
--   `order_status` int(11) DEFAULT NULL,
--   `tracking_id` int(11) DEFAULT NULL,
--   `vendor_id` int(11) DEFAULT NULL,
-- `qty_exchange` int(11) DEFAULT NULL,
--  `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_related_prods`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_related_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `related_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_taxes`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_taxes` (
  `id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_upsell_prods`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_upsell_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `upsell_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_has_vendors`
--

CREATE TABLE IF NOT EXISTS `tblprfx_has_vendors` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_kot`
--

CREATE TABLE IF NOT EXISTS `tblprfx_kot` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_kot`
--

INSERT INTO `tblprfx_kot` (`id`, `order_id`) VALUES
(1, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_language`
--

CREATE TABLE IF NOT EXISTS `tblprfx_language` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_language`
--

INSERT INTO `tblprfx_language` (`id`, `name`, `status`) VALUES
(1, 'Hindi', 1),
(2, 'English', 1),
(3, 'Bengali', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_layout`
--

CREATE TABLE IF NOT EXISTS `tblprfx_layout` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `url_key` varchar(200) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_del` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_layout`
--

INSERT INTO `tblprfx_layout` (`id`, `name`, `url_key`, `is_active`, `is_del`) VALUES
(1, 'Home Page Slider', 'home-page-slider', 1, 0),
(4, 'Home Page 3 Boxes', 'home-page-3-boxes', 1, 0);



-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_loyalty`
--

CREATE TABLE IF NOT EXISTS `tblprfx_loyalty` (
  `id` int(11) NOT NULL,
  `group` varchar(100) NOT NULL,
  `min_order_amt` float NOT NULL,
  `max_order_amt` float NOT NULL,
  `percent` float NOT NULL,
  `range_amt` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_loyalty`
--
INSERT INTO `tblprfx_loyalty` (`id`, `group`, `min_order_amt`, `max_order_amt`, `percent`, `range_amt`, `status`) VALUES
(1, 'Silver', 2000, 5000, 2, '2000 - 5,000', 1),
(2, 'Gold', 5001, 10000, 5, '5,001 - 10,000', 1),
(3, 'Platinum', 10001, 100000, 10, 'Above 10,001', 1);


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_newsletter`
--

CREATE TABLE IF NOT EXISTS `tblprfx_newsletter` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_notification`
--

CREATE TABLE IF NOT EXISTS `tblprfx_notification` (
  `id` int(11) NOT NULL,
  `email` varchar(230) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_occupancy_status`
--

CREATE TABLE IF NOT EXISTS `tblprfx_occupancy_status` (
  `id` int(11) NOT NULL,
  `ostatus` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_occupancy_status`
--

INSERT INTO `tblprfx_occupancy_status` (`id`, `ostatus`, `color`) VALUES
(1, 'Free', 'green'),
(2, 'Occupied', 'red'),
(3, 'Billed', 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_offers`
--

CREATE TABLE IF NOT EXISTS `tblprfx_offers` (
  `id` bigint(20) unsigned NOT NULL,
  `offer_name` varchar(111) NOT NULL,
  `offer_discount_type` tinyint(1) NOT NULL,
  `offer_type` int(11) NOT NULL,
  `offer_discount_value` int(11) NOT NULL,
  `min_order_qty` int(11) NOT NULL,
  `min_free_qty` int(11) NOT NULL,
  `min_order_amt` int(11) NOT NULL,
  `max_discount_amt` int(11) NOT NULL,
  `max_usage` int(11) NOT NULL,
  `actual_usage` int(11) NOT NULL,
  `full_incremental_order` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_specific` int(11) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_offers`
--

INSERT INTO `tblprfx_offers` (`id`, `offer_name`, `offer_discount_type`, `offer_type`, `offer_discount_value`, `min_order_qty`, `min_free_qty`, `min_order_amt`, `max_discount_amt`, `max_usage`, `actual_usage`, `full_incremental_order`, `start_date`, `end_date`, `user_specific`, `status`) VALUES
(4, 'Buy 2 get 20%off on 3rd product onwards', 1, 1, 20, 2, 0, 5000, 500, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_offers_categories`
--

CREATE TABLE IF NOT EXISTS `tblprfx_offers_categories` (
  `id` bigint(20) unsigned NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_offers_products`
--

CREATE TABLE IF NOT EXISTS `tblprfx_offers_products` (
  `id` bigint(20) NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_offers_users`
--

CREATE TABLE IF NOT EXISTS `tblprfx_offers_users` (
  `id` bigint(20) unsigned NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


-- Table structure for table `tblprfx_ordertypes`
--

CREATE TABLE IF NOT EXISTS `tblprfx_ordertypes` (
  `id` int(20) NOT NULL,
  `otype` varchar(20) NOT NULL,
  `status` tinyint(9) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_ordertypes`
--

INSERT INTO `tblprfx_ordertypes` (`id`, `otype`, `status`) VALUES
(1, 'Dine In', 1),
(2, 'Home Delivery', 1),
(3, 'Take Away', 1),
(4, 'Online', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_flag_history`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_flag_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `flag_id` int(11) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_history`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `cod` double NOT NULL,
  `cart` text NOT NULL,
  `shipping_amt` double NOT NULL,
  `gifting_amt` double NOT NULL,
  `coupon_amt` double NOT NULL,
  `voucher_amt` double NOT NULL,
  `referral_amt` double NOT NULL,
  `cashback_used` double NOT NULL,
  `order_amt` double NOT NULL,
  `pay_amt` double NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remark` varchar(500) NOT NULL,
  `additional_charge` text,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_return_action`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_return_action` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_order_return_action`
--

INSERT INTO `tblprfx_order_return_action` (`id`, `action`) VALUES
(1, 'Credit Issued'),
(2, 'Refunded'),
(3, 'No Action');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_return_cashback_history`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_return_cashback_history` (
  `id` int(11) NOT NULL,
  `return_order_id` int(11) NOT NULL,
  `cashback` float(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `cron_status` enum('0','1','2') NOT NULL DEFAULT '2',
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_return_open_unopen`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_return_open_unopen` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_order_return_open_unopen`
--

INSERT INTO `tblprfx_order_return_open_unopen` (`id`, `status`) VALUES
(1, 'Opened'),
(2, 'Unopened');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_return_reason`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_order_return_reason` (
--   `id` int(11) NOT NULL,
--   `reason` varchar(255) NOT NULL,
-- `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_order_return_reason`
--

-- INSERT INTO `tblprfx_order_return_reason` (`id`, `reason`) VALUES
-- (1, 'Dead on arrival'),
-- (2, 'Faulty Product'),
-- (3, 'Order error'),
-- (4, 'Received wrong item'),
-- (5, 'Bought by mistake'),
-- (6, 'Better price available'),
-- (7, 'Item arrived too late'),
-- (8, 'Both product and shipping box damaged'),
-- (9, 'Item defective or doesn’t work'),
-- (10, 'Received extra item I didn’t buy (no refund needed)'),
-- (11, 'No longer needed'),
-- (12, 'Too small'),
-- (13, 'Too large'),
-- (14, 'Style not as expected'),
-- (15, 'Ordered wrong size/colour'),
-- (16, 'Inaccurate website description'),
-- (17, 'Quality not as expected'),
-- (18, 'Managed By Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_return_status`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_order_return_status` (
--   `id` int(11) NOT NULL,
--   `status` varchar(255) NOT NULL,
-- `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_order_return_status`
--

-- INSERT INTO `tblprfx_order_return_status` (`id`, `status`) VALUES
-- (1, 'Awaiting Products'),
-- (2, 'Complete'),
-- (3, 'Pending'),
-- (4, 'No Status');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_status`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_status` (
  `id` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_order_status`
--

INSERT INTO `tblprfx_order_status` (`id`, `order_status`, `status`) VALUES
(1, 'Processing ', 1),
(2, 'Shipped', 1),
(3, 'Delivered', 1),
(4, 'Cancelled', 1),
(5, 'Exchanged', 1),
(6, 'Returned', 1),
(7, 'Undelivered', 1),
(8, 'Delayed', 1),
(9, 'Partially Shipped', 1),
(10, 'Refunded', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_order_status_history`
--

CREATE TABLE IF NOT EXISTS `tblprfx_order_status_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `notify` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_password_resets`
--

CREATE TABLE IF NOT EXISTS `tblprfx_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_payment_method`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_payment_method` (
--   `id` int(11) NOT NULL,
--   `name` varchar(255) NOT NULL,
--   `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_payment_method`
--

-- INSERT INTO `tblprfx_payment_method` (`id`, `name`) VALUES
-- (1, 'COD'),
-- (2, 'EBS'),
-- (3, 'Cashback/Points/Vouchers/Coupons'),
-- (4, 'Paypal'),
-- (5, 'PayU'),
-- (6, 'Citrus'),
-- (7, 'Razorpay');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_payment_status`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_payment_status` (
--   `id` int(11) NOT NULL,
--   `payment_status` varchar(255) NOT NULL,
--  `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_payment_status`
--

-- INSERT INTO `tblprfx_payment_status` (`id`, `payment_status`) VALUES
-- (1, 'Pending'),
-- (2, 'Cancelled'),
-- (3, 'Partially Paid'),
-- (4, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_permissions`
--

CREATE TABLE IF NOT EXISTS `tblprfx_permissions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=33130 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_permissions`
--
INSERT INTO `tblprfx_permissions` (`id`, `name`, `display_name`, `description`, `section_id`, `parent_id`, `status`) VALUES
(1, 'admin.dashboard', 'Dashboard', NULL, 1, 0, 0),
(2, 'admin.category.view', 'Category View', NULL, 2, 0, 0),
(3, 'admin.category.add', 'Category Add', NULL, 2, 0, 0),
(4, 'admin.category.save', 'Category Save', NULL, 2, 0, 0),
(5, 'admin.category.edit', 'Category Edit', NULL, 2, 0, 0),
(6, 'admin.attribute.set.view', 'Attribute Set View', NULL, 3, 0, 0),
(7, 'admin.attribute.set.add', 'Attribute Set Add', NULL, 3, 0, 0),
(8, 'admin.attribute.set.save', 'Attribute Set Save', NULL, 3, 0, 0),
(9, 'admin.attribute.set.edit', 'Attribute Set Edit', NULL, 3, 0, 0),
(10, 'admin.attribute.set.delete', 'Attribute Set Delete', NULL, 3, 0, 0),
(11, 'admin.attributes.view', 'Attributes View', NULL, 4, 0, 0),
(12, 'admin.attributes.add', 'Attributes Add', NULL, 4, 0, 0),
(13, 'admin.attributes.save', 'Attributes Save', NULL, 4, 0, 0),
(14, 'admin.attributes.edit', 'Attributes Edit', NULL, 4, 0, 0),
(15, 'admin.products.view', 'Products View', NULL, 5, 0, 0),
(16, 'admin.products.add', 'Products Add', NULL, 5, 0, 0),
(17, 'admin.products.delete', 'Products Delete', NULL, 5, 0, 0),
(18, 'admin.products.save', 'Products Save', NULL, 5, 0, 0),
(19, 'admin.products.general.info', 'Products General Info', NULL, 5, 0, 0),
(20, 'admin.products.update', 'Products Update', NULL, 5, 0, 0),
(21, 'admin.products.edit.category', 'Products Edit Category', NULL, 5, 0, 0),
(22, 'admin.products.update.category', 'Products Update Category', NULL, 5, 20, 0),
(23, 'admin.products.duplicate', 'Products Duplicate', NULL, 5, 0, 0),
(24, 'admin.products.update.combo', 'Products Update Combo', NULL, 5, 20, 0),
(25, 'admin.products.update.combo.attach', 'Products Update Combo Attach', NULL, 5, 20, 0),
(26, 'admin.products.update.combo.detach', 'Products Update Combo Detach', NULL, 5, 20, 0),
(27, 'admin.products.images', 'Products Images', NULL, 4, 0, 0),
(28, 'admin.products.images.save', 'Products Images Save', NULL, 5, 18, 0),
(29, 'admin.products.images.delete', 'Products Images Delete', NULL, 5, 17, 0),
(30, 'admin.products.attributes.update', 'Products Attributes Update', NULL, 5, 20, 0),
(31, 'admin.products.configurable.attributes', 'Products Configurable Attributes', NULL, 5, 0, 0),
(32, 'admin.products.configurable.update', 'Products Configurable Update', NULL, 5, 20, 0),
(33, 'admin.combo.products.view', 'Combo Products View', NULL, 5, 15, 0),
(34, 'admin.products.variant.update', 'Products Variant Update', NULL, 5, 20, 0),
(36, 'admin.products.upsell', 'Products Upsell', NULL, 5, 0, 0),
(37, 'admin.products.upsell.related', 'Products Upsell Related', NULL, 5, 0, 0),
(38, 'admin.products.related.attach', 'Products Related Attach', NULL, 5, 20, 0),
(39, 'admin.products.related.detach', 'Products Related Detach', NULL, 5, 20, 0),
(40, 'admin.products.upsell.attach', 'Products Upsell Attach', NULL, 5, 20, 0),
(41, 'admin.products.upsell.detach', 'Products Upsell Detach', NULL, 5, 20, 0),
(42, 'admin.roles.view', 'Roles View', NULL, 20, 0, 0),
(43, 'admin.roles.add', 'Roles Add', NULL, 20, 0, 0),
(44, 'admin.roles.save', 'Roles Save', NULL, 20, 0, 0),
(45, 'admin.roles.edit', 'Roles Edit', NULL, 20, 0, 0),
(46, 'admin.systemusers.view', 'Systemusers View', NULL, 43, 0, 0),
(47, 'admin.systemusers.add', 'Systemusers Add', NULL, 43, 0, 0),
(48, 'admin.systemusers.save', 'Systemusers Save', NULL, 43, 0, 0),
(49, 'admin.systemusers.edit', 'Systemusers Edit', NULL, 43, 0, 0),
(50, 'admin.systemusers.update', 'Systemusers Update', NULL, 43, 0, 0),
(51, 'admin.products.configurable.update.without.stock', 'Products Configurable Update Without Stock', NULL, 5, 20, 0),
(52, 'admin.products.configurable.without.stock.attributes', 'Products Configurable Without Stock Attributes', NULL, 5, 0, 0),
(53, 'admin.miscellaneous.view', 'Miscellaneous View', NULL, 0, 0, 0),
(54, 'admin.miscellaneous.add', 'Miscellaneous Add', NULL, 0, 0, 0),
(55, 'admin.miscellaneous.edit', 'Miscellaneous Edit', NULL, 0, 0, 0),
(56, 'admin.miscellaneous.save', 'Miscellaneous Save', NULL, 0, 0, 0),
(57, 'admin.miscellaneous.delete', 'Miscellaneous Delete', NULL, 0, 0, 0),
(58, 'admin.category.delete', 'Category Delete', NULL, 2, 0, 0),
(59, 'admin.attributes.delete', 'Attributes Delete', NULL, 4, 0, 0),
(60, 'admin.roles.delete', 'Roles Delete', NULL, 20, 0, 0),
(61, 'admin.systemusers.delete', 'Systemusers Delete', NULL, 43, 0, 0),
(62, 'admin.category.catSeo', 'Category Catseo', NULL, 2, 0, 0),
(63, 'admin.category.saveCatSeo', 'Category Savecatseo', NULL, 2, 4, 0),
(64, 'admin.products.attribute', 'Products Attribute', NULL, 5, 0, 0),
(65, 'admin.products.attribute.save', 'Products Attribute Save', NULL, 5, 18, 0),
(66, 'admin.products.prodSeo', 'Products Prodseo', NULL, 5, 0, 0),
(67, 'admin.products.prodSaveSeo', 'Products Prodsaveseo', NULL, 5, 18, 0),
(68, 'admin.products.prodUpload', 'Products Produpload', NULL, 5, 0, 0),
(69, 'admin.products.prodUploadDel', 'Products Produploaddel', NULL, 5, 0, 0),
(70, 'admin.products.prodSaveUpload', 'Products Prodsaveupload', NULL, 5, 18, 0),
(71, 'admin.coupons.view', 'Coupons View', NULL, 6, 0, 0),
(72, 'admin.coupons.add', 'Coupons Add', NULL, 6, 0, 0),
(73, 'admin.coupons.save', 'Coupons Save', NULL, 6, 0, 0),
(74, 'admin.coupons.edit', 'Coupons Edit', NULL, 6, 0, 0),
(75, 'admin.coupons.delete', 'Coupons Delete', NULL, 6, 0, 0),
(76, 'admin.coupons.searchUser', 'Coupons Searchuser', NULL, 6, 0, 0),
(77, 'admin.orders.view', 'Orders View', NULL, 13, 0, 0),
(78, 'admin.orders.add', 'Orders Add', NULL, 13, 0, 0),
(79, 'admin.orders.invoice', 'Orders Invoice', NULL, 13, 0, 0),
(80, 'admin.orders.invoice.print', 'Orders Invoice Print', NULL, 13, 0, 0),
(81, 'admin.orders.export', 'Orders Export', NULL, 13, 0, 0),
(82, 'admin.orders.update.payment', 'Orders Update Payment', NULL, 13, 292, 0),
(83, 'admin.orders.update.status', 'Orders Update Status', NULL, 13, 292, 0),
(84, 'admin.orders.update.return', 'Orders Update Return', NULL, 13, 292, 0),
(85, 'admin.orders.revert.return', 'Orders Revert Return', NULL, 13, 0, 0),
(86, 'admin.orders.update', 'Orders Update', NULL, 13, 0, 0),
(87, 'admin.orders.save', 'Orders Save', NULL, 13, 0, 0),
(88, 'admin.orders.edit', 'Orders Edit', NULL, 13, 0, 0),
(89, 'admin.orders.delete', 'Orders Delete', NULL, 13, 0, 0),
(90, 'admin.sales.byorder', 'Sales Byorder', NULL, 14, 0, 0),
(91, 'admin.sales.byproduct', 'Sales Byproduct', NULL, 14, 0, 0),
(92, 'admin.sales.bycategory', 'Sales Bycategory', NULL, 14, 0, 0),
(93, 'admin.sales.byartist', 'Sales Byartist', NULL, 14, 0, 0),
(94, 'admin.sales.export.attribute', 'Sales Export Attribute', NULL, 14, 0, 0),
(95, 'admin.sales.export.category', 'Sales Export Category', NULL, 14, 0, 0),
(96, 'admin.sales.export.artist', 'Sales Export Artist', NULL, 14, 0, 0),
(97, 'admin.sales.export.product', 'Sales Export Product', NULL, 14, 0, 0),
(98, 'admin.sales.export.order', 'Sales Export Order', NULL, 14, 0, 0),
(99, 'admin.sales.users', 'Sales Users', NULL, 14, 0, 0),
(100, 'admin.sales.byattribute', 'Sales Byattribute', NULL, 14, 0, 0),
(101, 'admin.offers.view', 'Offers View', NULL, 15, 0, 0),
(102, 'admin.offers.add', 'Offers Add', NULL, 15, 0, 0),
(103, 'admin.offers.save', 'Offers Save', NULL, 15, 0, 0),
(104, 'admin.offers.edit', 'Offers Edit', NULL, 15, 0, 0),
(105, 'admin.offers.delete', 'Offers Delete', NULL, 15, 0, 0),
(106, 'admin.offers.searchUser', 'Offers Searchuser', NULL, 15, 0, 0),
(107, 'admin.loyalty.view', 'Loyalty View', NULL, 22, 0, 0),
(108, 'admin.loyalty.add', 'Loyalty Add', NULL, 22, 0, 0),
(109, 'admin.loyalty.save', 'Loyalty Save', NULL, 22, 0, 0),
(110, 'admin.loyalty.edit', 'Loyalty Edit', NULL, 22, 0, 0),
(111, 'admin.loyalty.update', 'Loyalty Update', NULL, 22, 0, 0),
(112, 'admin.loyalty.delete', 'Loyalty Delete', NULL, 22, 0, 0),
(113, 'admin.generalSetting.view', 'Generalsetting View', NULL, 33, 0, 0),
(114, 'admin.generalSetting.add', 'Generalsetting Add', NULL, 33, 0, 0),
(115, 'admin.generalSetting.edit', 'Generalsetting Edit', NULL, 33, 0, 0),
(116, 'admin.generalSetting.save', 'Generalsetting Save', NULL, 33, 0, 0),
(117, 'admin.generalSetting.delete', 'Generalsetting Delete', NULL, 33, 0, 0),
(118, 'admin.paymentSetting.view', 'Paymentsetting View', NULL, 36, 0, 0),
(119, 'admin.paymentSetting.add', 'Paymentsetting Add', NULL, 36, 0, 0),
(120, 'admin.paymentSetting.edit', 'Paymentsetting Edit', NULL, 36, 0, 0),
(121, 'admin.paymentSetting.save', 'Paymentsetting Save', NULL, 36, 0, 0),
(122, 'admin.paymentSetting.delete', 'Paymentsetting Delete', NULL, 36, 0, 0),
(123, 'admin.advanceSetting.view', 'Advancesetting View', NULL, 37, 0, 0),
(124, 'admin.products.sampleBulkDownload', 'Products Samplebulkdownload', NULL, 5, 0, 0),
(125, 'admin.products.productBulkUpload', 'Products Productbulkupload', NULL, 5, 0, 0),
(126, 'admin.products.prdBulkImgUpload', 'Products Prdbulkimgupload', NULL, 5, 0, 0),
(127, 'admin.emailSetting.view', 'Emailsetting View', NULL, 38, 0, 0),
(128, 'admin.emailSetting.add', 'Emailsetting Add', NULL, 38, 0, 0),
(129, 'admin.emailSetting.edit', 'Emailsetting Edit', NULL, 38, 0, 0),
(130, 'admin.emailSetting.save', 'Emailsetting Save', NULL, 38, 0, 0),
(131, 'admin.emailSetting.delete', 'Emailsetting Delete', NULL, 38, 0, 0),
(132, 'admin.emailSetting.status', 'Emailsetting Status', NULL, 38, 0, 0),
(133, 'admin.templateSetting.view', 'Templatesetting View', NULL, 39, 0, 0),
(134, 'admin.templateSetting.add', 'Templatesetting Add', NULL, 39, 0, 0),
(135, 'admin.templateSetting.edit', 'Templatesetting Edit', NULL, 39, 0, 0),
(136, 'admin.templateSetting.save', 'Templatesetting Save', NULL, 39, 0, 0),
(137, 'admin.templateSetting.delete', 'Templatesetting Delete', NULL, 39, 0, 0),
(138, 'admin.templateSetting.status', 'Templatesetting Status', NULL, 39, 0, 0),
(139, 'admin.category.sampleCategoryDownload', 'Category Samplecategorydownload', NULL, 2, 0, 0),
(140, 'admin.category.sampleBulkDownload', 'Category Samplebulkdownload', NULL, 2, 0, 0),
(141, 'admin.category.categoryBulkUpload', 'Category Categorybulkupload', NULL, 2, 0, 0),
(142, 'admin.category.catBulkImgUpload', 'Category Catbulkimgupload', NULL, 2, 0, 0),
(143, 'admin.products.deleteVarient', 'Products Deletevarient', NULL, 5, 17, 0),
(144, 'admin.products.changeStatus', 'Products Changestatus', NULL, 5, 20, 0),
(145, 'admin.products.generateBarcode', 'Products Generatebarcode', NULL, 5, 0, 0),
(146, 'admin.products.printBarcode', 'Products Printbarcode', NULL, 5, 0, 0),
(147, 'admin.products.barcodeForm', 'Products Barcodeform', NULL, 5, 0, 0),
(148, 'admin.products.downloadbarcode', 'Products Downloadbarcode', NULL, 5, 0, 0),
(150, 'admin.products.showbarcodes', 'Products Showbarcodes', NULL, 5, 0, 0),
(151, 'admin.coupons.history', 'Coupons History', NULL, 6, 0, 0),
(152, 'admin.stock.view', 'Stock View', NULL, 7, 0, 0),
(153, 'admin.stock.outOfStock', 'Stock Outofstock', NULL, 7, 0, 0),
(154, 'admin.stock.runningShort', 'Stock Runningshort', NULL, 7, 0, 0),
(155, 'admin.stock.updateProdStock', 'Stock Updateprodstock', NULL, 7, 0, 0),
(156, 'admin.order.view', 'Order View', NULL, 9, 0, 0),
(157, 'admin.order.edit', 'Order Edit', NULL, 9, 0, 0),
(158, 'admin.order.status', 'Order Status', NULL, 42, 0, 0),
(159, 'admin.orders.ReturnOrder', 'Orders Returnorder', NULL, 13, 0, 0),
(160, 'admin.orders.ReturnOrderCal', 'Orders Returnordercal', NULL, 13, 0, 0),
(161, 'admin.orders.OrderReturn', 'Orders Orderreturn', NULL, 13, 0, 0),
(162, 'admin.orders.editreturn', 'Orders Editreturn', NULL, 13, 294, 0),
(163, 'admin.orders.UpdateReturnOrderStatus', 'Orders Updatereturnorderstatus', NULL, 13, 0, 0),
(164, 'admin.orders.addFlag', 'Orders Addflag', NULL, 13, 0, 0),
(165, 'admin.orders.addMulFlag', 'Orders Addmulflag', NULL, 13, 0, 0),
(166, 'admin.orders.orderHistory', 'Orders Orderhistory', NULL, 13, 0, 0),
(167, 'admin.orders.editReOrder', 'Orders Editreorder', NULL, 13, 294, 0),
(168, 'admin.orders.getProdDetails', 'Orders Getproddetails', NULL, 13, 0, 0),
(169, 'admin.orders.quantityUpdate', 'Orders Quantityupdate', NULL, 13, 292, 0),
(170, 'admin.orders.saveReOrder', 'Orders Savereorder', NULL, 13, 293, 0),
(171, 'admin.orders.addToCart', 'Orders Addtocart', NULL, 13, 0, 0),
(172, 'admin.sales.bycustomer', 'Sales Bycustomer', NULL, 14, 0, 0),
(173, 'admin.sales.orderByCustomer', 'Sales Orderbycustomer', NULL, 14, 0, 0),
(174, 'admin.sales.orderByCustomerExport', 'Sales Orderbycustomerexport', NULL, 14, 0, 0),
(175, 'admin.country.view', 'Country View', NULL, 18, 0, 0),
(176, 'admin.country.edit', 'Country Edit', NULL, 18, 0, 0),
(177, 'admin.country.save', 'Country Save', NULL, 18, 0, 0),
(178, 'admin.country.delete', 'Country Delete', NULL, 18, 0, 0),
(179, 'admin.currency.view', 'Currency View', NULL, 19, 0, 0),
(180, 'admin.currency.editCurrencyListing', 'Currency Editcurrencylisting', NULL, 19, 0, 0),
(181, 'admin.currency.save', 'Currency Save', NULL, 19, 0, 0),
(182, 'admin.currency.currencyStatus', 'Currency Currencystatus', NULL, 19, 0, 0),
(183, 'admin.customers.view', 'Customers View', NULL, 21, 0, 0),
(184, 'admin.customers.add', 'Customers Add', NULL, 21, 0, 0),
(185, 'admin.customers.save', 'Customers Save', NULL, 21, 0, 0),
(186, 'admin.customers.edit', 'Customers Edit', NULL, 21, 0, 0),
(188, 'admin.customers.update', 'Customers Update', NULL, 21, 0, 0),
(189, 'admin.customers.delete', 'Customers Delete', NULL, 21, 0, 0),
(190, 'admin.customers.export', 'Customers Export', NULL, 21, 0, 0),
(191, 'admin.customers.chkExistingUseremail', 'Customers Chkexistinguseremail', NULL, 21, 0, 0),
(192, 'admin.sliders.view', 'Sliders View', NULL, 32, 0, 0),
(193, 'admin.slider.add', 'Slider Add', NULL, 32, 0, 0),
(194, 'admin.slider.edit', 'Slider Edit', NULL, 32, 0, 0),
(195, 'admin.slider.save', 'Slider Save', NULL, 32, 0, 0),
(196, 'admin.slider.update', 'Slider Update', NULL, 32, 0, 0),
(197, 'admin.slider.delete', 'Slider Delete', NULL, 32, 0, 0),
(198, 'admin.slider.masterList', 'Slider Masterlist', NULL, 32, 808, 0),
(199, 'admin.slider.addSlider', 'Slider Addslider', NULL, 32, 809, 0),
(200, 'admin.slider.editSlider', 'Slider Editslider', NULL, 32, 810, 0),
(201, 'admin.slider.sliderDelete', 'Slider Sliderdelete', NULL, 32, 813, 0),
(202, 'admin.slider.saveEditSlider', 'Slider Saveeditslider', NULL, 32, 811, 0),
(203, 'admin.slider.updateMasterList', 'Slider Updatemasterlist', NULL, 32, 812, 0),
(204, 'admin.storeSetting.view', 'Storesetting View', NULL, 34, 0, 0),
(205, 'admin.storeSetting.add', 'Storesetting Add', NULL, 34, 0, 0),
(206, 'admin.returnPolicy.view', 'Returnpolicy View', NULL, 35, 0, 0),
(207, 'admin.returnPolicy.edit', 'Returnpolicy Edit', NULL, 35, 0, 0),
(208, 'admin.returnPolicy.save', 'Returnpolicy Save', NULL, 35, 0, 0),
(209, 'admin.miscellaneous.flags', 'Miscellaneous Flags', NULL, 41, 0, 0),
(210, 'admin.miscellaneous.addNewFlag', 'Miscellaneous Addnewflag', NULL, 41, 0, 0),
(211, 'admin.miscellaneous.editFlag', 'Miscellaneous Editflag', NULL, 41, 0, 0),
(212, 'admin.miscellaneous.saveFlag', 'Miscellaneous Saveflag', NULL, 41, 0, 0),
(213, 'admin.miscellaneous.updateFlag', 'Miscellaneous Updateflag', NULL, 41, 0, 0),
(214, 'admin.miscellaneous.deleteFlag', 'Miscellaneous Deleteflag', NULL, 41, 0, 0),
(215, 'admin.systemusers.export', 'Systemusers Export', NULL, 43, 0, 0),
(216, 'admin.staticpage.view', 'Staticpage View', NULL, 44, 0, 0),
(217, 'admin.staticpage.add', 'Staticpage Add', NULL, 44, 0, 0),
(218, 'admin.products.bulkUpdate', 'Products Bulkupdate', NULL, 5, 0, 0),
(219, 'admin.products.export', 'Products Export', NULL, 5, 0, 0),
(220, 'admin.tax.view', 'Tax View', NULL, 8, 0, 0),
(221, 'admin.tax.add', 'Tax Add', NULL, 8, 0, 0),
(222, 'admin.tax.save', 'Tax Save', NULL, 8, 0, 0),
(223, 'admin.tax.edit', 'Tax Edit', NULL, 8, 0, 0),
(224, 'admin.tax.delete', 'Tax Delete', NULL, 8, 0, 0),
(225, 'admin.tax.changeStatus', 'Tax Changestatus', NULL, 8, 0, 0),
(226, 'admin.apicat.view', 'Apicat View', NULL, 16, 0, 0),
(227, 'admin.apicat.add', 'Apicat Add', NULL, 16, 0, 0),
(228, 'admin.apicat.save', 'Apicat Save', NULL, 16, 0, 0),
(229, 'admin.apicat.edit', 'Apicat Edit', NULL, 16, 0, 0),
(230, 'admin.apicat.delete', 'Apicat Delete', NULL, 16, 0, 0),
(231, 'admin.apicat.changeStatus', 'Apicat Changestatus', NULL, 16, 0, 0),
(232, 'admin.apicat.catSeo', 'Apicat Catseo', NULL, 16, 0, 0),
(233, 'admin.apicat.saveCatSeo', 'Apicat Savecatseo', NULL, 16, 2014, 0),
(234, 'admin.apiprod.view', 'Apiprod View', NULL, 17, 0, 0),
(235, 'admin.apiprod.add', 'Apiprod Add', NULL, 17, 0, 0),
(236, 'admin.apiprod.save', 'Apiprod Save', NULL, 17, 0, 0),
(237, 'admin.apiprod.edit', 'Apiprod Edit', NULL, 17, 0, 0),
(238, 'admin.apiprod.delete', 'Apiprod Delete', NULL, 17, 0, 0),
(239, 'admin.apiprod.changeStatus', 'Apiprod Changestatus', NULL, 17, 0, 0),
(240, 'admin.testimonial.view', 'Testimonial View', NULL, 23, 0, 0),
(241, 'admin.testimonial.edit', 'Testimonial Edit', NULL, 23, 0, 0),
(242, 'admin.testimonial.changeStatus', 'Testimonial Changestatus', NULL, 23, 0, 0),
(243, 'admin.dynamicLayout.view', 'Dynamiclayout View', NULL, 24, 0, 0),
(244, 'admin.dynamicLayout.add', 'Dynamiclayout Add', NULL, 24, 0, 0),
(245, 'admin.dynamicLayout.edit', 'Dynamiclayout Edit', NULL, 24, 0, 0),
(246, 'admin.dynamicLayout.save', 'Dynamiclayout Save', NULL, 24, 0, 0),
(247, 'admin.dynamicLayout.delete', 'Dynamiclayout Delete', NULL, 24, 0, 0),
(248, 'admin.dynamicLayout.changeStatus', 'Dynamiclayout Changestatus', NULL, 24, 0, 0),
(249, 'admin.sizechart.view', 'Sizechart View', NULL, 25, 0, 0),
(250, 'admin.sizechart.add', 'Sizechart Add', NULL, 25, 0, 0),
(251, 'admin.sizechart.save', 'Sizechart Save', NULL, 25, 0, 0),
(252, 'admin.sizechart.edit', 'Sizechart Edit', NULL, 25, 0, 0),
(253, 'admin.sizechart.delete', 'Sizechart Delete', NULL, 25, 0, 0),
(254, 'admin.attribute.set.checkattrset', 'Attribute Set Checkattrset', NULL, 3, 0, 0),
(255, 'admin.attribute.set.changeStatus', 'Attribute Set Changestatus', NULL, 3, 0, 0),
(256, 'admin.attributes.checkattr', 'Attributes Checkattr', NULL, 4, 0, 0),
(257, 'admin.attributes.changeStatus', 'Attributes Changestatus', NULL, 4, 0, 0),
(258, 'admin.coupons.checkcoupon', 'Coupons Checkcoupon', NULL, 6, 0, 0),
(259, 'admin.coupons.changeStatus', 'Coupons Changestatus', NULL, 6, 0, 0),
(260, 'admin.stock.runningShortCount', 'Stock Runningshortcount', NULL, 7, 0, 0),
(261, 'admin.loyalty.changeStatus', 'Loyalty Changestatus', NULL, 22, 0, 0),
(262, 'admin.testimonial.delete', 'Testimonial Delete', NULL, 23, 0, 0),
(263, 'admin.slider.changestatus', 'Slider Changestatus', NULL, 32, 0, 0),
(264, 'admin.stockSetting.view', 'Stocksetting View', NULL, 40, 0, 0),
(265, 'admin.stockSetting.save', 'Stocksetting Save', NULL, 40, 0, 0),
(266, 'admin.category.checkcat', 'Category Checkcat', NULL, 2, 0, 0),
(267, 'admin.tax.checktax', 'Tax Checktax', NULL, 8, 0, 0),
(268, 'admin.systemusers.changeStatus', 'Systemusers Changestatus', NULL, 43, 50, 0),
(269, 'admin.pincodes.view', 'Pincodes View', NULL, 26, 0, 0),
(270, 'admin.pincodes.upload', 'Pincodes Upload', NULL, 26, 0, 0),
(271, 'admin.pincodes.samplecsv', 'Pincodes Samplecsv', NULL, 26, 0, 0),
(272, 'admin.category.changeStatus', 'Category Changestatus', NULL, 2, 0, 0),
(273, 'admin.customers.changeStatus', 'Customers Changestatus', NULL, 21, 798, 0),
(274, 'admin.staticpages.view', 'Staticpages View', NULL, 44, 0, 0),
(275, 'admin.staticpages.add', 'Staticpages Add', NULL, 44, 0, 0),
(276, 'admin.staticpages.save', 'Staticpages Save', NULL, 44, 0, 0),
(278, 'admin.staticpages.update', 'Staticpages Update', NULL, 44, 0, 0),
(279, 'admin.staticpages.edit', 'Staticpages Edit', NULL, 44, 0, 0),
(280, 'admin.staticpages.delete', 'Staticpages Delete', NULL, 44, 0, 0),
(281, 'admin.staticpages.changeStatus', 'Staticpages Changestatus', NULL, 44, 7402, 0),
(282, 'admin.staticpages.getdesc', 'Staticpages Getdesc', NULL, 44, 0, 0),
(283, 'admin.contact.view', 'Contact View', NULL, 45, 0, 0),
(284, 'admin.contact.add', 'Contact Add', NULL, 45, 0, 0),
(285, 'admin.contact.save', 'Contact Save', NULL, 45, 0, 0),
(286, 'admin.contact.update', 'Contact Update', NULL, 45, 0, 0),
(287, 'admin.contact.edit', 'Contact Edit', NULL, 45, 0, 0),
(288, 'admin.contact.delete', 'Contact Delete', NULL, 45, 0, 0),
(289, 'admin.contact.changeStatus', 'Contact Changestatus', NULL, 45, 7410, 0),
(290, 'admin.socialmedialink.view', 'Socialmedialink View', NULL, 46, 0, 0),
(291, 'admin.socialmedialink.add', 'Socialmedialink Add', NULL, 46, 0, 0),
(292, 'admin.socialmedialink.save', 'Socialmedialink Save', NULL, 46, 0, 0),
(293, 'admin.socialmedialink.update', 'Socialmedialink Update', NULL, 46, 0, 0),
(294, 'admin.socialmedialink.edit', 'Socialmedialink Edit', NULL, 46, 0, 0),
(295, 'admin.socialmedialink.delete', 'Socialmedialink Delete', NULL, 46, 0, 0),
(296, 'admin.socialmedialink.changeStatus', 'Socialmedialink Changestatus', NULL, 46, 7417, 0),
(297, 'admin.testimonial.addEdit', 'Testimonial Addedit', NULL, 23, 0, 0),
(298, 'admin.testimonial.save', 'Testimonial Save', NULL, 23, 0, 0),
(299, 'admin.category.sizeChart', 'Category Sizechart', NULL, 2, 0, 0),
(300, 'admin.pincodes.addEdit', 'Pincodes Addedit', NULL, 26, 0, 0),
(301, 'admin.pincodes.save', 'Pincodes Save', NULL, 26, 0, 0),
(302, 'admin.pincodes.delete', 'Pincodes Delete', NULL, 26, 0, 0),
(303, 'admin.smsSubscription.view', 'Smssubscription View', NULL, 27, 0, 0),
(304, 'admin.smsSubscription.addEdit', 'Smssubscription Addedit', NULL, 27, 0, 0),
(305, 'admin.smsSubscription.save', 'Smssubscription Save', NULL, 27, 0, 0),
(306, 'admin.smsSubscription.delete', 'Smssubscription Delete', NULL, 27, 0, 0),
(307, 'admin.pincodes.codStatusChange', 'Pincodes Codstatuschange', NULL, 26, 0, 0),
(308, 'admin.pincodes.delivaryStatusChange', 'Pincodes Delivarystatuschange', NULL, 26, 0, 0),
(309, 'admin.state.view', 'State View', NULL, 30, 0, 0),
(310, 'admin.state.addEdit', 'State Addedit', NULL, 30, 0, 0),
(311, 'admin.state.save', 'State Save', NULL, 30, 0, 0),
(312, 'admin.state.delete', 'State Delete', NULL, 30, 0, 0),
(313, 'admin.cities.view', 'Cities View', NULL, 31, 0, 0),
(314, 'admin.cities.addEdit', 'Cities Addedit', NULL, 31, 0, 0),
(315, 'admin.cities.save', 'Cities Save', NULL, 31, 0, 0),
(316, 'admin.cities.delete', 'Cities Delete', NULL, 31, 0, 0),
(317, 'admin.cities.changeStatus', 'Cities Changestatus', NULL, 31, 0, 0),
(318, 'admin.cities.changeDelivaryStatus', 'Cities Changedelivarystatus', NULL, 31, 12219, 0),
(319, 'admin.cities.changeCodStatus', 'Cities Changecodstatus', NULL, 31, 12219, 0),
(320, 'admin.pincodes.changeStatus', 'Pincodes Changestatus', NULL, 26, 0, 0),
(321, 'admin.language.view', 'Language View', NULL, 28, 0, 0),
(322, 'admin.language.addEdit', 'Language Addedit', NULL, 28, 0, 0),
(323, 'admin.language.save', 'Language Save', NULL, 28, 0, 0),
(324, 'admin.language.delete', 'Language Delete', NULL, 28, 0, 0),
(325, 'admin.language.changeStatus', 'Language Changestatus', NULL, 28, 0, 0),
(326, 'admin.translation.view', 'Translation View', NULL, 29, 0, 0),
(327, 'admin.translation.addEdit', 'Translation Addedit', NULL, 29, 0, 0),
(328, 'admin.translation.save', 'Translation Save', NULL, 29, 0, 0),
(329, 'admin.translation.delete', 'Translation Delete', NULL, 29, 0, 0),
(330, 'admin.translation.changeStatus', 'Translation Changestatus', NULL, 29, 0, 0),
(331, 'admin.home.view', 'Home View', NULL, 52, 0, 0),
(332, 'admin.order_status.view', 'Order_status View', NULL, 42, 0, 0),
(333, 'admin.order_status.add', 'Order_status Add', NULL, 42, 0, 0),
(334, 'admin.order_status.edit', 'Order_status Edit', NULL, 42, 0, 0),
(335, 'admin.order_status.save', 'Order_status Save', NULL, 42, 0, 0),
(336, 'admin.order_status.update', 'Order_status Update', NULL, 42, 0, 0),
(337, 'admin.order_status.delete', 'Order_status Delete', NULL, 42, 0, 0),
(338, 'admin.order_status.changeStatus', 'Order_status Changestatus', NULL, 42, 13129, 0),
(339, 'admin.loyalty.checkName', 'Loyalty Checkname', NULL, 22, 0, 0),
(340, 'admin.loyalty.checkRange', 'Loyalty Checkrange', NULL, 22, 0, 0),
(341, 'admin.state.getState', 'State Getstate', NULL, 30, 0, 0),
(342, 'admin.bill.view', 'Bill View', NULL, 47, 0, 0),
(343, 'admin.bill.add', 'Bill Add', NULL, 47, 0, 0),
(344, 'admin.bill.save', 'Bill Save', NULL, 47, 0, 0),
(345, 'admin.bill.update', 'Bill Update', NULL, 47, 0, 0),
(346, 'admin.bill.edit', 'Bill Edit', NULL, 47, 0, 0),
(347, 'admin.bill.delete', 'Bill Delete', NULL, 47, 0, 0),
(348, 'admin.vendors.view', 'Vendors View', NULL, 48, 0, 0),
(349, 'admin.vendors.add', 'Vendors Add', NULL, 48, 0, 0),
(350, 'admin.vendors.save', 'Vendors Save', NULL, 48, 0, 0),
(351, 'admin.vendors.update', 'Vendors Update', NULL, 48, 0, 0),
(352, 'admin.vendors.edit', 'Vendors Edit', NULL, 48, 0, 0),
(353, 'admin.vendors.delete', 'Vendors Delete', NULL, 48, 0, 0),
(354, 'admin.raw-material.view', 'Raw-material View', NULL, 49, 0, 0),
(355, 'admin.raw-material.add', 'Raw-material Add', NULL, 49, 0, 0),
(356, 'admin.raw-material.save', 'Raw-material Save', NULL, 49, 0, 0),
(357, 'admin.raw-material.update', 'Raw-material Update', NULL, 49, 0, 0),
(358, 'admin.raw-material.edit', 'Raw-material Edit', NULL, 49, 0, 0),
(359, 'admin.raw-material.delete', 'Raw-material Delete', NULL, 49, 0, 0),
(360, 'admin.orders.createOrder', 'Orders Createorder', NULL, 13, 284, 0),
(361, 'admin.orders.getCustomerEmails', 'Orders Getcustomeremails', NULL, 13, 0, 0),
(362, 'admin.orders.getCustomerData', 'Orders Getcustomerdata', NULL, 13, 0, 0),
(363, 'admin.orders.getCustomerZone', 'Orders Getcustomerzone', NULL, 13, 0, 0),
(364, 'admin.orders.getCustomerAdd', 'Orders Getcustomeradd', NULL, 13, 0, 0),
(365, 'admin.orders.saveCustomerAdd', 'Orders Savecustomeradd', NULL, 13, 293, 0),
(366, 'admin.orders.getCatProds', 'Orders Getcatprods', NULL, 13, 0, 0),
(367, 'admin.orders.getSubProds', 'Orders Getsubprods', NULL, 13, 0, 0),
(368, 'admin.orders.saveCartData', 'Orders Savecartdata', NULL, 13, 293, 0),
(369, 'admin.orders.getProdPrice', 'Orders Getprodprice', NULL, 13, 0, 0),
(370, 'admin.products.upsell.product', 'Products Upsell Product', NULL, 5, 0, 0),
(371, 'admin.products.upsell.related.search', 'Products Upsell Related Search', NULL, 5, 0, 0),
(372, 'admin.orders.getSearchProds', 'Orders Getsearchprods', NULL, 13, 0, 0),
(373, 'admin.products.related.search', 'Products Related Search', NULL, 5, 0, 0),
(374, 'admin.products.checkattr', 'Products Checkattr', NULL, 5, 0, 0),
(375, 'admin.orders.checkOrderCoupon', 'Orders Checkordercoupon', NULL, 13, 0, 0),
(376, 'admin.orders.editOrderChkStock', 'Orders Editorderchkstock', NULL, 13, 0, 0),
(377, 'admin.orders.getCartEditProd', 'Orders Getcarteditprod', NULL, 13, 0, 0),
(378, 'admin.orders.getCartEditProdVar', 'Orders Getcarteditprodvar', NULL, 13, 0, 0),
(379, 'admin.orders.cartEditGetComboSelect', 'Orders Carteditgetcomboselect', NULL, 13, 0, 0),
(380, 'admin.set.preference', 'Set Preference', NULL, 54, 0, 0),
(381, 'admin.tables.view', 'Tables View', NULL, 10, 0, 0),
(382, 'admin.tables.addEdit', 'Tables Addedit', NULL, 10, 0, 0),
(383, 'admin.tables.save', 'Tables Save', NULL, 10, 0, 0),
(384, 'admin.tables.delete', 'Tables Delete', NULL, 10, 0, 0),
(385, 'admin.tables.changeStatus', 'Tables Changestatus', NULL, 10, 0, 0),
(386, 'admin.restaurantlayout.view', 'Restaurantlayout View', NULL, 11, 0, 0),
(387, 'admin.restaurantlayout.addEdit', 'Restaurantlayout Addedit', NULL, 11, 0, 0),
(388, 'admin.restaurantlayout.save', 'Restaurantlayout Save', NULL, 11, 0, 0),
(389, 'admin.tableorder.view', 'Tableorder View', NULL, 12, 0, 0),
(390, 'admin.tableorder.addEdit', 'Tableorder Addedit', NULL, 12, 0, 0),
(391, 'admin.tableorder.save', 'Tableorder Save', NULL, 12, 0, 0),
(392, 'admin.order.additems', 'Order Additems', NULL, 9, 0, 0),
(393, 'admin.order.saveitems', 'Order Saveitems', NULL, 9, 0, 0),
(394, 'admin.additional-charges.view', 'Additional-charges View', NULL, 50, 0, 0),
(395, 'admin.additional-charges.add', 'Additional-charges Add', NULL, 50, 0, 0),
(396, 'admin.additional-charges.save', 'Additional-charges Save', NULL, 50, 0, 0),
(397, 'admin.additional-charges.edit', 'Additional-charges Edit', NULL, 50, 0, 0),
(398, 'admin.additional-charges.delete', 'Additional-charges Delete', NULL, 50, 0, 0),
(399, 'admin.additional-charges.changeStatus', 'Additional-charges Changestatus', NULL, 50, 0, 0),
(400, 'admin.home.changePopupStatus', 'Home Changepopupstatus', NULL, 52, 0, 0),
(401, 'admin.order.transferKot', 'Order Transferkot', NULL, 12, 0, 0),
(402, 'admin.order.addNewOrder', 'Order Addneworder', NULL, 12, 20977, 0),
(403, 'admin.order.getJoinTableCheckbox', 'Order Getjointablecheckbox', NULL, 12, 0, 0),
(404, 'admin.order.saveJoinTableOrder', 'Order Savejointableorder', NULL, 12, 20976, 0),
(405, 'admin.order.getOrderKotProds', 'Order Getorderkotprods', NULL, 12, 0, 0),
(406, 'admin.order.deleteKotProds', 'Order Deletekotprods', NULL, 12, 0, 0),
(407, 'admin.generalSetting.changeStatus', 'Generalsetting Changestatus', NULL, 33, 0, 0),
(408, 'admin.tableOccupiedOrder', 'Tableoccupiedorder', NULL, 12, 0, 0),
(409, 'admin.additional-charges.getAditionalCharge', 'Additional-charges Getaditionalcharge', NULL, 50, 0, 0),
(410, 'admin.getCartAmt', 'Getcartamt', NULL, 12, 0, 0),
(411, 'admin.orders.applyCashback', 'Orders Applycashback', NULL, 13, 0, 0),
(412, 'admin.orders.applyVoucher', 'Orders Applyvoucher', NULL, 13, 0, 0),
(413, 'admin.orders.applyUserLevelDisc', 'Orders Applyuserleveldisc', NULL, 13, 0, 0),
(414, 'admin.orders.applyReferel', 'Orders Applyreferel', NULL, 13, 0, 0),
(415, 'admin.product.vendors', 'Product Vendors', NULL, 5, 0, 0),
(416, 'admin.product.vendors.search', 'Product Vendors Search', NULL, 5, 0, 0),
(417, 'admin.vendors.dashboard', 'Vendors Dashboard', NULL, 48, 0, 0),
(418, 'admin.vendors.orders', 'Vendors Orders', NULL, 48, 0, 0),
(419, 'admin.vendors.rejectOrders', 'Vendors Rejectorders', NULL, 48, 0, 0),
(420, 'admin.vendors.product', 'Vendors Product', NULL, 48, 0, 0),
(421, 'admin.vendors.productStatus', 'Vendors Productstatus', NULL, 48, 0, 0),
(422, 'admin.vendors.productBulkAction', 'Vendors Productbulkaction', NULL, 48, 0, 0),
(423, 'admin.vendors.saleByOrder', 'Vendors Salebyorder', NULL, 48, 0, 0),
(424, 'admin.vendors.saleByProduct', 'Vendors Salebyproduct', NULL, 48, 0, 0),
(425, 'admin.vendor.export.order', 'Vendor Export Order', NULL, 48, 0, 0),
(426, 'admin.vendor.order.status', 'Vendor Order Status', NULL, 48, 0, 0),
(427, 'admin.product.vendors.save', 'Product Vendors Save', NULL, 5, 18, 0),
(428, 'admin.product.vendors.delete', 'Product Vendors Delete', NULL, 5, 17, 0),
(429, 'admin.section.view', 'Section View', NULL, 51, 0, 0);
INSERT INTO `tblprfx_permissions` (`id`, `name`, `display_name`, `description`, `section_id`, `parent_id`, `status`) VALUES
(430, 'admin.section.add', 'Section Add', NULL, 51, 0, 0),
(431, 'admin.section.save', 'Section Save', NULL, 51, 0, 0),
(432, 'admin.section.update', 'Section Update', NULL, 51, 0, 0),
(433, 'admin.section.edit', 'Section Edit', NULL, 51, 0, 0),
(434, 'admin.section.delete', 'Section Delete', NULL, 51, 0, 0),
(435, 'admin.traits.orders', 'Traits Orders', NULL, 55, 0, 0),
(436, 'admin.vendors.ordersDetails', 'Vendors Ordersdetails', NULL, 0, 0, 0),
(437, 'admin.dynamic-layout.addEdit', 'Dynamic-layout Addedit', NULL, 24, 0, 0),
(438, 'admin.dynamic-layout.save', 'Dynamic-layout Save', NULL, 24, 0, 0),
(439, 'admin.dynamic-layout.edit', 'Dynamic-layout Edit', NULL, 24, 0, 0),
(440, 'admin.dynamic-layout.saveEdit', 'Dynamic-layout Saveedit', NULL, 24, 0, 0),
(441, 'admin.dynamic-layout.changeStatus', 'Dynamic-layout Changestatus', NULL, 24, 0, 0),
(442, 'admin.dynamic-layout.view', 'Dynamic-layout View', NULL, 24, 0, 0),
(443, 'adminLogin', 'Adminlogin', NULL, 0, 0, 0),
(444, 'unauthorized', 'Unauthorized', NULL, 0, 0, 0),
(445, 'check_admin_user', 'Check_admin_user', NULL, 0, 0, 0),
(446, 'adminLogout', 'Adminlogout', NULL, 0, 0, 0),
(447, 'adminEditProfile', 'Admineditprofile', NULL, 0, 0, 0),
(448, 'adminSaveProfile', 'Adminsaveprofile', NULL, 0, 0, 0),
(449, 'chk_existing_username', 'Chk_existing_username', NULL, 0, 0, 0),
(450, 'admin.courier.view', 'Courier View', NULL, 56, 0, 0),
(451, 'admin.courier.add', 'Courier Add', NULL, 56, 0, 0),
(452, 'admin.courier.save', 'Courier Save', NULL, 56, 0, 0),
(453, 'admin.courier.update', 'Courier Update', NULL, 56, 0, 0),
(454, 'admin.courier.edit', 'Courier Edit', NULL, 56, 0, 0),
(455, 'admin.courier.delete', 'Courier Delete', NULL, 56, 0, 0),
(456, 'admin.pincodes.sampleBulkDownload', 'Pincodes Samplebulkdownload', NULL, 26, 0, 0),
(457, 'admin.raw-material.checkStatus', 'Raw-material Checkstatus', NULL, 0, 49, 0),
(458, 'admin.pages.view', 'Pages View', NULL, 0, 0, 0),
(459, 'admin.paymentSetting.changeStatus', 'Paymentsetting Changestatus', NULL, 36, 0, 0),
(460, 'admin.country.countryStatus', 'Country Countrystatus', NULL, 18, 0, 0),
(461, 'admin.courier.changeStatus', 'Courier Changestatus', NULL, 56, 0, 0),
(462, 'admin.tables.checkCoupon', 'Tables Checkcoupon', NULL, 10, 0, 0),
(463, 'admin.tables.getAdditionalcharge', 'Tables Getadditionalcharge', NULL, 10, 0, 0),
(464, 'admin.returnPolicy.changeStatus', 'Returnpolicy Changestatus', NULL, 35, 0, 0),
(465, 'admin.tables.reqloyalty', 'Tables Reqloyalty', NULL, 10, 0, 0),
(466, 'admin.tables.revloyalty', 'Tables Revloyalty', NULL, 10, 0, 0),
(467, 'admin.tables.tableCod', 'Tables Tablecod', NULL, 10, 0, 0),
(468, 'admin.order.getbill', 'Order Getbill', NULL, 57, 0, 0),
(469, 'admin.orders.cancelOrder', 'Orders Cancelorder', NULL, 13, 0, 0),
(470, 'admin.orders.cancelOrderEdit', 'Orders Cancelorderedit', NULL, 13, 0, 0),
(471, 'admin.orders.cancelOrderUpdate', 'Orders Cancelorderupdate', NULL, 13, 0, 0),
(472, 'admin.email.status', 'Email Status', NULL, 57, 0, 0),
(473, 'adminForgotPassword', 'Adminforgotpassword', NULL, 57, 0, 0),
(474, 'adminChkForgotPasswordEmail', 'Adminchkforgotpasswordemail', NULL, 57, 0, 0),
(475, 'adminResetPassword', 'Adminresetpassword', NULL, 57, 0, 0),
(476, 'adminSaveResetPwd', 'Adminsaveresetpwd', NULL, 57, 0, 0),
(477, 'admin.home.newsletter', 'Home Newsletter', NULL, 57, 0, 0),
(478, 'admin.contact.getState', 'Contact Getstate', NULL, 57, 0, 0),
(479, 'adminCheckCurPassowrd', 'Admincheckcurpassowrd', NULL, 57, 0, 0),
(480, 'admin.domains.view', 'Domains View', NULL, 57, 0, 0),
(481, 'admin.marketing.emails', 'Marketing Emails', NULL, 57, 0, 0),
(482, 'admin.marketing.addGroup', 'Marketing Addgroup', NULL, 57, 0, 0),
(483, 'admin.marketing.editGroup', 'Marketing Editgroup', NULL, 57, 0, 0),
(484, 'admin.marketing.saveGroup', 'Marketing Savegroup', NULL, 57, 0, 0),
(485, 'admin.marketing.changeStatus', 'Marketing Changestatus', NULL, 57, 0, 0),
(486, 'admin.marketing.groups', 'Marketing Groups', NULL, 57, 0, 0),
(487, 'admin.marketing.emailTemplates', 'Marketing Emailtemplates', NULL, 57, 0, 0),
(488, 'admin.marketing.changeTempStatus', 'Marketing Changetempstatus', NULL, 57, 0, 0),
(489, 'admin.marketing.addEmailTemp', 'Marketing Addemailtemp', NULL, 57, 0, 0),
(490, 'admin.marketing.editEmailTemp', 'Marketing Editemailtemp', NULL, 57, 0, 0),
(491, 'admin.marketing.saveEmailTemp', 'Marketing Saveemailtemp', NULL, 57, 0, 0),
(492, 'admin.domains.success', 'Domains Success', NULL, 57, 0, 0),
(493, 'check_fb_admin_user', 'Check_fb_admin_user', NULL, 57, 0, 0),
(494, 'admin.home.exportNewsLetter', 'Home Exportnewsletter', NULL, 57, 0, 0),
(495, 'admin.product.wishlist', 'Product Wishlist', NULL, 57, 0, 0),
(496, 'admin.referralProgram.view', 'Referralprogram View', NULL, 57, 0, 0),
(497, 'admin.referralProgram.editReferral', 'Referralprogram Editreferral', NULL, 57, 0, 0),
(498, 'admin.referralProgram.saveReferral', 'Referralprogram Savereferral', NULL, 57, 0, 0),
(499, 'admin.bankDetails.view', 'Bankdetails View', NULL, 57, 0, 0),
(500, 'admin.bankDetails.addEdit', 'Bankdetails Addedit', NULL, 57, 0, 0),
(501, 'admin.bankDetails.update', 'Bankdetails Update', NULL, 57, 0, 0),
(502, 'admin.product.mall.category', 'Product Mall Category', NULL, 57, 0, 0),
(503, 'admin.product.mall.product.Add', 'Product Mall Product Add', NULL, 57, 0, 0 ),
(504, 'admin.product.mall.product.update', 'Product Mall Product Update', NULL, 57, 0, 0),
(505, 'admin.orders.getECourier', 'Orders Getecourier', NULL, 57, 0, 0),
(506, 'admin.orders.mallOrderSave', 'Orders Mallordersave', NULL,57, 0, 0),
(507, 'admin.generalSetting.assignCourier', 'Generalsetting Assigncourier', NULL,57,0,0),
(508, 'admin.generalSetting.storeVersion', 'Generalsetting Storeversion', NULL, 57, 0,0),
(509, 'admin.orders.waybill', 'Orders Waybill', NULL, 57, 0, 0);
-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_permission_role`
--

CREATE TABLE IF NOT EXISTS `tblprfx_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_pincodes`
--
DROP TABLE IF EXISTS `tblprfx_pincodes`;
CREATE TABLE IF NOT EXISTS `tblprfx_pincodes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pincode` text NOT NULL,
  `cod_status` int(11) DEFAULT '0',
  `service_provider` int(11) DEFAULT '0',
  `pref` int(4) DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pincodes`
--

INSERT INTO `tblprfx_pincodes` (`id`, `pincode`, `cod_status`, `service_provider`, `pref`, `status`) VALUES
(1, '400022', 0, 1, 1, 1),
(2, '400021', 1, 1, 1, 1),
(3, '400023', 0, 1, 1, 1),
(4, '400024', 0, 1, 1, 1),
(5, '400025', 0, 2, 2, 1),
(6, '400026', 1, 2, 2, 1),
(7, '400027', 1, 2, 2, 1),
(8, '789456', 0, 3, 3, 1),
(9, '789654', 0, 3, 3, 1),
(10, '789456', 0, 3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_products`
--

CREATE TABLE IF NOT EXISTS `tblprfx_products` (
  `id` bigint(20) unsigned NOT NULL,
  `product` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` text COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `add_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `is_featured` tinyint(4) NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `prod_type` bigint(20) NOT NULL,
  `is_stock` int(11) NOT NULL COMMENT '0=>without stock 1=> with stock',
  `attr_set` bigint(20) NOT NULL,
  `url_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_avail` tinyint(1) NOT NULL DEFAULT '0',
  `is_listing` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `stock` float NOT NULL,
  `cur` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `max_price` float NOT NULL,
  `min_price` float NOT NULL,
  `purchase_price` decimal(8,2) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `unit_measure` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `consumption_uom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `conversion` decimal(10,2) NOT NULL,
  `height` float NOT NULL,
  `width` float NOT NULL,
  `length` float NOT NULL,
  `weight` float NOT NULL,
  `spl_price` decimal(8,2) NOT NULL,
  `selling_price` decimal(8,2) NOT NULL,
  `is_crowd_funded` tinyint(1) NOT NULL,
  `target_date` datetime NOT NULL,
  `target_qty` bigint(20) NOT NULL,
  `parent_prod_id` bigint(20) NOT NULL,
  `meta_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keys` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `art_cut` float NOT NULL,
  `is_cod` tinyint(1) NOT NULL DEFAULT '1',
  `added_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `is_individual` tinyint(1) NOT NULL,
  `sort_order` bigint(20) NOT NULL,
  `meta_robot` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `og_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `og_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `og_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_meta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_referal_discount` int(11) NOT NULL,
  `is_shipped_international` int(11) NOT NULL,
  `eCount` int(11) NOT NULL,
  `eNoOfDaysAllowed` int(11) NOT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_tax` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => ''no tax'',1 => ''inclusive tax'', 2 => ''exclusive tax''',
  `is_del` tinyint(4) NOT NULL DEFAULT '0',
   `is_trending` int(11) NOT NULL DEFAULT '0',
  `min_order_quantity` int(11) DEFAULT '1',
  `is_share_on_mall` tinyint(4) NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
INSERT INTO `tblprfx_products` (`id`, `product`, `product_code`, `alias`, `short_desc`, `long_desc`, `add_desc`, `is_featured`, `images`, `prod_type`, `is_stock`, `attr_set`, `url_key`, `is_avail`, `is_listing`, `status`, `stock`, `cur`, `max_price`, `min_price`, `purchase_price`, `price`, `unit_measure`, `consumption_uom`, `conversion`, `height`, `width`, `length`, `weight`, `spl_price`, `selling_price`, `is_crowd_funded`, `target_date`, `target_qty`, `parent_prod_id`, `meta_title`, `meta_keys`, `meta_desc`, `art_cut`, `is_cod`, `added_by`, `updated_by`, `is_individual`, `sort_order`, `meta_robot`, `canonical`, `og_title`, `og_desc`, `og_image`, `twitter_url`, `twitter_title`, `twitter_desc`, `twitter_image`, `og_url`, `other_meta`, `is_referal_discount`, `is_shipped_international`, `eCount`, `eNoOfDaysAllowed`, `barcode`, `is_tax`, `is_del`, `min_order_quantity`, `is_trending`) VALUES
(1, 'Men Green Printed Custom Fit Polo Collar T-shirt', '', '', '', '', '', 0, '/tmp/phpFCjDcZ', 1, 1, 1, 'men-green-printed-custom-fit-polo-collar-t-shirt', 1, 0, 1, 100, '', 0, 0, '0.00', '200173.54', '', '', '0.00', 0, 0, 0, 0, '120077.43', '120077.43', 0, '0000-00-00 00:00:00', 0, 0, '', '', '', 0, 1, 1, 1, 1, 0, '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, 0, '', 0, 0, 1, 1);


--
-- Table structure for table `tblprfx_product_has_taxes`
--

CREATE TABLE IF NOT EXISTS `tblprfx_product_has_taxes` (
  `id` int(10) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_product_types`
--

CREATE TABLE IF NOT EXISTS `tblprfx_product_types` (
  `id` bigint(20) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_product_types`
--

INSERT INTO `tblprfx_product_types` (`id`, `type`, `desc`, `status`) VALUES
(1, 'Simple', '', 1),
(2, 'Combo', '', 0),
(3, 'Configurable', '', 1),
(4, 'Configurable Without Stock', '', 0),
(5, 'Downloadable Product', 'Downloadable Product', 0),
(6, 'Raw Material/Non Saleable', '', 0),
(7, 'Simple Without Stock', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_prod_status`
--

CREATE TABLE IF NOT EXISTS `tblprfx_prod_status` (
  `id` bigint(20) NOT NULL,
  `prod_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_restaurant_tables`
--

CREATE TABLE IF NOT EXISTS `tblprfx_restaurant_tables` (
  `id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `table_label` varchar(50) NOT NULL,
  `table_type` int(11) NOT NULL COMMENT '1 - square | 2 - rectangle | 3 - circle',
  `chairs` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ostatus` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_return_order`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_return_order` (
--   `id` int(11) NOT NULL,
--   `order_id` int(11) NOT NULL,
-- `sub_prod` int(11) NOT NULL,
--   `product_id` int(11) NOT NULL,
--   `quantity` int(11) NOT NULL,
--   `return_amount` float(10,2) NOT NULL,
--   `reason_id` int(11) NOT NULL,
--   `opened_id` int(11) NOT NULL,
--   `remark` text NOT NULL,
--   `return_action` int(11) NOT NULL,
--   `return_status` int(11) NOT NULL,
--   `order_status` int(11) DEFAULT NULL,
-- `exchange_product_id` int(11) DEFAULT NULL,
-- `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_roles`
--

CREATE TABLE IF NOT EXISTS `tblprfx_roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_roles`
--


INSERT INTO `tblprfx_roles` (`id`, `name`, `display_name`, `description`) VALUES
(1, 'admin', 'Admin', 'This is the admin who has access to complete system.'),
(2, 'operator-manager', 'Operator/Manager', 'This is operator/manager role. You can change the viewing rights by editing it.'),
(3, 'sales-marketing', 'Sales/Marketing', 'This is sales/marketing user who has access to only Orders and Products. You can change the viewing rights by editing it.');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_role_user`
--

CREATE TABLE IF NOT EXISTS `tblprfx_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_saved_list`
--

CREATE TABLE IF NOT EXISTS `tblprfx_saved_list` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_sections`
--

CREATE TABLE IF NOT EXISTS `tblprfx_sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_sections`
--

INSERT INTO `tblprfx_sections` (`id`, `name`, `status`) VALUES
(1, 'Dashboard', 1),
(2, 'Category', 1),
(3, 'Attribute Set', 1),
(4, 'Attribute', 1),
(5, 'Product', 1),
(6, 'Coupon', 1),
(7, 'Stock', 1),
(8, 'Tax', 1),
(9, 'Order', 1),
(10, 'Tables', 1),
(11, 'Restaurant Layout', 1),
(12, 'Table Orders', 1),
(13, 'Orders', 1),
(14, 'Sales', 1),
(15, 'Offers', 1),
(16, 'API Category', 1),
(17, 'API Product', 1),
(18, 'Country', 1),
(19, 'Currency', 1),
(20, 'Roles', 1),
(21, 'Customer', 1),
(22, 'Loyalty', 1),
(23, 'Testimonial', 1),
(24, 'Dynamic Layout', 1),
(25, 'Sizechart', 1),
(26, 'pincode', 1),
(27, 'SMS Subscription', 1),
(28, 'Language', 1),
(29, 'Translation', 0),
(30, 'State', 1),
(31, 'Cities', 1),
(32, 'Slider', 1),
(33, 'General Settings', 1),
(34, 'Store Settings', 1),
(35, 'Retun Policy', 1),
(36, 'Payment Setting', 1),
(37, 'Advance Setting', 1),
(38, 'Email Setting', 1),
(39, 'Template Setting', 1),
(40, 'Stock Setting', 1),
(41, 'Flags', 1),
(42, 'Order Status', 1),
(43, 'System Users', 1),
(44, 'Static Pages', 1),
(45, 'contact', 1),
(46, 'social Media Link', 1),
(47, 'Bill', 1),
(48, 'vendor', 1),
(49, 'Raw Material', 1),
(50, 'Additional Charges', 1),
(51, 'Section', 1),
(52, 'Home', 1),
(54, 'Set Preference', 1),
(55, 'Traits', 1),
(56, 'Courier Service', 1),
(57, 'Others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_settings`
--

CREATE TABLE IF NOT EXISTS `tblprfx_settings` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `value` varchar(255) NOT NULL,
  `url_key` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_settings`
--

INSERT INTO `tblprfx_settings` (`id`, `name`, `value`, `url_key`) VALUES
(3, 'ACL', 'No', 'acl');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_sizechart`
--

CREATE TABLE IF NOT EXISTS `tblprfx_sizechart` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_slider`
--

CREATE TABLE IF NOT EXISTS `tblprfx_slider` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` int(20) NOT NULL,
  `link` text NOT NULL,
  `sort_order` int(20) NOT NULL,
  `alt` text NOT NULL,
  `slider_id` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_slider_master`
--

CREATE TABLE IF NOT EXISTS `tblprfx_slider_master` (
  `id` int(11) NOT NULL,
  `slider` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=active,1=deactive',
  `delete_master` enum('0','1') NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_slider_master`
--

INSERT INTO `tblprfx_slider_master` (`id`, `slider`, `is_active`, `delete_master`) VALUES
(1, 'main', '1', '0'),
(2, 'SiderBar', '0', '1'),
(3, 'SiderBar', '0', '1'),
(4, 'Footer Slider', '0', '0'),
(5, 'Sidebar', '0', '0'),
(6, 'cvcvcvc', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_sms_subscription`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_order_cancelled` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `uid` int(11) DEFAULT NULL,
--   `order_id` int(11) NOT NULL,
--   `return_amount` float NOT NULL,
--   `reason_id` int(11) NOT NULL,
--   `remark` text NOT NULL,
--   `status` int(11) DEFAULT NULL COMMENT '0:No,1: Yes',
--  `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL,
--   PRIMARY KEY (`id`),
--   KEY `order_id` (`order_id`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE `tblprfx_question_category` (
  `id` int(11) NOT NULL,
  `category` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
  `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tblprfx_question_category` (`id`, `category`, `status`, `sort_order`) VALUES
(1, 'Marketing', 1, 0),
(2, 'Management', 1, 0),
(3, 'Payment', 1, 0),
(4, 'Inventory', 1, 0),
(5, 'Product', 1, 0),
(6, 'Miscellaneous', 1, 0);
ALTER TABLE `tblprfx_question_category`
  ADD PRIMARY KEY (`id`);



CREATE TABLE IF NOT EXISTS `tblprfx_sms_subscription` (
  `id` bigint(20) NOT NULL,
  `no_of_sms` text NOT NULL,
  `purchased_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_social_media_links`
--

CREATE TABLE IF NOT EXISTS `tblprfx_social_media_links` (
  `id` int(10) unsigned NOT NULL,
  `media` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
`sort_order` int(11) NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_social_media_links`
--



INSERT INTO `tblprfx_social_media_links` (`id`, `media`, `link`, `image`, `status`, `sort_order`) VALUES
(1, 'facebook', 'https://www.facebook.com/', '16082017120616.png', 1, 0),
(3, 'instagram', 'https://www.instagram.com/', '15022018095403.jpg', 1, 0),
(5, 'twitter', 'https://twitter.com/', '23022018093140.png', 1, 0),
(6, 'google', 'https://plus.google.com/', '26022018091609.jpg', 1, 0),
(9, 'linkedin', 'https://www.linkedin.com/', '08032018065004.png', 1, 0),
(12, 'youtube', 'https://www.youtube.com/', '21062018121043.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_states`
--

CREATE TABLE IF NOT EXISTS `tblprfx_states` (
  `id` bigint(20) NOT NULL,
  `country_id` tinyint(4) DEFAULT NULL,
  `state_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_states`
--

INSERT INTO `tblprfx_states` (`id`, `country_id`, `state_name`) VALUES
(1, 99, 'Maharashatra'),
(2, 99, 'Gujrat');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_static_pages`
--

CREATE TABLE IF NOT EXISTS `tblprfx_static_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `description` longtext COLLATE utf8_unicode_ci,
  `map_url` text COLLATE utf8_unicode_ci,
  `email_list` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `is_menu` tinyint(4) NOT NULL DEFAULT '0',
 `contact_details` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblprfx_static_pages`
--





INSERT INTO `tblprfx_static_pages` (`id`, `page_name`, `url_key`, `image`, `description`, `map_url`, `email_list`, `link`, `status`, `is_menu`, `contact_details`, `sort_order`) VALUES
(1, 'About Us', 'about-us', '23062018113857.jpg', 'Your Store Name&nbsp;about page is an opportunity to tell a story that will help you to stick in your customer&rsquo;s minds. You can describe your History, Vision &amp; Mission, and Your Global Presence etc. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. &nbsp; Lorem ipsum dolor sit amet&nbsp; Duis aute irure dolor in reprehenderit Quis autem vel eum voluptate &nbsp; Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.\r\n', '', '', '', 1, 1, 'null', 1),
(2, 'Terms and Condition', 'terms-conditions', '', 'For the purpose of these Terms &amp; Conditions, wherever the context so requires &quot;You&quot; or &quot;User&quot; shall mean any natural or legal person who has agreed to become a buyer on the Website by providing Registration Data while registering on the Website as Registered User using the computer systems. &ldquo;Website URL&rdquo; allows the User to surf the Website or making purchases without registering on the Website. The term &quot;We&quot;, &quot;Us&quot;, &quot;Our&quot; shall mean &ldquo;Store Name&rdquo;.\r\n\r\nWhen You use any of the services provided by Us through the Website, including but not limited to, (e.g. Product Images, Testimonials), You will be subject to the rules, guidelines, policies, terms, and conditions applicable to such service, and they shall be deemed to be incorporated into this Terms &amp; Conditions and shall be considered as part and parcel of this Terms &amp; Conditions.&nbsp;\r\n\r\nWe reserve the right, at our sole discretion, to change, modify, add or remove portions of these Terms &amp; Conditions , at any time without any prior written notice to you. It is your responsibility to review these Terms &amp; Conditions periodically for updates / changes. Your continued use of the Website following the posting of changes will mean that you accept and agree to the revisions. As long as you comply with these Terms &amp; Conditions, We grant you a personal, non-exclusive, non-transferable, limited privilege to enter and use the Website.\r\n\r\nACCESSING, BROWSING OR OTHERWISE USING THE SITE INDICATES YOUR AGREEMENT TO ALL THE TERMS AND CONDITIONS UNDER THESE TERMS AND CONDITIONS, SO PLEASE READ THE TERMS AND CONDITIONS CAREFULLY BEFORE PROCEEDING.\r\n', '', '', '', 1, 0, 'null', 3),
(3, 'Privacy Policy', 'privacy-policy', NULL, '&nbsp;\r\n\r\nThis privacy notice discloses the privacy practices for (website address). This privacy notice applies solely to information collected by this website. It will notify you of the following:\r\n\r\n\r\n\r\n	What personally identifiable information is collected from you through the website, how it is used and with whom it may be shared.\r\n	What choices are available to you regarding the use of your data\r\n	The security procedures in place to protect the misuse of your information.\r\n	How you can correct any inaccuracies in the information.\r\n\r\n\r\n\r\nInformation Collection, Use, and Sharing&nbsp;\r\n\r\nWe are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.\r\n\r\nWe will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.\r\n\r\nUnless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.\r\n\r\n&nbsp;\r\n\r\nYour Access to and Control Over Information&nbsp;\r\n\r\nYou may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:\r\n\r\n\r\n\r\n	See what data we have about you, if any.\r\n	Change/correct any data we have about you.\r\n	Have us delete any data we have about you.\r\n	Express any concern you have about our use of your data.\r\n\r\n\r\n\r\nSecurity&nbsp;\r\n\r\nWe take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.\r\n\r\nWherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a lock icon in the address bar and looking for &quot;https&quot; at the beginning of the address of the Web page.\r\n\r\nWhile we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.\r\n\r\n&nbsp;\r\n\r\nIf you feel that we are not abiding by this privacy policy, you should contact us immediately via phone at 1234567890 or via email us at email@domain.com\r\n\r\n&nbsp;\r\n', '', '', '', 1, 0, 'null', 1),
(4, 'Contact Us', 'contact-us', NULL, '<p>Vidyavihar West, Mumbai</p>\r\n', '', '', '', 1, 1, '{\"contact_person\":\"John Smith\",\"mobile\":\"09000012345\",\"email\":\"abc@gmail.com\",\"address_line1\":\"C\\/501,  Chocolate  Building\",\"address_line2\":\"Vanila Street\",\"city\":\"Mumbai\",\"country\":\"99\",\"state\":\"1493\",\"pincode\":\"400123\","map_url":"https:\/\/www.google.com\/maps\/embed?pb=!1m18!1m12!1m3!1d3770.6811444007703!2d72.90397851490121!3d19.07775178708691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c62f40000039%3A0xe11790fc65fd4052!2sInfini+Systems+Pvt+Ltd!5e0!3m2!1sen!2sin!4v1503846275179"}', 4);


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_stock_update_history`
--

CREATE TABLE IF NOT EXISTS `tblprfx_stock_update_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `update_status` enum('0','1') NOT NULL COMMENT '0=minus,1=added',
  `update_qty` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_tagging_tagged`
--

CREATE TABLE IF NOT EXISTS `tblprfx_tagging_tagged` (
  `id` int(10) unsigned NOT NULL,
  `taggable_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_tagging_tags`
--

CREATE TABLE IF NOT EXISTS `tblprfx_tagging_tags` (
  `id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suggest` tinyint(1) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_tax`
--

CREATE TABLE IF NOT EXISTS `tblprfx_tax` (
  `id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `rate` float(5,2) NOT NULL,
  `tax_number` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0- deleted, 1 - Enabled, 2-disabled',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblprfx_tax` (`id`, `type`, `name`, `label`, `rate`, `tax_number`, `status`) VALUES
(1, 0, 'VAT', 'VAT', 10.00, 'ABCD1234', 0),
(2, 0, 'GST', 'GST', 18.00, '22ABCDE1234F2Z5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_testimonials`
--

CREATE TABLE IF NOT EXISTS `tblprfx_testimonials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `customer_name` varchar(50) NOT NULL,
 `gender` varchar(50) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tblprfx_testimonials` (`id`, `user_id`, `image`, `customer_name`, `testimonial`, `gender`, `sort_order`, `status`) VALUES
(3, 1, '21062018122049.jpg', 'Rini Shah, Veestores', 'Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!', 'female', 3, 1),
(5, 1, '21062018121817.jpg', 'John Doe, Abc Ltd.', 'Porro dolorem saepe reiciendis nihil minus neque. Ducimus rem necessitatibus repellat laborum nemo quod.', 'male', 2, 1),
(6, 1, '21062018121742.jpg', 'Steve Jobs, Apple Inc.', 'Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam.', 'male', 1, 1);


-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_translation`
--

CREATE TABLE IF NOT EXISTS `tblprfx_translation` (
  `id` bigint(20) NOT NULL,
  `hindi` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `english` varchar(50) NOT NULL,
  `bengali` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `page` text,
  `translate_for` varchar(255) DEFAULT NULL,
  `is_specific` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=MyISAM AUTO_INCREMENT=875 DEFAULT CHARSET=latin1;






-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_unit_measures`
--

CREATE TABLE IF NOT EXISTS `tblprfx_unit_measures` (
  `id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblprfx_unit_measures`
--

INSERT INTO `tblprfx_unit_measures` (`id`, `unit`, `status`) VALUES
(1, 'Meter', 1),
(2, 'Centimeter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_users`
--

-- CREATE TABLE IF NOT EXISTS `tblprfx_users` (
--   `id` int(10) unsigned NOT NULL,
--   `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
--   `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
--   `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
--   `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
--   `country_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
--   `telephone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
--   `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
--   `user_type` tinyint(4) NOT NULL,
--   `provider` text COLLATE utf8_unicode_ci NOT NULL,
--   `provider_id` bigint(20) NOT NULL,
--   `profile` text COLLATE utf8_unicode_ci NOT NULL,
--   `cashback` double NOT NULL,
--   `whishlist` bigint(20) NOT NULL,
--   `loyalty_group` int(11) NOT NULL,
--   `is_manually_updated` int(11) NOT NULL,
--   `total_purchase_till_now` float(20,2) NOT NULL,
--   `referal_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
--   `cart` text COLLATE utf8_unicode_ci NOT NULL,
--   `sort_order` int(11) NOT NULL,
--   `status` int(11) NOT NULL DEFAULT '1',
--   `newsletter` int(11) NOT NULL,
--   `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
--   `device_id` text COLLATE utf8_unicode_ci NOT NULL,
--  `created_at` timestamp NOT NULL DEFAULT NOW(),
--    `updated_at` timestamp  DEFAULT  NULL
-- ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- 
-- --
-- -- Dumping data for table `tblprfx_users`
-- --
-- 
-- INSERT INTO `tblprfx_users` (`id`, `firstname`, `lastname`, `email`, `password`,`country_code`, `telephone`, `remember_token`, `user_type`, `provider`, `provider_id`, `profile`, `cashback`, `whishlist`, `loyalty_group`, `is_manually_updated`, `total_purchase_till_now`, `referal_code`, `cart`, `sort_order`, `status`, `newsletter`, `ip`,`device_id`) VALUES
-- (1, 'Super', 'Admin', 'admin@inficart.com', '$2y$10$zaosj.mDRRhXdUSi9wpD4OQvzAHWbjnF1CBkyp546l.CP.ZdPY2hm','+91', '9685986589', 'TsY5yucwXJ5niWCohjhLwpqijGslwrGWYLgVXOSDUxRGG6G78gNmeFhlJOQG', 1, '', 0, '', 0, 0, 1, 0, 0.00, '', '', 0, 1, 0, '','');

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_vendors`
--

CREATE TABLE IF NOT EXISTS `tblprfx_vendors` (
  `id` int(10) unsigned NOT NULL,
  `vendor_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fname_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname_contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `toll_free` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line_1` text COLLATE utf8_unicode_ci,
  `address_line_2` text COLLATE utf8_unicode_ci,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_wishlist`
--

CREATE TABLE IF NOT EXISTS `tblprfx_wishlist` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblprfx_zones`
--

CREATE TABLE IF NOT EXISTS `tblprfx_zones` (
  `id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=4037 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblprfx_zones`
--

INSERT INTO `tblprfx_zones` (`id`, `country_id`, `name`, `code`, `status`) VALUES
(21, 1, 'Nangrahar', 'NAN', 1),
(22, 1, 'Nimruz', 'NIM', 1),
(23, 1, 'Nurestan', 'NUR', 1),
(24, 1, 'Oruzgan', 'ORU', 1),
(25, 1, 'Paktia', 'PIA', 1),
(26, 1, 'Paktika', 'PKA', 1),
(27, 1, 'Parwan', 'PAR', 1),
(28, 1, 'Samangan', 'SAM', 1),
(29, 1, 'Sar-e Pol', 'SAR', 1),
(30, 1, 'Takhar', 'TAK', 1),
(31, 1, 'Wardak', 'WAR', 1),
(32, 1, 'Zabol', 'ZAB', 1),
(33, 2, 'Berat', 'BR', 1),
(34, 2, 'Bulqize', 'BU', 1),
(35, 2, 'Delvine', 'DL', 1),
(36, 2, 'Devoll', 'DV', 1),
(37, 2, 'Diber', 'DI', 1),
(38, 2, 'Durres', 'DR', 1),
(39, 2, 'Elbasan', 'EL', 1),
(40, 2, 'Kolonje', 'ER', 1),
(41, 2, 'Fier', 'FR', 1),
(42, 2, 'Gjirokaster', 'GJ', 1),
(43, 2, 'Gramsh', 'GR', 1),
(44, 2, 'Has', 'HA', 1),
(45, 2, 'Kavaje', 'KA', 1),
(46, 2, 'Kurbin', 'KB', 1),
(47, 2, 'Kucove', 'KC', 1),
(48, 2, 'Korce', 'KO', 1),
(49, 2, 'Kruje', 'KR', 1),
(50, 2, 'Kukes', 'KU', 1),
(51, 2, 'Librazhd', 'LB', 1),
(52, 2, 'Lezhe', 'LE', 1),
(53, 2, 'Lushnje', 'LU', 1),
(54, 2, 'Malesi e Madhe', 'MM', 1),
(55, 2, 'Mallakaster', 'MK', 1),
(56, 2, 'Mat', 'MT', 1),
(57, 2, 'Mirdite', 'MR', 1),
(58, 2, 'Peqin', 'PQ', 1),
(59, 2, 'Permet', 'PR', 1),
(60, 2, 'Pogradec', 'PG', 1),
(61, 2, 'Puke', 'PU', 1),
(62, 2, 'Shkoder', 'SH', 1),
(63, 2, 'Skrapar', 'SK', 1),
(64, 2, 'Sarande', 'SR', 1),
(65, 2, 'Tepelene', 'TE', 1),
(66, 2, 'Tropoje', 'TP', 1),
(67, 2, 'Tirane', 'TR', 1),
(68, 2, 'Vlore', 'VL', 1),
(69, 3, 'Adrar', 'ADR', 1),
(70, 3, 'Ain Defla', 'ADE', 1),
(71, 3, 'Ain Temouchent', 'ATE', 1),
(72, 3, 'Alger', 'ALG', 1),
(73, 3, 'Annaba', 'ANN', 1),
(74, 3, 'Batna', 'BAT', 1),
(75, 3, 'Bechar', 'BEC', 1),
(76, 3, 'Bejaia', 'BEJ', 1),
(77, 3, 'Biskra', 'BIS', 1),
(78, 3, 'Blida', 'BLI', 1),
(79, 3, 'Bordj Bou Arreridj', 'BBA', 1),
(80, 3, 'Bouira', 'BOA', 1),
(81, 3, 'Boumerdes', 'BMD', 1),
(82, 3, 'Chlef', 'CHL', 1),
(83, 3, 'Constantine', 'CON', 1),
(84, 3, 'Djelfa', 'DJE', 1),
(85, 3, 'El Bayadh', 'EBA', 1),
(86, 3, 'El Oued', 'EOU', 1),
(87, 3, 'El Tarf', 'ETA', 1),
(88, 3, 'Ghardaia', 'GHA', 1),
(89, 3, 'Guelma', 'GUE', 1),
(90, 3, 'Illizi', 'ILL', 1),
(91, 3, 'Jijel', 'JIJ', 1),
(92, 3, 'Khenchela', 'KHE', 1),
(93, 3, 'Laghouat', 'LAG', 1),
(94, 3, 'Muaskar', 'MUA', 1),
(95, 3, 'Medea', 'MED', 1),
(96, 3, 'Mila', 'MIL', 1),
(97, 3, 'Mostaganem', 'MOS', 1),
(98, 3, 'M''Sila', 'MSI', 1),
(99, 3, 'Naama', 'NAA', 1),
(100, 3, 'Oran', 'ORA', 1),
(101, 3, 'Ouargla', 'OUA', 1),
(102, 3, 'Oum el-Bouaghi', 'OEB', 1),
(103, 3, 'Relizane', 'REL', 1),
(104, 3, 'Saida', 'SAI', 1),
(105, 3, 'Setif', 'SET', 1),
(106, 3, 'Sidi Bel Abbes', 'SBA', 1),
(107, 3, 'Skikda', 'SKI', 1),
(108, 3, 'Souk Ahras', 'SAH', 1),
(109, 3, 'Tamanghasset', 'TAM', 1),
(110, 3, 'Tebessa', 'TEB', 1),
(111, 3, 'Tiaret', 'TIA', 1),
(112, 3, 'Tindouf', 'TIN', 1),
(113, 3, 'Tipaza', 'TIP', 1),
(114, 3, 'Tissemsilt', 'TIS', 1),
(115, 3, 'Tizi Ouzou', 'TOU', 1),
(116, 3, 'Tlemcen', 'TLE', 1),
(117, 4, 'Eastern', 'E', 1),
(118, 4, 'Manu''a', 'M', 1),
(119, 4, 'Rose Island', 'R', 1),
(120, 4, 'Swains Island', 'S', 1),
(121, 4, 'Western', 'W', 1),
(122, 5, 'Andorra la Vella', 'ALV', 1),
(123, 5, 'Canillo', 'CAN', 1),
(124, 5, 'Encamp', 'ENC', 1),
(125, 5, 'Escaldes-Engordany', 'ESE', 1),
(126, 5, 'La Massana', 'LMA', 1),
(127, 5, 'Ordino', 'ORD', 1),
(128, 5, 'Sant Julia de Loria', 'SJL', 1),
(129, 6, 'Bengo', 'BGO', 1),
(130, 6, 'Benguela', 'BGU', 1),
(131, 6, 'Bie', 'BIE', 1),
(132, 6, 'Cabinda', 'CAB', 1),
(133, 6, 'Cuando-Cubango', 'CCU', 1),
(134, 6, 'Cuanza Norte', 'CNO', 1),
(135, 6, 'Cuanza Sul', 'CUS', 1),
(136, 6, 'Cunene', 'CNN', 1),
(137, 6, 'Huambo', 'HUA', 1),
(138, 6, 'Huila', 'HUI', 1),
(139, 6, 'Luanda', 'LUA', 1),
(140, 6, 'Lunda Norte', 'LNO', 1),
(141, 6, 'Lunda Sul', 'LSU', 1),
(142, 6, 'Malange', 'MAL', 1),
(143, 6, 'Moxico', 'MOX', 1),
(144, 6, 'Namibe', 'NAM', 1),
(145, 6, 'Uige', 'UIG', 1),
(146, 6, 'Zaire', 'ZAI', 1),
(147, 9, 'Saint George', 'ASG', 1),
(148, 9, 'Saint John', 'ASJ', 1),
(149, 9, 'Saint Mary', 'ASM', 1),
(150, 9, 'Saint Paul', 'ASL', 1),
(151, 9, 'Saint Peter', 'ASR', 1),
(152, 9, 'Saint Philip', 'ASH', 1),
(153, 9, 'Barbuda', 'BAR', 1),
(154, 9, 'Redonda', 'RED', 1),
(155, 10, 'Antartida e Islas del Atlantico', 'AN', 1),
(156, 10, 'Buenos Aires', 'BA', 1),
(157, 10, 'Catamarca', 'CA', 1),
(158, 10, 'Chaco', 'CH', 1),
(159, 10, 'Chubut', 'CU', 1),
(160, 10, 'Cordoba', 'CO', 1),
(161, 10, 'Corrientes', 'CR', 1),
(162, 10, 'Distrito Federal', 'DF', 1),
(163, 10, 'Entre Rios', 'ER', 1),
(164, 10, 'Formosa', 'FO', 1),
(165, 10, 'Jujuy', 'JU', 1),
(166, 10, 'La Pampa', 'LP', 1),
(167, 10, 'La Rioja', 'LR', 1),
(168, 10, 'Mendoza', 'ME', 1),
(169, 10, 'Misiones', 'MI', 1),
(170, 10, 'Neuquen', 'NE', 1),
(171, 10, 'Rio Negro', 'RN', 1),
(172, 10, 'Salta', 'SA', 1),
(173, 10, 'San Juan', 'SJ', 1),
(174, 10, 'San Luis', 'SL', 1),
(175, 10, 'Santa Cruz', 'SC', 1),
(176, 10, 'Santa Fe', 'SF', 1),
(177, 10, 'Santiago del Estero', 'SD', 1),
(178, 10, 'Tierra del Fuego', 'TF', 1),
(179, 10, 'Tucuman', 'TU', 1),
(180, 11, 'Aragatsotn', 'AGT', 1),
(181, 11, 'Ararat', 'ARR', 1),
(182, 11, 'Armavir', 'ARM', 1),
(183, 11, 'Geghark''unik''', 'GEG', 1),
(184, 11, 'Kotayk''', 'KOT', 1),
(185, 11, 'Lorri', 'LOR', 1),
(186, 11, 'Shirak', 'SHI', 1),
(187, 11, 'Syunik''', 'SYU', 1),
(188, 11, 'Tavush', 'TAV', 1),
(189, 11, 'Vayots'' Dzor', 'VAY', 1),
(190, 11, 'Yerevan', 'YER', 1),
(191, 13, 'Australian Capital Territory', 'ACT', 1),
(192, 13, 'New South Wales', 'NSW', 1),
(193, 13, 'Northern Territory', 'NT', 1),
(194, 13, 'Queensland', 'QLD', 1),
(195, 13, 'South Australia', 'SA', 1),
(196, 13, 'Tasmania', 'TAS', 1),
(197, 13, 'Victoria', 'VIC', 1),
(198, 13, 'Western Australia', 'WA', 1),
(199, 14, 'Burgenland', 'BUR', 1),
(200, 14, 'Kärnten', 'KAR', 1),
(201, 14, 'Nieder&ouml;sterreich', 'NOS', 1),
(202, 14, 'Ober&ouml;sterreich', 'OOS', 1),
(203, 14, 'Salzburg', 'SAL', 1),
(204, 14, 'Steiermark', 'STE', 1),
(205, 14, 'Tirol', 'TIR', 1),
(206, 14, 'Vorarlberg', 'VOR', 1),
(207, 14, 'Wien', 'WIE', 1),
(208, 15, 'Ali Bayramli', 'AB', 1),
(209, 15, 'Abseron', 'ABS', 1),
(210, 15, 'AgcabAdi', 'AGC', 1),
(211, 15, 'Agdam', 'AGM', 1),
(212, 15, 'Agdas', 'AGS', 1),
(213, 15, 'Agstafa', 'AGA', 1),
(214, 15, 'Agsu', 'AGU', 1),
(215, 15, 'Astara', 'AST', 1),
(216, 15, 'Baki', 'BA', 1),
(217, 15, 'BabAk', 'BAB', 1),
(218, 15, 'BalakAn', 'BAL', 1),
(219, 15, 'BArdA', 'BAR', 1),
(220, 15, 'Beylaqan', 'BEY', 1),
(221, 15, 'Bilasuvar', 'BIL', 1),
(222, 15, 'Cabrayil', 'CAB', 1),
(223, 15, 'Calilabab', 'CAL', 1),
(224, 15, 'Culfa', 'CUL', 1),
(225, 15, 'Daskasan', 'DAS', 1),
(226, 15, 'Davaci', 'DAV', 1),
(227, 15, 'Fuzuli', 'FUZ', 1),
(228, 15, 'Ganca', 'GA', 1),
(229, 15, 'Gadabay', 'GAD', 1),
(230, 15, 'Goranboy', 'GOR', 1),
(231, 15, 'Goycay', 'GOY', 1),
(232, 15, 'Haciqabul', 'HAC', 1),
(233, 15, 'Imisli', 'IMI', 1),
(234, 15, 'Ismayilli', 'ISM', 1),
(235, 15, 'Kalbacar', 'KAL', 1),
(236, 15, 'Kurdamir', 'KUR', 1),
(237, 15, 'Lankaran', 'LA', 1),
(238, 15, 'Lacin', 'LAC', 1),
(239, 15, 'Lankaran', 'LAN', 1),
(240, 15, 'Lerik', 'LER', 1),
(241, 15, 'Masalli', 'MAS', 1),
(242, 15, 'Mingacevir', 'MI', 1),
(243, 15, 'Naftalan', 'NA', 1),
(244, 15, 'Neftcala', 'NEF', 1),
(245, 15, 'Oguz', 'OGU', 1),
(246, 15, 'Ordubad', 'ORD', 1),
(247, 15, 'Qabala', 'QAB', 1),
(248, 15, 'Qax', 'QAX', 1),
(249, 15, 'Qazax', 'QAZ', 1),
(250, 15, 'Qobustan', 'QOB', 1),
(251, 15, 'Quba', 'QBA', 1),
(252, 15, 'Qubadli', 'QBI', 1),
(253, 15, 'Qusar', 'QUS', 1),
(254, 15, 'Saki', 'SA', 1),
(255, 15, 'Saatli', 'SAT', 1),
(256, 15, 'Sabirabad', 'SAB', 1),
(257, 15, 'Sadarak', 'SAD', 1),
(258, 15, 'Sahbuz', 'SAH', 1),
(259, 15, 'Saki', 'SAK', 1),
(260, 15, 'Salyan', 'SAL', 1),
(261, 15, 'Sumqayit', 'SM', 1),
(262, 15, 'Samaxi', 'SMI', 1),
(263, 15, 'Samkir', 'SKR', 1),
(264, 15, 'Samux', 'SMX', 1),
(265, 15, 'Sarur', 'SAR', 1),
(266, 15, 'Siyazan', 'SIY', 1),
(267, 15, 'Susa', 'SS', 1),
(268, 15, 'Susa', 'SUS', 1),
(269, 15, 'Tartar', 'TAR', 1),
(270, 15, 'Tovuz', 'TOV', 1),
(271, 15, 'Ucar', 'UCA', 1),
(272, 15, 'Xankandi', 'XA', 1),
(273, 15, 'Xacmaz', 'XAC', 1),
(274, 15, 'Xanlar', 'XAN', 1),
(275, 15, 'Xizi', 'XIZ', 1),
(276, 15, 'Xocali', 'XCI', 1),
(277, 15, 'Xocavand', 'XVD', 1),
(278, 15, 'Yardimli', 'YAR', 1),
(279, 15, 'Yevlax', 'YEV', 1),
(280, 15, 'Zangilan', 'ZAN', 1),
(281, 15, 'Zaqatala', 'ZAQ', 1),
(282, 15, 'Zardab', 'ZAR', 1),
(283, 15, 'Naxcivan', 'NX', 1),
(284, 16, 'Acklins', 'ACK', 1),
(285, 16, 'Berry Islands', 'BER', 1),
(286, 16, 'Bimini', 'BIM', 1),
(287, 16, 'Black Point', 'BLK', 1),
(288, 16, 'Cat Island', 'CAT', 1),
(289, 16, 'Central Abaco', 'CAB', 1),
(290, 16, 'Central Andros', 'CAN', 1),
(291, 16, 'Central Eleuthera', 'CEL', 1),
(292, 16, 'City of Freeport', 'FRE', 1),
(293, 16, 'Crooked Island', 'CRO', 1),
(294, 16, 'East Grand Bahama', 'EGB', 1),
(295, 16, 'Exuma', 'EXU', 1),
(296, 16, 'Grand Cay', 'GRD', 1),
(297, 16, 'Harbour Island', 'HAR', 1),
(298, 16, 'Hope Town', 'HOP', 1),
(299, 16, 'Inagua', 'INA', 1),
(300, 16, 'Long Island', 'LNG', 1),
(301, 16, 'Mangrove Cay', 'MAN', 1),
(302, 16, 'Mayaguana', 'MAY', 1),
(303, 16, 'Moore''s Island', 'MOO', 1),
(304, 16, 'North Abaco', 'NAB', 1),
(305, 16, 'North Andros', 'NAN', 1),
(306, 16, 'North Eleuthera', 'NEL', 1),
(307, 16, 'Ragged Island', 'RAG', 1),
(308, 16, 'Rum Cay', 'RUM', 1),
(309, 16, 'San Salvador', 'SAL', 1),
(310, 16, 'South Abaco', 'SAB', 1),
(311, 16, 'South Andros', 'SAN', 1),
(312, 16, 'South Eleuthera', 'SEL', 1),
(313, 16, 'Spanish Wells', 'SWE', 1),
(314, 16, 'West Grand Bahama', 'WGB', 1),
(315, 17, 'Capital', 'CAP', 1),
(316, 17, 'Central', 'CEN', 1),
(317, 17, 'Muharraq', 'MUH', 1),
(318, 17, 'Northern', 'NOR', 1),
(319, 17, 'Southern', 'SOU', 1),
(320, 18, 'Barisal', 'BAR', 1),
(321, 18, 'Chittagong', 'CHI', 1),
(322, 18, 'Dhaka', 'DHA', 1),
(323, 18, 'Khulna', 'KHU', 1),
(324, 18, 'Rajshahi', 'RAJ', 1),
(325, 18, 'Sylhet', 'SYL', 1),
(326, 19, 'Christ Church', 'CC', 1),
(327, 19, 'Saint Andrew', 'AND', 1),
(328, 19, 'Saint George', 'GEO', 1),
(329, 19, 'Saint James', 'JAM', 1),
(330, 19, 'Saint John', 'JOH', 1),
(331, 19, 'Saint Joseph', 'JOS', 1),
(332, 19, 'Saint Lucy', 'LUC', 1),
(333, 19, 'Saint Michael', 'MIC', 1),
(334, 19, 'Saint Peter', 'PET', 1),
(335, 19, 'Saint Philip', 'PHI', 1),
(336, 19, 'Saint Thomas', 'THO', 1),
(337, 20, 'Brestskaya (Brest)', 'BR', 1),
(338, 20, 'Homyel''skaya (Homyel'')', 'HO', 1),
(339, 20, 'Horad Minsk', 'HM', 1),
(340, 20, 'Hrodzyenskaya (Hrodna)', 'HR', 1),
(341, 20, 'Mahilyowskaya (Mahilyow)', 'MA', 1),
(342, 20, 'Minskaya', 'MI', 1),
(343, 20, 'Vitsyebskaya (Vitsyebsk)', 'VI', 1),
(344, 21, 'Antwerpen', 'VAN', 1),
(345, 21, 'Brabant Wallon', 'WBR', 1),
(346, 21, 'Hainaut', 'WHT', 1),
(347, 21, 'Liège', 'WLG', 1),
(348, 21, 'Limburg', 'VLI', 1),
(349, 21, 'Luxembourg', 'WLX', 1),
(350, 21, 'Namur', 'WNA', 1),
(351, 21, 'Oost-Vlaanderen', 'VOV', 1),
(352, 21, 'Vlaams Brabant', 'VBR', 1),
(353, 21, 'West-Vlaanderen', 'VWV', 1),
(354, 22, 'Belize', 'BZ', 1),
(355, 22, 'Cayo', 'CY', 1),
(356, 22, 'Corozal', 'CR', 1),
(357, 22, 'Orange Walk', 'OW', 1),
(358, 22, 'Stann Creek', 'SC', 1),
(359, 22, 'Toledo', 'TO', 1),
(360, 23, 'Alibori', 'AL', 1),
(361, 23, 'Atakora', 'AK', 1),
(362, 23, 'Atlantique', 'AQ', 1),
(363, 23, 'Borgou', 'BO', 1),
(364, 23, 'Collines', 'CO', 1),
(365, 23, 'Donga', 'DO', 1),
(366, 23, 'Kouffo', 'KO', 1),
(367, 23, 'Littoral', 'LI', 1),
(368, 23, 'Mono', 'MO', 1),
(369, 23, 'Oueme', 'OU', 1),
(370, 23, 'Plateau', 'PL', 1),
(371, 23, 'Zou', 'ZO', 1),
(372, 24, 'Devonshire', 'DS', 1),
(373, 24, 'Hamilton City', 'HC', 1),
(374, 24, 'Hamilton', 'HA', 1),
(375, 24, 'Paget', 'PG', 1),
(376, 24, 'Pembroke', 'PB', 1),
(377, 24, 'Saint George City', 'GC', 1),
(378, 24, 'Saint George''s', 'SG', 1),
(379, 24, 'Sandys', 'SA', 1),
(380, 24, 'Smith''s', 'SM', 1),
(381, 24, 'Southampton', 'SH', 1),
(382, 24, 'Warwick', 'WA', 1),
(383, 25, 'Bumthang', 'BUM', 1),
(384, 25, 'Chukha', 'CHU', 1),
(385, 25, 'Dagana', 'DAG', 1),
(386, 25, 'Gasa', 'GAS', 1),
(387, 25, 'Haa', 'HAA', 1),
(388, 25, 'Lhuntse', 'LHU', 1),
(389, 25, 'Mongar', 'MON', 1),
(390, 25, 'Paro', 'PAR', 1),
(391, 25, 'Pemagatshel', 'PEM', 1),
(392, 25, 'Punakha', 'PUN', 1),
(393, 25, 'Samdrup Jongkhar', 'SJO', 1),
(394, 25, 'Samtse', 'SAT', 1),
(395, 25, 'Sarpang', 'SAR', 1),
(396, 25, 'Thimphu', 'THI', 1),
(397, 25, 'Trashigang', 'TRG', 1),
(398, 25, 'Trashiyangste', 'TRY', 1),
(399, 25, 'Trongsa', 'TRO', 1),
(400, 25, 'Tsirang', 'TSI', 1),
(401, 25, 'Wangdue Phodrang', 'WPH', 1),
(402, 25, 'Zhemgang', 'ZHE', 1),
(403, 26, 'Beni', 'BEN', 1),
(404, 26, 'Chuquisaca', 'CHU', 1),
(405, 26, 'Cochabamba', 'COC', 1),
(406, 26, 'La Paz', 'LPZ', 1),
(407, 26, 'Oruro', 'ORU', 1),
(408, 26, 'Pando', 'PAN', 1),
(409, 26, 'Potosi', 'POT', 1),
(410, 26, 'Santa Cruz', 'SCZ', 1),
(411, 26, 'Tarija', 'TAR', 1),
(412, 27, 'Brcko district', 'BRO', 1),
(413, 27, 'Unsko-Sanski Kanton', 'FUS', 1),
(414, 27, 'Posavski Kanton', 'FPO', 1),
(415, 27, 'Tuzlanski Kanton', 'FTU', 1),
(416, 27, 'Zenicko-Dobojski Kanton', 'FZE', 1),
(417, 27, 'Bosanskopodrinjski Kanton', 'FBP', 1),
(418, 27, 'Srednjebosanski Kanton', 'FSB', 1),
(419, 27, 'Hercegovacko-neretvanski Kanton', 'FHN', 1),
(420, 27, 'Zapadnohercegovacka Zupanija', 'FZH', 1),
(421, 27, 'Kanton Sarajevo', 'FSA', 1),
(422, 27, 'Zapadnobosanska', 'FZA', 1),
(423, 27, 'Banja Luka', 'SBL', 1),
(424, 27, 'Doboj', 'SDO', 1),
(425, 27, 'Bijeljina', 'SBI', 1),
(426, 27, 'Vlasenica', 'SVL', 1),
(427, 27, 'Sarajevo-Romanija or Sokolac', 'SSR', 1),
(428, 27, 'Foca', 'SFO', 1),
(429, 27, 'Trebinje', 'STR', 1),
(430, 28, 'Central', 'CE', 1),
(431, 28, 'Ghanzi', 'GH', 1),
(432, 28, 'Kgalagadi', 'KD', 1),
(433, 28, 'Kgatleng', 'KT', 1),
(434, 28, 'Kweneng', 'KW', 1),
(435, 28, 'Ngamiland', 'NG', 1),
(436, 28, 'North East', 'NE', 1),
(437, 28, 'North West', 'NW', 1),
(438, 28, 'South East', 'SE', 1),
(439, 28, 'Southern', 'SO', 1),
(440, 30, 'Acre', 'AC', 1),
(441, 30, 'Alagoas', 'AL', 1),
(442, 30, 'Amapá', 'AP', 1),
(443, 30, 'Amazonas', 'AM', 1),
(444, 30, 'Bahia', 'BA', 1),
(445, 30, 'Ceará', 'CE', 1),
(446, 30, 'Distrito Federal', 'DF', 1),
(447, 30, 'Espírito Santo', 'ES', 1),
(448, 30, 'Goiás', 'GO', 1),
(449, 30, 'Maranhão', 'MA', 1),
(450, 30, 'Mato Grosso', 'MT', 1),
(451, 30, 'Mato Grosso do Sul', 'MS', 1),
(452, 30, 'Minas Gerais', 'MG', 1),
(453, 30, 'Pará', 'PA', 1),
(454, 30, 'Paraíba', 'PB', 1),
(455, 30, 'Paraná', 'PR', 1),
(456, 30, 'Pernambuco', 'PE', 1),
(457, 30, 'Piauí', 'PI', 1),
(458, 30, 'Rio de Janeiro', 'RJ', 1),
(459, 30, 'Rio Grande do Norte', 'RN', 1),
(460, 30, 'Rio Grande do Sul', 'RS', 1),
(461, 30, 'Rondônia', 'RO', 1),
(462, 30, 'Roraima', 'RR', 1),
(463, 30, 'Santa Catarina', 'SC', 1),
(464, 30, 'São Paulo', 'SP', 1),
(465, 30, 'Sergipe', 'SE', 1),
(466, 30, 'Tocantins', 'TO', 1),
(467, 31, 'Peros Banhos', 'PB', 1),
(468, 31, 'Salomon Islands', 'SI', 1),
(469, 31, 'Nelsons Island', 'NI', 1),
(470, 31, 'Three Brothers', 'TB', 1),
(471, 31, 'Eagle Islands', 'EA', 1),
(472, 31, 'Danger Island', 'DI', 1),
(473, 31, 'Egmont Islands', 'EG', 1),
(474, 31, 'Diego Garcia', 'DG', 1),
(475, 32, 'Belait', 'BEL', 1),
(476, 32, 'Brunei and Muara', 'BRM', 1),
(477, 32, 'Temburong', 'TEM', 1),
(478, 32, 'Tutong', 'TUT', 1),
(479, 33, 'Blagoevgrad', '', 1),
(480, 33, 'Burgas', '', 1),
(481, 33, 'Dobrich', '', 1),
(482, 33, 'Gabrovo', '', 1),
(483, 33, 'Haskovo', '', 1),
(484, 33, 'Kardjali', '', 1),
(485, 33, 'Kyustendil', '', 1),
(486, 33, 'Lovech', '', 1),
(487, 33, 'Montana', '', 1),
(488, 33, 'Pazardjik', '', 1),
(489, 33, 'Pernik', '', 1),
(490, 33, 'Pleven', '', 1),
(491, 33, 'Plovdiv', '', 1),
(492, 33, 'Razgrad', '', 1),
(493, 33, 'Shumen', '', 1),
(494, 33, 'Silistra', '', 1),
(495, 33, 'Sliven', '', 1),
(496, 33, 'Smolyan', '', 1),
(497, 33, 'Sofia', '', 1),
(498, 33, 'Sofia - town', '', 1),
(499, 33, 'Stara Zagora', '', 1),
(500, 33, 'Targovishte', '', 1),
(501, 33, 'Varna', '', 1),
(502, 33, 'Veliko Tarnovo', '', 1),
(503, 33, 'Vidin', '', 1),
(504, 33, 'Vratza', '', 1),
(505, 33, 'Yambol', '', 1),
(506, 34, 'Bale', 'BAL', 1),
(507, 34, 'Bam', 'BAM', 1),
(508, 34, 'Banwa', 'BAN', 1),
(509, 34, 'Bazega', 'BAZ', 1),
(510, 34, 'Bougouriba', 'BOR', 1),
(511, 34, 'Boulgou', 'BLG', 1),
(512, 34, 'Boulkiemde', 'BOK', 1),
(513, 34, 'Comoe', 'COM', 1),
(514, 34, 'Ganzourgou', 'GAN', 1),
(515, 34, 'Gnagna', 'GNA', 1),
(516, 34, 'Gourma', 'GOU', 1),
(517, 34, 'Houet', 'HOU', 1),
(518, 34, 'Ioba', 'IOA', 1),
(519, 34, 'Kadiogo', 'KAD', 1),
(520, 34, 'Kenedougou', 'KEN', 1),
(521, 34, 'Komondjari', 'KOD', 1),
(522, 34, 'Kompienga', 'KOP', 1),
(523, 34, 'Kossi', 'KOS', 1),
(524, 34, 'Koulpelogo', 'KOL', 1),
(525, 34, 'Kouritenga', 'KOT', 1),
(526, 34, 'Kourweogo', 'KOW', 1),
(527, 34, 'Leraba', 'LER', 1),
(528, 34, 'Loroum', 'LOR', 1),
(529, 34, 'Mouhoun', 'MOU', 1),
(530, 34, 'Nahouri', 'NAH', 1),
(531, 34, 'Namentenga', 'NAM', 1),
(532, 34, 'Nayala', 'NAY', 1),
(533, 34, 'Noumbiel', 'NOU', 1),
(534, 34, 'Oubritenga', 'OUB', 1),
(535, 34, 'Oudalan', 'OUD', 1),
(536, 34, 'Passore', 'PAS', 1),
(537, 34, 'Poni', 'PON', 1),
(538, 34, 'Sanguie', 'SAG', 1),
(539, 34, 'Sanmatenga', 'SAM', 1),
(540, 34, 'Seno', 'SEN', 1),
(541, 34, 'Sissili', 'SIS', 1),
(542, 34, 'Soum', 'SOM', 1),
(543, 34, 'Sourou', 'SOR', 1),
(544, 34, 'Tapoa', 'TAP', 1),
(545, 34, 'Tuy', 'TUY', 1),
(546, 34, 'Yagha', 'YAG', 1),
(547, 34, 'Yatenga', 'YAT', 1),
(548, 34, 'Ziro', 'ZIR', 1),
(549, 34, 'Zondoma', 'ZOD', 1),
(550, 34, 'Zoundweogo', 'ZOW', 1),
(551, 35, 'Bubanza', 'BB', 1),
(552, 35, 'Bujumbura', 'BJ', 1),
(553, 35, 'Bururi', 'BR', 1),
(554, 35, 'Cankuzo', 'CA', 1),
(555, 35, 'Cibitoke', 'CI', 1),
(556, 35, 'Gitega', 'GI', 1),
(557, 35, 'Karuzi', 'KR', 1),
(558, 35, 'Kayanza', 'KY', 1),
(559, 35, 'Kirundo', 'KI', 1),
(560, 35, 'Makamba', 'MA', 1),
(561, 35, 'Muramvya', 'MU', 1),
(562, 35, 'Muyinga', 'MY', 1),
(563, 35, 'Mwaro', 'MW', 1),
(564, 35, 'Ngozi', 'NG', 1),
(565, 35, 'Rutana', 'RT', 1),
(566, 35, 'Ruyigi', 'RY', 1),
(567, 36, 'Phnom Penh', 'PP', 1),
(568, 36, 'Preah Seihanu (Kompong Som or Sihanoukville)', 'PS', 1),
(569, 36, 'Pailin', 'PA', 1),
(570, 36, 'Keb', 'KB', 1),
(571, 36, 'Banteay Meanchey', 'BM', 1),
(572, 36, 'Battambang', 'BA', 1),
(573, 36, 'Kampong Cham', 'KM', 1),
(574, 36, 'Kampong Chhnang', 'KN', 1),
(575, 36, 'Kampong Speu', 'KU', 1),
(576, 36, 'Kampong Som', 'KO', 1),
(577, 36, 'Kampong Thom', 'KT', 1),
(578, 36, 'Kampot', 'KP', 1),
(579, 36, 'Kandal', 'KL', 1),
(580, 36, 'Kaoh Kong', 'KK', 1),
(581, 36, 'Kratie', 'KR', 1),
(582, 36, 'Mondul Kiri', 'MK', 1),
(583, 36, 'Oddar Meancheay', 'OM', 1),
(584, 36, 'Pursat', 'PU', 1),
(585, 36, 'Preah Vihear', 'PR', 1),
(586, 36, 'Prey Veng', 'PG', 1),
(587, 36, 'Ratanak Kiri', 'RK', 1),
(588, 36, 'Siemreap', 'SI', 1),
(589, 36, 'Stung Treng', 'ST', 1),
(590, 36, 'Svay Rieng', 'SR', 1),
(591, 36, 'Takeo', 'TK', 1),
(592, 37, 'Adamawa (Adamaoua)', 'ADA', 1),
(593, 37, 'Centre', 'CEN', 1),
(594, 37, 'East (Est)', 'EST', 1),
(595, 37, 'Extreme North (Extreme-Nord)', 'EXN', 1),
(596, 37, 'Littoral', 'LIT', 1),
(597, 37, 'North (Nord)', 'NOR', 1),
(598, 37, 'Northwest (Nord-Ouest)', 'NOT', 1),
(599, 37, 'West (Ouest)', 'OUE', 1),
(600, 37, 'South (Sud)', 'SUD', 1),
(601, 37, 'Southwest (Sud-Ouest).', 'SOU', 1),
(602, 38, 'Alberta', 'AB', 1),
(603, 38, 'British Columbia', 'BC', 1),
(604, 38, 'Manitoba', 'MB', 1),
(605, 38, 'New Brunswick', 'NB', 1),
(606, 38, 'Newfoundland and Labrador', 'NL', 1),
(607, 38, 'Northwest Territories', 'NT', 1),
(608, 38, 'Nova Scotia', 'NS', 1),
(609, 38, 'Nunavut', 'NU', 1),
(610, 38, 'Ontario', 'ON', 1),
(611, 38, 'Prince Edward Island', 'PE', 1),
(612, 38, 'Qu&eacute;bec', 'QC', 1),
(613, 38, 'Saskatchewan', 'SK', 1),
(614, 38, 'Yukon Territory', 'YT', 1),
(615, 39, 'Boa Vista', 'BV', 1),
(616, 39, 'Brava', 'BR', 1),
(617, 39, 'Calheta de Sao Miguel', 'CS', 1),
(618, 39, 'Maio', 'MA', 1),
(619, 39, 'Mosteiros', 'MO', 1),
(620, 39, 'Paul', 'PA', 1),
(621, 39, 'Porto Novo', 'PN', 1),
(622, 39, 'Praia', 'PR', 1),
(623, 39, 'Ribeira Grande', 'RG', 1),
(624, 39, 'Sal', 'SL', 1),
(625, 39, 'Santa Catarina', 'CA', 1),
(626, 39, 'Santa Cruz', 'CR', 1),
(627, 39, 'Sao Domingos', 'SD', 1),
(628, 39, 'Sao Filipe', 'SF', 1),
(629, 39, 'Sao Nicolau', 'SN', 1),
(630, 39, 'Sao Vicente', 'SV', 1),
(631, 39, 'Tarrafal', 'TA', 1),
(632, 40, 'Creek', 'CR', 1),
(633, 40, 'Eastern', 'EA', 1),
(634, 40, 'Midland', 'ML', 1),
(635, 40, 'South Town', 'ST', 1),
(636, 40, 'Spot Bay', 'SP', 1),
(637, 40, 'Stake Bay', 'SK', 1),
(638, 40, 'West End', 'WD', 1),
(639, 40, 'Western', 'WN', 1),
(640, 41, 'Bamingui-Bangoran', 'BBA', 1),
(641, 41, 'Basse-Kotto', 'BKO', 1),
(642, 41, 'Haute-Kotto', 'HKO', 1),
(643, 41, 'Haut-Mbomou', 'HMB', 1),
(644, 41, 'Kemo', 'KEM', 1),
(645, 41, 'Lobaye', 'LOB', 1),
(646, 41, 'Mambere-KadeÔ', 'MKD', 1),
(647, 41, 'Mbomou', 'MBO', 1),
(648, 41, 'Nana-Mambere', 'NMM', 1),
(649, 41, 'Ombella-M''Poko', 'OMP', 1),
(650, 41, 'Ouaka', 'OUK', 1),
(651, 41, 'Ouham', 'OUH', 1),
(652, 41, 'Ouham-Pende', 'OPE', 1),
(653, 41, 'Vakaga', 'VAK', 1),
(654, 41, 'Nana-Grebizi', 'NGR', 1),
(655, 41, 'Sangha-Mbaere', 'SMB', 1),
(656, 41, 'Bangui', 'BAN', 1),
(657, 42, 'Batha', 'BA', 1),
(658, 42, 'Biltine', 'BI', 1),
(659, 42, 'Borkou-Ennedi-Tibesti', 'BE', 1),
(660, 42, 'Chari-Baguirmi', 'CB', 1),
(661, 42, 'Guera', 'GU', 1),
(662, 42, 'Kanem', 'KA', 1),
(663, 42, 'Lac', 'LA', 1),
(664, 42, 'Logone Occidental', 'LC', 1),
(665, 42, 'Logone Oriental', 'LR', 1),
(666, 42, 'Mayo-Kebbi', 'MK', 1),
(667, 42, 'Moyen-Chari', 'MC', 1),
(668, 42, 'Ouaddai', 'OU', 1),
(669, 42, 'Salamat', 'SA', 1),
(670, 42, 'Tandjile', 'TA', 1),
(671, 43, 'Aisen del General Carlos Ibanez', 'AI', 1),
(672, 43, 'Antofagasta', 'AN', 1),
(673, 43, 'Araucania', 'AR', 1),
(674, 43, 'Atacama', 'AT', 1),
(675, 43, 'Bio-Bio', 'BI', 1),
(676, 43, 'Coquimbo', 'CO', 1),
(677, 43, 'Libertador General Bernardo O''Hi', 'LI', 1),
(678, 43, 'Los Lagos', 'LL', 1),
(679, 43, 'Magallanes y de la Antartica Chi', 'MA', 1),
(680, 43, 'Maule', 'ML', 1),
(681, 43, 'Region Metropolitana', 'RM', 1),
(682, 43, 'Tarapaca', 'TA', 1),
(683, 43, 'Valparaiso', 'VS', 1),
(684, 44, 'Anhui', 'AN', 1),
(685, 44, 'Beijing', 'BE', 1),
(686, 44, 'Chongqing', 'CH', 1),
(687, 44, 'Fujian', 'FU', 1),
(688, 44, 'Gansu', 'GA', 1),
(689, 44, 'Guangdong', 'GU', 1),
(690, 44, 'Guangxi', 'GX', 1),
(691, 44, 'Guizhou', 'GZ', 1),
(692, 44, 'Hainan', 'HA', 1),
(693, 44, 'Hebei', 'HB', 1),
(694, 44, 'Heilongjiang', 'HL', 1),
(695, 44, 'Henan', 'HE', 1),
(696, 44, 'Hong Kong', 'HK', 1),
(697, 44, 'Hubei', 'HU', 1),
(698, 44, 'Hunan', 'HN', 1),
(699, 44, 'Inner Mongolia', 'IM', 1),
(700, 44, 'Jiangsu', 'JI', 1),
(701, 44, 'Jiangxi', 'JX', 1),
(702, 44, 'Jilin', 'JL', 1),
(703, 44, 'Liaoning', 'LI', 1),
(704, 44, 'Macau', 'MA', 1),
(705, 44, 'Ningxia', 'NI', 1),
(706, 44, 'Shaanxi', 'SH', 1),
(707, 44, 'Shandong', 'SA', 1),
(708, 44, 'Shanghai', 'SG', 1),
(709, 44, 'Shanxi', 'SX', 1),
(710, 44, 'Sichuan', 'SI', 1),
(711, 44, 'Tianjin', 'TI', 1),
(712, 44, 'Xinjiang', 'XI', 1),
(713, 44, 'Yunnan', 'YU', 1),
(714, 44, 'Zhejiang', 'ZH', 1),
(715, 46, 'Direction Island', 'D', 1),
(716, 46, 'Home Island', 'H', 1),
(717, 46, 'Horsburgh Island', 'O', 1),
(718, 46, 'South Island', 'S', 1),
(719, 46, 'West Island', 'W', 1),
(720, 47, 'Amazonas', 'AMZ', 1),
(721, 47, 'Antioquia', 'ANT', 1),
(722, 47, 'Arauca', 'ARA', 1),
(723, 47, 'Atlantico', 'ATL', 1),
(724, 47, 'Bogota D.C.', 'BDC', 1),
(725, 47, 'Bolivar', 'BOL', 1),
(726, 47, 'Boyaca', 'BOY', 1),
(727, 47, 'Caldas', 'CAL', 1),
(728, 47, 'Caqueta', 'CAQ', 1),
(729, 47, 'Casanare', 'CAS', 1),
(730, 47, 'Cauca', 'CAU', 1),
(731, 47, 'Cesar', 'CES', 1),
(732, 47, 'Choco', 'CHO', 1),
(733, 47, 'Cordoba', 'COR', 1),
(734, 47, 'Cundinamarca', 'CAM', 1),
(735, 47, 'Guainia', 'GNA', 1),
(736, 47, 'Guajira', 'GJR', 1),
(737, 47, 'Guaviare', 'GVR', 1),
(738, 47, 'Huila', 'HUI', 1),
(739, 47, 'Magdalena', 'MAG', 1),
(740, 47, 'Meta', 'MET', 1),
(741, 47, 'Narino', 'NAR', 1),
(742, 47, 'Norte de Santander', 'NDS', 1),
(743, 47, 'Putumayo', 'PUT', 1),
(744, 47, 'Quindio', 'QUI', 1),
(745, 47, 'Risaralda', 'RIS', 1),
(746, 47, 'San Andres y Providencia', 'SAP', 1),
(747, 47, 'Santander', 'SAN', 1),
(748, 47, 'Sucre', 'SUC', 1),
(749, 47, 'Tolima', 'TOL', 1),
(750, 47, 'Valle del Cauca', 'VDC', 1),
(751, 47, 'Vaupes', 'VAU', 1),
(752, 47, 'Vichada', 'VIC', 1),
(753, 48, 'Grande Comore', 'G', 1),
(754, 48, 'Anjouan', 'A', 1),
(755, 48, 'Moheli', 'M', 1),
(756, 49, 'Bouenza', 'BO', 1),
(757, 49, 'Brazzaville', 'BR', 1),
(758, 49, 'Cuvette', 'CU', 1),
(759, 49, 'Cuvette-Ouest', 'CO', 1),
(760, 49, 'Kouilou', 'KO', 1),
(761, 49, 'Lekoumou', 'LE', 1),
(762, 49, 'Likouala', 'LI', 1),
(763, 49, 'Niari', 'NI', 1),
(764, 49, 'Plateaux', 'PL', 1),
(765, 49, 'Pool', 'PO', 1),
(766, 49, 'Sangha', 'SA', 1),
(767, 50, 'Pukapuka', 'PU', 1),
(768, 50, 'Rakahanga', 'RK', 1),
(769, 50, 'Manihiki', 'MK', 1),
(770, 50, 'Penrhyn', 'PE', 1),
(771, 50, 'Nassau Island', 'NI', 1),
(772, 50, 'Surwarrow', 'SU', 1),
(773, 50, 'Palmerston', 'PA', 1),
(774, 50, 'Aitutaki', 'AI', 1),
(775, 50, 'Manuae', 'MA', 1),
(776, 50, 'Takutea', 'TA', 1),
(777, 50, 'Mitiaro', 'MT', 1),
(778, 50, 'Atiu', 'AT', 1),
(779, 50, 'Mauke', 'MU', 1),
(780, 50, 'Rarotonga', 'RR', 1),
(781, 50, 'Mangaia', 'MG', 1),
(782, 51, 'Alajuela', 'AL', 1),
(783, 51, 'Cartago', 'CA', 1),
(784, 51, 'Guanacaste', 'GU', 1),
(785, 51, 'Heredia', 'HE', 1),
(786, 51, 'Limon', 'LI', 1),
(787, 51, 'Puntarenas', 'PU', 1),
(788, 51, 'San Jose', 'SJ', 1),
(789, 52, 'Abengourou', 'ABE', 1),
(790, 52, 'Abidjan', 'ABI', 1),
(791, 52, 'Aboisso', 'ABO', 1),
(792, 52, 'Adiake', 'ADI', 1),
(793, 52, 'Adzope', 'ADZ', 1),
(794, 52, 'Agboville', 'AGB', 1),
(795, 52, 'Agnibilekrou', 'AGN', 1),
(796, 52, 'Alepe', 'ALE', 1),
(797, 52, 'Bocanda', 'BOC', 1),
(798, 52, 'Bangolo', 'BAN', 1),
(799, 52, 'Beoumi', 'BEO', 1),
(800, 52, 'Biankouma', 'BIA', 1),
(801, 52, 'Bondoukou', 'BDK', 1),
(802, 52, 'Bongouanou', 'BGN', 1),
(803, 52, 'Bouafle', 'BFL', 1),
(804, 52, 'Bouake', 'BKE', 1),
(805, 52, 'Bouna', 'BNA', 1),
(806, 52, 'Boundiali', 'BDL', 1),
(807, 52, 'Dabakala', 'DKL', 1),
(808, 52, 'Dabou', 'DBU', 1),
(809, 52, 'Daloa', 'DAL', 1),
(810, 52, 'Danane', 'DAN', 1),
(811, 52, 'Daoukro', 'DAO', 1),
(812, 52, 'Dimbokro', 'DIM', 1),
(813, 52, 'Divo', 'DIV', 1),
(814, 52, 'Duekoue', 'DUE', 1),
(815, 52, 'Ferkessedougou', 'FER', 1),
(816, 52, 'Gagnoa', 'GAG', 1),
(817, 52, 'Grand-Bassam', 'GBA', 1),
(818, 52, 'Grand-Lahou', 'GLA', 1),
(819, 52, 'Guiglo', 'GUI', 1),
(820, 52, 'Issia', 'ISS', 1),
(821, 52, 'Jacqueville', 'JAC', 1),
(822, 52, 'Katiola', 'KAT', 1),
(823, 52, 'Korhogo', 'KOR', 1),
(824, 52, 'Lakota', 'LAK', 1),
(825, 52, 'Man', 'MAN', 1),
(826, 52, 'Mankono', 'MKN', 1),
(827, 52, 'Mbahiakro', 'MBA', 1),
(828, 52, 'Odienne', 'ODI', 1),
(829, 52, 'Oume', 'OUM', 1),
(830, 52, 'Sakassou', 'SAK', 1),
(831, 52, 'San-Pedro', 'SPE', 1),
(832, 52, 'Sassandra', 'SAS', 1),
(833, 52, 'Seguela', 'SEG', 1),
(834, 52, 'Sinfra', 'SIN', 1),
(835, 52, 'Soubre', 'SOU', 1),
(836, 52, 'Tabou', 'TAB', 1),
(837, 52, 'Tanda', 'TAN', 1),
(838, 52, 'Tiebissou', 'TIE', 1),
(839, 52, 'Tingrela', 'TIN', 1),
(840, 52, 'Tiassale', 'TIA', 1),
(841, 52, 'Touba', 'TBA', 1),
(842, 52, 'Toulepleu', 'TLP', 1),
(843, 52, 'Toumodi', 'TMD', 1),
(844, 52, 'Vavoua', 'VAV', 1),
(845, 52, 'Yamoussoukro', 'YAM', 1),
(846, 52, 'Zuenoula', 'ZUE', 1),
(847, 53, 'Bjelovar-Bilogora', 'BB', 1),
(848, 53, 'City of Zagreb', 'CZ', 1),
(849, 53, 'Dubrovnik-Neretva', 'DN', 1),
(850, 53, 'Istra', 'IS', 1),
(851, 53, 'Karlovac', 'KA', 1),
(852, 53, 'Koprivnica-Krizevci', 'KK', 1),
(853, 53, 'Krapina-Zagorje', 'KZ', 1),
(854, 53, 'Lika-Senj', 'LS', 1),
(855, 53, 'Medimurje', 'ME', 1),
(856, 53, 'Osijek-Baranja', 'OB', 1),
(857, 53, 'Pozega-Slavonia', 'PS', 1),
(858, 53, 'Primorje-Gorski Kotar', 'PG', 1),
(859, 53, 'Sibenik', 'SI', 1),
(860, 53, 'Sisak-Moslavina', 'SM', 1),
(861, 53, 'Slavonski Brod-Posavina', 'SB', 1),
(862, 53, 'Split-Dalmatia', 'SD', 1),
(863, 53, 'Varazdin', 'VA', 1),
(864, 53, 'Virovitica-Podravina', 'VP', 1),
(865, 53, 'Vukovar-Srijem', 'VS', 1),
(866, 53, 'Zadar-Knin', 'ZK', 1),
(867, 53, 'Zagreb', 'ZA', 1),
(868, 54, 'Camaguey', 'CA', 1),
(869, 54, 'Ciego de Avila', 'CD', 1),
(870, 54, 'Cienfuegos', 'CI', 1),
(871, 54, 'Ciudad de La Habana', 'CH', 1),
(872, 54, 'Granma', 'GR', 1),
(873, 54, 'Guantanamo', 'GU', 1),
(874, 54, 'Holguin', 'HO', 1),
(875, 54, 'Isla de la Juventud', 'IJ', 1),
(876, 54, 'La Habana', 'LH', 1),
(877, 54, 'Las Tunas', 'LT', 1),
(878, 54, 'Matanzas', 'MA', 1),
(879, 54, 'Pinar del Rio', 'PR', 1),
(880, 54, 'Sancti Spiritus', 'SS', 1),
(881, 54, 'Santiago de Cuba', 'SC', 1),
(882, 54, 'Villa Clara', 'VC', 1),
(883, 55, 'Famagusta', 'F', 1),
(884, 55, 'Kyrenia', 'K', 1),
(885, 55, 'Larnaca', 'A', 1),
(886, 55, 'Limassol', 'I', 1),
(887, 55, 'Nicosia', 'N', 1),
(888, 55, 'Paphos', 'P', 1),
(889, 56, 'Ústecký', 'U', 1),
(890, 56, 'Jiho', 'C', 1),
(891, 56, 'Jihomoravský', 'B', 1),
(892, 56, 'Karlovarský', 'K', 1),
(893, 56, 'Královehradecký', 'H', 1),
(894, 56, 'Liberecký', 'L', 1),
(895, 56, 'Moravskoslezský', 'T', 1),
(896, 56, 'Olomoucký', 'M', 1),
(897, 56, 'Pardubický', 'E', 1),
(898, 56, 'Plzeňský', 'P', 1),
(899, 56, 'Praha', 'A', 1),
(900, 56, 'Středo', 'S', 1),
(901, 56, 'Vyso', 'J', 1),
(902, 56, 'Zlínský', 'Z', 1),
(903, 57, 'Arhus', 'AR', 1),
(904, 57, 'Bornholm', 'BH', 1),
(905, 57, 'Copenhagen', 'CO', 1),
(906, 57, 'Faroe Islands', 'FO', 1),
(907, 57, 'Frederiksborg', 'FR', 1),
(908, 57, 'Fyn', 'FY', 1),
(909, 57, 'Kobenhavn', 'KO', 1),
(910, 57, 'Nordjylland', 'NO', 1),
(911, 57, 'Ribe', 'RI', 1),
(912, 57, 'Ringkobing', 'RK', 1),
(913, 57, 'Roskilde', 'RO', 1),
(914, 57, 'Sonderjylland', 'SO', 1),
(915, 57, 'Storstrom', 'ST', 1),
(916, 57, 'Vejle', 'VK', 1),
(917, 57, 'Vestj&aelig;lland', 'VJ', 1),
(918, 57, 'Viborg', 'VB', 1),
(919, 58, '''Ali Sabih', 'S', 1),
(920, 58, 'Dikhil', 'K', 1),
(921, 58, 'Djibouti', 'J', 1),
(922, 58, 'Obock', 'O', 1),
(923, 58, 'Tadjoura', 'T', 1),
(924, 59, 'Saint Andrew Parish', 'AND', 1),
(925, 59, 'Saint David Parish', 'DAV', 1),
(926, 59, 'Saint George Parish', 'GEO', 1),
(927, 59, 'Saint John Parish', 'JOH', 1),
(928, 59, 'Saint Joseph Parish', 'JOS', 1),
(929, 59, 'Saint Luke Parish', 'LUK', 1),
(930, 59, 'Saint Mark Parish', 'MAR', 1),
(931, 59, 'Saint Patrick Parish', 'PAT', 1),
(932, 59, 'Saint Paul Parish', 'PAU', 1),
(933, 59, 'Saint Peter Parish', 'PET', 1),
(934, 60, 'Distrito Nacional', 'DN', 1),
(935, 60, 'Azua', 'AZ', 1),
(936, 60, 'Baoruco', 'BC', 1),
(937, 60, 'Barahona', 'BH', 1),
(938, 60, 'Dajabon', 'DJ', 1),
(939, 60, 'Duarte', 'DU', 1),
(940, 60, 'Elias Pina', 'EL', 1),
(941, 60, 'El Seybo', 'SY', 1),
(942, 60, 'Espaillat', 'ET', 1),
(943, 60, 'Hato Mayor', 'HM', 1),
(944, 60, 'Independencia', 'IN', 1),
(945, 60, 'La Altagracia', 'AL', 1),
(946, 60, 'La Romana', 'RO', 1),
(947, 60, 'La Vega', 'VE', 1),
(948, 60, 'Maria Trinidad Sanchez', 'MT', 1),
(949, 60, 'Monsenor Nouel', 'MN', 1),
(950, 60, 'Monte Cristi', 'MC', 1),
(951, 60, 'Monte Plata', 'MP', 1),
(952, 60, 'Pedernales', 'PD', 1),
(953, 60, 'Peravia (Bani)', 'PR', 1),
(954, 60, 'Puerto Plata', 'PP', 1),
(955, 60, 'Salcedo', 'SL', 1),
(956, 60, 'Samana', 'SM', 1),
(957, 60, 'Sanchez Ramirez', 'SH', 1),
(958, 60, 'San Cristobal', 'SC', 1),
(959, 60, 'San Jose de Ocoa', 'JO', 1),
(960, 60, 'San Juan', 'SJ', 1),
(961, 60, 'San Pedro de Macoris', 'PM', 1),
(962, 60, 'Santiago', 'SA', 1),
(963, 60, 'Santiago Rodriguez', 'ST', 1),
(964, 60, 'Santo Domingo', 'SD', 1),
(965, 60, 'Valverde', 'VA', 1),
(966, 61, 'Aileu', 'AL', 1),
(967, 61, 'Ainaro', 'AN', 1),
(968, 61, 'Baucau', 'BA', 1),
(969, 61, 'Bobonaro', 'BO', 1),
(970, 61, 'Cova Lima', 'CO', 1),
(971, 61, 'Dili', 'DI', 1),
(972, 61, 'Ermera', 'ER', 1),
(973, 61, 'Lautem', 'LA', 1),
(974, 61, 'Liquica', 'LI', 1),
(975, 61, 'Manatuto', 'MT', 1),
(976, 61, 'Manufahi', 'MF', 1),
(977, 61, 'Oecussi', 'OE', 1),
(978, 61, 'Viqueque', 'VI', 1),
(979, 62, 'Azuay', 'AZU', 1),
(980, 62, 'Bolivar', 'BOL', 1),
(981, 62, 'Ca&ntilde;ar', 'CAN', 1),
(982, 62, 'Carchi', 'CAR', 1),
(983, 62, 'Chimborazo', 'CHI', 1),
(984, 62, 'Cotopaxi', 'COT', 1),
(985, 62, 'El Oro', 'EOR', 1),
(986, 62, 'Esmeraldas', 'ESM', 1),
(987, 62, 'Gal&aacute;pagos', 'GPS', 1),
(988, 62, 'Guayas', 'GUA', 1),
(989, 62, 'Imbabura', 'IMB', 1),
(990, 62, 'Loja', 'LOJ', 1),
(991, 62, 'Los Rios', 'LRO', 1),
(992, 62, 'Manab&iacute;', 'MAN', 1),
(993, 62, 'Morona Santiago', 'MSA', 1),
(994, 62, 'Napo', 'NAP', 1),
(995, 62, 'Orellana', 'ORE', 1),
(996, 62, 'Pastaza', 'PAS', 1),
(997, 62, 'Pichincha', 'PIC', 1),
(998, 62, 'Sucumb&iacute;os', 'SUC', 1),
(999, 62, 'Tungurahua', 'TUN', 1),
(1000, 62, 'Zamora Chinchipe', 'ZCH', 1),
(1001, 63, 'Ad Daqahliyah', 'DHY', 1),
(1002, 63, 'Al Bahr al Ahmar', 'BAM', 1),
(1003, 63, 'Al Buhayrah', 'BHY', 1),
(1004, 63, 'Al Fayyum', 'FYM', 1),
(1005, 63, 'Al Gharbiyah', 'GBY', 1),
(1006, 63, 'Al Iskandariyah', 'IDR', 1),
(1007, 63, 'Al Isma''iliyah', 'IML', 1),
(1008, 63, 'Al Jizah', 'JZH', 1),
(1009, 63, 'Al Minufiyah', 'MFY', 1),
(1010, 63, 'Al Minya', 'MNY', 1),
(1011, 63, 'Al Qahirah', 'QHR', 1),
(1012, 63, 'Al Qalyubiyah', 'QLY', 1),
(1013, 63, 'Al Wadi al Jadid', 'WJD', 1),
(1014, 63, 'Ash Sharqiyah', 'SHQ', 1),
(1015, 63, 'As Suways', 'SWY', 1),
(1016, 63, 'Aswan', 'ASW', 1),
(1017, 63, 'Asyut', 'ASY', 1),
(1018, 63, 'Bani Suwayf', 'BSW', 1),
(1019, 63, 'Bur Sa''id', 'BSD', 1),
(1020, 63, 'Dumyat', 'DMY', 1),
(1021, 63, 'Janub Sina''', 'JNS', 1),
(1022, 63, 'Kafr ash Shaykh', 'KSH', 1),
(1023, 63, 'Matruh', 'MAT', 1),
(1024, 63, 'Qina', 'QIN', 1),
(1025, 63, 'Shamal Sina''', 'SHS', 1),
(1026, 63, 'Suhaj', 'SUH', 1),
(1027, 64, 'Ahuachapan', 'AH', 1),
(1028, 64, 'Cabanas', 'CA', 1),
(1029, 64, 'Chalatenango', 'CH', 1),
(1030, 64, 'Cuscatlan', 'CU', 1),
(1031, 64, 'La Libertad', 'LB', 1),
(1032, 64, 'La Paz', 'PZ', 1),
(1033, 64, 'La Union', 'UN', 1),
(1034, 64, 'Morazan', 'MO', 1),
(1035, 64, 'San Miguel', 'SM', 1),
(1036, 64, 'San Salvador', 'SS', 1),
(1037, 64, 'San Vicente', 'SV', 1),
(1038, 64, 'Santa Ana', 'SA', 1),
(1039, 64, 'Sonsonate', 'SO', 1),
(1040, 64, 'Usulutan', 'US', 1),
(1041, 65, 'Provincia Annobon', 'AN', 1),
(1042, 65, 'Provincia Bioko Norte', 'BN', 1),
(1043, 65, 'Provincia Bioko Sur', 'BS', 1),
(1044, 65, 'Provincia Centro Sur', 'CS', 1),
(1045, 65, 'Provincia Kie-Ntem', 'KN', 1),
(1046, 65, 'Provincia Litoral', 'LI', 1),
(1047, 65, 'Provincia Wele-Nzas', 'WN', 1),
(1048, 66, 'Central (Maekel)', 'MA', 1),
(1049, 66, 'Anseba (Keren)', 'KE', 1),
(1050, 66, 'Southern Red Sea (Debub-Keih-Bahri)', 'DK', 1),
(1051, 66, 'Northern Red Sea (Semien-Keih-Bahri)', 'SK', 1),
(1052, 66, 'Southern (Debub)', 'DE', 1),
(1053, 66, 'Gash-Barka (Barentu)', 'BR', 1),
(1054, 67, 'Harjumaa (Tallinn)', 'HA', 1),
(1055, 67, 'Hiiumaa (Kardla)', 'HI', 1),
(1056, 67, 'Ida-Virumaa (Johvi)', 'IV', 1),
(1057, 67, 'Jarvamaa (Paide)', 'JA', 1),
(1058, 67, 'Jogevamaa (Jogeva)', 'JO', 1),
(1059, 67, 'Laane-Virumaa (Rakvere)', 'LV', 1),
(1060, 67, 'Laanemaa (Haapsalu)', 'LA', 1),
(1061, 67, 'Parnumaa (Parnu)', 'PA', 1),
(1062, 67, 'Polvamaa (Polva)', 'PO', 1),
(1063, 67, 'Raplamaa (Rapla)', 'RA', 1),
(1064, 67, 'Saaremaa (Kuessaare)', 'SA', 1),
(1065, 67, 'Tartumaa (Tartu)', 'TA', 1),
(1066, 67, 'Valgamaa (Valga)', 'VA', 1),
(1067, 67, 'Viljandimaa (Viljandi)', 'VI', 1),
(1068, 67, 'Vorumaa (Voru)', 'VO', 1),
(1069, 68, 'Afar', 'AF', 1),
(1070, 68, 'Amhara', 'AH', 1),
(1071, 68, 'Benishangul-Gumaz', 'BG', 1),
(1072, 68, 'Gambela', 'GB', 1),
(1073, 68, 'Hariai', 'HR', 1),
(1074, 68, 'Oromia', 'OR', 1),
(1075, 68, 'Somali', 'SM', 1),
(1076, 68, 'Southern Nations - Nationalities and Peoples Region', 'SN', 1),
(1077, 68, 'Tigray', 'TG', 1),
(1078, 68, 'Addis Ababa', 'AA', 1),
(1079, 68, 'Dire Dawa', 'DD', 1),
(1080, 71, 'Central Division', 'C', 1),
(1081, 71, 'Northern Division', 'N', 1),
(1082, 71, 'Eastern Division', 'E', 1),
(1083, 71, 'Western Division', 'W', 1),
(1084, 71, 'Rotuma', 'R', 1),
(1085, 72, 'Ahvenanmaan Laani', 'AL', 1),
(1086, 72, 'Etela-Suomen Laani', 'ES', 1),
(1087, 72, 'Ita-Suomen Laani', 'IS', 1),
(1088, 72, 'Lansi-Suomen Laani', 'LS', 1),
(1089, 72, 'Lapin Lanani', 'LA', 1),
(1090, 72, 'Oulun Laani', 'OU', 1),
(1114, 74, 'Ain', '01', 1),
(1115, 74, 'Aisne', '02', 1),
(1116, 74, 'Allier', '03', 1),
(1117, 74, 'Alpes de Haute Provence', '04', 1),
(1118, 74, 'Hautes-Alpes', '05', 1),
(1119, 74, 'Alpes Maritimes', '06', 1),
(1120, 74, 'Ard&egrave;che', '07', 1),
(1121, 74, 'Ardennes', '08', 1),
(1122, 74, 'Ari&egrave;ge', '09', 1),
(1123, 74, 'Aube', '10', 1),
(1124, 74, 'Aude', '11', 1),
(1125, 74, 'Aveyron', '12', 1),
(1126, 74, 'Bouches du Rh&ocirc;ne', '13', 1),
(1127, 74, 'Calvados', '14', 1),
(1128, 74, 'Cantal', '15', 1),
(1129, 74, 'Charente', '16', 1),
(1130, 74, 'Charente Maritime', '17', 1),
(1131, 74, 'Cher', '18', 1),
(1132, 74, 'Corr&egrave;ze', '19', 1),
(1133, 74, 'Corse du Sud', '2A', 1),
(1134, 74, 'Haute Corse', '2B', 1),
(1135, 74, 'C&ocirc;te d&#039;or', '21', 1),
(1136, 74, 'C&ocirc;tes d&#039;Armor', '22', 1),
(1137, 74, 'Creuse', '23', 1),
(1138, 74, 'Dordogne', '24', 1),
(1139, 74, 'Doubs', '25', 1),
(1140, 74, 'Dr&ocirc;me', '26', 1),
(1141, 74, 'Eure', '27', 1),
(1142, 74, 'Eure et Loir', '28', 1),
(1143, 74, 'Finist&egrave;re', '29', 1),
(1144, 74, 'Gard', '30', 1),
(1145, 74, 'Haute Garonne', '31', 1),
(1146, 74, 'Gers', '32', 1),
(1147, 74, 'Gironde', '33', 1),
(1148, 74, 'H&eacute;rault', '34', 1),
(1149, 74, 'Ille et Vilaine', '35', 1),
(1150, 74, 'Indre', '36', 1),
(1151, 74, 'Indre et Loire', '37', 1),
(1152, 74, 'Is&eacute;re', '38', 1),
(1153, 74, 'Jura', '39', 1),
(1154, 74, 'Landes', '40', 1),
(1155, 74, 'Loir et Cher', '41', 1),
(1156, 74, 'Loire', '42', 1),
(1157, 74, 'Haute Loire', '43', 1),
(1158, 74, 'Loire Atlantique', '44', 1),
(1159, 74, 'Loiret', '45', 1),
(1160, 74, 'Lot', '46', 1),
(1161, 74, 'Lot et Garonne', '47', 1),
(1162, 74, 'Loz&egrave;re', '48', 1),
(1163, 74, 'Maine et Loire', '49', 1),
(1164, 74, 'Manche', '50', 1),
(1165, 74, 'Marne', '51', 1),
(1166, 74, 'Haute Marne', '52', 1),
(1167, 74, 'Mayenne', '53', 1),
(1168, 74, 'Meurthe et Moselle', '54', 1),
(1169, 74, 'Meuse', '55', 1),
(1170, 74, 'Morbihan', '56', 1),
(1171, 74, 'Moselle', '57', 1),
(1172, 74, 'Ni&egrave;vre', '58', 1),
(1173, 74, 'Nord', '59', 1),
(1174, 74, 'Oise', '60', 1),
(1175, 74, 'Orne', '61', 1),
(1176, 74, 'Pas de Calais', '62', 1),
(1177, 74, 'Puy de D&ocirc;me', '63', 1),
(1178, 74, 'Pyr&eacute;n&eacute;es Atlantiques', '64', 1),
(1179, 74, 'Hautes Pyr&eacute;n&eacute;es', '65', 1),
(1180, 74, 'Pyr&eacute;n&eacute;es Orientales', '66', 1),
(1181, 74, 'Bas Rhin', '67', 1),
(1182, 74, 'Haut Rhin', '68', 1),
(1183, 74, 'Rh&ocirc;ne', '69', 1),
(1184, 74, 'Haute Sa&ocirc;ne', '70', 1),
(1185, 74, 'Sa&ocirc;ne et Loire', '71', 1),
(1186, 74, 'Sarthe', '72', 1),
(1187, 74, 'Savoie', '73', 1),
(1188, 74, 'Haute Savoie', '74', 1),
(1189, 74, 'Paris', '75', 1),
(1190, 74, 'Seine Maritime', '76', 1),
(1191, 74, 'Seine et Marne', '77', 1),
(1192, 74, 'Yvelines', '78', 1),
(1193, 74, 'Deux S&egrave;vres', '79', 1),
(1194, 74, 'Somme', '80', 1),
(1195, 74, 'Tarn', '81', 1),
(1196, 74, 'Tarn et Garonne', '82', 1),
(1197, 74, 'Var', '83', 1),
(1198, 74, 'Vaucluse', '84', 1),
(1199, 74, 'Vend&eacute;e', '85', 1),
(1200, 74, 'Vienne', '86', 1),
(1201, 74, 'Haute Vienne', '87', 1),
(1202, 74, 'Vosges', '88', 1),
(1203, 74, 'Yonne', '89', 1),
(1204, 74, 'Territoire de Belfort', '90', 1),
(1205, 74, 'Essonne', '91', 1),
(1206, 74, 'Hauts de Seine', '92', 1),
(1207, 74, 'Seine St-Denis', '93', 1),
(1208, 74, 'Val de Marne', '94', 1),
(1209, 74, 'Val d''Oise', '95', 1),
(1210, 76, 'Archipel des Marquises', 'M', 1),
(1211, 76, 'Archipel des Tuamotu', 'T', 1),
(1212, 76, 'Archipel des Tubuai', 'I', 1),
(1213, 76, 'Iles du Vent', 'V', 1),
(1214, 76, 'Iles Sous-le-Vent', 'S', 1),
(1215, 77, 'Iles Crozet', 'C', 1),
(1216, 77, 'Iles Kerguelen', 'K', 1),
(1217, 77, 'Ile Amsterdam', 'A', 1),
(1218, 77, 'Ile Saint-Paul', 'P', 1),
(1219, 77, 'Adelie Land', 'D', 1),
(1220, 78, 'Estuaire', 'ES', 1),
(1221, 78, 'Haut-Ogooue', 'HO', 1),
(1222, 78, 'Moyen-Ogooue', 'MO', 1),
(1223, 78, 'Ngounie', 'NG', 1),
(1224, 78, 'Nyanga', 'NY', 1),
(1225, 78, 'Ogooue-Ivindo', 'OI', 1),
(1226, 78, 'Ogooue-Lolo', 'OL', 1),
(1227, 78, 'Ogooue-Maritime', 'OM', 1),
(1228, 78, 'Woleu-Ntem', 'WN', 1),
(1229, 79, 'Banjul', 'BJ', 1),
(1230, 79, 'Basse', 'BS', 1),
(1231, 79, 'Brikama', 'BR', 1),
(1232, 79, 'Janjangbure', 'JA', 1),
(1233, 79, 'Kanifeng', 'KA', 1),
(1234, 79, 'Kerewan', 'KE', 1),
(1235, 79, 'Kuntaur', 'KU', 1),
(1236, 79, 'Mansakonko', 'MA', 1),
(1237, 79, 'Lower River', 'LR', 1),
(1238, 79, 'Central River', 'CR', 1),
(1239, 79, 'North Bank', 'NB', 1),
(1240, 79, 'Upper River', 'UR', 1),
(1241, 79, 'Western', 'WE', 1),
(1242, 80, 'Abkhazia', 'AB', 1),
(1243, 80, 'Ajaria', 'AJ', 1),
(1244, 80, 'Tbilisi', 'TB', 1),
(1245, 80, 'Guria', 'GU', 1),
(1246, 80, 'Imereti', 'IM', 1),
(1247, 80, 'Kakheti', 'KA', 1),
(1248, 80, 'Kvemo Kartli', 'KK', 1),
(1249, 80, 'Mtskheta-Mtianeti', 'MM', 1),
(1250, 80, 'Racha Lechkhumi and Kvemo Svanet', 'RL', 1),
(1251, 80, 'Samegrelo-Zemo Svaneti', 'SZ', 1),
(1252, 80, 'Samtskhe-Javakheti', 'SJ', 1),
(1253, 80, 'Shida Kartli', 'SK', 1),
(1254, 81, 'Baden-W&uuml;rttemberg', 'BAW', 1),
(1255, 81, 'Bayern', 'BAY', 1),
(1256, 81, 'Berlin', 'BER', 1),
(1257, 81, 'Brandenburg', 'BRG', 1),
(1258, 81, 'Bremen', 'BRE', 1),
(1259, 81, 'Hamburg', 'HAM', 1),
(1260, 81, 'Hessen', 'HES', 1),
(1261, 81, 'Mecklenburg-Vorpommern', 'MEC', 1),
(1262, 81, 'Niedersachsen', 'NDS', 1),
(1263, 81, 'Nordrhein-Westfalen', 'NRW', 1),
(1264, 81, 'Rheinland-Pfalz', 'RHE', 1),
(1265, 81, 'Saarland', 'SAR', 1),
(1266, 81, 'Sachsen', 'SAS', 1),
(1267, 81, 'Sachsen-Anhalt', 'SAC', 1),
(1268, 81, 'Schleswig-Holstein', 'SCN', 1),
(1269, 81, 'Th&uuml;ringen', 'THE', 1),
(1270, 82, 'Ashanti Region', 'AS', 1),
(1271, 82, 'Brong-Ahafo Region', 'BA', 1),
(1272, 82, 'Central Region', 'CE', 1),
(1273, 82, 'Eastern Region', 'EA', 1),
(1274, 82, 'Greater Accra Region', 'GA', 1),
(1275, 82, 'Northern Region', 'NO', 1),
(1276, 82, 'Upper East Region', 'UE', 1),
(1277, 82, 'Upper West Region', 'UW', 1),
(1278, 82, 'Volta Region', 'VO', 1),
(1279, 82, 'Western Region', 'WE', 1),
(1280, 84, 'Attica', 'AT', 1),
(1281, 84, 'Central Greece', 'CN', 1),
(1282, 84, 'Central Macedonia', 'CM', 1),
(1283, 84, 'Crete', 'CR', 1),
(1284, 84, 'East Macedonia and Thrace', 'EM', 1),
(1285, 84, 'Epirus', 'EP', 1),
(1286, 84, 'Ionian Islands', 'II', 1),
(1287, 84, 'North Aegean', 'NA', 1),
(1288, 84, 'Peloponnesos', 'PP', 1),
(1289, 84, 'South Aegean', 'SA', 1),
(1290, 84, 'Thessaly', 'TH', 1),
(1291, 84, 'West Greece', 'WG', 1),
(1292, 84, 'West Macedonia', 'WM', 1),
(1293, 85, 'Avannaa', 'A', 1),
(1294, 85, 'Tunu', 'T', 1),
(1295, 85, 'Kitaa', 'K', 1),
(1296, 86, 'Saint Andrew', 'A', 1),
(1297, 86, 'Saint David', 'D', 1),
(1298, 86, 'Saint George', 'G', 1),
(1299, 86, 'Saint John', 'J', 1),
(1300, 86, 'Saint Mark', 'M', 1),
(1301, 86, 'Saint Patrick', 'P', 1),
(1302, 86, 'Carriacou', 'C', 1),
(1303, 86, 'Petit Martinique', 'Q', 1),
(1304, 89, 'Alta Verapaz', 'AV', 1),
(1305, 89, 'Baja Verapaz', 'BV', 1),
(1306, 89, 'Chimaltenango', 'CM', 1),
(1307, 89, 'Chiquimula', 'CQ', 1),
(1308, 89, 'El Peten', 'PE', 1),
(1309, 89, 'El Progreso', 'PR', 1),
(1310, 89, 'El Quiche', 'QC', 1),
(1311, 89, 'Escuintla', 'ES', 1),
(1312, 89, 'Guatemala', 'GU', 1),
(1313, 89, 'Huehuetenango', 'HU', 1),
(1314, 89, 'Izabal', 'IZ', 1),
(1315, 89, 'Jalapa', 'JA', 1),
(1316, 89, 'Jutiapa', 'JU', 1),
(1317, 89, 'Quetzaltenango', 'QZ', 1),
(1318, 89, 'Retalhuleu', 'RE', 1),
(1319, 89, 'Sacatepequez', 'ST', 1),
(1320, 89, 'San Marcos', 'SM', 1),
(1321, 89, 'Santa Rosa', 'SR', 1),
(1322, 89, 'Solola', 'SO', 1),
(1323, 89, 'Suchitepequez', 'SU', 1),
(1324, 89, 'Totonicapan', 'TO', 1),
(1325, 89, 'Zacapa', 'ZA', 1),
(1326, 90, 'Conakry', 'CNK', 1),
(1327, 90, 'Beyla', 'BYL', 1),
(1328, 90, 'Boffa', 'BFA', 1),
(1329, 90, 'Boke', 'BOK', 1),
(1330, 90, 'Coyah', 'COY', 1),
(1331, 90, 'Dabola', 'DBL', 1),
(1332, 90, 'Dalaba', 'DLB', 1),
(1333, 90, 'Dinguiraye', 'DGR', 1),
(1334, 90, 'Dubreka', 'DBR', 1),
(1335, 90, 'Faranah', 'FRN', 1),
(1336, 90, 'Forecariah', 'FRC', 1),
(1337, 90, 'Fria', 'FRI', 1),
(1338, 90, 'Gaoual', 'GAO', 1),
(1339, 90, 'Gueckedou', 'GCD', 1),
(1340, 90, 'Kankan', 'KNK', 1),
(1341, 90, 'Kerouane', 'KRN', 1),
(1342, 90, 'Kindia', 'KND', 1),
(1343, 90, 'Kissidougou', 'KSD', 1),
(1344, 90, 'Koubia', 'KBA', 1),
(1345, 90, 'Koundara', 'KDA', 1),
(1346, 90, 'Kouroussa', 'KRA', 1),
(1347, 90, 'Labe', 'LAB', 1),
(1348, 90, 'Lelouma', 'LLM', 1),
(1349, 90, 'Lola', 'LOL', 1),
(1350, 90, 'Macenta', 'MCT', 1),
(1351, 90, 'Mali', 'MAL', 1),
(1352, 90, 'Mamou', 'MAM', 1),
(1353, 90, 'Mandiana', 'MAN', 1),
(1354, 90, 'Nzerekore', 'NZR', 1),
(1355, 90, 'Pita', 'PIT', 1),
(1356, 90, 'Siguiri', 'SIG', 1),
(1357, 90, 'Telimele', 'TLM', 1),
(1358, 90, 'Tougue', 'TOG', 1),
(1359, 90, 'Yomou', 'YOM', 1),
(1360, 91, 'Bafata Region', 'BF', 1),
(1361, 91, 'Biombo Region', 'BB', 1),
(1362, 91, 'Bissau Region', 'BS', 1),
(1363, 91, 'Bolama Region', 'BL', 1),
(1364, 91, 'Cacheu Region', 'CA', 1),
(1365, 91, 'Gabu Region', 'GA', 1),
(1366, 91, 'Oio Region', 'OI', 1),
(1367, 91, 'Quinara Region', 'QU', 1),
(1368, 91, 'Tombali Region', 'TO', 1),
(1369, 92, 'Barima-Waini', 'BW', 1),
(1370, 92, 'Cuyuni-Mazaruni', 'CM', 1),
(1371, 92, 'Demerara-Mahaica', 'DM', 1),
(1372, 92, 'East Berbice-Corentyne', 'EC', 1),
(1373, 92, 'Essequibo Islands-West Demerara', 'EW', 1),
(1374, 92, 'Mahaica-Berbice', 'MB', 1),
(1375, 92, 'Pomeroon-Supenaam', 'PM', 1),
(1376, 92, 'Potaro-Siparuni', 'PI', 1),
(1377, 92, 'Upper Demerara-Berbice', 'UD', 1),
(1378, 92, 'Upper Takutu-Upper Essequibo', 'UT', 1),
(1379, 93, 'Artibonite', 'AR', 1),
(1380, 93, 'Centre', 'CE', 1),
(1381, 93, 'Grand''Anse', 'GA', 1),
(1382, 93, 'Nord', 'ND', 1),
(1383, 93, 'Nord-Est', 'NE', 1),
(1384, 93, 'Nord-Ouest', 'NO', 1),
(1385, 93, 'Ouest', 'OU', 1),
(1386, 93, 'Sud', 'SD', 1),
(1387, 93, 'Sud-Est', 'SE', 1),
(1388, 94, 'Flat Island', 'F', 1),
(1389, 94, 'McDonald Island', 'M', 1),
(1390, 94, 'Shag Island', 'S', 1),
(1391, 94, 'Heard Island', 'H', 1),
(1392, 95, 'Atlantida', 'AT', 1),
(1393, 95, 'Choluteca', 'CH', 1),
(1394, 95, 'Colon', 'CL', 1),
(1395, 95, 'Comayagua', 'CM', 1),
(1396, 95, 'Copan', 'CP', 1),
(1397, 95, 'Cortes', 'CR', 1),
(1398, 95, 'El Paraiso', 'PA', 1),
(1399, 95, 'Francisco Morazan', 'FM', 1),
(1400, 95, 'Gracias a Dios', 'GD', 1),
(1401, 95, 'Intibuca', 'IN', 1),
(1402, 95, 'Islas de la Bahia (Bay Islands)', 'IB', 1),
(1403, 95, 'La Paz', 'PZ', 1),
(1404, 95, 'Lempira', 'LE', 1),
(1405, 95, 'Ocotepeque', 'OC', 1),
(1406, 95, 'Olancho', 'OL', 1),
(1407, 95, 'Santa Barbara', 'SB', 1),
(1408, 95, 'Valle', 'VA', 1),
(1409, 95, 'Yoro', 'YO', 1),
(1410, 96, 'Central and Western Hong Kong Island', 'HCW', 1),
(1411, 96, 'Eastern Hong Kong Island', 'HEA', 1),
(1412, 96, 'Southern Hong Kong Island', 'HSO', 1),
(1413, 96, 'Wan Chai Hong Kong Island', 'HWC', 1),
(1414, 96, 'Kowloon City Kowloon', 'KKC', 1),
(1415, 96, 'Kwun Tong Kowloon', 'KKT', 1),
(1416, 96, 'Sham Shui Po Kowloon', 'KSS', 1),
(1417, 96, 'Wong Tai Sin Kowloon', 'KWT', 1),
(1418, 96, 'Yau Tsim Mong Kowloon', 'KYT', 1),
(1419, 96, 'Islands New Territories', 'NIS', 1),
(1420, 96, 'Kwai Tsing New Territories', 'NKT', 1),
(1421, 96, 'North New Territories', 'NNO', 1),
(1422, 96, 'Sai Kung New Territories', 'NSK', 1),
(1423, 96, 'Sha Tin New Territories', 'NST', 1),
(1424, 96, 'Tai Po New Territories', 'NTP', 1),
(1425, 96, 'Tsuen Wan New Territories', 'NTW', 1),
(1426, 96, 'Tuen Mun New Territories', 'NTM', 1),
(1427, 96, 'Yuen Long New Territories', 'NYL', 1),
(1428, 97, 'Bacs-Kiskun', 'BK', 1),
(1429, 97, 'Baranya', 'BA', 1),
(1430, 97, 'Bekes', 'BE', 1),
(1431, 97, 'Bekescsaba', 'BS', 1),
(1432, 97, 'Borsod-Abauj-Zemplen', 'BZ', 1),
(1433, 97, 'Budapest', 'BU', 1),
(1434, 97, 'Csongrad', 'CS', 1),
(1435, 97, 'Debrecen', 'DE', 1),
(1436, 97, 'Dunaujvaros', 'DU', 1),
(1437, 97, 'Eger', 'EG', 1),
(1438, 97, 'Fejer', 'FE', 1),
(1439, 97, 'Gyor', 'GY', 1),
(1440, 97, 'Gyor-Moson-Sopron', 'GM', 1),
(1441, 97, 'Hajdu-Bihar', 'HB', 1),
(1442, 97, 'Heves', 'HE', 1),
(1443, 97, 'Hodmezovasarhely', 'HO', 1),
(1444, 97, 'Jasz-Nagykun-Szolnok', 'JN', 1),
(1445, 97, 'Kaposvar', 'KA', 1),
(1446, 97, 'Kecskemet', 'KE', 1),
(1447, 97, 'Komarom-Esztergom', 'KO', 1),
(1448, 97, 'Miskolc', 'MI', 1),
(1449, 97, 'Nagykanizsa', 'NA', 1),
(1450, 97, 'Nograd', 'NO', 1),
(1451, 97, 'Nyiregyhaza', 'NY', 1),
(1452, 97, 'Pecs', 'PE', 1),
(1453, 97, 'Pest', 'PS', 1),
(1454, 97, 'Somogy', 'SO', 1),
(1455, 97, 'Sopron', 'SP', 1),
(1456, 97, 'Szabolcs-Szatmar-Bereg', 'SS', 1),
(1457, 97, 'Szeged', 'SZ', 1),
(1458, 97, 'Szekesfehervar', 'SE', 1),
(1459, 97, 'Szolnok', 'SL', 1),
(1460, 97, 'Szombathely', 'SM', 1),
(1461, 97, 'Tatabanya', 'TA', 1),
(1462, 97, 'Tolna', 'TO', 1),
(1463, 97, 'Vas', 'VA', 1),
(1464, 97, 'Veszprem', 'VE', 1),
(1465, 97, 'Zala', 'ZA', 1),
(1466, 97, 'Zalaegerszeg', 'ZZ', 1),
(1467, 98, 'Austurland', 'AL', 1),
(1468, 98, 'Hofuoborgarsvaeoi', 'HF', 1),
(1469, 98, 'Norourland eystra', 'NE', 1),
(1470, 98, 'Norourland vestra', 'NV', 1),
(1471, 98, 'Suourland', 'SL', 1),
(1472, 98, 'Suournes', 'SN', 1),
(1473, 98, 'Vestfiroir', 'VF', 1),
(1474, 98, 'Vesturland', 'VL', 1),
(1475, 99, 'Andaman and Nicobar Islands', 'AN', 1),
(1476, 99, 'Andhra Pradesh', 'AP', 1),
(1477, 99, 'Arunachal Pradesh', 'AR', 1),
(1478, 99, 'Assam', 'AS', 1),
(1479, 99, 'Bihar', 'BI', 1),
(1480, 99, 'Chandigarh', 'CH', 1),
(1481, 99, 'Dadra and Nagar Haveli', 'DA', 1),
(1482, 99, 'Daman and Diu', 'DM', 1),
(1483, 99, 'Delhi', 'DE', 1),
(1484, 99, 'Goa', 'GO', 1),
(1485, 99, 'Gujarat', 'GU', 1),
(1486, 99, 'Haryana', 'HA', 1),
(1487, 99, 'Himachal Pradesh', 'HP', 1),
(1488, 99, 'Jammu and Kashmir', 'JA', 1),
(1489, 99, 'Karnataka', 'KA', 1),
(1490, 99, 'Kerala', 'KE', 1),
(1491, 99, 'Lakshadweep Islands', 'LI', 1),
(1492, 99, 'Madhya Pradesh', 'MP', 1),
(1493, 99, 'Maharashtra', 'MA', 1),
(1494, 99, 'Manipur', 'MN', 1),
(1495, 99, 'Meghalaya', 'ME', 1),
(1496, 99, 'Mizoram', 'MI', 1),
(1497, 99, 'Nagaland', 'NA', 1),
(1498, 99, 'Odisha', 'OR', 1),
(1499, 99, 'Pondicherry', 'PO', 1),
(1500, 99, 'Punjab', 'PU', 1),
(1501, 99, 'Rajasthan', 'RA', 1),
(1502, 99, 'Sikkim', 'SI', 1),
(1503, 99, 'Tamil Nadu', 'TN', 1),
(1504, 99, 'Tripura', 'TR', 1),
(1505, 99, 'Uttar Pradesh', 'UP', 1),
(1506, 99, 'West Bengal', 'WB', 1),
(1507, 100, 'Aceh', 'AC', 1),
(1508, 100, 'Bali', 'BA', 1),
(1509, 100, 'Banten', 'BT', 1),
(1510, 100, 'Bengkulu', 'BE', 1),
(1511, 100, 'BoDeTaBek', 'BD', 1),
(1512, 100, 'Gorontalo', 'GO', 1),
(1513, 100, 'Jakarta Raya', 'JK', 1),
(1514, 100, 'Jambi', 'JA', 1),
(1515, 100, 'Jawa Barat', 'JB', 1),
(1516, 100, 'Jawa Tengah', 'JT', 1),
(1517, 100, 'Jawa Timur', 'JI', 1),
(1518, 100, 'Kalimantan Barat', 'KB', 1),
(1519, 100, 'Kalimantan Selatan', 'KS', 1),
(1520, 100, 'Kalimantan Tengah', 'KT', 1),
(1521, 100, 'Kalimantan Timur', 'KI', 1),
(1522, 100, 'Kepulauan Bangka Belitung', 'BB', 1),
(1523, 100, 'Lampung', 'LA', 1),
(1524, 100, 'Maluku', 'MA', 1),
(1525, 100, 'Maluku Utara', 'MU', 1),
(1526, 100, 'Nusa Tenggara Barat', 'NB', 1),
(1527, 100, 'Nusa Tenggara Timur', 'NT', 1),
(1528, 100, 'Papua', 'PA', 1),
(1529, 100, 'Riau', 'RI', 1),
(1530, 100, 'Sulawesi Selatan', 'SN', 1),
(1531, 100, 'Sulawesi Tengah', 'ST', 1),
(1532, 100, 'Sulawesi Tenggara', 'SG', 1),
(1533, 100, 'Sulawesi Utara', 'SA', 1),
(1534, 100, 'Sumatera Barat', 'SB', 1),
(1535, 100, 'Sumatera Selatan', 'SS', 1),
(1536, 100, 'Sumatera Utara', 'SU', 1),
(1537, 100, 'Yogyakarta', 'YO', 1),
(1538, 101, 'Tehran', 'TEH', 1),
(1539, 101, 'Qom', 'QOM', 1),
(1540, 101, 'Markazi', 'MKZ', 1),
(1541, 101, 'Qazvin', 'QAZ', 1),
(1542, 101, 'Gilan', 'GIL', 1),
(1543, 101, 'Ardabil', 'ARD', 1),
(1544, 101, 'Zanjan', 'ZAN', 1),
(1545, 101, 'East Azarbaijan', 'EAZ', 1),
(1546, 101, 'West Azarbaijan', 'WEZ', 1),
(1547, 101, 'Kurdistan', 'KRD', 1),
(1548, 101, 'Hamadan', 'HMD', 1),
(1549, 101, 'Kermanshah', 'KRM', 1),
(1550, 101, 'Ilam', 'ILM', 1),
(1551, 101, 'Lorestan', 'LRS', 1),
(1552, 101, 'Khuzestan', 'KZT', 1),
(1553, 101, 'Chahar Mahaal and Bakhtiari', 'CMB', 1),
(1554, 101, 'Kohkiluyeh and Buyer Ahmad', 'KBA', 1),
(1555, 101, 'Bushehr', 'BSH', 1),
(1556, 101, 'Fars', 'FAR', 1),
(1557, 101, 'Hormozgan', 'HRM', 1),
(1558, 101, 'Sistan and Baluchistan', 'SBL', 1),
(1559, 101, 'Kerman', 'KRB', 1),
(1560, 101, 'Yazd', 'YZD', 1),
(1561, 101, 'Esfahan', 'EFH', 1),
(1562, 101, 'Semnan', 'SMN', 1),
(1563, 101, 'Mazandaran', 'MZD', 1),
(1564, 101, 'Golestan', 'GLS', 1),
(1565, 101, 'North Khorasan', 'NKH', 1),
(1566, 101, 'Razavi Khorasan', 'RKH', 1),
(1567, 101, 'South Khorasan', 'SKH', 1),
(1568, 102, 'Baghdad', 'BD', 1),
(1569, 102, 'Salah ad Din', 'SD', 1),
(1570, 102, 'Diyala', 'DY', 1),
(1571, 102, 'Wasit', 'WS', 1),
(1572, 102, 'Maysan', 'MY', 1),
(1573, 102, 'Al Basrah', 'BA', 1),
(1574, 102, 'Dhi Qar', 'DQ', 1),
(1575, 102, 'Al Muthanna', 'MU', 1);
INSERT INTO `tblprfx_zones` (`id`, `country_id`, `name`, `code`, `status`) VALUES
(1576, 102, 'Al Qadisyah', 'QA', 1),
(1577, 102, 'Babil', 'BB', 1),
(1578, 102, 'Al Karbala', 'KB', 1),
(1579, 102, 'An Najaf', 'NJ', 1),
(1580, 102, 'Al Anbar', 'AB', 1),
(1581, 102, 'Ninawa', 'NN', 1),
(1582, 102, 'Dahuk', 'DH', 1),
(1583, 102, 'Arbil', 'AL', 1),
(1584, 102, 'At Ta''mim', 'TM', 1),
(1585, 102, 'As Sulaymaniyah', 'SL', 1),
(1586, 103, 'Carlow', 'CA', 1),
(1587, 103, 'Cavan', 'CV', 1),
(1588, 103, 'Clare', 'CL', 1),
(1589, 103, 'Cork', 'CO', 1),
(1590, 103, 'Donegal', 'DO', 1),
(1591, 103, 'Dublin', 'DU', 1),
(1592, 103, 'Galway', 'GA', 1),
(1593, 103, 'Kerry', 'KE', 1),
(1594, 103, 'Kildare', 'KI', 1),
(1595, 103, 'Kilkenny', 'KL', 1),
(1596, 103, 'Laois', 'LA', 1),
(1597, 103, 'Leitrim', 'LE', 1),
(1598, 103, 'Limerick', 'LI', 1),
(1599, 103, 'Longford', 'LO', 1),
(1600, 103, 'Louth', 'LU', 1),
(1601, 103, 'Mayo', 'MA', 1),
(1602, 103, 'Meath', 'ME', 1),
(1603, 103, 'Monaghan', 'MO', 1),
(1604, 103, 'Offaly', 'OF', 1),
(1605, 103, 'Roscommon', 'RO', 1),
(1606, 103, 'Sligo', 'SL', 1),
(1607, 103, 'Tipperary', 'TI', 1),
(1608, 103, 'Waterford', 'WA', 1),
(1609, 103, 'Westmeath', 'WE', 1),
(1610, 103, 'Wexford', 'WX', 1),
(1611, 103, 'Wicklow', 'WI', 1),
(1612, 104, 'Be''er Sheva', 'BS', 1),
(1613, 104, 'Bika''at Hayarden', 'BH', 1),
(1614, 104, 'Eilat and Arava', 'EA', 1),
(1615, 104, 'Galil', 'GA', 1),
(1616, 104, 'Haifa', 'HA', 1),
(1617, 104, 'Jehuda Mountains', 'JM', 1),
(1618, 104, 'Jerusalem', 'JE', 1),
(1619, 104, 'Negev', 'NE', 1),
(1620, 104, 'Semaria', 'SE', 1),
(1621, 104, 'Sharon', 'SH', 1),
(1622, 104, 'Tel Aviv (Gosh Dan)', 'TA', 1),
(3860, 105, 'Caltanissetta', 'CL', 1),
(3842, 105, 'Agrigento', 'AG', 1),
(3843, 105, 'Alessandria', 'AL', 1),
(3844, 105, 'Ancona', 'AN', 1),
(3845, 105, 'Aosta', 'AO', 1),
(3846, 105, 'Arezzo', 'AR', 1),
(3847, 105, 'Ascoli Piceno', 'AP', 1),
(3848, 105, 'Asti', 'AT', 1),
(3849, 105, 'Avellino', 'AV', 1),
(3850, 105, 'Bari', 'BA', 1),
(3851, 105, 'Belluno', 'BL', 1),
(3852, 105, 'Benevento', 'BN', 1),
(3853, 105, 'Bergamo', 'BG', 1),
(3854, 105, 'Biella', 'BI', 1),
(3855, 105, 'Bologna', 'BO', 1),
(3856, 105, 'Bolzano', 'BZ', 1),
(3857, 105, 'Brescia', 'BS', 1),
(3858, 105, 'Brindisi', 'BR', 1),
(3859, 105, 'Cagliari', 'CA', 1),
(1643, 106, 'Clarendon Parish', 'CLA', 1),
(1644, 106, 'Hanover Parish', 'HAN', 1),
(1645, 106, 'Kingston Parish', 'KIN', 1),
(1646, 106, 'Manchester Parish', 'MAN', 1),
(1647, 106, 'Portland Parish', 'POR', 1),
(1648, 106, 'Saint Andrew Parish', 'AND', 1),
(1649, 106, 'Saint Ann Parish', 'ANN', 1),
(1650, 106, 'Saint Catherine Parish', 'CAT', 1),
(1651, 106, 'Saint Elizabeth Parish', 'ELI', 1),
(1652, 106, 'Saint James Parish', 'JAM', 1),
(1653, 106, 'Saint Mary Parish', 'MAR', 1),
(1654, 106, 'Saint Thomas Parish', 'THO', 1),
(1655, 106, 'Trelawny Parish', 'TRL', 1),
(1656, 106, 'Westmoreland Parish', 'WML', 1),
(1657, 107, 'Aichi', 'AI', 1),
(1658, 107, 'Akita', 'AK', 1),
(1659, 107, 'Aomori', 'AO', 1),
(1660, 107, 'Chiba', 'CH', 1),
(1661, 107, 'Ehime', 'EH', 1),
(1662, 107, 'Fukui', 'FK', 1),
(1663, 107, 'Fukuoka', 'FU', 1),
(1664, 107, 'Fukushima', 'FS', 1),
(1665, 107, 'Gifu', 'GI', 1),
(1666, 107, 'Gumma', 'GU', 1),
(1667, 107, 'Hiroshima', 'HI', 1),
(1668, 107, 'Hokkaido', 'HO', 1),
(1669, 107, 'Hyogo', 'HY', 1),
(1670, 107, 'Ibaraki', 'IB', 1),
(1671, 107, 'Ishikawa', 'IS', 1),
(1672, 107, 'Iwate', 'IW', 1),
(1673, 107, 'Kagawa', 'KA', 1),
(1674, 107, 'Kagoshima', 'KG', 1),
(1675, 107, 'Kanagawa', 'KN', 1),
(1676, 107, 'Kochi', 'KO', 1),
(1677, 107, 'Kumamoto', 'KU', 1),
(1678, 107, 'Kyoto', 'KY', 1),
(1679, 107, 'Mie', 'MI', 1),
(1680, 107, 'Miyagi', 'MY', 1),
(1681, 107, 'Miyazaki', 'MZ', 1),
(1682, 107, 'Nagano', 'NA', 1),
(1683, 107, 'Nagasaki', 'NG', 1),
(1684, 107, 'Nara', 'NR', 1),
(1685, 107, 'Niigata', 'NI', 1),
(1686, 107, 'Oita', 'OI', 1),
(1687, 107, 'Okayama', 'OK', 1),
(1688, 107, 'Okinawa', 'ON', 1),
(1689, 107, 'Osaka', 'OS', 1),
(1690, 107, 'Saga', 'SA', 1),
(1691, 107, 'Saitama', 'SI', 1),
(1692, 107, 'Shiga', 'SH', 1),
(1693, 107, 'Shimane', 'SM', 1),
(1694, 107, 'Shizuoka', 'SZ', 1),
(1695, 107, 'Tochigi', 'TO', 1),
(1696, 107, 'Tokushima', 'TS', 1),
(1697, 107, 'Tokyo', 'TK', 1),
(1698, 107, 'Tottori', 'TT', 1),
(1699, 107, 'Toyama', 'TY', 1),
(1700, 107, 'Wakayama', 'WA', 1),
(1701, 107, 'Yamagata', 'YA', 1),
(1702, 107, 'Yamaguchi', 'YM', 1),
(1703, 107, 'Yamanashi', 'YN', 1),
(1704, 108, '''Amman', 'AM', 1),
(1705, 108, 'Ajlun', 'AJ', 1),
(1706, 108, 'Al ''Aqabah', 'AA', 1),
(1707, 108, 'Al Balqa''', 'AB', 1),
(1708, 108, 'Al Karak', 'AK', 1),
(1709, 108, 'Al Mafraq', 'AL', 1),
(1710, 108, 'At Tafilah', 'AT', 1),
(1711, 108, 'Az Zarqa''', 'AZ', 1),
(1712, 108, 'Irbid', 'IR', 1),
(1713, 108, 'Jarash', 'JA', 1),
(1714, 108, 'Ma''an', 'MA', 1),
(1715, 108, 'Madaba', 'MD', 1),
(1716, 109, 'Almaty', 'AL', 1),
(1717, 109, 'Almaty City', 'AC', 1),
(1718, 109, 'Aqmola', 'AM', 1),
(1719, 109, 'Aqtobe', 'AQ', 1),
(1720, 109, 'Astana City', 'AS', 1),
(1721, 109, 'Atyrau', 'AT', 1),
(1722, 109, 'Batys Qazaqstan', 'BA', 1),
(1723, 109, 'Bayqongyr City', 'BY', 1),
(1724, 109, 'Mangghystau', 'MA', 1),
(1725, 109, 'Ongtustik Qazaqstan', 'ON', 1),
(1726, 109, 'Pavlodar', 'PA', 1),
(1727, 109, 'Qaraghandy', 'QA', 1),
(1728, 109, 'Qostanay', 'QO', 1),
(1729, 109, 'Qyzylorda', 'QY', 1),
(1730, 109, 'Shyghys Qazaqstan', 'SH', 1),
(1731, 109, 'Soltustik Qazaqstan', 'SO', 1),
(1732, 109, 'Zhambyl', 'ZH', 1),
(1733, 110, 'Central', 'CE', 1),
(1734, 110, 'Coast', 'CO', 1),
(1735, 110, 'Eastern', 'EA', 1),
(1736, 110, 'Nairobi Area', 'NA', 1),
(1737, 110, 'North Eastern', 'NE', 1),
(1738, 110, 'Nyanza', 'NY', 1),
(1739, 110, 'Rift Valley', 'RV', 1),
(1740, 110, 'Western', 'WE', 1),
(1741, 111, 'Abaiang', 'AG', 1),
(1742, 111, 'Abemama', 'AM', 1),
(1743, 111, 'Aranuka', 'AK', 1),
(1744, 111, 'Arorae', 'AO', 1),
(1745, 111, 'Banaba', 'BA', 1),
(1746, 111, 'Beru', 'BE', 1),
(1747, 111, 'Butaritari', 'bT', 1),
(1748, 111, 'Kanton', 'KA', 1),
(1749, 111, 'Kiritimati', 'KR', 1),
(1750, 111, 'Kuria', 'KU', 1),
(1751, 111, 'Maiana', 'MI', 1),
(1752, 111, 'Makin', 'MN', 1),
(1753, 111, 'Marakei', 'ME', 1),
(1754, 111, 'Nikunau', 'NI', 1),
(1755, 111, 'Nonouti', 'NO', 1),
(1756, 111, 'Onotoa', 'ON', 1),
(1757, 111, 'Tabiteuea', 'TT', 1),
(1758, 111, 'Tabuaeran', 'TR', 1),
(1759, 111, 'Tamana', 'TM', 1),
(1760, 111, 'Tarawa', 'TW', 1),
(1761, 111, 'Teraina', 'TE', 1),
(1762, 112, 'Chagang-do', 'CHA', 1),
(1763, 112, 'Hamgyong-bukto', 'HAB', 1),
(1764, 112, 'Hamgyong-namdo', 'HAN', 1),
(1765, 112, 'Hwanghae-bukto', 'HWB', 1),
(1766, 112, 'Hwanghae-namdo', 'HWN', 1),
(1767, 112, 'Kangwon-do', 'KAN', 1),
(1768, 112, 'P''yongan-bukto', 'PYB', 1),
(1769, 112, 'P''yongan-namdo', 'PYN', 1),
(1770, 112, 'Ryanggang-do (Yanggang-do)', 'YAN', 1),
(1771, 112, 'Rason Directly Governed City', 'NAJ', 1),
(1772, 112, 'P''yongyang Special City', 'PYO', 1),
(1773, 113, 'Ch''ungch''ong-bukto', 'CO', 1),
(1774, 113, 'Ch''ungch''ong-namdo', 'CH', 1),
(1775, 113, 'Cheju-do', 'CD', 1),
(1776, 113, 'Cholla-bukto', 'CB', 1),
(1777, 113, 'Cholla-namdo', 'CN', 1),
(1778, 113, 'Inch''on-gwangyoksi', 'IG', 1),
(1779, 113, 'Kangwon-do', 'KA', 1),
(1780, 113, 'Kwangju-gwangyoksi', 'KG', 1),
(1781, 113, 'Kyonggi-do', 'KD', 1),
(1782, 113, 'Kyongsang-bukto', 'KB', 1),
(1783, 113, 'Kyongsang-namdo', 'KN', 1),
(1784, 113, 'Pusan-gwangyoksi', 'PG', 1),
(1785, 113, 'Soul-t''ukpyolsi', 'SO', 1),
(1786, 113, 'Taegu-gwangyoksi', 'TA', 1),
(1787, 113, 'Taejon-gwangyoksi', 'TG', 1),
(1788, 114, 'Al ''Asimah', 'AL', 1),
(1789, 114, 'Al Ahmadi', 'AA', 1),
(1790, 114, 'Al Farwaniyah', 'AF', 1),
(1791, 114, 'Al Jahra''', 'AJ', 1),
(1792, 114, 'Hawalli', 'HA', 1),
(1793, 115, 'Bishkek', 'GB', 1),
(1794, 115, 'Batken', 'B', 1),
(1795, 115, 'Chu', 'C', 1),
(1796, 115, 'Jalal-Abad', 'J', 1),
(1797, 115, 'Naryn', 'N', 1),
(1798, 115, 'Osh', 'O', 1),
(1799, 115, 'Talas', 'T', 1),
(1800, 115, 'Ysyk-Kol', 'Y', 1),
(1801, 116, 'Vientiane', 'VT', 1),
(1802, 116, 'Attapu', 'AT', 1),
(1803, 116, 'Bokeo', 'BK', 1),
(1804, 116, 'Bolikhamxai', 'BL', 1),
(1805, 116, 'Champasak', 'CH', 1),
(1806, 116, 'Houaphan', 'HO', 1),
(1807, 116, 'Khammouan', 'KH', 1),
(1808, 116, 'Louang Namtha', 'LM', 1),
(1809, 116, 'Louangphabang', 'LP', 1),
(1810, 116, 'Oudomxai', 'OU', 1),
(1811, 116, 'Phongsali', 'PH', 1),
(1812, 116, 'Salavan', 'SL', 1),
(1813, 116, 'Savannakhet', 'SV', 1),
(1814, 116, 'Vientiane', 'VI', 1),
(1815, 116, 'Xaignabouli', 'XA', 1),
(1816, 116, 'Xekong', 'XE', 1),
(1817, 116, 'Xiangkhoang', 'XI', 1),
(1818, 116, 'Xaisomboun', 'XN', 1),
(1819, 117, 'Aizkraukles Rajons', 'AIZ', 1),
(1820, 117, 'Aluksnes Rajons', 'ALU', 1),
(1821, 117, 'Balvu Rajons', 'BAL', 1),
(1822, 117, 'Bauskas Rajons', 'BAU', 1),
(1823, 117, 'Cesu Rajons', 'CES', 1),
(1824, 117, 'Daugavpils Rajons', 'DGR', 1),
(1825, 117, 'Dobeles Rajons', 'DOB', 1),
(1826, 117, 'Gulbenes Rajons', 'GUL', 1),
(1827, 117, 'Jekabpils Rajons', 'JEK', 1),
(1828, 117, 'Jelgavas Rajons', 'JGR', 1),
(1829, 117, 'Kraslavas Rajons', 'KRA', 1),
(1830, 117, 'Kuldigas Rajons', 'KUL', 1),
(1831, 117, 'Liepajas Rajons', 'LPR', 1),
(1832, 117, 'Limbazu Rajons', 'LIM', 1),
(1833, 117, 'Ludzas Rajons', 'LUD', 1),
(1834, 117, 'Madonas Rajons', 'MAD', 1),
(1835, 117, 'Ogres Rajons', 'OGR', 1),
(1836, 117, 'Preilu Rajons', 'PRE', 1),
(1837, 117, 'Rezeknes Rajons', 'RZR', 1),
(1838, 117, 'Rigas Rajons', 'RGR', 1),
(1839, 117, 'Saldus Rajons', 'SAL', 1),
(1840, 117, 'Talsu Rajons', 'TAL', 1),
(1841, 117, 'Tukuma Rajons', 'TUK', 1),
(1842, 117, 'Valkas Rajons', 'VLK', 1),
(1843, 117, 'Valmieras Rajons', 'VLM', 1),
(1844, 117, 'Ventspils Rajons', 'VSR', 1),
(1845, 117, 'Daugavpils', 'DGV', 1),
(1846, 117, 'Jelgava', 'JGV', 1),
(1847, 117, 'Jurmala', 'JUR', 1),
(1848, 117, 'Liepaja', 'LPK', 1),
(1849, 117, 'Rezekne', 'RZK', 1),
(1850, 117, 'Riga', 'RGA', 1),
(1851, 117, 'Ventspils', 'VSL', 1),
(1852, 119, 'Berea', 'BE', 1),
(1853, 119, 'Butha-Buthe', 'BB', 1),
(1854, 119, 'Leribe', 'LE', 1),
(1855, 119, 'Mafeteng', 'MF', 1),
(1856, 119, 'Maseru', 'MS', 1),
(1857, 119, 'Mohale''s Hoek', 'MH', 1),
(1858, 119, 'Mokhotlong', 'MK', 1),
(1859, 119, 'Qacha''s Nek', 'QN', 1),
(1860, 119, 'Quthing', 'QT', 1),
(1861, 119, 'Thaba-Tseka', 'TT', 1),
(1862, 120, 'Bomi', 'BI', 1),
(1863, 120, 'Bong', 'BG', 1),
(1864, 120, 'Grand Bassa', 'GB', 1),
(1865, 120, 'Grand Cape Mount', 'CM', 1),
(1866, 120, 'Grand Gedeh', 'GG', 1),
(1867, 120, 'Grand Kru', 'GK', 1),
(1868, 120, 'Lofa', 'LO', 1),
(1869, 120, 'Margibi', 'MG', 1),
(1870, 120, 'Maryland', 'ML', 1),
(1871, 120, 'Montserrado', 'MS', 1),
(1872, 120, 'Nimba', 'NB', 1),
(1873, 120, 'River Cess', 'RC', 1),
(1874, 120, 'Sinoe', 'SN', 1),
(1875, 121, 'Ajdabiya', 'AJ', 1),
(1876, 121, 'Al ''Aziziyah', 'AZ', 1),
(1877, 121, 'Al Fatih', 'FA', 1),
(1878, 121, 'Al Jabal al Akhdar', 'JA', 1),
(1879, 121, 'Al Jufrah', 'JU', 1),
(1880, 121, 'Al Khums', 'KH', 1),
(1881, 121, 'Al Kufrah', 'KU', 1),
(1882, 121, 'An Nuqat al Khams', 'NK', 1),
(1883, 121, 'Ash Shati''', 'AS', 1),
(1884, 121, 'Awbari', 'AW', 1),
(1885, 121, 'Az Zawiyah', 'ZA', 1),
(1886, 121, 'Banghazi', 'BA', 1),
(1887, 121, 'Darnah', 'DA', 1),
(1888, 121, 'Ghadamis', 'GD', 1),
(1889, 121, 'Gharyan', 'GY', 1),
(1890, 121, 'Misratah', 'MI', 1),
(1891, 121, 'Murzuq', 'MZ', 1),
(1892, 121, 'Sabha', 'SB', 1),
(1893, 121, 'Sawfajjin', 'SW', 1),
(1894, 121, 'Surt', 'SU', 1),
(1895, 121, 'Tarabulus (Tripoli)', 'TL', 1),
(1896, 121, 'Tarhunah', 'TH', 1),
(1897, 121, 'Tubruq', 'TU', 1),
(1898, 121, 'Yafran', 'YA', 1),
(1899, 121, 'Zlitan', 'ZL', 1),
(1900, 122, 'Vaduz', 'V', 1),
(1901, 122, 'Schaan', 'A', 1),
(1902, 122, 'Balzers', 'B', 1),
(1903, 122, 'Triesen', 'N', 1),
(1904, 122, 'Eschen', 'E', 1),
(1905, 122, 'Mauren', 'M', 1),
(1906, 122, 'Triesenberg', 'T', 1),
(1907, 122, 'Ruggell', 'R', 1),
(1908, 122, 'Gamprin', 'G', 1),
(1909, 122, 'Schellenberg', 'L', 1),
(1910, 122, 'Planken', 'P', 1),
(1911, 123, 'Alytus', 'AL', 1),
(1912, 123, 'Kaunas', 'KA', 1),
(1913, 123, 'Klaipeda', 'KL', 1),
(1914, 123, 'Marijampole', 'MA', 1),
(1915, 123, 'Panevezys', 'PA', 1),
(1916, 123, 'Siauliai', 'SI', 1),
(1917, 123, 'Taurage', 'TA', 1),
(1918, 123, 'Telsiai', 'TE', 1),
(1919, 123, 'Utena', 'UT', 1),
(1920, 123, 'Vilnius', 'VI', 1),
(1921, 124, 'Diekirch', 'DD', 1),
(1922, 124, 'Clervaux', 'DC', 1),
(1923, 124, 'Redange', 'DR', 1),
(1924, 124, 'Vianden', 'DV', 1),
(1925, 124, 'Wiltz', 'DW', 1),
(1926, 124, 'Grevenmacher', 'GG', 1),
(1927, 124, 'Echternach', 'GE', 1),
(1928, 124, 'Remich', 'GR', 1),
(1929, 124, 'Luxembourg', 'LL', 1),
(1930, 124, 'Capellen', 'LC', 1),
(1931, 124, 'Esch-sur-Alzette', 'LE', 1),
(1932, 124, 'Mersch', 'LM', 1),
(1933, 125, 'Our Lady Fatima Parish', 'OLF', 1),
(1934, 125, 'St. Anthony Parish', 'ANT', 1),
(1935, 125, 'St. Lazarus Parish', 'LAZ', 1),
(1936, 125, 'Cathedral Parish', 'CAT', 1),
(1937, 125, 'St. Lawrence Parish', 'LAW', 1),
(1938, 127, 'Antananarivo', 'AN', 1),
(1939, 127, 'Antsiranana', 'AS', 1),
(1940, 127, 'Fianarantsoa', 'FN', 1),
(1941, 127, 'Mahajanga', 'MJ', 1),
(1942, 127, 'Toamasina', 'TM', 1),
(1943, 127, 'Toliara', 'TL', 1),
(1944, 128, 'Balaka', 'BLK', 1),
(1945, 128, 'Blantyre', 'BLT', 1),
(1946, 128, 'Chikwawa', 'CKW', 1),
(1947, 128, 'Chiradzulu', 'CRD', 1),
(1948, 128, 'Chitipa', 'CTP', 1),
(1949, 128, 'Dedza', 'DDZ', 1),
(1950, 128, 'Dowa', 'DWA', 1),
(1951, 128, 'Karonga', 'KRG', 1),
(1952, 128, 'Kasungu', 'KSG', 1),
(1953, 128, 'Likoma', 'LKM', 1),
(1954, 128, 'Lilongwe', 'LLG', 1),
(1955, 128, 'Machinga', 'MCG', 1),
(1956, 128, 'Mangochi', 'MGC', 1),
(1957, 128, 'Mchinji', 'MCH', 1),
(1958, 128, 'Mulanje', 'MLJ', 1),
(1959, 128, 'Mwanza', 'MWZ', 1),
(1960, 128, 'Mzimba', 'MZM', 1),
(1961, 128, 'Ntcheu', 'NTU', 1),
(1962, 128, 'Nkhata Bay', 'NKB', 1),
(1963, 128, 'Nkhotakota', 'NKH', 1),
(1964, 128, 'Nsanje', 'NSJ', 1),
(1965, 128, 'Ntchisi', 'NTI', 1),
(1966, 128, 'Phalombe', 'PHL', 1),
(1967, 128, 'Rumphi', 'RMP', 1),
(1968, 128, 'Salima', 'SLM', 1),
(1969, 128, 'Thyolo', 'THY', 1),
(1970, 128, 'Zomba', 'ZBA', 1),
(1971, 129, 'Johor', 'JO', 1),
(1972, 129, 'Kedah', 'KE', 1),
(1973, 129, 'Kelantan', 'KL', 1),
(1974, 129, 'Labuan', 'LA', 1),
(1975, 129, 'Melaka', 'ME', 1),
(1976, 129, 'Negeri Sembilan', 'NS', 1),
(1977, 129, 'Pahang', 'PA', 1),
(1978, 129, 'Perak', 'PE', 1),
(1979, 129, 'Perlis', 'PR', 1),
(1980, 129, 'Pulau Pinang', 'PP', 1),
(1981, 129, 'Sabah', 'SA', 1),
(1982, 129, 'Sarawak', 'SR', 1),
(1983, 129, 'Selangor', 'SE', 1),
(1984, 129, 'Terengganu', 'TE', 1),
(1985, 129, 'Wilayah Persekutuan', 'WP', 1),
(1986, 130, 'Thiladhunmathi Uthuru', 'THU', 1),
(1987, 130, 'Thiladhunmathi Dhekunu', 'THD', 1),
(1988, 130, 'Miladhunmadulu Uthuru', 'MLU', 1),
(1989, 130, 'Miladhunmadulu Dhekunu', 'MLD', 1),
(1990, 130, 'Maalhosmadulu Uthuru', 'MAU', 1),
(1991, 130, 'Maalhosmadulu Dhekunu', 'MAD', 1),
(1992, 130, 'Faadhippolhu', 'FAA', 1),
(1993, 130, 'Male Atoll', 'MAA', 1),
(1994, 130, 'Ari Atoll Uthuru', 'AAU', 1),
(1995, 130, 'Ari Atoll Dheknu', 'AAD', 1),
(1996, 130, 'Felidhe Atoll', 'FEA', 1),
(1997, 130, 'Mulaku Atoll', 'MUA', 1),
(1998, 130, 'Nilandhe Atoll Uthuru', 'NAU', 1),
(1999, 130, 'Nilandhe Atoll Dhekunu', 'NAD', 1),
(2000, 130, 'Kolhumadulu', 'KLH', 1),
(2001, 130, 'Hadhdhunmathi', 'HDH', 1),
(2002, 130, 'Huvadhu Atoll Uthuru', 'HAU', 1),
(2003, 130, 'Huvadhu Atoll Dhekunu', 'HAD', 1),
(2004, 130, 'Fua Mulaku', 'FMU', 1),
(2005, 130, 'Addu', 'ADD', 1),
(2006, 131, 'Gao', 'GA', 1),
(2007, 131, 'Kayes', 'KY', 1),
(2008, 131, 'Kidal', 'KD', 1),
(2009, 131, 'Koulikoro', 'KL', 1),
(2010, 131, 'Mopti', 'MP', 1),
(2011, 131, 'Segou', 'SG', 1),
(2012, 131, 'Sikasso', 'SK', 1),
(2013, 131, 'Tombouctou', 'TB', 1),
(2014, 131, 'Bamako Capital District', 'CD', 1),
(2015, 132, 'Attard', 'ATT', 1),
(2016, 132, 'Balzan', 'BAL', 1),
(2017, 132, 'Birgu', 'BGU', 1),
(2018, 132, 'Birkirkara', 'BKK', 1),
(2019, 132, 'Birzebbuga', 'BRZ', 1),
(2020, 132, 'Bormla', 'BOR', 1),
(2021, 132, 'Dingli', 'DIN', 1),
(2022, 132, 'Fgura', 'FGU', 1),
(2023, 132, 'Floriana', 'FLO', 1),
(2024, 132, 'Gudja', 'GDJ', 1),
(2025, 132, 'Gzira', 'GZR', 1),
(2026, 132, 'Gargur', 'GRG', 1),
(2027, 132, 'Gaxaq', 'GXQ', 1),
(2028, 132, 'Hamrun', 'HMR', 1),
(2029, 132, 'Iklin', 'IKL', 1),
(2030, 132, 'Isla', 'ISL', 1),
(2031, 132, 'Kalkara', 'KLK', 1),
(2032, 132, 'Kirkop', 'KRK', 1),
(2033, 132, 'Lija', 'LIJ', 1),
(2034, 132, 'Luqa', 'LUQ', 1),
(2035, 132, 'Marsa', 'MRS', 1),
(2036, 132, 'Marsaskala', 'MKL', 1),
(2037, 132, 'Marsaxlokk', 'MXL', 1),
(2038, 132, 'Mdina', 'MDN', 1),
(2039, 132, 'Melliea', 'MEL', 1),
(2040, 132, 'Mgarr', 'MGR', 1),
(2041, 132, 'Mosta', 'MST', 1),
(2042, 132, 'Mqabba', 'MQA', 1),
(2043, 132, 'Msida', 'MSI', 1),
(2044, 132, 'Mtarfa', 'MTF', 1),
(2045, 132, 'Naxxar', 'NAX', 1),
(2046, 132, 'Paola', 'PAO', 1),
(2047, 132, 'Pembroke', 'PEM', 1),
(2048, 132, 'Pieta', 'PIE', 1),
(2049, 132, 'Qormi', 'QOR', 1),
(2050, 132, 'Qrendi', 'QRE', 1),
(2051, 132, 'Rabat', 'RAB', 1),
(2052, 132, 'Safi', 'SAF', 1),
(2053, 132, 'San Giljan', 'SGI', 1),
(2054, 132, 'Santa Lucija', 'SLU', 1),
(2055, 132, 'San Pawl il-Bahar', 'SPB', 1),
(2056, 132, 'San Gwann', 'SGW', 1),
(2057, 132, 'Santa Venera', 'SVE', 1),
(2058, 132, 'Siggiewi', 'SIG', 1),
(2059, 132, 'Sliema', 'SLM', 1),
(2060, 132, 'Swieqi', 'SWQ', 1),
(2061, 132, 'Ta Xbiex', 'TXB', 1),
(2062, 132, 'Tarxien', 'TRX', 1),
(2063, 132, 'Valletta', 'VLT', 1),
(2064, 132, 'Xgajra', 'XGJ', 1),
(2065, 132, 'Zabbar', 'ZBR', 1),
(2066, 132, 'Zebbug', 'ZBG', 1),
(2067, 132, 'Zejtun', 'ZJT', 1),
(2068, 132, 'Zurrieq', 'ZRQ', 1),
(2069, 132, 'Fontana', 'FNT', 1),
(2070, 132, 'Ghajnsielem', 'GHJ', 1),
(2071, 132, 'Gharb', 'GHR', 1),
(2072, 132, 'Ghasri', 'GHS', 1),
(2073, 132, 'Kercem', 'KRC', 1),
(2074, 132, 'Munxar', 'MUN', 1),
(2075, 132, 'Nadur', 'NAD', 1),
(2076, 132, 'Qala', 'QAL', 1),
(2077, 132, 'Victoria', 'VIC', 1),
(2078, 132, 'San Lawrenz', 'SLA', 1),
(2079, 132, 'Sannat', 'SNT', 1),
(2080, 132, 'Xagra', 'ZAG', 1),
(2081, 132, 'Xewkija', 'XEW', 1),
(2082, 132, 'Zebbug', 'ZEB', 1),
(2083, 133, 'Ailinginae', 'ALG', 1),
(2084, 133, 'Ailinglaplap', 'ALL', 1),
(2085, 133, 'Ailuk', 'ALK', 1),
(2086, 133, 'Arno', 'ARN', 1),
(2087, 133, 'Aur', 'AUR', 1),
(2088, 133, 'Bikar', 'BKR', 1),
(2089, 133, 'Bikini', 'BKN', 1),
(2090, 133, 'Bokak', 'BKK', 1),
(2091, 133, 'Ebon', 'EBN', 1),
(2092, 133, 'Enewetak', 'ENT', 1),
(2093, 133, 'Erikub', 'EKB', 1),
(2094, 133, 'Jabat', 'JBT', 1),
(2095, 133, 'Jaluit', 'JLT', 1),
(2096, 133, 'Jemo', 'JEM', 1),
(2097, 133, 'Kili', 'KIL', 1),
(2098, 133, 'Kwajalein', 'KWJ', 1),
(2099, 133, 'Lae', 'LAE', 1),
(2100, 133, 'Lib', 'LIB', 1),
(2101, 133, 'Likiep', 'LKP', 1),
(2102, 133, 'Majuro', 'MJR', 1),
(2103, 133, 'Maloelap', 'MLP', 1),
(2104, 133, 'Mejit', 'MJT', 1),
(2105, 133, 'Mili', 'MIL', 1),
(2106, 133, 'Namorik', 'NMK', 1),
(2107, 133, 'Namu', 'NAM', 1),
(2108, 133, 'Rongelap', 'RGL', 1),
(2109, 133, 'Rongrik', 'RGK', 1),
(2110, 133, 'Toke', 'TOK', 1),
(2111, 133, 'Ujae', 'UJA', 1),
(2112, 133, 'Ujelang', 'UJL', 1),
(2113, 133, 'Utirik', 'UTK', 1),
(2114, 133, 'Wotho', 'WTH', 1),
(2115, 133, 'Wotje', 'WTJ', 1),
(2116, 135, 'Adrar', 'AD', 1),
(2117, 135, 'Assaba', 'AS', 1),
(2118, 135, 'Brakna', 'BR', 1),
(2119, 135, 'Dakhlet Nouadhibou', 'DN', 1),
(2120, 135, 'Gorgol', 'GO', 1),
(2121, 135, 'Guidimaka', 'GM', 1),
(2122, 135, 'Hodh Ech Chargui', 'HC', 1),
(2123, 135, 'Hodh El Gharbi', 'HG', 1),
(2124, 135, 'Inchiri', 'IN', 1),
(2125, 135, 'Tagant', 'TA', 1),
(2126, 135, 'Tiris Zemmour', 'TZ', 1),
(2127, 135, 'Trarza', 'TR', 1),
(2128, 135, 'Nouakchott', 'NO', 1),
(2129, 136, 'Beau Bassin-Rose Hill', 'BR', 1),
(2130, 136, 'Curepipe', 'CU', 1),
(2131, 136, 'Port Louis', 'PU', 1),
(2132, 136, 'Quatre Bornes', 'QB', 1),
(2133, 136, 'Vacoas-Phoenix', 'VP', 1),
(2134, 136, 'Agalega Islands', 'AG', 1),
(2135, 136, 'Cargados Carajos Shoals (Saint Brandon Islands)', 'CC', 1),
(2136, 136, 'Rodrigues', 'RO', 1),
(2137, 136, 'Black River', 'BL', 1),
(2138, 136, 'Flacq', 'FL', 1),
(2139, 136, 'Grand Port', 'GP', 1),
(2140, 136, 'Moka', 'MO', 1),
(2141, 136, 'Pamplemousses', 'PA', 1),
(2142, 136, 'Plaines Wilhems', 'PW', 1),
(2143, 136, 'Port Louis', 'PL', 1),
(2144, 136, 'Riviere du Rempart', 'RR', 1),
(2145, 136, 'Savanne', 'SA', 1),
(2146, 138, 'Baja California Norte', 'BN', 1),
(2147, 138, 'Baja California Sur', 'BS', 1),
(2148, 138, 'Campeche', 'CA', 1),
(2149, 138, 'Chiapas', 'CI', 1),
(2150, 138, 'Chihuahua', 'CH', 1),
(2151, 138, 'Coahuila de Zaragoza', 'CZ', 1),
(2152, 138, 'Colima', 'CL', 1),
(2153, 138, 'Distrito Federal', 'DF', 1),
(2154, 138, 'Durango', 'DU', 1),
(2155, 138, 'Guanajuato', 'GA', 1),
(2156, 138, 'Guerrero', 'GE', 1),
(2157, 138, 'Hidalgo', 'HI', 1),
(2158, 138, 'Jalisco', 'JA', 1),
(2159, 138, 'Mexico', 'ME', 1),
(2160, 138, 'Michoacan de Ocampo', 'MI', 1),
(2161, 138, 'Morelos', 'MO', 1),
(2162, 138, 'Nayarit', 'NA', 1),
(2163, 138, 'Nuevo Leon', 'NL', 1),
(2164, 138, 'Oaxaca', 'OA', 1),
(2165, 138, 'Puebla', 'PU', 1),
(2166, 138, 'Queretaro de Arteaga', 'QA', 1),
(2167, 138, 'Quintana Roo', 'QR', 1),
(2168, 138, 'San Luis Potosi', 'SA', 1),
(2169, 138, 'Sinaloa', 'SI', 1),
(2170, 138, 'Sonora', 'SO', 1),
(2171, 138, 'Tabasco', 'TB', 1),
(2172, 138, 'Tamaulipas', 'TM', 1),
(2173, 138, 'Tlaxcala', 'TL', 1),
(2174, 138, 'Veracruz-Llave', 'VE', 1),
(2175, 138, 'Yucatan', 'YU', 1),
(2176, 138, 'Zacatecas', 'ZA', 1),
(2177, 139, 'Chuuk', 'C', 1),
(2178, 139, 'Kosrae', 'K', 1),
(2179, 139, 'Pohnpei', 'P', 1),
(2180, 139, 'Yap', 'Y', 1),
(2181, 140, 'Gagauzia', 'GA', 1),
(2182, 140, 'Chisinau', 'CU', 1),
(2183, 140, 'Balti', 'BA', 1),
(2184, 140, 'Cahul', 'CA', 1),
(2185, 140, 'Edinet', 'ED', 1),
(2186, 140, 'Lapusna', 'LA', 1),
(2187, 140, 'Orhei', 'OR', 1),
(2188, 140, 'Soroca', 'SO', 1),
(2189, 140, 'Tighina', 'TI', 1),
(2190, 140, 'Ungheni', 'UN', 1),
(2191, 140, 'St‚nga Nistrului', 'SN', 1),
(2192, 141, 'Fontvieille', 'FV', 1),
(2193, 141, 'La Condamine', 'LC', 1),
(2194, 141, 'Monaco-Ville', 'MV', 1),
(2195, 141, 'Monte-Carlo', 'MC', 1),
(2196, 142, 'Ulanbaatar', '1', 1),
(2197, 142, 'Orhon', '035', 1),
(2198, 142, 'Darhan uul', '037', 1),
(2199, 142, 'Hentiy', '039', 1),
(2200, 142, 'Hovsgol', '041', 1),
(2201, 142, 'Hovd', '043', 1),
(2202, 142, 'Uvs', '046', 1),
(2203, 142, 'Tov', '047', 1),
(2204, 142, 'Selenge', '049', 1),
(2205, 142, 'Suhbaatar', '051', 1),
(2206, 142, 'Omnogovi', '053', 1),
(2207, 142, 'Ovorhangay', '055', 1),
(2208, 142, 'Dzavhan', '057', 1),
(2209, 142, 'DundgovL', '059', 1),
(2210, 142, 'Dornod', '061', 1),
(2211, 142, 'Dornogov', '063', 1),
(2212, 142, 'Govi-Sumber', '064', 1),
(2213, 142, 'Govi-Altay', '065', 1),
(2214, 142, 'Bulgan', '067', 1),
(2215, 142, 'Bayanhongor', '069', 1),
(2216, 142, 'Bayan-Olgiy', '071', 1),
(2217, 142, 'Arhangay', '073', 1),
(2218, 143, 'Saint Anthony', 'A', 1),
(2219, 143, 'Saint Georges', 'G', 1),
(2220, 143, 'Saint Peter', 'P', 1),
(2221, 144, 'Agadir', 'AGD', 1),
(2222, 144, 'Al Hoceima', 'HOC', 1),
(2223, 144, 'Azilal', 'AZI', 1),
(2224, 144, 'Beni Mellal', 'BME', 1),
(2225, 144, 'Ben Slimane', 'BSL', 1),
(2226, 144, 'Boulemane', 'BLM', 1),
(2227, 144, 'Casablanca', 'CBL', 1),
(2228, 144, 'Chaouen', 'CHA', 1),
(2229, 144, 'El Jadida', 'EJA', 1),
(2230, 144, 'El Kelaa des Sraghna', 'EKS', 1),
(2231, 144, 'Er Rachidia', 'ERA', 1),
(2232, 144, 'Essaouira', 'ESS', 1),
(2233, 144, 'Fes', 'FES', 1),
(2234, 144, 'Figuig', 'FIG', 1),
(2235, 144, 'Guelmim', 'GLM', 1),
(2236, 144, 'Ifrane', 'IFR', 1),
(2237, 144, 'Kenitra', 'KEN', 1),
(2238, 144, 'Khemisset', 'KHM', 1),
(2239, 144, 'Khenifra', 'KHN', 1),
(2240, 144, 'Khouribga', 'KHO', 1),
(2241, 144, 'Laayoune', 'LYN', 1),
(2242, 144, 'Larache', 'LAR', 1),
(2243, 144, 'Marrakech', 'MRK', 1),
(2244, 144, 'Meknes', 'MKN', 1),
(2245, 144, 'Nador', 'NAD', 1),
(2246, 144, 'Ouarzazate', 'ORZ', 1),
(2247, 144, 'Oujda', 'OUJ', 1),
(2248, 144, 'Rabat-Sale', 'RSA', 1),
(2249, 144, 'Safi', 'SAF', 1),
(2250, 144, 'Settat', 'SET', 1),
(2251, 144, 'Sidi Kacem', 'SKA', 1),
(2252, 144, 'Tangier', 'TGR', 1),
(2253, 144, 'Tan-Tan', 'TAN', 1),
(2254, 144, 'Taounate', 'TAO', 1),
(2255, 144, 'Taroudannt', 'TRD', 1),
(2256, 144, 'Tata', 'TAT', 1),
(2257, 144, 'Taza', 'TAZ', 1),
(2258, 144, 'Tetouan', 'TET', 1),
(2259, 144, 'Tiznit', 'TIZ', 1),
(2260, 144, 'Ad Dakhla', 'ADK', 1),
(2261, 144, 'Boujdour', 'BJD', 1),
(2262, 144, 'Es Smara', 'ESM', 1),
(2263, 145, 'Cabo Delgado', 'CD', 1),
(2264, 145, 'Gaza', 'GZ', 1),
(2265, 145, 'Inhambane', 'IN', 1),
(2266, 145, 'Manica', 'MN', 1),
(2267, 145, 'Maputo (city)', 'MC', 1),
(2268, 145, 'Maputo', 'MP', 1),
(2269, 145, 'Nampula', 'NA', 1),
(2270, 145, 'Niassa', 'NI', 1),
(2271, 145, 'Sofala', 'SO', 1),
(2272, 145, 'Tete', 'TE', 1),
(2273, 145, 'Zambezia', 'ZA', 1),
(2274, 146, 'Ayeyarwady', 'AY', 1),
(2275, 146, 'Bago', 'BG', 1),
(2276, 146, 'Magway', 'MG', 1),
(2277, 146, 'Mandalay', 'MD', 1),
(2278, 146, 'Sagaing', 'SG', 1),
(2279, 146, 'Tanintharyi', 'TN', 1),
(2280, 146, 'Yangon', 'YG', 1),
(2281, 146, 'Chin State', 'CH', 1),
(2282, 146, 'Kachin State', 'KC', 1),
(2283, 146, 'Kayah State', 'KH', 1),
(2284, 146, 'Kayin State', 'KN', 1),
(2285, 146, 'Mon State', 'MN', 1),
(2286, 146, 'Rakhine State', 'RK', 1),
(2287, 146, 'Shan State', 'SH', 1),
(2288, 147, 'Caprivi', 'CA', 1),
(2289, 147, 'Erongo', 'ER', 1),
(2290, 147, 'Hardap', 'HA', 1),
(2291, 147, 'Karas', 'KR', 1),
(2292, 147, 'Kavango', 'KV', 1),
(2293, 147, 'Khomas', 'KH', 1),
(2294, 147, 'Kunene', 'KU', 1),
(2295, 147, 'Ohangwena', 'OW', 1),
(2296, 147, 'Omaheke', 'OK', 1),
(2297, 147, 'Omusati', 'OT', 1),
(2298, 147, 'Oshana', 'ON', 1),
(2299, 147, 'Oshikoto', 'OO', 1),
(2300, 147, 'Otjozondjupa', 'OJ', 1),
(2301, 148, 'Aiwo', 'AO', 1),
(2302, 148, 'Anabar', 'AA', 1),
(2303, 148, 'Anetan', 'AT', 1),
(2304, 148, 'Anibare', 'AI', 1),
(2305, 148, 'Baiti', 'BA', 1),
(2306, 148, 'Boe', 'BO', 1),
(2307, 148, 'Buada', 'BU', 1),
(2308, 148, 'Denigomodu', 'DE', 1),
(2309, 148, 'Ewa', 'EW', 1),
(2310, 148, 'Ijuw', 'IJ', 1),
(2311, 148, 'Meneng', 'ME', 1),
(2312, 148, 'Nibok', 'NI', 1),
(2313, 148, 'Uaboe', 'UA', 1),
(2314, 148, 'Yaren', 'YA', 1),
(2315, 149, 'Bagmati', 'BA', 1),
(2316, 149, 'Bheri', 'BH', 1),
(2317, 149, 'Dhawalagiri', 'DH', 1),
(2318, 149, 'Gandaki', 'GA', 1),
(2319, 149, 'Janakpur', 'JA', 1),
(2320, 149, 'Karnali', 'KA', 1),
(2321, 149, 'Kosi', 'KO', 1),
(2322, 149, 'Lumbini', 'LU', 1),
(2323, 149, 'Mahakali', 'MA', 1),
(2324, 149, 'Mechi', 'ME', 1),
(2325, 149, 'Narayani', 'NA', 1),
(2326, 149, 'Rapti', 'RA', 1),
(2327, 149, 'Sagarmatha', 'SA', 1),
(2328, 149, 'Seti', 'SE', 1),
(2329, 150, 'Drenthe', 'DR', 1),
(2330, 150, 'Flevoland', 'FL', 1),
(2331, 150, 'Friesland', 'FR', 1),
(2332, 150, 'Gelderland', 'GE', 1),
(2333, 150, 'Groningen', 'GR', 1),
(2334, 150, 'Limburg', 'LI', 1),
(2335, 150, 'Noord Brabant', 'NB', 1),
(2336, 150, 'Noord Holland', 'NH', 1),
(2337, 150, 'Overijssel', 'OV', 1),
(2338, 150, 'Utrecht', 'UT', 1),
(2339, 150, 'Zeeland', 'ZE', 1),
(2340, 150, 'Zuid Holland', 'ZH', 1),
(2341, 152, 'Iles Loyaute', 'L', 1),
(2342, 152, 'Nord', 'N', 1),
(2343, 152, 'Sud', 'S', 1),
(2344, 153, 'Auckland', 'AUK', 1),
(2345, 153, 'Bay of Plenty', 'BOP', 1),
(2346, 153, 'Canterbury', 'CAN', 1),
(2347, 153, 'Coromandel', 'COR', 1),
(2348, 153, 'Gisborne', 'GIS', 1),
(2349, 153, 'Fiordland', 'FIO', 1),
(2350, 153, 'Hawke''s Bay', 'HKB', 1),
(2351, 153, 'Marlborough', 'MBH', 1),
(2352, 153, 'Manawatu-Wanganui', 'MWT', 1),
(2353, 153, 'Mt Cook-Mackenzie', 'MCM', 1),
(2354, 153, 'Nelson', 'NSN', 1),
(2355, 153, 'Northland', 'NTL', 1),
(2356, 153, 'Otago', 'OTA', 1),
(2357, 153, 'Southland', 'STL', 1),
(2358, 153, 'Taranaki', 'TKI', 1),
(2359, 153, 'Wellington', 'WGN', 1),
(2360, 153, 'Waikato', 'WKO', 1),
(2361, 153, 'Wairarapa', 'WAI', 1),
(2362, 153, 'West Coast', 'WTC', 1),
(2363, 154, 'Atlantico Norte', 'AN', 1),
(2364, 154, 'Atlantico Sur', 'AS', 1),
(2365, 154, 'Boaco', 'BO', 1),
(2366, 154, 'Carazo', 'CA', 1),
(2367, 154, 'Chinandega', 'CI', 1),
(2368, 154, 'Chontales', 'CO', 1),
(2369, 154, 'Esteli', 'ES', 1),
(2370, 154, 'Granada', 'GR', 1),
(2371, 154, 'Jinotega', 'JI', 1),
(2372, 154, 'Leon', 'LE', 1),
(2373, 154, 'Madriz', 'MD', 1),
(2374, 154, 'Managua', 'MN', 1),
(2375, 154, 'Masaya', 'MS', 1),
(2376, 154, 'Matagalpa', 'MT', 1),
(2377, 154, 'Nuevo Segovia', 'NS', 1),
(2378, 154, 'Rio San Juan', 'RS', 1),
(2379, 154, 'Rivas', 'RI', 1),
(2380, 155, 'Agadez', 'AG', 1),
(2381, 155, 'Diffa', 'DF', 1),
(2382, 155, 'Dosso', 'DS', 1),
(2383, 155, 'Maradi', 'MA', 1),
(2384, 155, 'Niamey', 'NM', 1),
(2385, 155, 'Tahoua', 'TH', 1),
(2386, 155, 'Tillaberi', 'TL', 1),
(2387, 155, 'Zinder', 'ZD', 1),
(2388, 156, 'Abia', 'AB', 1),
(2389, 156, 'Abuja Federal Capital Territory', 'CT', 1),
(2390, 156, 'Adamawa', 'AD', 1),
(2391, 156, 'Akwa Ibom', 'AK', 1),
(2392, 156, 'Anambra', 'AN', 1),
(2393, 156, 'Bauchi', 'BC', 1),
(2394, 156, 'Bayelsa', 'BY', 1),
(2395, 156, 'Benue', 'BN', 1),
(2396, 156, 'Borno', 'BO', 1),
(2397, 156, 'Cross River', 'CR', 1),
(2398, 156, 'Delta', 'DE', 1),
(2399, 156, 'Ebonyi', 'EB', 1),
(2400, 156, 'Edo', 'ED', 1),
(2401, 156, 'Ekiti', 'EK', 1),
(2402, 156, 'Enugu', 'EN', 1),
(2403, 156, 'Gombe', 'GO', 1),
(2404, 156, 'Imo', 'IM', 1),
(2405, 156, 'Jigawa', 'JI', 1),
(2406, 156, 'Kaduna', 'KD', 1),
(2407, 156, 'Kano', 'KN', 1),
(2408, 156, 'Katsina', 'KT', 1),
(2409, 156, 'Kebbi', 'KE', 1),
(2410, 156, 'Kogi', 'KO', 1),
(2411, 156, 'Kwara', 'KW', 1),
(2412, 156, 'Lagos', 'LA', 1),
(2413, 156, 'Nassarawa', 'NA', 1),
(2414, 156, 'Niger', 'NI', 1),
(2415, 156, 'Ogun', 'OG', 1),
(2416, 156, 'Ondo', 'ONG', 1),
(2417, 156, 'Osun', 'OS', 1),
(2418, 156, 'Oyo', 'OY', 1),
(2419, 156, 'Plateau', 'PL', 1),
(2420, 156, 'Rivers', 'RI', 1),
(2421, 156, 'Sokoto', 'SO', 1),
(2422, 156, 'Taraba', 'TA', 1),
(2423, 156, 'Yobe', 'YO', 1),
(2424, 156, 'Zamfara', 'ZA', 1),
(2425, 159, 'Northern Islands', 'N', 1),
(2426, 159, 'Rota', 'R', 1),
(2427, 159, 'Saipan', 'S', 1),
(2428, 159, 'Tinian', 'T', 1),
(2429, 160, 'Akershus', 'AK', 1),
(2430, 160, 'Aust-Agder', 'AA', 1),
(2431, 160, 'Buskerud', 'BU', 1),
(2432, 160, 'Finnmark', 'FM', 1),
(2433, 160, 'Hedmark', 'HM', 1),
(2434, 160, 'Hordaland', 'HL', 1),
(2435, 160, 'More og Romdal', 'MR', 1),
(2436, 160, 'Nord-Trondelag', 'NT', 1),
(2437, 160, 'Nordland', 'NL', 1),
(2438, 160, 'Ostfold', 'OF', 1),
(2439, 160, 'Oppland', 'OP', 1),
(2440, 160, 'Oslo', 'OL', 1),
(2441, 160, 'Rogaland', 'RL', 1),
(2442, 160, 'Sor-Trondelag', 'ST', 1),
(2443, 160, 'Sogn og Fjordane', 'SJ', 1),
(2444, 160, 'Svalbard', 'SV', 1),
(2445, 160, 'Telemark', 'TM', 1),
(2446, 160, 'Troms', 'TR', 1),
(2447, 160, 'Vest-Agder', 'VA', 1),
(2448, 160, 'Vestfold', 'VF', 1),
(2449, 161, 'Ad Dakhiliyah', 'DA', 1),
(2450, 161, 'Al Batinah', 'BA', 1),
(2451, 161, 'Al Wusta', 'WU', 1),
(2452, 161, 'Ash Sharqiyah', 'SH', 1),
(2453, 161, 'Az Zahirah', 'ZA', 1),
(2454, 161, 'Masqat', 'MA', 1),
(2455, 161, 'Musandam', 'MU', 1),
(2456, 161, 'Zufar', 'ZU', 1),
(2457, 162, 'Balochistan', 'B', 1),
(2458, 162, 'Federally Administered Tribal Areas', 'T', 1),
(2459, 162, 'Islamabad Capital Territory', 'I', 1),
(2460, 162, 'North-West Frontier', 'N', 1),
(2461, 162, 'Punjab', 'P', 1),
(2462, 162, 'Sindh', 'S', 1),
(2463, 163, 'Aimeliik', 'AM', 1),
(2464, 163, 'Airai', 'AR', 1),
(2465, 163, 'Angaur', 'AN', 1),
(2466, 163, 'Hatohobei', 'HA', 1),
(2467, 163, 'Kayangel', 'KA', 1),
(2468, 163, 'Koror', 'KO', 1),
(2469, 163, 'Melekeok', 'ME', 1),
(2470, 163, 'Ngaraard', 'NA', 1),
(2471, 163, 'Ngarchelong', 'NG', 1),
(2472, 163, 'Ngardmau', 'ND', 1),
(2473, 163, 'Ngatpang', 'NT', 1),
(2474, 163, 'Ngchesar', 'NC', 1),
(2475, 163, 'Ngeremlengui', 'NR', 1),
(2476, 163, 'Ngiwal', 'NW', 1),
(2477, 163, 'Peleliu', 'PE', 1),
(2478, 163, 'Sonsorol', 'SO', 1),
(2479, 164, 'Bocas del Toro', 'BT', 1),
(2480, 164, 'Chiriqui', 'CH', 1),
(2481, 164, 'Cocle', 'CC', 1),
(2482, 164, 'Colon', 'CL', 1),
(2483, 164, 'Darien', 'DA', 1),
(2484, 164, 'Herrera', 'HE', 1),
(2485, 164, 'Los Santos', 'LS', 1),
(2486, 164, 'Panama', 'PA', 1),
(2487, 164, 'San Blas', 'SB', 1),
(2488, 164, 'Veraguas', 'VG', 1),
(2489, 165, 'Bougainville', 'BV', 1),
(2490, 165, 'Central', 'CE', 1),
(2491, 165, 'Chimbu', 'CH', 1),
(2492, 165, 'Eastern Highlands', 'EH', 1),
(2493, 165, 'East New Britain', 'EB', 1),
(2494, 165, 'East Sepik', 'ES', 1),
(2495, 165, 'Enga', 'EN', 1),
(2496, 165, 'Gulf', 'GU', 1),
(2497, 165, 'Madang', 'MD', 1),
(2498, 165, 'Manus', 'MN', 1),
(2499, 165, 'Milne Bay', 'MB', 1),
(2500, 165, 'Morobe', 'MR', 1),
(2501, 165, 'National Capital', 'NC', 1),
(2502, 165, 'New Ireland', 'NI', 1),
(2503, 165, 'Northern', 'NO', 1),
(2504, 165, 'Sandaun', 'SA', 1),
(2505, 165, 'Southern Highlands', 'SH', 1),
(2506, 165, 'Western', 'WE', 1),
(2507, 165, 'Western Highlands', 'WH', 1),
(2508, 165, 'West New Britain', 'WB', 1),
(2509, 166, 'Alto Paraguay', 'AG', 1),
(2510, 166, 'Alto Parana', 'AN', 1),
(2511, 166, 'Amambay', 'AM', 1),
(2512, 166, 'Asuncion', 'AS', 1),
(2513, 166, 'Boqueron', 'BO', 1),
(2514, 166, 'Caaguazu', 'CG', 1),
(2515, 166, 'Caazapa', 'CZ', 1),
(2516, 166, 'Canindeyu', 'CN', 1),
(2517, 166, 'Central', 'CE', 1),
(2518, 166, 'Concepcion', 'CC', 1),
(2519, 166, 'Cordillera', 'CD', 1),
(2520, 166, 'Guaira', 'GU', 1),
(2521, 166, 'Itapua', 'IT', 1),
(2522, 166, 'Misiones', 'MI', 1),
(2523, 166, 'Neembucu', 'NE', 1),
(2524, 166, 'Paraguari', 'PA', 1),
(2525, 166, 'Presidente Hayes', 'PH', 1),
(2526, 166, 'San Pedro', 'SP', 1),
(2527, 167, 'Amazonas', 'AM', 1),
(2528, 167, 'Ancash', 'AN', 1),
(2529, 167, 'Apurimac', 'AP', 1),
(2530, 167, 'Arequipa', 'AR', 1),
(2531, 167, 'Ayacucho', 'AY', 1),
(2532, 167, 'Cajamarca', 'CJ', 1),
(2533, 167, 'Callao', 'CL', 1),
(2534, 167, 'Cusco', 'CU', 1),
(2535, 167, 'Huancavelica', 'HV', 1),
(2536, 167, 'Huanuco', 'HO', 1),
(2537, 167, 'Ica', 'IC', 1),
(2538, 167, 'Junin', 'JU', 1),
(2539, 167, 'La Libertad', 'LD', 1),
(2540, 167, 'Lambayeque', 'LY', 1),
(2541, 167, 'Lima', 'LI', 1),
(2542, 167, 'Loreto', 'LO', 1),
(2543, 167, 'Madre de Dios', 'MD', 1),
(2544, 167, 'Moquegua', 'MO', 1),
(2545, 167, 'Pasco', 'PA', 1),
(2546, 167, 'Piura', 'PI', 1),
(2547, 167, 'Puno', 'PU', 1),
(2548, 167, 'San Martin', 'SM', 1),
(2549, 167, 'Tacna', 'TA', 1),
(2550, 167, 'Tumbes', 'TU', 1),
(2551, 167, 'Ucayali', 'UC', 1),
(2552, 168, 'Abra', 'ABR', 1),
(2553, 168, 'Agusan del Norte', 'ANO', 1),
(2554, 168, 'Agusan del Sur', 'ASU', 1),
(2555, 168, 'Aklan', 'AKL', 1),
(2556, 168, 'Albay', 'ALB', 1),
(2557, 168, 'Antique', 'ANT', 1),
(2558, 168, 'Apayao', 'APY', 1),
(2559, 168, 'Aurora', 'AUR', 1),
(2560, 168, 'Basilan', 'BAS', 1),
(2561, 168, 'Bataan', 'BTA', 1),
(2562, 168, 'Batanes', 'BTE', 1),
(2563, 168, 'Batangas', 'BTG', 1),
(2564, 168, 'Biliran', 'BLR', 1),
(2565, 168, 'Benguet', 'BEN', 1),
(2566, 168, 'Bohol', 'BOL', 1),
(2567, 168, 'Bukidnon', 'BUK', 1),
(2568, 168, 'Bulacan', 'BUL', 1),
(2569, 168, 'Cagayan', 'CAG', 1),
(2570, 168, 'Camarines Norte', 'CNO', 1),
(2571, 168, 'Camarines Sur', 'CSU', 1),
(2572, 168, 'Camiguin', 'CAM', 1),
(2573, 168, 'Capiz', 'CAP', 1),
(2574, 168, 'Catanduanes', 'CAT', 1),
(2575, 168, 'Cavite', 'CAV', 1),
(2576, 168, 'Cebu', 'CEB', 1),
(2577, 168, 'Compostela', 'CMP', 1),
(2578, 168, 'Davao del Norte', 'DNO', 1),
(2579, 168, 'Davao del Sur', 'DSU', 1),
(2580, 168, 'Davao Oriental', 'DOR', 1),
(2581, 168, 'Eastern Samar', 'ESA', 1),
(2582, 168, 'Guimaras', 'GUI', 1),
(2583, 168, 'Ifugao', 'IFU', 1),
(2584, 168, 'Ilocos Norte', 'INO', 1),
(2585, 168, 'Ilocos Sur', 'ISU', 1),
(2586, 168, 'Iloilo', 'ILO', 1),
(2587, 168, 'Isabela', 'ISA', 1),
(2588, 168, 'Kalinga', 'KAL', 1),
(2589, 168, 'Laguna', 'LAG', 1),
(2590, 168, 'Lanao del Norte', 'LNO', 1),
(2591, 168, 'Lanao del Sur', 'LSU', 1),
(2592, 168, 'La Union', 'UNI', 1),
(2593, 168, 'Leyte', 'LEY', 1),
(2594, 168, 'Maguindanao', 'MAG', 1),
(2595, 168, 'Marinduque', 'MRN', 1),
(2596, 168, 'Masbate', 'MSB', 1),
(2597, 168, 'Mindoro Occidental', 'MIC', 1),
(2598, 168, 'Mindoro Oriental', 'MIR', 1),
(2599, 168, 'Misamis Occidental', 'MSC', 1),
(2600, 168, 'Misamis Oriental', 'MOR', 1),
(2601, 168, 'Mountain', 'MOP', 1),
(2602, 168, 'Negros Occidental', 'NOC', 1),
(2603, 168, 'Negros Oriental', 'NOR', 1),
(2604, 168, 'North Cotabato', 'NCT', 1),
(2605, 168, 'Northern Samar', 'NSM', 1),
(2606, 168, 'Nueva Ecija', 'NEC', 1),
(2607, 168, 'Nueva Vizcaya', 'NVZ', 1),
(2608, 168, 'Palawan', 'PLW', 1),
(2609, 168, 'Pampanga', 'PMP', 1),
(2610, 168, 'Pangasinan', 'PNG', 1),
(2611, 168, 'Quezon', 'QZN', 1),
(2612, 168, 'Quirino', 'QRN', 1),
(2613, 168, 'Rizal', 'RIZ', 1),
(2614, 168, 'Romblon', 'ROM', 1),
(2615, 168, 'Samar', 'SMR', 1),
(2616, 168, 'Sarangani', 'SRG', 1),
(2617, 168, 'Siquijor', 'SQJ', 1),
(2618, 168, 'Sorsogon', 'SRS', 1),
(2619, 168, 'South Cotabato', 'SCO', 1),
(2620, 168, 'Southern Leyte', 'SLE', 1),
(2621, 168, 'Sultan Kudarat', 'SKU', 1),
(2622, 168, 'Sulu', 'SLU', 1),
(2623, 168, 'Surigao del Norte', 'SNO', 1),
(2624, 168, 'Surigao del Sur', 'SSU', 1),
(2625, 168, 'Tarlac', 'TAR', 1),
(2626, 168, 'Tawi-Tawi', 'TAW', 1),
(2627, 168, 'Zambales', 'ZBL', 1),
(2628, 168, 'Zamboanga del Norte', 'ZNO', 1),
(2629, 168, 'Zamboanga del Sur', 'ZSU', 1),
(2630, 168, 'Zamboanga Sibugay', 'ZSI', 1),
(2631, 170, 'Dolnoslaskie', 'DO', 1),
(2632, 170, 'Kujawsko-Pomorskie', 'KP', 1),
(2633, 170, 'Lodzkie', 'LO', 1),
(2634, 170, 'Lubelskie', 'LL', 1),
(2635, 170, 'Lubuskie', 'LU', 1),
(2636, 170, 'Malopolskie', 'ML', 1),
(2637, 170, 'Mazowieckie', 'MZ', 1),
(2638, 170, 'Opolskie', 'OP', 1),
(2639, 170, 'Podkarpackie', 'PP', 1),
(2640, 170, 'Podlaskie', 'PL', 1),
(2641, 170, 'Pomorskie', 'PM', 1),
(2642, 170, 'Slaskie', 'SL', 1),
(2643, 170, 'Swietokrzyskie', 'SW', 1),
(2644, 170, 'Warminsko-Mazurskie', 'WM', 1),
(2645, 170, 'Wielkopolskie', 'WP', 1),
(2646, 170, 'Zachodniopomorskie', 'ZA', 1),
(2647, 198, 'Saint Pierre', 'P', 1),
(2648, 198, 'Miquelon', 'M', 1),
(2649, 171, 'A&ccedil;ores', 'AC', 1),
(2650, 171, 'Aveiro', 'AV', 1),
(2651, 171, 'Beja', 'BE', 1),
(2652, 171, 'Braga', 'BR', 1),
(2653, 171, 'Bragan&ccedil;a', 'BA', 1),
(2654, 171, 'Castelo Branco', 'CB', 1),
(2655, 171, 'Coimbra', 'CO', 1),
(2656, 171, '&Eacute;vora', 'EV', 1),
(2657, 171, 'Faro', 'FA', 1),
(2658, 171, 'Guarda', 'GU', 1),
(2659, 171, 'Leiria', 'LE', 1),
(2660, 171, 'Lisboa', 'LI', 1),
(2661, 171, 'Madeira', 'ME', 1),
(2662, 171, 'Portalegre', 'PO', 1),
(2663, 171, 'Porto', 'PR', 1),
(2664, 171, 'Santar&eacute;m', 'SA', 1),
(2665, 171, 'Set&uacute;bal', 'SE', 1),
(2666, 171, 'Viana do Castelo', 'VC', 1),
(2667, 171, 'Vila Real', 'VR', 1),
(2668, 171, 'Viseu', 'VI', 1),
(2669, 173, 'Ad Dawhah', 'DW', 1),
(2670, 173, 'Al Ghuwayriyah', 'GW', 1),
(2671, 173, 'Al Jumayliyah', 'JM', 1),
(2672, 173, 'Al Khawr', 'KR', 1),
(2673, 173, 'Al Wakrah', 'WK', 1),
(2674, 173, 'Ar Rayyan', 'RN', 1),
(2675, 173, 'Jarayan al Batinah', 'JB', 1),
(2676, 173, 'Madinat ash Shamal', 'MS', 1),
(2677, 173, 'Umm Sa''id', 'UD', 1),
(2678, 173, 'Umm Salal', 'UL', 1),
(2679, 175, 'Alba', 'AB', 1),
(2680, 175, 'Arad', 'AR', 1),
(2681, 175, 'Arges', 'AG', 1),
(2682, 175, 'Bacau', 'BC', 1),
(2683, 175, 'Bihor', 'BH', 1),
(2684, 175, 'Bistrita-Nasaud', 'BN', 1),
(2685, 175, 'Botosani', 'BT', 1),
(2686, 175, 'Brasov', 'BV', 1),
(2687, 175, 'Braila', 'BR', 1),
(2688, 175, 'Bucuresti', 'B', 1),
(2689, 175, 'Buzau', 'BZ', 1),
(2690, 175, 'Caras-Severin', 'CS', 1),
(2691, 175, 'Calarasi', 'CL', 1),
(2692, 175, 'Cluj', 'CJ', 1),
(2693, 175, 'Constanta', 'CT', 1),
(2694, 175, 'Covasna', 'CV', 1),
(2695, 175, 'Dimbovita', 'DB', 1),
(2696, 175, 'Dolj', 'DJ', 1),
(2697, 175, 'Galati', 'GL', 1),
(2698, 175, 'Giurgiu', 'GR', 1),
(2699, 175, 'Gorj', 'GJ', 1),
(2700, 175, 'Harghita', 'HR', 1),
(2701, 175, 'Hunedoara', 'HD', 1),
(2702, 175, 'Ialomita', 'IL', 1),
(2703, 175, 'Iasi', 'IS', 1),
(2704, 175, 'Ilfov', 'IF', 1),
(2705, 175, 'Maramures', 'MM', 1),
(2706, 175, 'Mehedinti', 'MH', 1),
(2707, 175, 'Mures', 'MS', 1),
(2708, 175, 'Neamt', 'NT', 1),
(2709, 175, 'Olt', 'OT', 1),
(2710, 175, 'Prahova', 'PH', 1),
(2711, 175, 'Satu-Mare', 'SM', 1),
(2712, 175, 'Salaj', 'SJ', 1),
(2713, 175, 'Sibiu', 'SB', 1),
(2714, 175, 'Suceava', 'SV', 1),
(2715, 175, 'Teleorman', 'TR', 1),
(2716, 175, 'Timis', 'TM', 1),
(2717, 175, 'Tulcea', 'TL', 1),
(2718, 175, 'Vaslui', 'VS', 1),
(2719, 175, 'Valcea', 'VL', 1),
(2720, 175, 'Vrancea', 'VN', 1),
(2721, 176, 'Abakan', 'AB', 1),
(2722, 176, 'Aginskoye', 'AG', 1),
(2723, 176, 'Anadyr', 'AN', 1),
(2724, 176, 'Arkahangelsk', 'AR', 1),
(2725, 176, 'Astrakhan', 'AS', 1),
(2726, 176, 'Barnaul', 'BA', 1),
(2727, 176, 'Belgorod', 'BE', 1),
(2728, 176, 'Birobidzhan', 'BI', 1),
(2729, 176, 'Blagoveshchensk', 'BL', 1),
(2730, 176, 'Bryansk', 'BR', 1),
(2731, 176, 'Cheboksary', 'CH', 1),
(2732, 176, 'Chelyabinsk', 'CL', 1),
(2733, 176, 'Cherkessk', 'CR', 1),
(2734, 176, 'Chita', 'CI', 1),
(2735, 176, 'Dudinka', 'DU', 1),
(2736, 176, 'Elista', 'EL', 1),
(2737, 176, 'Gomo-Altaysk', 'GO', 1),
(2738, 176, 'Gorno-Altaysk', 'GA', 1),
(2739, 176, 'Groznyy', 'GR', 1),
(2740, 176, 'Irkutsk', 'IR', 1),
(2741, 176, 'Ivanovo', 'IV', 1),
(2742, 176, 'Izhevsk', 'IZ', 1),
(2743, 176, 'Kalinigrad', 'KA', 1),
(2744, 176, 'Kaluga', 'KL', 1),
(2745, 176, 'Kasnodar', 'KS', 1),
(2746, 176, 'Kazan', 'KZ', 1),
(2747, 176, 'Kemerovo', 'KE', 1),
(2748, 176, 'Khabarovsk', 'KH', 1),
(2749, 176, 'Khanty-Mansiysk', 'KM', 1),
(2750, 176, 'Kostroma', 'KO', 1),
(2751, 176, 'Krasnodar', 'KR', 1),
(2752, 176, 'Krasnoyarsk', 'KN', 1),
(2753, 176, 'Kudymkar', 'KU', 1),
(2754, 176, 'Kurgan', 'KG', 1),
(2755, 176, 'Kursk', 'KK', 1),
(2756, 176, 'Kyzyl', 'KY', 1),
(2757, 176, 'Lipetsk', 'LI', 1),
(2758, 176, 'Magadan', 'MA', 1),
(2759, 176, 'Makhachkala', 'MK', 1),
(2760, 176, 'Maykop', 'MY', 1),
(2761, 176, 'Moscow', 'MO', 1),
(2762, 176, 'Murmansk', 'MU', 1),
(2763, 176, 'Nalchik', 'NA', 1),
(2764, 176, 'Naryan Mar', 'NR', 1),
(2765, 176, 'Nazran', 'NZ', 1),
(2766, 176, 'Nizhniy Novgorod', 'NI', 1),
(2767, 176, 'Novgorod', 'NO', 1),
(2768, 176, 'Novosibirsk', 'NV', 1),
(2769, 176, 'Omsk', 'OM', 1),
(2770, 176, 'Orel', 'OR', 1),
(2771, 176, 'Orenburg', 'OE', 1),
(2772, 176, 'Palana', 'PA', 1),
(2773, 176, 'Penza', 'PE', 1),
(2774, 176, 'Perm', 'PR', 1),
(2775, 176, 'Petropavlovsk-Kamchatskiy', 'PK', 1),
(2776, 176, 'Petrozavodsk', 'PT', 1),
(2777, 176, 'Pskov', 'PS', 1),
(2778, 176, 'Rostov-na-Donu', 'RO', 1),
(2779, 176, 'Ryazan', 'RY', 1),
(2780, 176, 'Salekhard', 'SL', 1),
(2781, 176, 'Samara', 'SA', 1),
(2782, 176, 'Saransk', 'SR', 1),
(2783, 176, 'Saratov', 'SV', 1),
(2784, 176, 'Smolensk', 'SM', 1),
(2785, 176, 'St. Petersburg', 'SP', 1),
(2786, 176, 'Stavropol', 'ST', 1),
(2787, 176, 'Syktyvkar', 'SY', 1),
(2788, 176, 'Tambov', 'TA', 1),
(2789, 176, 'Tomsk', 'TO', 1),
(2790, 176, 'Tula', 'TU', 1),
(2791, 176, 'Tura', 'TR', 1),
(2792, 176, 'Tver', 'TV', 1),
(2793, 176, 'Tyumen', 'TY', 1),
(2794, 176, 'Ufa', 'UF', 1),
(2795, 176, 'Ul''yanovsk', 'UL', 1),
(2796, 176, 'Ulan-Ude', 'UU', 1),
(2797, 176, 'Ust''-Ordynskiy', 'US', 1),
(2798, 176, 'Vladikavkaz', 'VL', 1),
(2799, 176, 'Vladimir', 'VA', 1),
(2800, 176, 'Vladivostok', 'VV', 1),
(2801, 176, 'Volgograd', 'VG', 1),
(2802, 176, 'Vologda', 'VD', 1),
(2803, 176, 'Voronezh', 'VO', 1),
(2804, 176, 'Vyatka', 'VY', 1),
(2805, 176, 'Yakutsk', 'YA', 1),
(2806, 176, 'Yaroslavl', 'YR', 1),
(2807, 176, 'Yekaterinburg', 'YE', 1),
(2808, 176, 'Yoshkar-Ola', 'YO', 1),
(2809, 177, 'Butare', 'BU', 1),
(2810, 177, 'Byumba', 'BY', 1),
(2811, 177, 'Cyangugu', 'CY', 1),
(2812, 177, 'Gikongoro', 'GK', 1),
(2813, 177, 'Gisenyi', 'GS', 1),
(2814, 177, 'Gitarama', 'GT', 1),
(2815, 177, 'Kibungo', 'KG', 1),
(2816, 177, 'Kibuye', 'KY', 1),
(2817, 177, 'Kigali Rurale', 'KR', 1),
(2818, 177, 'Kigali-ville', 'KV', 1),
(2819, 177, 'Ruhengeri', 'RU', 1),
(2820, 177, 'Umutara', 'UM', 1),
(2821, 178, 'Christ Church Nichola Town', 'CCN', 1),
(2822, 178, 'Saint Anne Sandy Point', 'SAS', 1),
(2823, 178, 'Saint George Basseterre', 'SGB', 1),
(2824, 178, 'Saint George Gingerland', 'SGG', 1),
(2825, 178, 'Saint James Windward', 'SJW', 1),
(2826, 178, 'Saint John Capesterre', 'SJC', 1),
(2827, 178, 'Saint John Figtree', 'SJF', 1),
(2828, 178, 'Saint Mary Cayon', 'SMC', 1),
(2829, 178, 'Saint Paul Capesterre', 'CAP', 1),
(2830, 178, 'Saint Paul Charlestown', 'CHA', 1),
(2831, 178, 'Saint Peter Basseterre', 'SPB', 1),
(2832, 178, 'Saint Thomas Lowland', 'STL', 1),
(2833, 178, 'Saint Thomas Middle Island', 'STM', 1),
(2834, 178, 'Trinity Palmetto Point', 'TPP', 1),
(2835, 179, 'Anse-la-Raye', 'AR', 1),
(2836, 179, 'Castries', 'CA', 1),
(2837, 179, 'Choiseul', 'CH', 1),
(2838, 179, 'Dauphin', 'DA', 1),
(2839, 179, 'Dennery', 'DE', 1),
(2840, 179, 'Gros-Islet', 'GI', 1),
(2841, 179, 'Laborie', 'LA', 1),
(2842, 179, 'Micoud', 'MI', 1),
(2843, 179, 'Praslin', 'PR', 1),
(2844, 179, 'Soufriere', 'SO', 1),
(2845, 179, 'Vieux-Fort', 'VF', 1),
(2846, 180, 'Charlotte', 'C', 1),
(2847, 180, 'Grenadines', 'R', 1),
(2848, 180, 'Saint Andrew', 'A', 1),
(2849, 180, 'Saint David', 'D', 1),
(2850, 180, 'Saint George', 'G', 1),
(2851, 180, 'Saint Patrick', 'P', 1),
(2852, 181, 'A''ana', 'AN', 1),
(2853, 181, 'Aiga-i-le-Tai', 'AI', 1),
(2854, 181, 'Atua', 'AT', 1),
(2855, 181, 'Fa''asaleleaga', 'FA', 1),
(2856, 181, 'Gaga''emauga', 'GE', 1),
(2857, 181, 'Gagaifomauga', 'GF', 1),
(2858, 181, 'Palauli', 'PA', 1),
(2859, 181, 'Satupa''itea', 'SA', 1),
(2860, 181, 'Tuamasaga', 'TU', 1),
(2861, 181, 'Va''a-o-Fonoti', 'VF', 1),
(2862, 181, 'Vaisigano', 'VS', 1),
(2863, 182, 'Acquaviva', 'AC', 1),
(2864, 182, 'Borgo Maggiore', 'BM', 1),
(2865, 182, 'Chiesanuova', 'CH', 1),
(2866, 182, 'Domagnano', 'DO', 1),
(2867, 182, 'Faetano', 'FA', 1),
(2868, 182, 'Fiorentino', 'FI', 1),
(2869, 182, 'Montegiardino', 'MO', 1),
(2870, 182, 'Citta di San Marino', 'SM', 1),
(2871, 182, 'Serravalle', 'SE', 1),
(2872, 183, 'Sao Tome', 'S', 1),
(2873, 183, 'Principe', 'P', 1),
(2874, 184, 'Al Bahah', 'BH', 1),
(2875, 184, 'Al Hudud ash Shamaliyah', 'HS', 1),
(2876, 184, 'Al Jawf', 'JF', 1),
(2877, 184, 'Al Madinah', 'MD', 1),
(2878, 184, 'Al Qasim', 'QS', 1),
(2879, 184, 'Ar Riyad', 'RD', 1),
(2880, 184, 'Ash Sharqiyah (Eastern)', 'AQ', 1),
(2881, 184, '''Asir', 'AS', 1),
(2882, 184, 'Ha''il', 'HL', 1),
(2883, 184, 'Jizan', 'JZ', 1),
(2884, 184, 'Makkah', 'ML', 1),
(2885, 184, 'Najran', 'NR', 1),
(2886, 184, 'Tabuk', 'TB', 1),
(2887, 185, 'Dakar', 'DA', 1),
(2888, 185, 'Diourbel', 'DI', 1),
(2889, 185, 'Fatick', 'FA', 1),
(2890, 185, 'Kaolack', 'KA', 1),
(2891, 185, 'Kolda', 'KO', 1),
(2892, 185, 'Louga', 'LO', 1),
(2893, 185, 'Matam', 'MA', 1),
(2894, 185, 'Saint-Louis', 'SL', 1),
(2895, 185, 'Tambacounda', 'TA', 1),
(2896, 185, 'Thies', 'TH', 1),
(2897, 185, 'Ziguinchor', 'ZI', 1),
(2898, 186, 'Anse aux Pins', 'AP', 1),
(2899, 186, 'Anse Boileau', 'AB', 1),
(2900, 186, 'Anse Etoile', 'AE', 1),
(2901, 186, 'Anse Louis', 'AL', 1),
(2902, 186, 'Anse Royale', 'AR', 1),
(2903, 186, 'Baie Lazare', 'BL', 1),
(2904, 186, 'Baie Sainte Anne', 'BS', 1),
(2905, 186, 'Beau Vallon', 'BV', 1),
(2906, 186, 'Bel Air', 'BA', 1),
(2907, 186, 'Bel Ombre', 'BO', 1),
(2908, 186, 'Cascade', 'CA', 1),
(2909, 186, 'Glacis', 'GL', 1),
(2910, 186, 'Grand'' Anse (on Mahe)', 'GM', 1),
(2911, 186, 'Grand'' Anse (on Praslin)', 'GP', 1),
(2912, 186, 'La Digue', 'DG', 1),
(2913, 186, 'La Riviere Anglaise', 'RA', 1),
(2914, 186, 'Mont Buxton', 'MB', 1),
(2915, 186, 'Mont Fleuri', 'MF', 1),
(2916, 186, 'Plaisance', 'PL', 1),
(2917, 186, 'Pointe La Rue', 'PR', 1),
(2918, 186, 'Port Glaud', 'PG', 1),
(2919, 186, 'Saint Louis', 'SL', 1),
(2920, 186, 'Takamaka', 'TA', 1),
(2921, 187, 'Eastern', 'E', 1),
(2922, 187, 'Northern', 'N', 1),
(2923, 187, 'Southern', 'S', 1),
(2924, 187, 'Western', 'W', 1),
(2925, 189, 'Banskobystrický', 'BA', 1),
(2926, 189, 'Bratislavský', 'BR', 1),
(2927, 189, 'Košický', 'KO', 1),
(2928, 189, 'Nitriansky', 'NI', 1),
(2929, 189, 'Prešovský', 'PR', 1),
(2930, 189, 'Tren', 'TC', 1),
(2931, 189, 'Trnavský', 'TV', 1),
(2932, 189, 'Žilinský', 'ZI', 1),
(2933, 191, 'Central', 'CE', 1),
(2934, 191, 'Choiseul', 'CH', 1),
(2935, 191, 'Guadalcanal', 'GC', 1),
(2936, 191, 'Honiara', 'HO', 1),
(2937, 191, 'Isabel', 'IS', 1),
(2938, 191, 'Makira', 'MK', 1),
(2939, 191, 'Malaita', 'ML', 1),
(2940, 191, 'Rennell and Bellona', 'RB', 1),
(2941, 191, 'Temotu', 'TM', 1),
(2942, 191, 'Western', 'WE', 1),
(2943, 192, 'Awdal', 'AW', 1),
(2944, 192, 'Bakool', 'BK', 1),
(2945, 192, 'Banaadir', 'BN', 1),
(2946, 192, 'Bari', 'BR', 1),
(2947, 192, 'Bay', 'BY', 1),
(2948, 192, 'Galguduud', 'GA', 1),
(2949, 192, 'Gedo', 'GE', 1),
(2950, 192, 'Hiiraan', 'HI', 1),
(2951, 192, 'Jubbada Dhexe', 'JD', 1),
(2952, 192, 'Jubbada Hoose', 'JH', 1),
(2953, 192, 'Mudug', 'MU', 1),
(2954, 192, 'Nugaal', 'NU', 1),
(2955, 192, 'Sanaag', 'SA', 1),
(2956, 192, 'Shabeellaha Dhexe', 'SD', 1),
(2957, 192, 'Shabeellaha Hoose', 'SH', 1),
(2958, 192, 'Sool', 'SL', 1),
(2959, 192, 'Togdheer', 'TO', 1),
(2960, 192, 'Woqooyi Galbeed', 'WG', 1),
(2961, 193, 'Eastern Cape', 'EC', 1),
(2962, 193, 'Free State', 'FS', 1),
(2963, 193, 'Gauteng', 'GT', 1),
(2964, 193, 'KwaZulu-Natal', 'KN', 1),
(2965, 193, 'Limpopo', 'LP', 1),
(2966, 193, 'Mpumalanga', 'MP', 1),
(2967, 193, 'North West', 'NW', 1),
(2968, 193, 'Northern Cape', 'NC', 1),
(2969, 193, 'Western Cape', 'WC', 1),
(2970, 195, 'La Coru&ntilde;a', 'CA', 1),
(2971, 195, '&Aacute;lava', 'AL', 1),
(2972, 195, 'Albacete', 'AB', 1),
(2973, 195, 'Alicante', 'AC', 1),
(2974, 195, 'Almeria', 'AM', 1),
(2975, 195, 'Asturias', 'AS', 1),
(2976, 195, '&Aacute;vila', 'AV', 1),
(2977, 195, 'Badajoz', 'BJ', 1),
(2978, 195, 'Baleares', 'IB', 1),
(2979, 195, 'Barcelona', 'BA', 1),
(2980, 195, 'Burgos', 'BU', 1),
(2981, 195, 'C&aacute;ceres', 'CC', 1),
(2982, 195, 'C&aacute;diz', 'CZ', 1),
(2983, 195, 'Cantabria', 'CT', 1),
(2984, 195, 'Castell&oacute;n', 'CL', 1),
(2985, 195, 'Ceuta', 'CE', 1),
(2986, 195, 'Ciudad Real', 'CR', 1),
(2987, 195, 'C&oacute;rdoba', 'CD', 1),
(2988, 195, 'Cuenca', 'CU', 1),
(2989, 195, 'Girona', 'GI', 1),
(2990, 195, 'Granada', 'GD', 1),
(2991, 195, 'Guadalajara', 'GJ', 1),
(2992, 195, 'Guip&uacute;zcoa', 'GP', 1),
(2993, 195, 'Huelva', 'HL', 1),
(2994, 195, 'Huesca', 'HS', 1),
(2995, 195, 'Ja&eacute;n', 'JN', 1),
(2996, 195, 'La Rioja', 'RJ', 1),
(2997, 195, 'Las Palmas', 'PM', 1),
(2998, 195, 'Leon', 'LE', 1),
(2999, 195, 'Lleida', 'LL', 1),
(3000, 195, 'Lugo', 'LG', 1),
(3001, 195, 'Madrid', 'MD', 1),
(3002, 195, 'Malaga', 'MA', 1),
(3003, 195, 'Melilla', 'ML', 1),
(3004, 195, 'Murcia', 'MU', 1),
(3005, 195, 'Navarra', 'NV', 1),
(3006, 195, 'Ourense', 'OU', 1),
(3007, 195, 'Palencia', 'PL', 1),
(3008, 195, 'Pontevedra', 'PO', 1),
(3009, 195, 'Salamanca', 'SL', 1),
(3010, 195, 'Santa Cruz de Tenerife', 'SC', 1),
(3011, 195, 'Segovia', 'SG', 1),
(3012, 195, 'Sevilla', 'SV', 1),
(3013, 195, 'Soria', 'SO', 1),
(3014, 195, 'Tarragona', 'TA', 1),
(3015, 195, 'Teruel', 'TE', 1),
(3016, 195, 'Toledo', 'TO', 1),
(3017, 195, 'Valencia', 'VC', 1),
(3018, 195, 'Valladolid', 'VD', 1),
(3019, 195, 'Vizcaya', 'VZ', 1),
(3020, 195, 'Zamora', 'ZM', 1),
(3021, 195, 'Zaragoza', 'ZR', 1),
(3022, 196, 'Central', 'CE', 1),
(3023, 196, 'Eastern', 'EA', 1),
(3024, 196, 'North Central', 'NC', 1),
(3025, 196, 'Northern', 'NO', 1),
(3026, 196, 'North Western', 'NW', 1),
(3027, 196, 'Sabaragamuwa', 'SA', 1),
(3028, 196, 'Southern', 'SO', 1),
(3029, 196, 'Uva', 'UV', 1),
(3030, 196, 'Western', 'WE', 1),
(3031, 197, 'Ascension', 'A', 1),
(3032, 197, 'Saint Helena', 'S', 1),
(3033, 197, 'Tristan da Cunha', 'T', 1),
(3034, 199, 'A''ali an Nil', 'ANL', 1),
(3035, 199, 'Al Bahr al Ahmar', 'BAM', 1),
(3036, 199, 'Al Buhayrat', 'BRT', 1),
(3037, 199, 'Al Jazirah', 'JZR', 1),
(3038, 199, 'Al Khartum', 'KRT', 1),
(3039, 199, 'Al Qadarif', 'QDR', 1),
(3040, 199, 'Al Wahdah', 'WDH', 1),
(3041, 199, 'An Nil al Abyad', 'ANB', 1),
(3042, 199, 'An Nil al Azraq', 'ANZ', 1),
(3043, 199, 'Ash Shamaliyah', 'ASH', 1),
(3044, 199, 'Bahr al Jabal', 'BJA', 1),
(3045, 199, 'Gharb al Istiwa''iyah', 'GIS', 1),
(3046, 199, 'Gharb Bahr al Ghazal', 'GBG', 1),
(3047, 199, 'Gharb Darfur', 'GDA', 1),
(3048, 199, 'Gharb Kurdufan', 'GKU', 1),
(3049, 199, 'Janub Darfur', 'JDA', 1),
(3050, 199, 'Janub Kurdufan', 'JKU', 1),
(3051, 199, 'Junqali', 'JQL', 1),
(3052, 199, 'Kassala', 'KSL', 1),
(3053, 199, 'Nahr an Nil', 'NNL', 1),
(3054, 199, 'Shamal Bahr al Ghazal', 'SBG', 1),
(3055, 199, 'Shamal Darfur', 'SDA', 1),
(3056, 199, 'Shamal Kurdufan', 'SKU', 1),
(3057, 199, 'Sharq al Istiwa''iyah', 'SIS', 1),
(3058, 199, 'Sinnar', 'SNR', 1),
(3059, 199, 'Warab', 'WRB', 1),
(3060, 200, 'Brokopondo', 'BR', 1),
(3061, 200, 'Commewijne', 'CM', 1),
(3062, 200, 'Coronie', 'CR', 1),
(3063, 200, 'Marowijne', 'MA', 1),
(3064, 200, 'Nickerie', 'NI', 1),
(3065, 200, 'Para', 'PA', 1),
(3066, 200, 'Paramaribo', 'PM', 1),
(3067, 200, 'Saramacca', 'SA', 1),
(3068, 200, 'Sipaliwini', 'SI', 1),
(3069, 200, 'Wanica', 'WA', 1),
(3070, 202, 'Hhohho', 'H', 1),
(3071, 202, 'Lubombo', 'L', 1),
(3072, 202, 'Manzini', 'M', 1),
(3073, 202, 'Shishelweni', 'S', 1),
(3074, 203, 'Blekinge', 'K', 1),
(3075, 203, 'Dalarna', 'W', 1),
(3076, 203, 'G&auml;vleborg', 'X', 1);
INSERT INTO `tblprfx_zones` (`id`, `country_id`, `name`, `code`, `status`) VALUES
(3077, 203, 'Gotland', 'I', 1),
(3078, 203, 'Halland', 'N', 1),
(3079, 203, 'J&auml;mtland', 'Z', 1),
(3080, 203, 'J&ouml;nk&ouml;ping', 'F', 1),
(3081, 203, 'Kalmar', 'H', 1),
(3082, 203, 'Kronoberg', 'G', 1),
(3083, 203, 'Norrbotten', 'BD', 1),
(3084, 203, '&Ouml;rebro', 'T', 1),
(3085, 203, '&Ouml;sterg&ouml;tland', 'E', 1),
(3086, 203, 'Sk&aring;ne', 'M', 1),
(3087, 203, 'S&ouml;dermanland', 'D', 1),
(3088, 203, 'Stockholm', 'AB', 1),
(3089, 203, 'Uppsala', 'C', 1),
(3090, 203, 'V&auml;rmland', 'S', 1),
(3091, 203, 'V&auml;sterbotten', 'AC', 1),
(3092, 203, 'V&auml;sternorrland', 'Y', 1),
(3093, 203, 'V&auml;stmanland', 'U', 1),
(3094, 203, 'V&auml;stra G&ouml;taland', 'O', 1),
(3095, 204, 'Aargau', 'AG', 1),
(3096, 204, 'Appenzell Ausserrhoden', 'AR', 1),
(3097, 204, 'Appenzell Innerrhoden', 'AI', 1),
(3098, 204, 'Basel-Stadt', 'BS', 1),
(3099, 204, 'Basel-Landschaft', 'BL', 1),
(3100, 204, 'Bern', 'BE', 1),
(3101, 204, 'Fribourg', 'FR', 1),
(3102, 204, 'Gen&egrave;ve', 'GE', 1),
(3103, 204, 'Glarus', 'GL', 1),
(3104, 204, 'Graub&uuml;nden', 'GR', 1),
(3105, 204, 'Jura', 'JU', 1),
(3106, 204, 'Luzern', 'LU', 1),
(3107, 204, 'Neuch&acirc;tel', 'NE', 1),
(3108, 204, 'Nidwald', 'NW', 1),
(3109, 204, 'Obwald', 'OW', 1),
(3110, 204, 'St. Gallen', 'SG', 1),
(3111, 204, 'Schaffhausen', 'SH', 1),
(3112, 204, 'Schwyz', 'SZ', 1),
(3113, 204, 'Solothurn', 'SO', 1),
(3114, 204, 'Thurgau', 'TG', 1),
(3115, 204, 'Ticino', 'TI', 1),
(3116, 204, 'Uri', 'UR', 1),
(3117, 204, 'Valais', 'VS', 1),
(3118, 204, 'Vaud', 'VD', 1),
(3119, 204, 'Zug', 'ZG', 1),
(3120, 204, 'Z&uuml;rich', 'ZH', 1),
(3121, 205, 'Al Hasakah', 'HA', 1),
(3122, 205, 'Al Ladhiqiyah', 'LA', 1),
(3123, 205, 'Al Qunaytirah', 'QU', 1),
(3124, 205, 'Ar Raqqah', 'RQ', 1),
(3125, 205, 'As Suwayda', 'SU', 1),
(3126, 205, 'Dara', 'DA', 1),
(3127, 205, 'Dayr az Zawr', 'DZ', 1),
(3128, 205, 'Dimashq', 'DI', 1),
(3129, 205, 'Halab', 'HL', 1),
(3130, 205, 'Hamah', 'HM', 1),
(3131, 205, 'Hims', 'HI', 1),
(3132, 205, 'Idlib', 'ID', 1),
(3133, 205, 'Rif Dimashq', 'RD', 1),
(3134, 205, 'Tartus', 'TA', 1),
(3135, 206, 'Chang-hua', 'CH', 1),
(3136, 206, 'Chia-i', 'CI', 1),
(3137, 206, 'Hsin-chu', 'HS', 1),
(3138, 206, 'Hua-lien', 'HL', 1),
(3139, 206, 'I-lan', 'IL', 1),
(3140, 206, 'Kao-hsiung county', 'KH', 1),
(3141, 206, 'Kin-men', 'KM', 1),
(3142, 206, 'Lien-chiang', 'LC', 1),
(3143, 206, 'Miao-li', 'ML', 1),
(3144, 206, 'Nan-t''ou', 'NT', 1),
(3145, 206, 'P''eng-hu', 'PH', 1),
(3146, 206, 'P''ing-tung', 'PT', 1),
(3147, 206, 'T''ai-chung', 'TG', 1),
(3148, 206, 'T''ai-nan', 'TA', 1),
(3149, 206, 'T''ai-pei county', 'TP', 1),
(3150, 206, 'T''ai-tung', 'TT', 1),
(3151, 206, 'T''ao-yuan', 'TY', 1),
(3152, 206, 'Yun-lin', 'YL', 1),
(3153, 206, 'Chia-i city', 'CC', 1),
(3154, 206, 'Chi-lung', 'CL', 1),
(3155, 206, 'Hsin-chu', 'HC', 1),
(3156, 206, 'T''ai-chung', 'TH', 1),
(3157, 206, 'T''ai-nan', 'TN', 1),
(3158, 206, 'Kao-hsiung city', 'KC', 1),
(3159, 206, 'T''ai-pei city', 'TC', 1),
(3160, 207, 'Gorno-Badakhstan', 'GB', 1),
(3161, 207, 'Khatlon', 'KT', 1),
(3162, 207, 'Sughd', 'SU', 1),
(3163, 208, 'Arusha', 'AR', 1),
(3164, 208, 'Dar es Salaam', 'DS', 1),
(3165, 208, 'Dodoma', 'DO', 1),
(3166, 208, 'Iringa', 'IR', 1),
(3167, 208, 'Kagera', 'KA', 1),
(3168, 208, 'Kigoma', 'KI', 1),
(3169, 208, 'Kilimanjaro', 'KJ', 1),
(3170, 208, 'Lindi', 'LN', 1),
(3171, 208, 'Manyara', 'MY', 1),
(3172, 208, 'Mara', 'MR', 1),
(3173, 208, 'Mbeya', 'MB', 1),
(3174, 208, 'Morogoro', 'MO', 1),
(3175, 208, 'Mtwara', 'MT', 1),
(3176, 208, 'Mwanza', 'MW', 1),
(3177, 208, 'Pemba North', 'PN', 1),
(3178, 208, 'Pemba South', 'PS', 1),
(3179, 208, 'Pwani', 'PW', 1),
(3180, 208, 'Rukwa', 'RK', 1),
(3181, 208, 'Ruvuma', 'RV', 1),
(3182, 208, 'Shinyanga', 'SH', 1),
(3183, 208, 'Singida', 'SI', 1),
(3184, 208, 'Tabora', 'TB', 1),
(3185, 208, 'Tanga', 'TN', 1),
(3186, 208, 'Zanzibar Central/South', 'ZC', 1),
(3187, 208, 'Zanzibar North', 'ZN', 1),
(3188, 208, 'Zanzibar Urban/West', 'ZU', 1),
(3189, 209, 'Amnat Charoen', 'Amnat Charoen', 1),
(3190, 209, 'Ang Thong', 'Ang Thong', 1),
(3191, 209, 'Ayutthaya', 'Ayutthaya', 1),
(3192, 209, 'Bangkok', 'Bangkok', 1),
(3193, 209, 'Buriram', 'Buriram', 1),
(3194, 209, 'Chachoengsao', 'Chachoengsao', 1),
(3195, 209, 'Chai Nat', 'Chai Nat', 1),
(3196, 209, 'Chaiyaphum', 'Chaiyaphum', 1),
(3197, 209, 'Chanthaburi', 'Chanthaburi', 1),
(3198, 209, 'Chiang Mai', 'Chiang Mai', 1),
(3199, 209, 'Chiang Rai', 'Chiang Rai', 1),
(3200, 209, 'Chon Buri', 'Chon Buri', 1),
(3201, 209, 'Chumphon', 'Chumphon', 1),
(3202, 209, 'Kalasin', 'Kalasin', 1),
(3203, 209, 'Kamphaeng Phet', 'Kamphaeng Phet', 1),
(3204, 209, 'Kanchanaburi', 'Kanchanaburi', 1),
(3205, 209, 'Khon Kaen', 'Khon Kaen', 1),
(3206, 209, 'Krabi', 'Krabi', 1),
(3207, 209, 'Lampang', 'Lampang', 1),
(3208, 209, 'Lamphun', 'Lamphun', 1),
(3209, 209, 'Loei', 'Loei', 1),
(3210, 209, 'Lop Buri', 'Lop Buri', 1),
(3211, 209, 'Mae Hong Son', 'Mae Hong Son', 1),
(3212, 209, 'Maha Sarakham', 'Maha Sarakham', 1),
(3213, 209, 'Mukdahan', 'Mukdahan', 1),
(3214, 209, 'Nakhon Nayok', 'Nakhon Nayok', 1),
(3215, 209, 'Nakhon Pathom', 'Nakhon Pathom', 1),
(3216, 209, 'Nakhon Phanom', 'Nakhon Phanom', 1),
(3217, 209, 'Nakhon Ratchasima', 'Nakhon Ratchasima', 1),
(3218, 209, 'Nakhon Sawan', 'Nakhon Sawan', 1),
(3219, 209, 'Nakhon Si Thammarat', 'Nakhon Si Thammarat', 1),
(3220, 209, 'Nan', 'Nan', 1),
(3221, 209, 'Narathiwat', 'Narathiwat', 1),
(3222, 209, 'Nong Bua Lamphu', 'Nong Bua Lamphu', 1),
(3223, 209, 'Nong Khai', 'Nong Khai', 1),
(3224, 209, 'Nonthaburi', 'Nonthaburi', 1),
(3225, 209, 'Pathum Thani', 'Pathum Thani', 1),
(3226, 209, 'Pattani', 'Pattani', 1),
(3227, 209, 'Phangnga', 'Phangnga', 1),
(3228, 209, 'Phatthalung', 'Phatthalung', 1),
(3229, 209, 'Phayao', 'Phayao', 1),
(3230, 209, 'Phetchabun', 'Phetchabun', 1),
(3231, 209, 'Phetchaburi', 'Phetchaburi', 1),
(3232, 209, 'Phichit', 'Phichit', 1),
(3233, 209, 'Phitsanulok', 'Phitsanulok', 1),
(3234, 209, 'Phrae', 'Phrae', 1),
(3235, 209, 'Phuket', 'Phuket', 1),
(3236, 209, 'Prachin Buri', 'Prachin Buri', 1),
(3237, 209, 'Prachuap Khiri Khan', 'Prachuap Khiri Khan', 1),
(3238, 209, 'Ranong', 'Ranong', 1),
(3239, 209, 'Ratchaburi', 'Ratchaburi', 1),
(3240, 209, 'Rayong', 'Rayong', 1),
(3241, 209, 'Roi Et', 'Roi Et', 1),
(3242, 209, 'Sa Kaeo', 'Sa Kaeo', 1),
(3243, 209, 'Sakon Nakhon', 'Sakon Nakhon', 1),
(3244, 209, 'Samut Prakan', 'Samut Prakan', 1),
(3245, 209, 'Samut Sakhon', 'Samut Sakhon', 1),
(3246, 209, 'Samut Songkhram', 'Samut Songkhram', 1),
(3247, 209, 'Sara Buri', 'Sara Buri', 1),
(3248, 209, 'Satun', 'Satun', 1),
(3249, 209, 'Sing Buri', 'Sing Buri', 1),
(3250, 209, 'Sisaket', 'Sisaket', 1),
(3251, 209, 'Songkhla', 'Songkhla', 1),
(3252, 209, 'Sukhothai', 'Sukhothai', 1),
(3253, 209, 'Suphan Buri', 'Suphan Buri', 1),
(3254, 209, 'Surat Thani', 'Surat Thani', 1),
(3255, 209, 'Surin', 'Surin', 1),
(3256, 209, 'Tak', 'Tak', 1),
(3257, 209, 'Trang', 'Trang', 1),
(3258, 209, 'Trat', 'Trat', 1),
(3259, 209, 'Ubon Ratchathani', 'Ubon Ratchathani', 1),
(3260, 209, 'Udon Thani', 'Udon Thani', 1),
(3261, 209, 'Uthai Thani', 'Uthai Thani', 1),
(3262, 209, 'Uttaradit', 'Uttaradit', 1),
(3263, 209, 'Yala', 'Yala', 1),
(3264, 209, 'Yasothon', 'Yasothon', 1),
(3265, 210, 'Kara', 'K', 1),
(3266, 210, 'Plateaux', 'P', 1),
(3267, 210, 'Savanes', 'S', 1),
(3268, 210, 'Centrale', 'C', 1),
(3269, 210, 'Maritime', 'M', 1),
(3270, 211, 'Atafu', 'A', 1),
(3271, 211, 'Fakaofo', 'F', 1),
(3272, 211, 'Nukunonu', 'N', 1),
(3273, 212, 'Ha''apai', 'H', 1),
(3274, 212, 'Tongatapu', 'T', 1),
(3275, 212, 'Vava''u', 'V', 1),
(3276, 213, 'Couva/Tabaquite/Talparo', 'CT', 1),
(3277, 213, 'Diego Martin', 'DM', 1),
(3278, 213, 'Mayaro/Rio Claro', 'MR', 1),
(3279, 213, 'Penal/Debe', 'PD', 1),
(3280, 213, 'Princes Town', 'PT', 1),
(3281, 213, 'Sangre Grande', 'SG', 1),
(3282, 213, 'San Juan/Laventille', 'SL', 1),
(3283, 213, 'Siparia', 'SI', 1),
(3284, 213, 'Tunapuna/Piarco', 'TP', 1),
(3285, 213, 'Port of Spain', 'PS', 1),
(3286, 213, 'San Fernando', 'SF', 1),
(3287, 213, 'Arima', 'AR', 1),
(3288, 213, 'Point Fortin', 'PF', 1),
(3289, 213, 'Chaguanas', 'CH', 1),
(3290, 213, 'Tobago', 'TO', 1),
(3291, 214, 'Ariana', 'AR', 1),
(3292, 214, 'Beja', 'BJ', 1),
(3293, 214, 'Ben Arous', 'BA', 1),
(3294, 214, 'Bizerte', 'BI', 1),
(3295, 214, 'Gabes', 'GB', 1),
(3296, 214, 'Gafsa', 'GF', 1),
(3297, 214, 'Jendouba', 'JE', 1),
(3298, 214, 'Kairouan', 'KR', 1),
(3299, 214, 'Kasserine', 'KS', 1),
(3300, 214, 'Kebili', 'KB', 1),
(3301, 214, 'Kef', 'KF', 1),
(3302, 214, 'Mahdia', 'MH', 1),
(3303, 214, 'Manouba', 'MN', 1),
(3304, 214, 'Medenine', 'ME', 1),
(3305, 214, 'Monastir', 'MO', 1),
(3306, 214, 'Nabeul', 'NA', 1),
(3307, 214, 'Sfax', 'SF', 1),
(3308, 214, 'Sidi', 'SD', 1),
(3309, 214, 'Siliana', 'SL', 1),
(3310, 214, 'Sousse', 'SO', 1),
(3311, 214, 'Tataouine', 'TA', 1),
(3312, 214, 'Tozeur', 'TO', 1),
(3313, 214, 'Tunis', 'TU', 1),
(3314, 214, 'Zaghouan', 'ZA', 1),
(3315, 215, 'Adana', 'ADA', 1),
(3316, 215, 'Adıyaman', 'ADI', 1),
(3317, 215, 'Afyonkarahisar', 'AFY', 1),
(3318, 215, 'Ağrı', 'AGR', 1),
(3319, 215, 'Aksaray', 'AKS', 1),
(3320, 215, 'Amasya', 'AMA', 1),
(3321, 215, 'Ankara', 'ANK', 1),
(3322, 215, 'Antalya', 'ANT', 1),
(3323, 215, 'Ardahan', 'ARD', 1),
(3324, 215, 'Artvin', 'ART', 1),
(3325, 215, 'Aydın', 'AYI', 1),
(3326, 215, 'Balıkesir', 'BAL', 1),
(3327, 215, 'Bartın', 'BAR', 1),
(3328, 215, 'Batman', 'BAT', 1),
(3329, 215, 'Bayburt', 'BAY', 1),
(3330, 215, 'Bilecik', 'BIL', 1),
(3331, 215, 'Bingöl', 'BIN', 1),
(3332, 215, 'Bitlis', 'BIT', 1),
(3333, 215, 'Bolu', 'BOL', 1),
(3334, 215, 'Burdur', 'BRD', 1),
(3335, 215, 'Bursa', 'BRS', 1),
(3336, 215, 'Çanakkale', 'CKL', 1),
(3337, 215, 'Çankırı', 'CKR', 1),
(3338, 215, 'Çorum', 'COR', 1),
(3339, 215, 'Denizli', 'DEN', 1),
(3340, 215, 'Diyarbakir', 'DIY', 1),
(3341, 215, 'Düzce', 'DUZ', 1),
(3342, 215, 'Edirne', 'EDI', 1),
(3343, 215, 'Elazığ', 'ELA', 1),
(3344, 215, 'Erzincan', 'EZC', 1),
(3345, 215, 'Erzurum', 'EZR', 1),
(3346, 215, 'Eskişehir', 'ESK', 1),
(3347, 215, 'Gaziantep', 'GAZ', 1),
(3348, 215, 'Giresun', 'GIR', 1),
(3349, 215, 'Gümüşhane', 'GMS', 1),
(3350, 215, 'Hakkari', 'HKR', 1),
(3351, 215, 'Hatay', 'HTY', 1),
(3352, 215, 'Iğdır', 'IGD', 1),
(3353, 215, 'Isparta', 'ISP', 1),
(3354, 215, 'İstanbul', 'IST', 1),
(3355, 215, 'İzmir', 'IZM', 1),
(3356, 215, 'Kahramanmaraş', 'KAH', 1),
(3357, 215, 'Karabük', 'KRB', 1),
(3358, 215, 'Karaman', 'KRM', 1),
(3359, 215, 'Kars', 'KRS', 1),
(3360, 215, 'Kastamonu', 'KAS', 1),
(3361, 215, 'Kayseri', 'KAY', 1),
(3362, 215, 'Kilis', 'KLS', 1),
(3363, 215, 'Kırıkkale', 'KRK', 1),
(3364, 215, 'Kırklareli', 'KLR', 1),
(3365, 215, 'Kırşehir', 'KRH', 1),
(3366, 215, 'Kocaeli', 'KOC', 1),
(3367, 215, 'Konya', 'KON', 1),
(3368, 215, 'Kütahya', 'KUT', 1),
(3369, 215, 'Malatya', 'MAL', 1),
(3370, 215, 'Manisa', 'MAN', 1),
(3371, 215, 'Mardin', 'MAR', 1),
(3372, 215, 'Mersin', 'MER', 1),
(3373, 215, 'Muğla', 'MUG', 1),
(3374, 215, 'Muş', 'MUS', 1),
(3375, 215, 'Nevşehir', 'NEV', 1),
(3376, 215, 'Niğde', 'NIG', 1),
(3377, 215, 'Ordu', 'ORD', 1),
(3378, 215, 'Osmaniye', 'OSM', 1),
(3379, 215, 'Rize', 'RIZ', 1),
(3380, 215, 'Sakarya', 'SAK', 1),
(3381, 215, 'Samsun', 'SAM', 1),
(3382, 215, 'Şanlıurfa', 'SAN', 1),
(3383, 215, 'Siirt', 'SII', 1),
(3384, 215, 'Sinop', 'SIN', 1),
(3385, 215, 'Şırnak', 'SIR', 1),
(3386, 215, 'Sivas', 'SIV', 1),
(3387, 215, 'Tekirdağ', 'TEL', 1),
(3388, 215, 'Tokat', 'TOK', 1),
(3389, 215, 'Trabzon', 'TRA', 1),
(3390, 215, 'Tunceli', 'TUN', 1),
(3391, 215, 'Uşak', 'USK', 1),
(3392, 215, 'Van', 'VAN', 1),
(3393, 215, 'Yalova', 'YAL', 1),
(3394, 215, 'Yozgat', 'YOZ', 1),
(3395, 215, 'Zonguldak', 'ZON', 1),
(3396, 216, 'Ahal Welayaty', 'A', 1),
(3397, 216, 'Balkan Welayaty', 'B', 1),
(3398, 216, 'Dashhowuz Welayaty', 'D', 1),
(3399, 216, 'Lebap Welayaty', 'L', 1),
(3400, 216, 'Mary Welayaty', 'M', 1),
(3401, 217, 'Ambergris Cays', 'AC', 1),
(3402, 217, 'Dellis Cay', 'DC', 1),
(3403, 217, 'French Cay', 'FC', 1),
(3404, 217, 'Little Water Cay', 'LW', 1),
(3405, 217, 'Parrot Cay', 'RC', 1),
(3406, 217, 'Pine Cay', 'PN', 1),
(3407, 217, 'Salt Cay', 'SL', 1),
(3408, 217, 'Grand Turk', 'GT', 1),
(3409, 217, 'South Caicos', 'SC', 1),
(3410, 217, 'East Caicos', 'EC', 1),
(3411, 217, 'Middle Caicos', 'MC', 1),
(3412, 217, 'North Caicos', 'NC', 1),
(3413, 217, 'Providenciales', 'PR', 1),
(3414, 217, 'West Caicos', 'WC', 1),
(3415, 218, 'Nanumanga', 'NMG', 1),
(3416, 218, 'Niulakita', 'NLK', 1),
(3417, 218, 'Niutao', 'NTO', 1),
(3418, 218, 'Funafuti', 'FUN', 1),
(3419, 218, 'Nanumea', 'NME', 1),
(3420, 218, 'Nui', 'NUI', 1),
(3421, 218, 'Nukufetau', 'NFT', 1),
(3422, 218, 'Nukulaelae', 'NLL', 1),
(3423, 218, 'Vaitupu', 'VAI', 1),
(3424, 219, 'Kalangala', 'KAL', 1),
(3425, 219, 'Kampala', 'KMP', 1),
(3426, 219, 'Kayunga', 'KAY', 1),
(3427, 219, 'Kiboga', 'KIB', 1),
(3428, 219, 'Luwero', 'LUW', 1),
(3429, 219, 'Masaka', 'MAS', 1),
(3430, 219, 'Mpigi', 'MPI', 1),
(3431, 219, 'Mubende', 'MUB', 1),
(3432, 219, 'Mukono', 'MUK', 1),
(3433, 219, 'Nakasongola', 'NKS', 1),
(3434, 219, 'Rakai', 'RAK', 1),
(3435, 219, 'Sembabule', 'SEM', 1),
(3436, 219, 'Wakiso', 'WAK', 1),
(3437, 219, 'Bugiri', 'BUG', 1),
(3438, 219, 'Busia', 'BUS', 1),
(3439, 219, 'Iganga', 'IGA', 1),
(3440, 219, 'Jinja', 'JIN', 1),
(3441, 219, 'Kaberamaido', 'KAB', 1),
(3442, 219, 'Kamuli', 'KML', 1),
(3443, 219, 'Kapchorwa', 'KPC', 1),
(3444, 219, 'Katakwi', 'KTK', 1),
(3445, 219, 'Kumi', 'KUM', 1),
(3446, 219, 'Mayuge', 'MAY', 1),
(3447, 219, 'Mbale', 'MBA', 1),
(3448, 219, 'Pallisa', 'PAL', 1),
(3449, 219, 'Sironko', 'SIR', 1),
(3450, 219, 'Soroti', 'SOR', 1),
(3451, 219, 'Tororo', 'TOR', 1),
(3452, 219, 'Adjumani', 'ADJ', 1),
(3453, 219, 'Apac', 'APC', 1),
(3454, 219, 'Arua', 'ARU', 1),
(3455, 219, 'Gulu', 'GUL', 1),
(3456, 219, 'Kitgum', 'KIT', 1),
(3457, 219, 'Kotido', 'KOT', 1),
(3458, 219, 'Lira', 'LIR', 1),
(3459, 219, 'Moroto', 'MRT', 1),
(3460, 219, 'Moyo', 'MOY', 1),
(3461, 219, 'Nakapiripirit', 'NAK', 1),
(3462, 219, 'Nebbi', 'NEB', 1),
(3463, 219, 'Pader', 'PAD', 1),
(3464, 219, 'Yumbe', 'YUM', 1),
(3465, 219, 'Bundibugyo', 'BUN', 1),
(3466, 219, 'Bushenyi', 'BSH', 1),
(3467, 219, 'Hoima', 'HOI', 1),
(3468, 219, 'Kabale', 'KBL', 1),
(3469, 219, 'Kabarole', 'KAR', 1),
(3470, 219, 'Kamwenge', 'KAM', 1),
(3471, 219, 'Kanungu', 'KAN', 1),
(3472, 219, 'Kasese', 'KAS', 1),
(3473, 219, 'Kibaale', 'KBA', 1),
(3474, 219, 'Kisoro', 'KIS', 1),
(3475, 219, 'Kyenjojo', 'KYE', 1),
(3476, 219, 'Masindi', 'MSN', 1),
(3477, 219, 'Mbarara', 'MBR', 1),
(3478, 219, 'Ntungamo', 'NTU', 1),
(3479, 219, 'Rukungiri', 'RUK', 1),
(3480, 220, 'Cherkasy', 'CK', 1),
(3481, 220, 'Chernihiv', 'CH', 1),
(3482, 220, 'Chernivtsi', 'CV', 1),
(3483, 220, 'Crimea', 'CR', 1),
(3484, 220, 'Dnipropetrovs''k', 'DN', 1),
(3485, 220, 'Donets''k', 'DO', 1),
(3486, 220, 'Ivano-Frankivs''k', 'IV', 1),
(3487, 220, 'Kharkiv Kherson', 'KL', 1),
(3488, 220, 'Khmel''nyts''kyy', 'KM', 1),
(3489, 220, 'Kirovohrad', 'KR', 1),
(3490, 220, 'Kiev', 'KV', 1),
(3491, 220, 'Kyyiv', 'KY', 1),
(3492, 220, 'Luhans''k', 'LU', 1),
(3493, 220, 'L''viv', 'LV', 1),
(3494, 220, 'Mykolayiv', 'MY', 1),
(3495, 220, 'Odesa', 'OD', 1),
(3496, 220, 'Poltava', 'PO', 1),
(3497, 220, 'Rivne', 'RI', 1),
(3498, 220, 'Sevastopol', 'SE', 1),
(3499, 220, 'Sumy', 'SU', 1),
(3500, 220, 'Ternopil''', 'TE', 1),
(3501, 220, 'Vinnytsya', 'VI', 1),
(3502, 220, 'Volyn''', 'VO', 1),
(3503, 220, 'Zakarpattya', 'ZK', 1),
(3504, 220, 'Zaporizhzhya', 'ZA', 1),
(3505, 220, 'Zhytomyr', 'ZH', 1),
(3506, 221, 'Abu Zaby', 'AZ', 1),
(3507, 221, '''Ajman', 'AJ', 1),
(3508, 221, 'Al Fujayrah', 'FU', 1),
(3509, 221, 'Ash Shariqah', 'SH', 1),
(3510, 221, 'Dubayy', 'DU', 1),
(3511, 221, 'R''as al Khaymah', 'RK', 1),
(3512, 221, 'Umm al Qaywayn', 'UQ', 1),
(3513, 222, 'Aberdeen', 'ABN', 1),
(3514, 222, 'Aberdeenshire', 'ABNS', 1),
(3515, 222, 'Anglesey', 'ANG', 1),
(3516, 222, 'Angus', 'AGS', 1),
(3517, 222, 'Argyll and Bute', 'ARY', 1),
(3518, 222, 'Bedfordshire', 'BEDS', 1),
(3519, 222, 'Berkshire', 'BERKS', 1),
(3520, 222, 'Blaenau Gwent', 'BLA', 1),
(3521, 222, 'Bridgend', 'BRI', 1),
(3522, 222, 'Bristol', 'BSTL', 1),
(3523, 222, 'Buckinghamshire', 'BUCKS', 1),
(3524, 222, 'Caerphilly', 'CAE', 1),
(3525, 222, 'Cambridgeshire', 'CAMBS', 1),
(3526, 222, 'Cardiff', 'CDF', 1),
(3527, 222, 'Carmarthenshire', 'CARM', 1),
(3528, 222, 'Ceredigion', 'CDGN', 1),
(3529, 222, 'Cheshire', 'CHES', 1),
(3530, 222, 'Clackmannanshire', 'CLACK', 1),
(3531, 222, 'Conwy', 'CON', 1),
(3532, 222, 'Cornwall', 'CORN', 1),
(3533, 222, 'Denbighshire', 'DNBG', 1),
(3534, 222, 'Derbyshire', 'DERBY', 1),
(3535, 222, 'Devon', 'DVN', 1),
(3536, 222, 'Dorset', 'DOR', 1),
(3537, 222, 'Dumfries and Galloway', 'DGL', 1),
(3538, 222, 'Dundee', 'DUND', 1),
(3539, 222, 'Durham', 'DHM', 1),
(3540, 222, 'East Ayrshire', 'ARYE', 1),
(3541, 222, 'East Dunbartonshire', 'DUNBE', 1),
(3542, 222, 'East Lothian', 'LOTE', 1),
(3543, 222, 'East Renfrewshire', 'RENE', 1),
(3544, 222, 'East Riding of Yorkshire', 'ERYS', 1),
(3545, 222, 'East Sussex', 'SXE', 1),
(3546, 222, 'Edinburgh', 'EDIN', 1),
(3547, 222, 'Essex', 'ESX', 1),
(3548, 222, 'Falkirk', 'FALK', 1),
(3549, 222, 'Fife', 'FFE', 1),
(3550, 222, 'Flintshire', 'FLINT', 1),
(3551, 222, 'Glasgow', 'GLAS', 1),
(3552, 222, 'Gloucestershire', 'GLOS', 1),
(3553, 222, 'Greater London', 'LDN', 1),
(3554, 222, 'Greater Manchester', 'MCH', 1),
(3555, 222, 'Gwynedd', 'GDD', 1),
(3556, 222, 'Hampshire', 'HANTS', 1),
(3557, 222, 'Herefordshire', 'HWR', 1),
(3558, 222, 'Hertfordshire', 'HERTS', 1),
(3559, 222, 'Highlands', 'HLD', 1),
(3560, 222, 'Inverclyde', 'IVER', 1),
(3561, 222, 'Isle of Wight', 'IOW', 1),
(3562, 222, 'Kent', 'KNT', 1),
(3563, 222, 'Lancashire', 'LANCS', 1),
(3564, 222, 'Leicestershire', 'LEICS', 1),
(3565, 222, 'Lincolnshire', 'LINCS', 1),
(3566, 222, 'Merseyside', 'MSY', 1),
(3567, 222, 'Merthyr Tydfil', 'MERT', 1),
(3568, 222, 'Midlothian', 'MLOT', 1),
(3569, 222, 'Monmouthshire', 'MMOUTH', 1),
(3570, 222, 'Moray', 'MORAY', 1),
(3571, 222, 'Neath Port Talbot', 'NPRTAL', 1),
(3572, 222, 'Newport', 'NEWPT', 1),
(3573, 222, 'Norfolk', 'NOR', 1),
(3574, 222, 'North Ayrshire', 'ARYN', 1),
(3575, 222, 'North Lanarkshire', 'LANN', 1),
(3576, 222, 'North Yorkshire', 'YSN', 1),
(3577, 222, 'Northamptonshire', 'NHM', 1),
(3578, 222, 'Northumberland', 'NLD', 1),
(3579, 222, 'Nottinghamshire', 'NOT', 1),
(3580, 222, 'Orkney Islands', 'ORK', 1),
(3581, 222, 'Oxfordshire', 'OFE', 1),
(3582, 222, 'Pembrokeshire', 'PEM', 1),
(3583, 222, 'Perth and Kinross', 'PERTH', 1),
(3584, 222, 'Powys', 'PWS', 1),
(3585, 222, 'Renfrewshire', 'REN', 1),
(3586, 222, 'Rhondda Cynon Taff', 'RHON', 1),
(3587, 222, 'Rutland', 'RUT', 1),
(3588, 222, 'Scottish Borders', 'BOR', 1),
(3589, 222, 'Shetland Islands', 'SHET', 1),
(3590, 222, 'Shropshire', 'SPE', 1),
(3591, 222, 'Somerset', 'SOM', 1),
(3592, 222, 'South Ayrshire', 'ARYS', 1),
(3593, 222, 'South Lanarkshire', 'LANS', 1),
(3594, 222, 'South Yorkshire', 'YSS', 1),
(3595, 222, 'Staffordshire', 'SFD', 1),
(3596, 222, 'Stirling', 'STIR', 1),
(3597, 222, 'Suffolk', 'SFK', 1),
(3598, 222, 'Surrey', 'SRY', 1),
(3599, 222, 'Swansea', 'SWAN', 1),
(3600, 222, 'Torfaen', 'TORF', 1),
(3601, 222, 'Tyne and Wear', 'TWR', 1),
(3602, 222, 'Vale of Glamorgan', 'VGLAM', 1),
(3603, 222, 'Warwickshire', 'WARKS', 1),
(3604, 222, 'West Dunbartonshire', 'WDUN', 1),
(3605, 222, 'West Lothian', 'WLOT', 1),
(3606, 222, 'West Midlands', 'WMD', 1),
(3607, 222, 'West Sussex', 'SXW', 1),
(3608, 222, 'West Yorkshire', 'YSW', 1),
(3609, 222, 'Western Isles', 'WIL', 1),
(3610, 222, 'Wiltshire', 'WLT', 1),
(3611, 222, 'Worcestershire', 'WORCS', 1),
(3612, 222, 'Wrexham', 'WRX', 1),
(3613, 223, 'Alabama', 'AL', 1),
(3614, 223, 'Alaska', 'AK', 1),
(3615, 223, 'American Samoa', 'AS', 1),
(3616, 223, 'Arizona', 'AZ', 1),
(3617, 223, 'Arkansas', 'AR', 1),
(3618, 223, 'Armed Forces Africa', 'AF', 1),
(3619, 223, 'Armed Forces Americas', 'AA', 1),
(3620, 223, 'Armed Forces Canada', 'AC', 1),
(3621, 223, 'Armed Forces Europe', 'AE', 1),
(3622, 223, 'Armed Forces Middle East', 'AM', 1),
(3623, 223, 'Armed Forces Pacific', 'AP', 1),
(3624, 223, 'California', 'CA', 1),
(3625, 223, 'Colorado', 'CO', 1),
(3626, 223, 'Connecticut', 'CT', 1),
(3627, 223, 'Delaware', 'DE', 1),
(3628, 223, 'District of Columbia', 'DC', 1),
(3629, 223, 'Federated States Of Micronesia', 'FM', 1),
(3630, 223, 'Florida', 'FL', 1),
(3631, 223, 'Georgia', 'GA', 1),
(3632, 223, 'Guam', 'GU', 1),
(3633, 223, 'Hawaii', 'HI', 1),
(3634, 223, 'Idaho', 'ID', 1),
(3635, 223, 'Illinois', 'IL', 1),
(3636, 223, 'Indiana', 'IN', 1),
(3637, 223, 'Iowa', 'IA', 1),
(3638, 223, 'Kansas', 'KS', 1),
(3639, 223, 'Kentucky', 'KY', 1),
(3640, 223, 'Louisiana', 'LA', 1),
(3641, 223, 'Maine', 'ME', 1),
(3642, 223, 'Marshall Islands', 'MH', 1),
(3643, 223, 'Maryland', 'MD', 1),
(3644, 223, 'Massachusetts', 'MA', 1),
(3645, 223, 'Michigan', 'MI', 1),
(3646, 223, 'Minnesota', 'MN', 1),
(3647, 223, 'Mississippi', 'MS', 1),
(3648, 223, 'Missouri', 'MO', 1),
(3649, 223, 'Montana', 'MT', 1),
(3650, 223, 'Nebraska', 'NE', 1),
(3651, 223, 'Nevada', 'NV', 1),
(3652, 223, 'New Hampshire', 'NH', 1),
(3653, 223, 'New Jersey', 'NJ', 1),
(3654, 223, 'New Mexico', 'NM', 1),
(3655, 223, 'New York', 'NY', 1),
(3656, 223, 'North Carolina', 'NC', 1),
(3657, 223, 'North Dakota', 'ND', 1),
(3658, 223, 'Northern Mariana Islands', 'MP', 1),
(3659, 223, 'Ohio', 'OH', 1),
(3660, 223, 'Oklahoma', 'OK', 1),
(3661, 223, 'Oregon', 'OR', 1),
(3662, 223, 'Palau', 'PW', 1),
(3663, 223, 'Pennsylvania', 'PA', 1),
(3664, 223, 'Puerto Rico', 'PR', 1),
(3665, 223, 'Rhode Island', 'RI', 1),
(3666, 223, 'South Carolina', 'SC', 1),
(3667, 223, 'South Dakota', 'SD', 1),
(3668, 223, 'Tennessee', 'TN', 1),
(3669, 223, 'Texas', 'TX', 1),
(3670, 223, 'Utah', 'UT', 1),
(3671, 223, 'Vermont', 'VT', 1),
(3672, 223, 'Virgin Islands', 'VI', 1),
(3673, 223, 'Virginia', 'VA', 1),
(3674, 223, 'Washington', 'WA', 1),
(3675, 223, 'West Virginia', 'WV', 1),
(3676, 223, 'Wisconsin', 'WI', 1),
(3677, 223, 'Wyoming', 'WY', 1),
(3678, 224, 'Baker Island', 'BI', 1),
(3679, 224, 'Howland Island', 'HI', 1),
(3680, 224, 'Jarvis Island', 'JI', 1),
(3681, 224, 'Johnston Atoll', 'JA', 1),
(3682, 224, 'Kingman Reef', 'KR', 1),
(3683, 224, 'Midway Atoll', 'MA', 1),
(3684, 224, 'Navassa Island', 'NI', 1),
(3685, 224, 'Palmyra Atoll', 'PA', 1),
(3686, 224, 'Wake Island', 'WI', 1),
(3687, 225, 'Artigas', 'AR', 1),
(3688, 225, 'Canelones', 'CA', 1),
(3689, 225, 'Cerro Largo', 'CL', 1),
(3690, 225, 'Colonia', 'CO', 1),
(3691, 225, 'Durazno', 'DU', 1),
(3692, 225, 'Flores', 'FS', 1),
(3693, 225, 'Florida', 'FA', 1),
(3694, 225, 'Lavalleja', 'LA', 1),
(3695, 225, 'Maldonado', 'MA', 1),
(3696, 225, 'Montevideo', 'MO', 1),
(3697, 225, 'Paysandu', 'PA', 1),
(3698, 225, 'Rio Negro', 'RN', 1),
(3699, 225, 'Rivera', 'RV', 1),
(3700, 225, 'Rocha', 'RO', 1),
(3701, 225, 'Salto', 'SL', 1),
(3702, 225, 'San Jose', 'SJ', 1),
(3703, 225, 'Soriano', 'SO', 1),
(3704, 225, 'Tacuarembo', 'TA', 1),
(3705, 225, 'Treinta y Tres', 'TT', 1),
(3706, 226, 'Andijon', 'AN', 1),
(3707, 226, 'Buxoro', 'BU', 1),
(3708, 226, 'Farg''ona', 'FA', 1),
(3709, 226, 'Jizzax', 'JI', 1),
(3710, 226, 'Namangan', 'NG', 1),
(3711, 226, 'Navoiy', 'NW', 1),
(3712, 226, 'Qashqadaryo', 'QA', 1),
(3713, 226, 'Qoraqalpog''iston Republikasi', 'QR', 1),
(3714, 226, 'Samarqand', 'SA', 1),
(3715, 226, 'Sirdaryo', 'SI', 1),
(3716, 226, 'Surxondaryo', 'SU', 1),
(3717, 226, 'Toshkent City', 'TK', 1),
(3718, 226, 'Toshkent Region', 'TO', 1),
(3719, 226, 'Xorazm', 'XO', 1),
(3720, 227, 'Malampa', 'MA', 1),
(3721, 227, 'Penama', 'PE', 1),
(3722, 227, 'Sanma', 'SA', 1),
(3723, 227, 'Shefa', 'SH', 1),
(3724, 227, 'Tafea', 'TA', 1),
(3725, 227, 'Torba', 'TO', 1),
(3726, 229, 'Amazonas', 'AM', 1),
(3727, 229, 'Anzoategui', 'AN', 1),
(3728, 229, 'Apure', 'AP', 1),
(3729, 229, 'Aragua', 'AR', 1),
(3730, 229, 'Barinas', 'BA', 1),
(3731, 229, 'Bolivar', 'BO', 1),
(3732, 229, 'Carabobo', 'CA', 1),
(3733, 229, 'Cojedes', 'CO', 1),
(3734, 229, 'Delta Amacuro', 'DA', 1),
(3735, 229, 'Dependencias Federales', 'DF', 1),
(3736, 229, 'Distrito Federal', 'DI', 1),
(3737, 229, 'Falcon', 'FA', 1),
(3738, 229, 'Guarico', 'GU', 1),
(3739, 229, 'Lara', 'LA', 1),
(3740, 229, 'Merida', 'ME', 1),
(3741, 229, 'Miranda', 'MI', 1),
(3742, 229, 'Monagas', 'MO', 1),
(3743, 229, 'Nueva Esparta', 'NE', 1),
(3744, 229, 'Portuguesa', 'PO', 1),
(3745, 229, 'Sucre', 'SU', 1),
(3746, 229, 'Tachira', 'TA', 1),
(3747, 229, 'Trujillo', 'TR', 1),
(3748, 229, 'Vargas', 'VA', 1),
(3749, 229, 'Yaracuy', 'YA', 1),
(3750, 229, 'Zulia', 'ZU', 1),
(3751, 230, 'An Giang', 'AG', 1),
(3752, 230, 'Bac Giang', 'BG', 1),
(3753, 230, 'Bac Kan', 'BK', 1),
(3754, 230, 'Bac Lieu', 'BL', 1),
(3755, 230, 'Bac Ninh', 'BC', 1),
(3756, 230, 'Ba Ria-Vung Tau', 'BR', 1),
(3757, 230, 'Ben Tre', 'BN', 1),
(3758, 230, 'Binh Dinh', 'BH', 1),
(3759, 230, 'Binh Duong', 'BU', 1),
(3760, 230, 'Binh Phuoc', 'BP', 1),
(3761, 230, 'Binh Thuan', 'BT', 1),
(3762, 230, 'Ca Mau', 'CM', 1),
(3763, 230, 'Can Tho', 'CT', 1),
(3764, 230, 'Cao Bang', 'CB', 1),
(3765, 230, 'Dak Lak', 'DL', 1),
(3766, 230, 'Dak Nong', 'DG', 1),
(3767, 230, 'Da Nang', 'DN', 1),
(3768, 230, 'Dien Bien', 'DB', 1),
(3769, 230, 'Dong Nai', 'DI', 1),
(3770, 230, 'Dong Thap', 'DT', 1),
(3771, 230, 'Gia Lai', 'GL', 1),
(3772, 230, 'Ha Giang', 'HG', 1),
(3773, 230, 'Hai Duong', 'HD', 1),
(3774, 230, 'Hai Phong', 'HP', 1),
(3775, 230, 'Ha Nam', 'HM', 1),
(3776, 230, 'Ha Noi', 'HI', 1),
(3777, 230, 'Ha Tay', 'HT', 1),
(3778, 230, 'Ha Tinh', 'HH', 1),
(3779, 230, 'Hoa Binh', 'HB', 1),
(3780, 230, 'Ho Chi Minh City', 'HC', 1),
(3781, 230, 'Hau Giang', 'HU', 1),
(3782, 230, 'Hung Yen', 'HY', 1),
(3783, 232, 'Saint Croix', 'C', 1),
(3784, 232, 'Saint John', 'J', 1),
(3785, 232, 'Saint Thomas', 'T', 1),
(3786, 233, 'Alo', 'A', 1),
(3787, 233, 'Sigave', 'S', 1),
(3788, 233, 'Wallis', 'W', 1),
(3789, 235, 'Abyan', 'AB', 1),
(3790, 235, 'Adan', 'AD', 1),
(3791, 235, 'Amran', 'AM', 1),
(3792, 235, 'Al Bayda', 'BA', 1),
(3793, 235, 'Ad Dali', 'DA', 1),
(3794, 235, 'Dhamar', 'DH', 1),
(3795, 235, 'Hadramawt', 'HD', 1),
(3796, 235, 'Hajjah', 'HJ', 1),
(3797, 235, 'Al Hudaydah', 'HU', 1),
(3798, 235, 'Ibb', 'IB', 1),
(3799, 235, 'Al Jawf', 'JA', 1),
(3800, 235, 'Lahij', 'LA', 1),
(3801, 235, 'Ma''rib', 'MA', 1),
(3802, 235, 'Al Mahrah', 'MR', 1),
(3803, 235, 'Al Mahwit', 'MW', 1),
(3804, 235, 'Sa''dah', 'SD', 1),
(3805, 235, 'San''a', 'SN', 1),
(3806, 235, 'Shabwah', 'SH', 1),
(3807, 235, 'Ta''izz', 'TA', 1),
(3812, 237, 'Bas-Congo', 'BC', 1),
(3813, 237, 'Bandundu', 'BN', 1),
(3814, 237, 'Equateur', 'EQ', 1),
(3815, 237, 'Katanga', 'KA', 1),
(3816, 237, 'Kasai-Oriental', 'KE', 1),
(3817, 237, 'Kinshasa', 'KN', 1),
(3818, 237, 'Kasai-Occidental', 'KW', 1),
(3819, 237, 'Maniema', 'MA', 1),
(3820, 237, 'Nord-Kivu', 'NK', 1),
(3821, 237, 'Orientale', 'OR', 1),
(3822, 237, 'Sud-Kivu', 'SK', 1),
(3823, 238, 'Central', 'CE', 1),
(3824, 238, 'Copperbelt', 'CB', 1),
(3825, 238, 'Eastern', 'EA', 1),
(3826, 238, 'Luapula', 'LP', 1),
(3827, 238, 'Lusaka', 'LK', 1),
(3828, 238, 'Northern', 'NO', 1),
(3829, 238, 'North-Western', 'NW', 1),
(3830, 238, 'Southern', 'SO', 1),
(3831, 238, 'Western', 'WE', 1),
(3832, 239, 'Bulawayo', 'BU', 1),
(3833, 239, 'Harare', 'HA', 1),
(3834, 239, 'Manicaland', 'ML', 1),
(3835, 239, 'Mashonaland Central', 'MC', 1),
(3836, 239, 'Mashonaland East', 'ME', 1),
(3837, 239, 'Mashonaland West', 'MW', 1),
(3838, 239, 'Masvingo', 'MV', 1),
(3839, 239, 'Matabeleland North', 'MN', 1),
(3840, 239, 'Matabeleland South', 'MS', 1),
(3841, 239, 'Midlands', 'MD', 1),
(3861, 105, 'Campobasso', 'CB', 1),
(3862, 105, 'Carbonia-Iglesias', 'CI', 1),
(3863, 105, 'Caserta', 'CE', 1),
(3864, 105, 'Catania', 'CT', 1),
(3865, 105, 'Catanzaro', 'CZ', 1),
(3866, 105, 'Chieti', 'CH', 1),
(3867, 105, 'Como', 'CO', 1),
(3868, 105, 'Cosenza', 'CS', 1),
(3869, 105, 'Cremona', 'CR', 1),
(3870, 105, 'Crotone', 'KR', 1),
(3871, 105, 'Cuneo', 'CN', 1),
(3872, 105, 'Enna', 'EN', 1),
(3873, 105, 'Ferrara', 'FE', 1),
(3874, 105, 'Firenze', 'FI', 1),
(3875, 105, 'Foggia', 'FG', 1),
(3876, 105, 'Forli-Cesena', 'FC', 1),
(3877, 105, 'Frosinone', 'FR', 1),
(3878, 105, 'Genova', 'GE', 1),
(3879, 105, 'Gorizia', 'GO', 1),
(3880, 105, 'Grosseto', 'GR', 1),
(3881, 105, 'Imperia', 'IM', 1),
(3882, 105, 'Isernia', 'IS', 1),
(3883, 105, 'L&#39;Aquila', 'AQ', 1),
(3884, 105, 'La Spezia', 'SP', 1),
(3885, 105, 'Latina', 'LT', 1),
(3886, 105, 'Lecce', 'LE', 1),
(3887, 105, 'Lecco', 'LC', 1),
(3888, 105, 'Livorno', 'LI', 1),
(3889, 105, 'Lodi', 'LO', 1),
(3890, 105, 'Lucca', 'LU', 1),
(3891, 105, 'Macerata', 'MC', 1),
(3892, 105, 'Mantova', 'MN', 1),
(3893, 105, 'Massa-Carrara', 'MS', 1),
(3894, 105, 'Matera', 'MT', 1),
(3895, 105, 'Medio Campidano', 'VS', 1),
(3896, 105, 'Messina', 'ME', 1),
(3897, 105, 'Milano', 'MI', 1),
(3898, 105, 'Modena', 'MO', 1),
(3899, 105, 'Napoli', 'NA', 1),
(3900, 105, 'Novara', 'NO', 1),
(3901, 105, 'Nuoro', 'NU', 1),
(3902, 105, 'Ogliastra', 'OG', 1),
(3903, 105, 'Olbia-Tempio', 'OT', 1),
(3904, 105, 'Oristano', 'OR', 1),
(3905, 105, 'Padova', 'PD', 1),
(3906, 105, 'Palermo', 'PA', 1),
(3907, 105, 'Parma', 'PR', 1),
(3908, 105, 'Pavia', 'PV', 1),
(3909, 105, 'Perugia', 'PG', 1),
(3910, 105, 'Pesaro e Urbino', 'PU', 1),
(3911, 105, 'Pescara', 'PE', 1),
(3912, 105, 'Piacenza', 'PC', 1),
(3913, 105, 'Pisa', 'PI', 1),
(3914, 105, 'Pistoia', 'PT', 1),
(3915, 105, 'Pordenone', 'PN', 1),
(3916, 105, 'Potenza', 'PZ', 1),
(3917, 105, 'Prato', 'PO', 1),
(3918, 105, 'Ragusa', 'RG', 1),
(3919, 105, 'Ravenna', 'RA', 1),
(3920, 105, 'Reggio Calabria', 'RC', 1),
(3921, 105, 'Reggio Emilia', 'RE', 1),
(3922, 105, 'Rieti', 'RI', 1),
(3923, 105, 'Rimini', 'RN', 1),
(3924, 105, 'Roma', 'RM', 1),
(3925, 105, 'Rovigo', 'RO', 1),
(3926, 105, 'Salerno', 'SA', 1),
(3927, 105, 'Sassari', 'SS', 1),
(3928, 105, 'Savona', 'SV', 1),
(3929, 105, 'Siena', 'SI', 1),
(3930, 105, 'Siracusa', 'SR', 1),
(3931, 105, 'Sondrio', 'SO', 1),
(3932, 105, 'Taranto', 'TA', 1),
(3933, 105, 'Teramo', 'TE', 1),
(3934, 105, 'Terni', 'TR', 1),
(3935, 105, 'Torino', 'TO', 1),
(3936, 105, 'Trapani', 'TP', 1),
(3937, 105, 'Trento', 'TN', 1),
(3938, 105, 'Treviso', 'TV', 1),
(3939, 105, 'Trieste', 'TS', 1),
(3940, 105, 'Udine', 'UD', 1),
(3941, 105, 'Varese', 'VA', 1),
(3942, 105, 'Venezia', 'VE', 1),
(3943, 105, 'Verbano-Cusio-Ossola', 'VB', 1),
(3944, 105, 'Vercelli', 'VC', 1),
(3945, 105, 'Verona', 'VR', 1),
(3946, 105, 'Vibo Valentia', 'VV', 1),
(3947, 105, 'Vicenza', 'VI', 1),
(3948, 105, 'Viterbo', 'VT', 1),
(3949, 222, 'County Antrim', 'ANT', 1),
(3950, 222, 'County Armagh', 'ARM', 1),
(3951, 222, 'County Down', 'DOW', 1),
(3952, 222, 'County Fermanagh', 'FER', 1),
(3953, 222, 'County Londonderry', 'LDY', 1),
(3954, 222, 'County Tyrone', 'TYR', 1),
(3955, 222, 'Cumbria', 'CMA', 1),
(3956, 190, 'Pomurska', '1', 1),
(3957, 190, 'Podravska', '2', 1),
(3958, 190, 'Koroška', '3', 1),
(3959, 190, 'Savinjska', '4', 1),
(3960, 190, 'Zasavska', '5', 1),
(3961, 190, 'Spodnjeposavska', '6', 1),
(3962, 190, 'Jugovzhodna Slovenija', '7', 1),
(3963, 190, 'Osrednjeslovenska', '8', 1),
(3964, 190, 'Gorenjska', '9', 1),
(3965, 190, 'Notranjsko-kraška', '10', 1),
(3966, 190, 'Goriška', '11', 1),
(3967, 190, 'Obalno-kraška', '12', 1),
(3968, 33, 'Ruse', '', 1),
(3969, 101, 'Alborz', 'ALB', 1),
(3970, 21, 'Brussels-Capital Region', 'BRU', 1),
(3971, 138, 'Aguascalientes', 'AG', 1),
(3972, 222, 'Isle of Man', 'IOM', 1),
(3973, 242, 'Andrijevica', '01', 1),
(3974, 242, 'Bar', '02', 1),
(3975, 242, 'Berane', '03', 1),
(3976, 242, 'Bijelo Polje', '04', 1),
(3977, 242, 'Budva', '05', 1),
(3978, 242, 'Cetinje', '06', 1),
(3979, 242, 'Danilovgrad', '07', 1),
(3980, 242, 'Herceg-Novi', '08', 1),
(3981, 242, 'Kolašin', '09', 1),
(3982, 242, 'Kotor', '10', 1),
(3983, 242, 'Mojkovac', '11', 1),
(3984, 242, 'Nikšić', '12', 1),
(3985, 242, 'Plav', '13', 1),
(3986, 242, 'Pljevlja', '14', 1),
(3987, 242, 'Plužine', '15', 1),
(3988, 242, 'Podgorica', '16', 1),
(3989, 242, 'Rožaje', '17', 1),
(3990, 242, 'Šavnik', '18', 1),
(3991, 242, 'Tivat', '19', 1),
(3992, 242, 'Ulcinj', '20', 1),
(3993, 242, 'Žabljak', '21', 1),
(3994, 243, 'Belgrade', '00', 1),
(3995, 243, 'North Ba', '01', 1),
(3996, 243, 'Central Banat', '02', 1),
(3997, 243, 'North Banat', '03', 1),
(3998, 243, 'South Banat', '04', 1),
(3999, 243, 'West Ba', '05', 1),
(4000, 243, 'South Ba', '06', 1),
(4001, 243, 'Srem', '07', 1),
(4002, 243, 'Ma', '08', 1),
(4003, 243, 'Kolubara', '09', 1),
(4004, 243, 'Podunavlje', '10', 1),
(4005, 243, 'Brani', '11', 1),
(4006, 243, 'Šumadija', '12', 1),
(4007, 243, 'Pomoravlje', '13', 1),
(4008, 243, 'Bor', '14', 1),
(4009, 243, 'Zaje', '15', 1),
(4010, 243, 'Zlatibor', '16', 1),
(4011, 243, 'Moravica', '17', 1),
(4012, 243, 'Raška', '18', 1),
(4013, 243, 'Rasina', '19', 1),
(4014, 243, 'Nišava', '20', 1),
(4015, 243, 'Toplica', '21', 1),
(4016, 243, 'Pirot', '22', 1),
(4017, 243, 'Jablanica', '23', 1),
(4018, 243, 'P', '24', 1),
(4019, 243, 'Kosovo', 'KM', 1),
(4020, 245, 'Bonaire', 'BO', 1),
(4021, 245, 'Saba', 'SA', 1),
(4022, 245, 'Sint Eustatius', 'SE', 1),
(4023, 248, 'Central Equatoria', 'EC', 1),
(4024, 248, 'Eastern Equatoria', 'EE', 1),
(4025, 248, 'Jonglei', 'JG', 1),
(4026, 248, 'Lakes', 'LK', 1),
(4027, 248, 'Northern Bahr el-Ghazal', 'BN', 1),
(4028, 248, 'Unity', 'UY', 1),
(4029, 248, 'Upper Nile', 'NU', 1),
(4030, 248, 'Warrap', 'WR', 1),
(4031, 248, 'Western Bahr el-Ghazal', 'BW', 1),
(4032, 248, 'Western Equatoria', 'EW', 1),
(4033, 99, 'Mumbai(Maharashtra)', 'MUM', 1),
(4034, 99, 'Uttarakhand', 'UTK', 1),
(4035, 99, 'Chhatisgarh', 'CHG', 1),
(4036, 99, 'Jharkhand', 'JH', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblprfx_additional_charges`
--
ALTER TABLE `tblprfx_additional_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_attributes`
--
ALTER TABLE `tblprfx_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_attribute_sets`
--
ALTER TABLE `tblprfx_attribute_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_attribute_types`
--
ALTER TABLE `tblprfx_attribute_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_attribute_values`
--
ALTER TABLE `tblprfx_attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_catalog_images`
--
ALTER TABLE `tblprfx_catalog_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_categories`
--
ALTER TABLE `tblprfx_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_lft_index` (`lft`),
  ADD KEY `categories_rgt_index` (`rgt`);

--
-- Indexes for table `tblprfx_cities`
--
ALTER TABLE `tblprfx_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_comments`
--
ALTER TABLE `tblprfx_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_contacts`
--
ALTER TABLE `tblprfx_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_countries`
--
ALTER TABLE `tblprfx_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_coupons`
--
ALTER TABLE `tblprfx_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_name` (`coupon_name`),
  ADD KEY `start_date` (`start_date`),
  ADD KEY `end_date` (`end_date`);

--
-- Indexes for table `tblprfx_coupons_categories`
--
ALTER TABLE `tblprfx_coupons_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_coupons_products`
--
ALTER TABLE `tblprfx_coupons_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_coupons_users`
--
ALTER TABLE `tblprfx_coupons_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_currencies`
--
ALTER TABLE `tblprfx_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_downlodable_prods`
--
ALTER TABLE `tblprfx_downlodable_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_dynamic_layout`
--
ALTER TABLE `tblprfx_dynamic_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_email_template`
--
ALTER TABLE `tblprfx_email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_flags`
--
ALTER TABLE `tblprfx_flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_general_setting`
--
ALTER TABLE `tblprfx_general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_gifts`
--
ALTER TABLE `tblprfx_gifts`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `tblprfx_has_attributes`
--
ALTER TABLE `tblprfx_has_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_attribute_values`
--
ALTER TABLE `tblprfx_has_attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_categories`
--
ALTER TABLE `tblprfx_has_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_combo_prods`
--
ALTER TABLE `tblprfx_has_combo_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_currency`
--
ALTER TABLE `tblprfx_has_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_layouts`
--
ALTER TABLE `tblprfx_has_layouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_options`
--
ALTER TABLE `tblprfx_has_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_products`
-- --
-- ALTER TABLE `tblprfx_has_products`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_related_prods`
--
ALTER TABLE `tblprfx_has_related_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_taxes`
--
ALTER TABLE `tblprfx_has_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_upsell_prods`
--
ALTER TABLE `tblprfx_has_upsell_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_has_vendors`
--
ALTER TABLE `tblprfx_has_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_kot`
--
ALTER TABLE `tblprfx_kot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_language`
--
ALTER TABLE `tblprfx_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_layout`
--
ALTER TABLE `tblprfx_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_loyalty`
--
ALTER TABLE `tblprfx_loyalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_newsletter`
--
ALTER TABLE `tblprfx_newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_notification`
--
ALTER TABLE `tblprfx_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_occupancy_status`
--
ALTER TABLE `tblprfx_occupancy_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_offers`
--
ALTER TABLE `tblprfx_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_offers_categories`
--
ALTER TABLE `tblprfx_offers_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_offers_products`
--
ALTER TABLE `tblprfx_offers_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_offers_users`
--
ALTER TABLE `tblprfx_offers_users`
  ADD PRIMARY KEY (`id`);



--
-- Indexes for table `tblprfx_ordertypes`
--
ALTER TABLE `tblprfx_ordertypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_flag_history`
--
ALTER TABLE `tblprfx_order_flag_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_history`
--
ALTER TABLE `tblprfx_order_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_return_action`
--
ALTER TABLE `tblprfx_order_return_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_return_cashback_history`
--
ALTER TABLE `tblprfx_order_return_cashback_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_return_open_unopen`
--
ALTER TABLE `tblprfx_order_return_open_unopen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_return_reason`
--
-- ALTER TABLE `tblprfx_order_return_reason`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_return_status`
--
-- ALTER TABLE `tblprfx_order_return_status`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_status`
--
ALTER TABLE `tblprfx_order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_order_status_history`
--
ALTER TABLE `tblprfx_order_status_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_password_resets`
--
ALTER TABLE `tblprfx_password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tblprfx_payment_method`
--
-- ALTER TABLE `tblprfx_payment_method`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_payment_status`
--
-- ALTER TABLE `tblprfx_payment_status`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_permissions`
--
ALTER TABLE `tblprfx_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `tblprfx_permission_role`
--
ALTER TABLE `tblprfx_permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);



--
-- Indexes for table `tblprfx_products`
--
ALTER TABLE `tblprfx_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_product_has_taxes`
--
ALTER TABLE `tblprfx_product_has_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_product_types`
--
ALTER TABLE `tblprfx_product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_prod_status`
--
ALTER TABLE `tblprfx_prod_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_restaurant_tables`
--
ALTER TABLE `tblprfx_restaurant_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_return_order`
--
-- ALTER TABLE `tblprfx_return_order`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tblprfx_roles`
--
ALTER TABLE `tblprfx_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `tblprfx_role_user`
--
ALTER TABLE `tblprfx_role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `tblprfx_saved_list`
--
ALTER TABLE `tblprfx_saved_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_sections`
--
ALTER TABLE `tblprfx_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_settings`
--
ALTER TABLE `tblprfx_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_sizechart`
--
ALTER TABLE `tblprfx_sizechart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_slider`
--
ALTER TABLE `tblprfx_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_slider_master`
--
ALTER TABLE `tblprfx_slider_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_sms_subscription`
--
ALTER TABLE `tblprfx_sms_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_social_media_links`
--
ALTER TABLE `tblprfx_social_media_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_states`
--
ALTER TABLE `tblprfx_states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_static_pages`
--
ALTER TABLE `tblprfx_static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_stock_update_history`
--
ALTER TABLE `tblprfx_stock_update_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_tagging_tagged`
--
ALTER TABLE `tblprfx_tagging_tagged`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tagged_taggable_id_index` (`taggable_id`),
  ADD KEY `tagging_tagged_taggable_type_index` (`taggable_type`),
  ADD KEY `tagging_tagged_tag_slug_index` (`tag_slug`);

--
-- Indexes for table `tblprfx_tagging_tags`
--
ALTER TABLE `tblprfx_tagging_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tags_slug_index` (`slug`);

--
-- Indexes for table `tblprfx_tax`
--
ALTER TABLE `tblprfx_tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_testimonials`
--
ALTER TABLE `tblprfx_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_translation`
--
ALTER TABLE `tblprfx_translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_unit_measures`
--
ALTER TABLE `tblprfx_unit_measures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_users`
--
-- ALTER TABLE `tblprfx_users`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_vendors`
--
ALTER TABLE `tblprfx_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_wishlist`
--
ALTER TABLE `tblprfx_wishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprfx_zones`
--
ALTER TABLE `tblprfx_zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblprfx_additional_charges`
--
ALTER TABLE `tblprfx_additional_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_attributes`
--
ALTER TABLE `tblprfx_attributes`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_attribute_sets`
--
ALTER TABLE `tblprfx_attribute_sets`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tblprfx_attribute_types`
--
ALTER TABLE `tblprfx_attribute_types`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tblprfx_attribute_values`
--
ALTER TABLE `tblprfx_attribute_values`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_catalog_images`
--
ALTER TABLE `tblprfx_catalog_images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_categories`
--
ALTER TABLE `tblprfx_categories`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_cities`
--
ALTER TABLE `tblprfx_cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_comments`
--
ALTER TABLE `tblprfx_comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_contacts`
--
ALTER TABLE `tblprfx_contacts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_countries`
--
ALTER TABLE `tblprfx_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=252;
--
-- AUTO_INCREMENT for table `tblprfx_coupons`
--
ALTER TABLE `tblprfx_coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_coupons_categories`
--
ALTER TABLE `tblprfx_coupons_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_coupons_products`
--
ALTER TABLE `tblprfx_coupons_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_coupons_users`
--
ALTER TABLE `tblprfx_coupons_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_currencies`
--
ALTER TABLE `tblprfx_currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprfx_downlodable_prods`
--
ALTER TABLE `tblprfx_downlodable_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tblprfx_dynamic_layout`
--
ALTER TABLE `tblprfx_dynamic_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_email_template`
--
ALTER TABLE `tblprfx_email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_flags`
--
ALTER TABLE `tblprfx_flags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tblprfx_general_setting`
--
ALTER TABLE `tblprfx_general_setting`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `tblprfx_gifts`
--
ALTER TABLE `tblprfx_gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--

-- AUTO_INCREMENT for table `tblprfx_has_attributes`
--
ALTER TABLE `tblprfx_has_attributes`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tblprfx_has_attribute_values`
--
ALTER TABLE `tblprfx_has_attribute_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_categories`
--
ALTER TABLE `tblprfx_has_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_combo_prods`
--
ALTER TABLE `tblprfx_has_combo_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_currency`
--
ALTER TABLE `tblprfx_has_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `tblprfx_has_layouts`
--
ALTER TABLE `tblprfx_has_layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_options`
--
ALTER TABLE `tblprfx_has_options`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_products`
--
-- ALTER TABLE `tblprfx_has_products`
--   MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_related_prods`
--
ALTER TABLE `tblprfx_has_related_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_taxes`
--
ALTER TABLE `tblprfx_has_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_upsell_prods`
--
ALTER TABLE `tblprfx_has_upsell_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_has_vendors`
--
ALTER TABLE `tblprfx_has_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_kot`
--
ALTER TABLE `tblprfx_kot`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_language`
--
ALTER TABLE `tblprfx_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_layout`
--
ALTER TABLE `tblprfx_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprfx_loyalty`
--
ALTER TABLE `tblprfx_loyalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_newsletter`
--
ALTER TABLE `tblprfx_newsletter`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_notification`
--
ALTER TABLE `tblprfx_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_occupancy_status`
--
ALTER TABLE `tblprfx_occupancy_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_offers`
--
ALTER TABLE `tblprfx_offers`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprfx_offers_categories`
--
ALTER TABLE `tblprfx_offers_categories`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_offers_products`
--
ALTER TABLE `tblprfx_offers_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_offers_users`
--
ALTER TABLE `tblprfx_offers_users`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--

--
-- AUTO_INCREMENT for table `tblprfx_ordertypes`
--
ALTER TABLE `tblprfx_ordertypes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tblprfx_order_flag_history`
--
ALTER TABLE `tblprfx_order_flag_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_order_history`
--
ALTER TABLE `tblprfx_order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_order_return_action`
--
ALTER TABLE `tblprfx_order_return_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_order_return_cashback_history`
--
ALTER TABLE `tblprfx_order_return_cashback_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_order_return_open_unopen`
--
ALTER TABLE `tblprfx_order_return_open_unopen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_order_return_reason`
--
-- ALTER TABLE `tblprfx_order_return_reason`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tblprfx_order_return_status`
--
-- ALTER TABLE `tblprfx_order_return_status`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprfx_order_status`
--
ALTER TABLE `tblprfx_order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tblprfx_order_status_history`
--
ALTER TABLE `tblprfx_order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_payment_method`
--
-- ALTER TABLE `tblprfx_payment_method`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tblprfx_payment_status`
--
-- ALTER TABLE `tblprfx_payment_status`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tblprfx_permissions`
--
ALTER TABLE `tblprfx_permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28714;
--
-- AUTO_INCREMENT for table `tblprfx_pincodes`
--
ALTER TABLE `tblprfx_pincodes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_products`
--
ALTER TABLE `tblprfx_products`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_product_has_taxes`
--
ALTER TABLE `tblprfx_product_has_taxes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_product_types`
--
ALTER TABLE `tblprfx_product_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tblprfx_prod_status`
--
ALTER TABLE `tblprfx_prod_status`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_restaurant_tables`
--
ALTER TABLE `tblprfx_restaurant_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tblprfx_return_order`
--
-- ALTER TABLE `tblprfx_return_order`
--   MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_roles`
--
ALTER TABLE `tblprfx_roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblprfx_saved_list`
--
ALTER TABLE `tblprfx_saved_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_sections`
--
ALTER TABLE `tblprfx_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `tblprfx_settings`
--
ALTER TABLE `tblprfx_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblprfx_sizechart`
--
ALTER TABLE `tblprfx_sizechart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_slider`
--
ALTER TABLE `tblprfx_slider`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_slider_master`
--
ALTER TABLE `tblprfx_slider_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tblprfx_sms_subscription`
--
ALTER TABLE `tblprfx_sms_subscription`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_social_media_links`
--
ALTER TABLE `tblprfx_social_media_links`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblprfx_states`
--
ALTER TABLE `tblprfx_states`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_static_pages`
--
ALTER TABLE `tblprfx_static_pages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblprfx_stock_update_history`
--
ALTER TABLE `tblprfx_stock_update_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_tagging_tagged`
--
ALTER TABLE `tblprfx_tagging_tagged`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_tagging_tags`
--
ALTER TABLE `tblprfx_tagging_tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_tax`
--
ALTER TABLE `tblprfx_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_testimonials`
--
ALTER TABLE `tblprfx_testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_translation`
--
ALTER TABLE `tblprfx_translation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=875;
--
-- AUTO_INCREMENT for table `tblprfx_unit_measures`
--
ALTER TABLE `tblprfx_unit_measures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblprfx_users`
--
-- ALTER TABLE `tblprfx_users`
--   MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblprfx_vendors`
--
ALTER TABLE `tblprfx_vendors`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_wishlist`
--
ALTER TABLE `tblprfx_wishlist`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblprfx_zones`
--
ALTER TABLE `tblprfx_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4037;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblprfx_permission_role`
--
ALTER TABLE `tblprfx_permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `tblprfx_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tblprfx_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblprfx_role_user`
--
ALTER TABLE `tblprfx_role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tblprfx_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
