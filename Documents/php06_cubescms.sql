-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2016 at 03:15 PM
-- Server version: 10.1.14-MariaDB
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php06_cubescms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_members`
--

CREATE TABLE IF NOT EXISTS `cms_members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `work_title` varchar(255) NOT NULL DEFAULT '',
  `resume` longtext NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `order_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms_members`
--

INSERT INTO `cms_members` (`id`, `first_name`, `last_name`, `email`, `work_title`, `resume`, `status`, `order_number`) VALUES
(1, 'Aleksandar', 'Stevanović', 'alexsandarrr@gmail.com', 'PHP Developer', '', 1, 7),
(2, 'Aleksandra', 'Petković', 'a13x.petkovic@gmail.com', 'PHP Developer', '', 1, 9),
(3, 'Arben', 'Bakiu', 'arben.bakiu91@gmail.com', 'PHP Developer', '', 1, 5),
(4, 'Bojan', 'Jončić', 'joncicb@gmail.com', 'PHP Developer', '', 1, 8),
(5, 'Djordje', 'Stojiljković', 'djordjewebdizajn@gmail.com', 'PHP Developer', '', 1, 4),
(6, 'Milomir', 'Dragović', 'milomir.drago@gmail.com', 'PHP Developer', 'sd§f', 1, 1),
(7, 'Miloš', 'Stefanović', 'stefanovic.milos.srb@gmail.com', 'PHP Developer', '', 0, 10),
(8, 'Miroslav', 'Mutić', 'mmutix@gmail.com', 'PHP Developer', '', 1, 11),
(9, 'Nataša', 'Lukić', 'natasa80lukic@gmail.com', 'PHP Developer', '', 0, 3),
(10, 'Željka', 'Babić', 'pcelica88@gmail.com', 'PHP Developer', 'asfdgasdgsad gsadg sadg asdgsdg', 1, 6),
(16, 'dsgasd', 'gsadgsag', 'sag@dsg', '', '', 0, 12),
(17, 'sdagf', 'sfagsad', 'sfdgaas@fasg', 'fsgasdg', '', 1, 13),
(19, 'Reload', 'asdf', 'asdf@reload', '', '', 1, 2),
(20, 'ksdagfkl', 'akgskdg', 'qksadfj@gsfak', 'asdgfsfdg', 'asdg', 1, 14),
(21, 'sfdgsadg', 'sadgfa', 'asffdgasgd!@fdgs', 'asdfgasdgf', '', 1, 15),
(22, 'sadf', 'sdf', 'sadf@dsgf', '', '', 1, 16),
(23, 'sagfd', 'sadgf', 'sag@gds', '', '', 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `cms_services`
--

CREATE TABLE IF NOT EXISTS `cms_services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms_services`
--

INSERT INTO `cms_services` (`id`, `title`, `icon`, `description`, `status`, `order_number`) VALUES
(1, 'Web', 'glyphicon glyphicon-wrench icon-small icon-inverse-80 _icon-circle', 'Etiam nec metus leo. Aliquam non sagittis augue. In in congue dolor. Cras mollis lobortis sem quis rutrum. Aenean ornare interdum arcu, a sollicitudin dui tincidunt nec. Mauris eu nibh viverra, egestas enim non, venenatis massa. Morbi ut diam ornare ex convallis porttitor eget a nulla. Cras nec iaculis erat. Nam sagittis rutrum neque, sit amet hendrerit felis facilisis in. Proin eget felis tincidunt, vehicula leo eget, fringilla lacus. Duis ultrices mollis quam, nec aliquet augue suscipit et.', 1, 5),
(2, 'SEO', 'glyphicon glyphicon-search icon-small icon-inverse-80 _icon-circle', 'Suspendisse vitae mauris id nisl blandit faucibus in id nibh. Nam non nisl viverra lacus volutpat elementum. Donec consequat purus in dui euismod porta. Pellentesque iaculis malesuada mollis. Nulla tempus leo et quam maximus vehicula. Aenean vitae pellentesque tellus. Nullam elementum justo sit amet porttitor elementum. Cras arcu eros, hendrerit feugiat dictum et, pretium quis lacus. Phasellus vehicula leo lacus, at convallis risus maximus eget. Aliquam molestie quis tortor ac efficitur. Vivamus quam eros, ultricies vel porta eu, accumsan in urna. Duis imperdiet sem vitae diam elementum, vel porta arcu blandit.', 1, 1),
(3, 'Design', 'glyphicon glyphicon-pencil icon-small icon-inverse-80 _icon-circle', 'Cras augue ex, viverra a tristique quis, eleifend nec justo. Aenean iaculis at magna ut laoreet. Integer ut quam ac lorem tincidunt fermentum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam a neque ullamcorper, cursus magna et, vehicula eros. Mauris a tristique tellus, id eleifend ante. Pellentesque eu purus convallis leo tincidunt vulputate a quis ex. Sed a dapibus mi. Sed porta eros dui, non dignissim erat laoreet ut. Cras vel lectus faucibus, vehicula metus non, molestie massa.', 1, 2),
(4, 'eCommerce', 'glyphicon glyphicon-shopping-cart icon-small icon-inverse-80 _icon-circle', 'Pellentesque quis metus rhoncus nisi cursus semper nec sit amet libero. Suspendisse mattis, est bibendum mollis elementum, tortor est aliquet ex, at volutpat purus metus eget risus. Morbi nunc leo, condimentum ac consectetur a, feugiat et ligula. Phasellus vitae sapien pharetra, malesuada mauris ut, sodales nulla. Nulla facilisi. Etiam eu lectus aliquam, finibus erat eu, molestie massa. Nulla non dolor blandit, euismod ex sit amet, feugiat dolor. Curabitur eget rutrum felis. Maecenas dictum urna eu tellus interdum tincidunt. Fusce eleifend elit vulputate, egestas diam vel, facilisis nisl. Donec vestibulum odio imperdiet odio volutpat commodo. Vivamus et semper eros. Pellentesque interdum nisi id pharetra imperdiet.', 1, 6),
(5, 'Glass', 'glyphicon glyphicon-glass icon-small icon-inverse-80 _icon-circle', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec et lorem pulvinar, pretium est eget, maximus dolor. Phasellus leo magna, vehicula ornare mattis et, venenatis non ex. Sed ut ipsum eget sapien mattis auctor vitae tincidunt nisi. Cras tortor nisi, scelerisque vitae tortor ac, viverra varius ipsum. In scelerisque bibendum dui, eu maximus libero condimentum facilisis. Cras condimentum pharetra ligula, posuere dapibus massa mollis in. Sed ornare malesuada cursus.', 1, 9),
(6, 'Home', 'glyphicon glyphicon-home icon-small icon-inverse-80 _icon-circle', 'Aenean fringilla, augue vitae pulvinar convallis, sem mauris convallis eros, ut faucibus libero tellus at sem. Vivamus id quam accumsan, tempor magna et, convallis odio. Sed felis nunc, pretium quis ex sed, interdum porta ipsum. Etiam maximus vulputate porta. Nunc lorem neque, pharetra eu auctor mollis, elementum quis mauris.', 1, 7),
(8, 'Beer', 'fa fa-beer icon-small icon-inverse-80 _icon-circle', 'Comming soon...', 0, 8),
(9, 'Bicycle', 'fa fa-bicycle icon-small icon-inverse-80 _icon-circle', 'Comming soon...', 0, 3),
(12, 'insertService', 'fa fa-beer', 'sdfagsd afdsa fsda fsadf', 0, 10),
(14, 'sdaf', 'dsaf', '', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
  `id` int(11) NOT NULL,
  `username` char(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `status`) VALUES
(1, 'cubes', 'd5908e4aa76277878259ed57c19c5f78', 'vuk.dzic@gmail.com', 'Vuk', 'Karadzic', 1),
(2, 'aleksandar.stevanovic', '7182821555d2101b3c64a14b82e12e2c', 'alexsandarrr@gmail.com', 'Aleksandar', 'Stevanovic', 1),
(3, 'natasa.lukic', '7182821555d2101b3c64a14b82e12e2c', 'natasa80lukic@gmail.com', 'Natasa', 'Lukic', 1),
(4, 'aleksandra.petkovic', '7182821555d2101b3c64a14b82e12e2c', 'a13x.petkovic@gmail.com', 'Aleksandra', 'Petkovic', 1),
(5, 'djordje.stojiljkovic', '7182821555d2101b3c64a14b82e12e2c', 'djordjewebdizajn@gmail.com', 'Djordje', 'Stojiljkovic', 1),
(6, 'milos.stefanovic', '7182821555d2101b3c64a14b82e12e2c', 'stefanovic.milos.srb@gmail.com', 'Milos', 'Stefanovic', 1),
(7, 'milomir.dragovic', '7182821555d2101b3c64a14b82e12e2c', 'milomir.drago@gmail.com', 'Milomir', 'Dragovic', 1),
(8, 'miroslav.mutic', '7182821555d2101b3c64a14b82e12e2c', 'mmutix@gmail.com', 'Miroslav', 'Mutic', 1),
(9, 'bojan.joncic', '7182821555d2101b3c64a14b82e12e2c', 'joncicb@gmail.com', 'Bojan', 'Joncic', 1),
(10, 'arben.bakiu', '7182821555d2101b3c64a14b82e12e2c', 'arben.bakiu91@gmail.com', 'Arben', 'Bakiu', 1),
(11, 'zeljka.babic', '7182821555d2101b3c64a14b82e12e2c', 'pcelica88@gmail.com', 'Zeljka', 'Babic', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_members`
--
ALTER TABLE `cms_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_services`
--
ALTER TABLE `cms_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users`
--
ALTER TABLE `cms_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ix_cms_users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_members`
--
ALTER TABLE `cms_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cms_services`
--
ALTER TABLE `cms_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `cms_users`
--
ALTER TABLE `cms_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
