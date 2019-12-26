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

--
-- Dumping data for table `permissions`
--
INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `section_id`, `parent_id`, `status`) VALUES
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
(509, 'admin.orders.waybill', 'Orders Waybill', NULL, 57, 0, 0),
(510, 'admin.category.catImgDelete', 'Category Catimgdelete', NULL,57,0, 0),
(511, 'admin.staticpages.imgdelete', 'Staticpages Imgdelete', NULL, 57, 0, 0);

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

ALTER TABLE `email_template` ADD `url_key` TEXT NOT NULL AFTER `name`;
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
-- ALTER TABLE `vendors` ADD `store_id` BIGINT(20) NOT NULL AFTER `status`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
