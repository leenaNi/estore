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
-- Table structure for table `contacts_groups`
--

CREATE TABLE IF NOT EXISTS `contacts_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contacts_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contacts_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Table structure for table `group_has_contacts`
--
CREATE TABLE IF NOT EXISTS `group_has_contacts` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `group_has_contacts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `group_has_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Table structure for table `email_campaigns`
--
CREATE TABLE IF NOT EXISTS `email_campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `subject` varchar(225) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=published,2=draft',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Table structure for table `store_contacts`
--

CREATE TABLE IF NOT EXISTS `store_contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobileNo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `anniversary` datetime NOT NULL,
  `birthDate` datetime NOT NULL,
  `contact_type` int(11) NOT NULL COMMENT '1=master,2=customer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kaya403485_store_contacts`
--
ALTER TABLE `store_contacts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kaya403485_store_contacts`
--
ALTER TABLE `store_contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=bulk send,2=save as draft',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_name` text NOT NULL,
  `delivary_status` int(11) NOT NULL,
  `cod_status` int(11) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `city_name`, `delivary_status`, `cod_status`, `status`) VALUES
(1, 1, 'Mumbai', 1, 1, 0),
(2, 2, 'Ahemdabad', 1, 0, 1),
(3, 1, 'Navi Mumbai', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `status_id` bigint(20) NOT NULL,
  `comment` text NOT NULL,
  `notify` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Order History';

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--


CREATE TABLE IF NOT EXISTS `contacts` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
--
-- Dumping data for table `contacts`
--


-- --------------------------------------------------------
--
-- Table structure for table `customer_reviews`
--

CREATE TABLE IF NOT EXISTS `customer_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `rating` int(11) NOT NULL,
  `publish` int(11) NOT NULL COMMENT '1=review published',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_reviews`
--
ALTER TABLE `customer_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_reviews`
--
ALTER TABLE `customer_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_categories`
--

CREATE TABLE IF NOT EXISTS `coupons_categories` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_products`
--

CREATE TABLE IF NOT EXISTS `coupons_products` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_users`
--

CREATE TABLE IF NOT EXISTS `coupons_users` (
  `id` bigint(20) NOT NULL,
  `c_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `downlodable_prods`
--

CREATE TABLE IF NOT EXISTS `downlodable_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `image_d` varchar(255) NOT NULL,
  `sort_order_d` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
 `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_layout`
--

CREATE TABLE IF NOT EXISTS `dynamic_layout` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `alignment` varchar(100) NOT NULL,
  `image` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW(),
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


-- Table structure for table `flags`
--

CREATE TABLE IF NOT EXISTS `flags` (
  `id` int(11) NOT NULL,
  `flag` varchar(100) NOT NULL,
  `value` varchar(30) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE IF NOT EXISTS `gifts` (
  `id` int(11) NOT NULL,
  `sender_email` varchar(200) NOT NULL,
  `receiver_email` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `coupon` varchar(200) NOT NULL,
  `limit` smallint(4) NOT NULL,
  `valid_upto` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `has_attributes`
--

CREATE TABLE IF NOT EXISTS `has_attributes` (
  `id` bigint(20) unsigned NOT NULL,
  `attr_id` bigint(20) NOT NULL,
  `attr_set` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `has_attribute_values`
--

CREATE TABLE IF NOT EXISTS `has_attribute_values` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_type_id` int(11) NOT NULL,
  `value` text NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `has_combo_prods`
--

CREATE TABLE IF NOT EXISTS `has_combo_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `combo_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `has_layouts`
--

CREATE TABLE IF NOT EXISTS `has_layouts` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `has_options`
--

CREATE TABLE IF NOT EXISTS `has_options` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `attr_id` bigint(20) NOT NULL,
  `attr_type_id` bigint(20) NOT NULL,
  `attr_val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `has_industries` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `general_setting_id` bigint(20) NOT NULL,
  `industry_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


--
-- Dumping data for table `has_industries`
--

INSERT INTO `has_industries` (`general_setting_id`, `industry_id`) VALUES
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
(56,1),
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
-- Table structure for table `has_related_prods`
--

CREATE TABLE IF NOT EXISTS `has_related_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `related_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `has_taxes`
--

CREATE TABLE IF NOT EXISTS `has_taxes` (
  `id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `has_upsell_prods`
--

CREATE TABLE IF NOT EXISTS `has_upsell_prods` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `upsell_prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `has_vendors`
--

CREATE TABLE IF NOT EXISTS `has_vendors` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kot`
--

CREATE TABLE IF NOT EXISTS `kot` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `status`) VALUES
(1, 'Hindi', 1),
(2, 'English', 1),
(3, 'Bengali', 1);

-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `url_key` varchar(200) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_del` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `loyalty`
--

CREATE TABLE IF NOT EXISTS `loyalty` (
  `id` int(11) NOT NULL,
  `group` varchar(100) NOT NULL,
  `min_order_amt` float NOT NULL,
  `max_order_amt` float NOT NULL,
  `percent` float NOT NULL,
  `range_amt` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL,
  `email` varchar(230) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `occupancy_status`
--

CREATE TABLE IF NOT EXISTS `occupancy_status` (
  `id` int(11) NOT NULL,
  `ostatus` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `occupancy_status`
--

INSERT INTO `occupancy_status` (`id`, `ostatus`, `color`) VALUES
(1, 'Free', 'green'),
(2, 'Occupied', 'red'),
(3, 'Billed', 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offers_categories`
--

CREATE TABLE IF NOT EXISTS `offers_categories` (
  `id` bigint(20) unsigned NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `cat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offers_products`
--

CREATE TABLE IF NOT EXISTS `offers_products` (
  `id` bigint(20) NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offers_users`
--

CREATE TABLE IF NOT EXISTS `offers_users` (
  `id` bigint(20) unsigned NOT NULL,
  `offer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


-- Table structure for table `ordertypes`
--

CREATE TABLE IF NOT EXISTS `ordertypes` (
  `id` int(20) NOT NULL,
  `otype` varchar(20) NOT NULL,
  `status` tinyint(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordertypes`
--

INSERT INTO `ordertypes` (`id`, `otype`, `status`) VALUES
(1, 'Dine In', 1),
(2, 'Home Delivery', 1),
(3, 'Take Away', 1),
(4, 'Online', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_flag_history`
--

CREATE TABLE IF NOT EXISTS `order_flag_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `flag_id` int(11) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE IF NOT EXISTS `order_history` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_return_action`
--

CREATE TABLE IF NOT EXISTS `order_return_action` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_return_action`
--

INSERT INTO `order_return_action` (`id`, `action`) VALUES
(1, 'Credit Issued'),
(2, 'Refunded'),
(3, 'No Action');

-- --------------------------------------------------------

--
-- Table structure for table `order_return_cashback_history`
--

CREATE TABLE IF NOT EXISTS `order_return_cashback_history` (
  `id` int(11) NOT NULL,
  `return_order_id` int(11) NOT NULL,
  `cashback` float(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `cron_status` enum('0','1','2') NOT NULL DEFAULT '2',
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_return_open_unopen`
--

CREATE TABLE IF NOT EXISTS `order_return_open_unopen` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_return_open_unopen`
--

INSERT INTO `order_return_open_unopen` (`id`, `status`) VALUES
(1, 'Opened'),
(2, 'Unopened');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `order_status_history`
--

CREATE TABLE IF NOT EXISTS `order_status_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status_id` tinyint(4) NOT NULL,
  `remark` varchar(500) NOT NULL,
  `notify` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_has_taxes`
--

CREATE TABLE IF NOT EXISTS `product_has_taxes` (
  `id` int(10) NOT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` bigint(20) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prod_status`
--

CREATE TABLE IF NOT EXISTS `prod_status` (
  `id` bigint(20) NOT NULL,
  `prod_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE IF NOT EXISTS `restaurant_tables` (
  `id` int(11) NOT NULL,
  `table_no` int(11) NOT NULL,
  `table_label` varchar(50) NOT NULL,
  `table_type` int(11) NOT NULL COMMENT '1 - square | 2 - rectangle | 3 - circle',
  `chairs` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ostatus` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_list`
--

CREATE TABLE IF NOT EXISTS `saved_list` (
  `id` bigint(20) NOT NULL,
  `prod_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `store_settings` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `value` varchar(255) NOT NULL,
  `url_key` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sizechart`
--

CREATE TABLE IF NOT EXISTS `sizechart` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` int(20) NOT NULL,
  `link` text NOT NULL,
  `sort_order` int(20) NOT NULL,
  `alt` text NOT NULL,
  `slider_id` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slider_master`
--

CREATE TABLE IF NOT EXISTS `slider_master` (
  `id` int(11) NOT NULL,
  `slider` varchar(255) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=active,1=deactive',
  `delete_master` enum('0','1') NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

CREATE TABLE `question_category` (
  `id` int(11) NOT NULL,
  `category` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
  `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question_category` (`id`, `category`, `status`, `sort_order`) VALUES
(1, 'Marketing', 1, 0),
(2, 'Management', 1, 0),
(3, 'Payment', 1, 0),
(4, 'Inventory', 1, 0),
(5, 'Product', 1, 0),
(6, 'Miscellaneous', 1, 0);
ALTER TABLE `question_category`
  ADD PRIMARY KEY (`id`);



CREATE TABLE IF NOT EXISTS `sms_subscription` (
  `id` bigint(20) NOT NULL,
  `no_of_sms` text NOT NULL,
  `purchased_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `social_media_links`
--

CREATE TABLE IF NOT EXISTS `social_media_links` (
  `id` int(10) unsigned NOT NULL,
  `media` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
`sort_order` int(11) NOT NULL DEFAULT '0',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint(20) NOT NULL,
  `country_id` tinyint(4) DEFAULT NULL,
  `state_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `static_pages`
--

CREATE TABLE IF NOT EXISTS `static_pages` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_update_history`
--

CREATE TABLE IF NOT EXISTS `stock_update_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `update_status` enum('0','1') NOT NULL COMMENT '0=minus,1=added',
  `update_qty` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tagged`
--

CREATE TABLE IF NOT EXISTS `tagging_tagged` (
  `id` int(10) unsigned NOT NULL,
  `taggable_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagging_tags`
--

CREATE TABLE IF NOT EXISTS `tagging_tags` (
  `id` int(10) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suggest` tinyint(1) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE IF NOT EXISTS `tax` (
  `id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(50) DEFAULT NULL,
  `rate` float(5,2) NOT NULL,
  `tax_number` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0- deleted, 1 - Enabled, 2-disabled',
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `customer_name` varchar(50) NOT NULL,
 `gender` varchar(50) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `translation`
--

CREATE TABLE IF NOT EXISTS `translation` (
  `id` bigint(20) NOT NULL,
  `hindi` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `english` varchar(50) NOT NULL,
  `bengali` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `page` text,
  `translate_for` varchar(255) DEFAULT NULL,
  `is_specific` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `unit_measures`
--

CREATE TABLE IF NOT EXISTS `unit_measures` (
  `id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT NOW(),
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
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
   `updated_at` timestamp  DEFAULT  NOW()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

INSERT INTO `has_industries` (`id`, `general_setting_id`, `industry_id`) VALUES (NULL, '50', '1');

INSERT INTO `has_industries` (`id`, `general_setting_id`, `industry_id`) VALUES (NULL, '13', '2');

UPDATE `general_setting` SET `status` = '1' WHERE `general_setting`.`id` in (13,50);
--
-- Indexes for dumped tables
--
--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_lft_index` (`lft`),
  ADD KEY `categories_rgt_index` (`rgt`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_name` (`coupon_name`),
  ADD KEY `start_date` (`start_date`),
  ADD KEY `end_date` (`end_date`);

--
-- Indexes for table `coupons_categories`
--
ALTER TABLE `coupons_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons_products`
--
ALTER TABLE `coupons_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons_users`
--
ALTER TABLE `coupons_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downlodable_prods`
--
ALTER TABLE `downlodable_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_layout`
--
ALTER TABLE `dynamic_layout`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `flags`
--
ALTER TABLE `flags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`id`);


-- Indexes for table `has_attributes`
--
ALTER TABLE `has_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_attribute_values`
--
ALTER TABLE `has_attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_combo_prods`
--
ALTER TABLE `has_combo_prods`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `has_layouts`
--
ALTER TABLE `has_layouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_options`
--
ALTER TABLE `has_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_related_prods`
--
ALTER TABLE `has_related_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_taxes`
--
ALTER TABLE `has_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has_upsell_prods`
--
ALTER TABLE `has_upsell_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kot`
--
ALTER TABLE `kot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout`
--
ALTER TABLE `layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loyalty`
--
ALTER TABLE `loyalty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `occupancy_status`
--
ALTER TABLE `occupancy_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_categories`
--
ALTER TABLE `offers_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_products`
--
ALTER TABLE `offers_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_users`
--
ALTER TABLE `offers_users`
  ADD PRIMARY KEY (`id`);



--
-- Indexes for table `ordertypes`
--
ALTER TABLE `ordertypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_flag_history`
--
ALTER TABLE `order_flag_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_return_action`
--
ALTER TABLE `order_return_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_return_cashback_history`
--
ALTER TABLE `order_return_cashback_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_return_open_unopen`
--
ALTER TABLE `order_return_open_unopen`
  ADD PRIMARY KEY (`id`);

-- ALTER TABLE `order_status`
--   ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);


--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_has_taxes`
--
ALTER TABLE `product_has_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prod_status`
--
ALTER TABLE `prod_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `saved_list`
--
ALTER TABLE `saved_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizechart`
--
ALTER TABLE `sizechart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_master`
--
ALTER TABLE `slider_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_subscription`
--
ALTER TABLE `sms_subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media_links`
--
ALTER TABLE `social_media_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_pages`
--
ALTER TABLE `static_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_update_history`
--
ALTER TABLE `stock_update_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tagged_taggable_id_index` (`taggable_id`),
  ADD KEY `tagging_tagged_taggable_type_index` (`taggable_type`),
  ADD KEY `tagging_tagged_tag_slug_index` (`tag_slug`);

--
-- Indexes for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagging_tags_slug_index` (`slug`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translation`
--
ALTER TABLE `translation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_measures`
--
ALTER TABLE `unit_measures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupons_categories`
--
ALTER TABLE `coupons_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupons_products`
--
ALTER TABLE `coupons_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupons_users`
--
ALTER TABLE `coupons_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `downlodable_prods`
--
ALTER TABLE `downlodable_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dynamic_layout`
--
ALTER TABLE `dynamic_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `flags`
--
ALTER TABLE `flags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--

-- AUTO_INCREMENT for table `has_attributes`
--
ALTER TABLE `has_attributes`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_attribute_values`
--
ALTER TABLE `has_attribute_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_combo_prods`
--
ALTER TABLE `has_combo_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_layouts`
--
ALTER TABLE `has_layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_options`
--
ALTER TABLE `has_options`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `has_related_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_taxes`
--
ALTER TABLE `has_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_upsell_prods`
--
ALTER TABLE `has_upsell_prods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `has_vendors`
--
ALTER TABLE `has_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kot`
--
ALTER TABLE `kot`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `layout`
--
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loyalty`
--
ALTER TABLE `loyalty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `occupancy_status`
--
ALTER TABLE `occupancy_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers_categories`
--
ALTER TABLE `offers_categories`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers_products`
--
ALTER TABLE `offers_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offers_users`
--
ALTER TABLE `offers_users`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ordertypes`
--
ALTER TABLE `ordertypes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_flag_history`
--
ALTER TABLE `order_flag_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_return_action`
--
ALTER TABLE `order_return_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_return_cashback_history`
--
ALTER TABLE `order_return_cashback_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_return_open_unopen`
--
ALTER TABLE `order_return_open_unopen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_has_taxes`
--
ALTER TABLE `product_has_taxes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `prod_status`
--
ALTER TABLE `prod_status`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saved_list`
--
ALTER TABLE `saved_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sizechart`
--
ALTER TABLE `sizechart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `slider_master`
--
ALTER TABLE `slider_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sms_subscription`
--
ALTER TABLE `sms_subscription`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_media_links`
--
ALTER TABLE `social_media_links`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `static_pages`
--
ALTER TABLE `static_pages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_update_history`
--
ALTER TABLE `stock_update_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tagging_tagged`
--
ALTER TABLE `tagging_tagged`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tagging_tags`
--
ALTER TABLE `tagging_tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `translation`
--
ALTER TABLE `translation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit_measures`
--
ALTER TABLE `unit_measures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables


ALTER TABLE `notification` ADD `deleted_at` INT NULL AFTER `updated_at`;

ALTER TABLE `notification` ADD `status` INT(10) NOT NULL AFTER `email`;
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
-- ALTER TABLE `role_user`
--   ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `additional_charges` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `attribute_sets` ADD `status` tinyint(20) NOT NULL AFTER `attr_set`;
ALTER TABLE `attribute_sets` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `categories` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `cities` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `contacts` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `countries` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `coupons` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `couriers` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `dynamic_layout` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `email_template` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `flags` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `general_setting` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `gifts` ADD `store_id` BIGINT(20) NOT NULL AFTER `valid_upto`;
ALTER TABLE `language` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `layout` ADD `store_id` BIGINT(20) NOT NULL AFTER `is_del`;
ALTER TABLE `loyalty` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `newsletter` ADD `store_id` BIGINT(20) NOT NULL AFTER `email`;
ALTER TABLE `notification` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `offers` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `order_return_action` ADD `store_id` BIGINT(20) NOT NULL AFTER `action`;
ALTER TABLE `order_return_open_unopen` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `order_return_reason` ADD `store_id` BIGINT(20) NOT NULL AFTER `reason`;
ALTER TABLE `order_status` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `pincodes` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `products` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `prod_status` ADD `store_id` BIGINT(20) NOT NULL AFTER `prod_status`;
ALTER TABLE `product_types` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `product_types` ADD `type_id` INT NOT NULL AFTER `type`;
ALTER TABLE `restaurant_tables` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `roles` ADD `store_id` BIGINT(20) NOT NULL AFTER `description`;
ALTER TABLE `sections` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `sizechart` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `slider` ADD `store_id` BIGINT(20) NOT NULL AFTER `slider_id`;
ALTER TABLE `slider_master` ADD `store_id` BIGINT(20) NOT NULL AFTER `is_active`;
ALTER TABLE `sms_subscription` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `social_media_links` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `static_pages` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `store_contacts` ADD `store_id` BIGINT(20) NOT NULL AFTER `birthDate`;
ALTER TABLE `tax` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `testimonials` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `translation` ADD `store_id` BIGINT(20) NOT NULL AFTER `is_specific`;
ALTER TABLE `unit_measures` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `vendors` ADD `zip` BIGINT(20) NOT NULL AFTER `status`;
ALTER TABLE `roles` ADD `store_id` BIGINT(20) NOT NULL AFTER `description`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
