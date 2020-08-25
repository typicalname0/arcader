SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `fan` (
  `id` int(11) NOT NULL,
  `following` varchar(255) NOT NULL,
  `follower` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `extrainfo` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(1) NOT NULL DEFAULT 'n',
  `agerating` varchar(1) NOT NULL DEFAULT 'E',
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `profilecomments` (
  `id` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `stocknames` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '10',
  `name` varchar(255) NOT NULL,
  `coname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `stockname` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `css` varchar(5000) NOT NULL DEFAULT '',
  `bio` varchar(500) NOT NULL DEFAULT '',
  `music` varchar(255) NOT NULL DEFAULT 'default.mp3',
  `pfp` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(255) NOT NULL DEFAULT '?',
  `age` varchar(255) NOT NULL DEFAULT '?',
  `gender` varchar(255) NOT NULL DEFAULT '?',
  `bobux` double NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `fan`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `profilecomments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stocknames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `fan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `profilecomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stocknames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
