-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2016 at 03:48 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playdatabase`
--
/*CREATE DATABASE IF NOT EXISTS `playdatabase` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;*/
/*USE `playdatabase`;*/

-- --------------------------------------------------------

--
-- Table structure for table `category`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `category`:
--

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(01, 'Autos & Vehicles'),
(02, 'Comedy'),
(03, 'Education'),
(04, 'Entertainment'),
(05, 'Film & Animation'),
(06, 'Gaming'),
(07, 'How to & Style'),
(08, 'Music'),
(09, 'News & Politics'),
(10, 'Nonprofits & Activism'),
(11, 'People & Blogs'),
(12, 'Pets & Animals'),
(13, 'Science & Technology'),
(14, 'Sports'),
(15, 'Travel & Events');

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `channel`;
CREATE TABLE `channel` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slug` varchar(32) NOT NULL,
  `image_filename` varchar(128) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `channel`:
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `video_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `message` text NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `comment`:
--   `video_id`
--       `videos` -> `id`
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `guests`;
CREATE TABLE `guests` (
  `id` bigint(21) UNSIGNED ZEROFILL NOT NULL,
  `address` varchar(17) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `guests`:
--

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `playlist`;
CREATE TABLE `playlist` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(50) NOT NULL,
  `video_id` bigint(20) UNSIGNED ZEROFILL DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `playlist`:
--   `user_id`
--       `users` -> `id`
--   `video_id`
--       `videos` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE `reply` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `comment_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `message` text NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `reply`:
--   `comment_id`
--       `comment` -> `id`
--   `user_id`
--       `users` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `subscriber`;
CREATE TABLE `subscriber` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `channel_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `subscribed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `subscriber`:
--   `user_id`
--       `users` -> `id`
--   `channel_id`
--       `channel` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hash` varchar(32) DEFAULT NULL,
  `status` enum('activated','deactivated') NOT NULL DEFAULT 'deactivated',
  `image_filename` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `users`:
--

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `channel_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `category` tinyint(2) UNSIGNED ZEROFILL DEFAULT NULL,
  `video_filename` varchar(128) NOT NULL,
  `audio_filename` varchar(128) DEFAULT NULL,
  `subtitle_filename` varchar(128) DEFAULT NULL,
  `thumbnail_filename` varchar(128) DEFAULT NULL,
  `published` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` enum('private','unlist','public') NOT NULL DEFAULT 'private',
  `votes` enum('on','off') NOT NULL DEFAULT 'on',
  `comments` enum('on','off') NOT NULL DEFAULT 'on',
  `url` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `videos`:
--   `channel_id`
--       `channel` -> `id`
--   `category`
--       `category` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `views`
--
-- Creation: Nov 01, 2016 at 06:02 PM
--

DROP TABLE IF EXISTS `views`;
CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `video_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `viewed_by` enum('user','guest') NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL DEFAULT NULL,
  `guest_id` bigint(21) UNSIGNED ZEROFILL DEFAULT NULL,
  `viewed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `views`:
--   `video_id`
--       `videos` -> `id`
--   `user_id`
--       `users` -> `id`
--   `guest_id`
--       `guests` -> `id`
--

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--
-- Creation: Nov 01, 2016 at 07:45 PM
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `video_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `user_id` bigint(20) UNSIGNED ZEROFILL NOT NULL,
  `voted_as` enum('like','dislike') NOT NULL,
  `voted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `votes`:
--   `video_id`
--       `videos` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `address` (`address`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel_id` (`channel_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `video_filename` (`video_filename`),
  ADD UNIQUE KEY `url` (`url`),
  ADD UNIQUE KEY `audio_filename` (`audio_filename`),
  ADD UNIQUE KEY `subtitle_filename` (`subtitle_filename`),
  ADD UNIQUE KEY `thumbnail_filename` (`thumbnail_filename`),
  ADD KEY `channel_id` (`channel_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(21) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `channel`
--
ALTER TABLE `channel`
  ADD CONSTRAINT `channel_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `playlist_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD CONSTRAINT `subscriber_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriber_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `views_ibfk_3` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Metadata
--
/*USE `phpmyadmin`;*/

--
-- Metadata for category
--

--
-- Metadata for channel
--

--
-- Metadata for comment
--

--
-- Metadata for guests
--

--
-- Metadata for playlist
--

--
-- Metadata for reply
--

--
-- Metadata for subscriber
--

--
-- Metadata for users
--

--
-- Metadata for videos
--

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'playdatabase', 'videos', '{"sorted_col":"`videos`.`thumbnail_filename`  DESC"}', '2016-10-26 17:59:32');

--
-- Metadata for views
--

--
-- Metadata for votes
--

--
-- Metadata for playdatabase
--

--
-- Dumping data for table `pma__pdf_pages`
--

INSERT INTO `pma__pdf_pages` (`db_name`, `page_descr`) VALUES
('playdatabase', 'all tables');

SET @LAST_PAGE = LAST_INSERT_ID();

--
-- Dumping data for table `pma__table_coords`
--

INSERT INTO `pma__table_coords` (`db_name`, `table_name`, `pdf_page_number`, `x`, `y`) VALUES
('playdatabase', 'category', @LAST_PAGE, 1049, 550),
('playdatabase', 'channel', @LAST_PAGE, 358, 417),
('playdatabase', 'comment', @LAST_PAGE, 1011, 197),
('playdatabase', 'guests', @LAST_PAGE, 55, 31),
('playdatabase', 'playlist', @LAST_PAGE, 359, 159),
('playdatabase', 'reply', @LAST_PAGE, 987, 373),
('playdatabase', 'subscriber', @LAST_PAGE, 52, 189),
('playdatabase', 'users', @LAST_PAGE, 53, 372),
('playdatabase', 'videos', @LAST_PAGE, 670, 293),
('playdatabase', 'views', @LAST_PAGE, 670, 29),
('playdatabase', 'votes', @LAST_PAGE, 1002, 31);

--
-- Dumping data for table `pma__pdf_pages`
--

INSERT INTO `pma__pdf_pages` (`db_name`, `page_descr`) VALUES
('playdatabase', 'PLAYDATABASE');

SET @LAST_PAGE = LAST_INSERT_ID();

--
-- Dumping data for table `pma__table_coords`
--

INSERT INTO `pma__table_coords` (`db_name`, `table_name`, `pdf_page_number`, `x`, `y`) VALUES
('playdatabase', 'category', @LAST_PAGE, 1049, 550),
('playdatabase', 'channel', @LAST_PAGE, 358, 417),
('playdatabase', 'comment', @LAST_PAGE, 1011, 197),
('playdatabase', 'guests', @LAST_PAGE, 55, 31),
('playdatabase', 'playlist', @LAST_PAGE, 359, 159),
('playdatabase', 'reply', @LAST_PAGE, 987, 373),
('playdatabase', 'subscriber', @LAST_PAGE, 52, 189),
('playdatabase', 'users', @LAST_PAGE, 53, 372),
('playdatabase', 'videos', @LAST_PAGE, 670, 293),
('playdatabase', 'views', @LAST_PAGE, 670, 29),
('playdatabase', 'votes', @LAST_PAGE, 1002, 31);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
