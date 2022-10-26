-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 07, 2021 at 04:16 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noticeboard`
--
CREATE DATABASE IF NOT EXISTS `noticeboard` DEFAULT CHARACTER SET utf16 COLLATE utf16_general_ci;
USE `noticeboard`;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `postid` int(5) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(120) DEFAULT NULL,
  `created` datetime NOT NULL,
  `content` varchar(800) DEFAULT NULL,
  `image` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postid`, `uid`, `title`, `created`, `content`, `image`) VALUES
(1, 14, 'Lost grey tabby cat', '2021-11-01 11:16:39', 'My grey and white tabby cat when missing on Tuesday this week. Last seen in the city centre park. She should be wearing a red collar with a bell. Quite shy so will run away when approached. Please contact me if you see her: ', 'img/grey-cat.png'),
(2, NULL, 'Classic Car Volkswagen Golf Mk1 1.5 litre model - £12500 (1983 model)', '2021-12-20 15:42:16', 'Classic Car Volkswagen Golf Mk1 1.5L 1983 - £12,750 in Sky Blue.\r\nThree owners so far, full service history\r\nNo dents. Small scratches on front bumper and tyres need replacing in next year\r\nMileage: 98,761\r\nMax speed: 96.3–98.2 mph\r\nEngine: 1,457 cc \r\nGearBox: 4 Speed Manual', 'img/vw-golf-blue.png'),
(3, 8, 'Great one bedroom flat for rent', '2022-01-03 09:14:44', 'The property  benefits from a well cared for communal entrance with a lift to the 25th floor, the entrance hall having useful storage.\nAn open plan 30.4\'ft lounge/contemporary kitchen with 5 year old integrated appliances but no microwave. There is a small veranda off the living room. One double bedroom, storage cupboard, and 1 en-suite bathroom. Sadly no on-site parking. £650 per month in cash only. Call if interested.', 'img/apartment-1bed.jpg'),
(4, 10, 'Piano and keyboard lessons', '2021-10-15 17:22:33', 'Do you want to learn how to play the piano or improve what you can do already? I can teach and provide lessons up to Grade 8 in piano or keyboards. I can travel to your home or you can come to me for lessons. Lessons cost £30 per hour. ', NULL),
(5, 25, 'Wanted West Ham Tickets at Everton - £100', '2022-01-05 14:07:17', 'Wanted: two Home End tickets for West Ham v Everton 2nd April 2022 - Face to Face Exchange please. Will pay more for pitch-side seats, up to £150.', NULL),
(6, 25, 'Wanted Brentford Tickets at West Ham - £160', '2022-01-05 14:12:29', 'Wanted: four Away End tickets for Brentford versus West Ham on 9th April 2022 - Face to Face Exchange please.', NULL),
(7, 17, 'Security Operative Needed x 3', '2021-12-02 05:08:40', 'Seeking THREE experienced security individuals to work Friday and Saturday evening shifts at local night club. Potential candidates need to have some experience and current certification for door security staff. Should be able to take orders and execute them ASAP. Good communication skills are a must. ', NULL),
(8, 4, 'Office Chair for Sale. £15.', '2022-01-06 04:47:15', 'Black office chair with fake leather covering - pickup/cash only', 'img/office-chair-blk.jpg'),
(9, 4, 'Three seater fabric sofa in green. FREE', '2022-01-06 04:53:00', 'Green sofa available for free. Some small marks and tears from pets but still comfortable. Need this gone by Saturday! Free to anyone who can collect it!', 'img/green-sofa.jpg'),
(10, 19, 'RX 580 Gaming PC - £600', '2021-11-28 01:51:12', 'The specs for my PC are as follows:\nIntel I5-7500,\nAMD Radeon RX 580x 8 GB VRAM,\nCorsair 16 GB RAM,\nCooler Master AIO Liquid Cooler,\n2 TB SSD,\nAcer CD-DVD drive,\nCooler Master case and RGB fan kit,\nWindows 10', NULL),
(11, NULL, 'Dinner at Ramirez\'s Steakhouse and Bar', '2021-11-05 16:12:14', 'Ramirez\'s the premier downtown steak and grill restaurant, is open every Friday and Saturday night for Prepaid Dinner. Three affordable fixed menus: £25, £40, or £55 per person. Delivery and takeout also available. Non-communal private tables for you and your family and friends.', NULL),
(12, 8, 'Wallet Found outside train station', '2022-01-17 05:19:34', 'Found wallet on the pavement just outside the central train station! ID and cards still in there, would like to return it. There is also £40 in cash. Brown leather with clasp.', 'img/brown-found-wallet.jpg'),
(13, 3, 'Affordable Cleaning for your home or small office', '2021-09-19 12:31:12', 'Personable professional cleaner, very reliable and thorough with over 10 years of experience. Happy to deal with cleaning, laundry and ironing. References are available. Has own transportation. Please email or call for an estimate.', NULL),
(14, 10, 'Car Wash workers needed', '2022-01-10 19:08:00', 'Car wash company E-Z-Clean-4-U in the finance district is looking for workers to vacuum, brush, and dry cars for the 7:30am-2pm shift. Experience is preferred but not required. Please reply with your name and phone number. Pay is £7 per hour with potential for tips from customers. Must have own sponge.', NULL),
(15, 13, 'Looking to rent a garage or 24 hour access storage space', '2021-12-29 22:52:18', 'I\'m looking to rent a garage or similar sized storage space.I would prefer if it has electricity. Willing to pay up to £100 per month. Good security and lighting outside is a must.', NULL),
(16, 2, 'Casio digital watch with black strap - £40 ono', '2021-11-28 11:21:50', 'Brand new casio watch for sale. All the usual features: stopwatch, alarm, etc. Cash pickup only.', 'img/digital-watch.jpg'),
(17, 5, 'Wanted: Les Paul Custom guitar (1998)', '2021-11-09 12:58:02', 'Wanted: 1998 Gibson Les Paul Custom in Wine Red. Willing to pay up to £2,200', NULL),
(18, 3, 'Graphic Designer needed', '2021-12-09 09:32:46', 'Small company looking to re-brand. Requires strong understanding and implementation of all necessary design software and already has access to this. Turnaround is 2 months. Will pay up to £3000 for complete rebranding work.', NULL),
(19, NULL, 'Looking to rent a room', '2022-01-06 06:58:20', 'I\'m looking to rent a room in a city suburb or on the outskirts. Can be short or long term. When responding, please include town, price, and contact phone number. Please be pet friendly. No texts, no emails. Voice calls only on 01234 567890.', NULL),
(20, 12, 'Xbox 360 w/15 games & 2 controllers - £180', '2020-07-15 20:17:16', 'Xbox 360 Console; two controllers, power brick, HDMI cable, 15 games. Original box, instructions and all components included. Used but all still working. Selling everything for £180.', 'img/xbox-360.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `firstname` varchar(64) DEFAULT NULL,
  `lastname` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `age` smallint(3) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `county` varchar(40) DEFAULT NULL,
  `country` varchar(60) DEFAULT NULL,
  `phone` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `firstname`, `lastname`, `email`, `age`, `city`, `county`, `country`, `phone`) VALUES
(1, 'organicrabbit57', 'rosemary', 'Felix', 'Thomas', 'felix.thomas@example.com', 45, 'Lower Hutt', 'Tasman', 'New Zealand', '5018914184'),
(2, 'silverpanda145', 'semper', 'Mathew', 'Carter', 'mathew.carter@example.com', 37, 'Athlone', 'Roscommon', 'Ireland', '612122816'),
(3, 'angrycat29', 'amber1', 'Larissa', 'Souza', 'larissa.souza@example.com', 74, 'Uberaba', 'Minas Gerais', 'Brazil', '9568171731'),
(4, 'heavycat533', 'golden', 'Ceylan', 'Akyuz', 'ceylan.akyuz@example.com', 72, 'Sinop', 'Sinop', 'Turkey', '6198082101'),
(5, 'silverkoala474', 'forest', 'Justin', 'Anderson', 'justin.anderson@example.com', 28, 'St. Antoine', 'New Brunswick', 'Canada', '3155066199'),
(6, 'ticklishlion155', 'crystal', 'Domingo', 'Navarro', 'domingo.navarro@example.com', 69, 'Sevilla', 'Galicia', 'Spain', '920829274'),
(7, 'organicbear21', 'diva66', 'Emily', 'Campbell', 'emily.campbell@example.com', 22, 'Carleton', 'Ontario', 'Canada', '9286555750'),
(8, 'redmouse5', 'simon', 'Jeppe', 'Petersen', 'jeppe.petersen@example.com', 39, 'Dalmose', 'Zealand', 'Denmark', '78043558'),
(9, 'tinyfish499', 'coolhand', 'Bob', 'Wright', 'bob.wright@example.com', 72, 'Peterborough', 'Staffordshire', 'United Kingdom', '1768419199'),
(10, 'lazybird447', 'ireland', 'Benjamin', 'Olsen', 'benjamin.olsen@example.com', 57, 'Aalborg', 'Syddanmark', 'Denmark', '37289080'),
(11, 'heavydog676', 'goldberg', 'Isaac', 'Coort', 'isaac.coort@example.com', 49, 'Eemdijk', 'Groningen', 'Netherlands', '2298015724'),
(12, 'goldenleopard838', 'telephone8', 'Jared', 'Stephens', 'jared.stephens@example.com', 76, 'Traralgon', 'Northern Territory', 'Australia', '618565260'),
(13, 'ticklishostrich664', 'modles', 'Charline', 'Leclerc', 'charline.leclerc@example.com', 19, 'Rouen', 'Normandy', 'France', '276350589'),
(14, 'bigfish970', 'fearless', 'Niklas', 'Remes', 'niklas.remes@example.com', 33, 'Ruokolahti', 'Northern Savonia', 'Finland', '8009050'),
(15, 'ticklishlion330', 'pelican', 'Xavier', 'Wong', 'xavier.wong@example.com', 65, 'Jasper', 'Nunavut', 'Canada', '9459097456'),
(16, 'heavydog654', '29ying', 'Minttu', 'Justi', 'minttu.justi@example.com', 43, 'Tampere', 'Pirkanmaa', 'Finland', '2834349'),
(17, 'yellowfish7', 'sigma', 'Rose', 'Duncan', 'rose.duncan@example.com', 50, 'Winchester', 'Dorset', 'United Kingdom', '1387399340'),
(18, 'happygorilla82', 'russell', 'Clarence', 'Henry', 'clarence.henry@example.com', 49, 'Tralee', 'Cork City', 'Ireland', '412734696'),
(19, 'biglion859', 'disney', 'Colleen', 'Simmmons', 'colleen.simmmons@example.com', 60, 'Eugene', 'New Mexico', 'United States', '8686197734'),
(20, 'goldenostrich2', 'potato', 'Charles', 'Silva', 'charles.silva@example.com', 40, 'Salisbury', 'Mid Glamorgan', 'United Kingdom', '179881228'),
(21, 'heavyladybug883', 'trace', 'Cassandra', 'Davis', 'cassandra.davis@example.com', 41, 'Baton Rouge', 'Florida', 'United States', '5205928477'),
(22, 'ticklishgoose999', 'dominic**', 'Josefine', 'Berg', 'josefine.berg@example.com', 48, 'Esbjerg', 'Jutland', 'Denmark', '94692973'),
(23, 'beautifulleopard17', 'review', 'Nicete', 'Costa', 'nicete.costa@example.com', 26, 'Feira de Santana', 'Minas Gerais', 'Brazil', '1364358168'),
(24, 'organicleopard51', 'never', 'Genesis', 'Armstrong', 'genesis.armstrong@example.com', 47, 'Albury', 'Victoria', 'Australia', '612674988'),
(25, 'thundercat21', 'punkling', 'Juliette', 'Campbell', 'juliette.campbell@example.com', 59, 'Tilbury', 'Essex', 'United Kingdom', '7941599883'),
(26, 'admin', 'banner21', 'Caroline', 'Edwards', 'admin@example.com', 42, 'Truth or Consequences', 'New Mexico', 'USA', '1746797795');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
