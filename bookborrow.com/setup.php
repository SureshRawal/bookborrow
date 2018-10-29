<?php
$connection = mysqli_connect("127.0.0.1","root","");
$createDatabase = "create database 00167690_sureshrawal";
mysqli_query($connection,$createDatabase);
$actualConnection = mysqli_connect("127.0.0.1","root","","00167690_sureshrawal");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `book` (
`book_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `ISBN` varchar(15) NOT NULL,
  `publication_date` date NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `book_description` varchar(10000) NOT NULL,
  `book_image` varchar(255) NOT NULL,
  `book_genre` varchar(50) NOT NULL,
  `max_borrow` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `created_date` date NOT NULL,
  `learner_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"INSERT INTO `book` (`book_id`, `book_name`, `author`, `ISBN`, `publication_date`, `publisher`, `book_description`, `book_image`, `book_genre`, `max_borrow`, `rating`, `created_date`, `learner_id`) VALUES
(9, 'Pride and PreJudice', 'Austen, Jane', '978-0-571-33701', '2018-01-08', 'Faber & Faber', 'Part of our new collection of Young Adult Classics, Pride and Prejudice is one of the most popular books of all time. Its irresistible romance combined with its humorous depiction of country life make it wholly enjoyable.', 'index.jpg', 'Science Fiction', 5, 12, '2018-10-10', 2),
(10, 'A Christmas Carol', 'Dickens, Charles', '978-1-72622-975', '2018-01-08', 'CreateSpace Independent Publishing Platform', 'A Christmas CarolBy Charles DickensI have endeavoured in this Ghostly little book, to raise the Ghost of an Idea, which shall not put my readers out of humour with themselves, with each other, with the season, or with me. May it haunt their houses pleasantly, and no one wish to lay it', '2.jpg', 'Science Fiction', 6, 0, '2018-10-10', 1),
(15, 'The Sideman', 'Ramsay, Caro', '978-0-7278-8808', '2018-01-01', 'Severn House Publishers, Limited', 'Part of our new collection of Young Adult Classics, Pride and Prejudice is one of the most popular books of all time. Its irresistible romance combined with its humorous depiction of country life make it wholly enjoyable.', 'index2.jpg', 'Adventure', 10, 0, '2018-10-11', 1)");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `borrow` (
`borrow_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_days` int(11) NOT NULL,
  `borrow_start_date` date NOT NULL,
  `borrow_end_date` date DEFAULT NULL,
  `borrower_points` varchar(5) DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"INSERT INTO `borrow` (`borrow_id`, `borrower_id`, `book_id`, `borrow_days`, `borrow_start_date`, `borrow_end_date`, `borrower_points`, `updated_at`, `status`) VALUES
(2, 2, 10, 5, '2018-10-29', '2018-11-03', NULL, NULL, 1)");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `claim` (
`claim_id` int(11) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `giveaway_id` int(11) NOT NULL,
  `claim_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `discussion` (
`discussion_id` int(11) NOT NULL,
  `discussion` varchar(255) NOT NULL,
  `learner_id` int(11) NOT NULL,
  `visited` int(11) NOT NULL,
  `replied` int(11) NOT NULL,
  `post_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `discussion_reply` (
`reply_id` int(11) NOT NULL,
  `replier_id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `reply` varchar(255) NOT NULL,
  `reply_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `giveaway` (
`giveaway_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `ISBN` varchar(15) NOT NULL,
  `publication_date` date NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `book_description` varchar(10000) NOT NULL,
  `book_image` varchar(255) NOT NULL,
  `book_genre` varchar(50) NOT NULL,
  `created_date` date NOT NULL,
  `carousel_index` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"INSERT INTO `giveaway` (`giveaway_id`, `book_name`, `author`, `ISBN`, `publication_date`, `publisher`, `book_description`, `book_image`, `book_genre`, `created_date`, `carousel_index`, `points`) VALUES
(3, 'Vanity Fair', 'Thackeray, William Makepeace', '978-1-72227-870', '2018-01-01', 'Little', 'The classic novel of villainy, crime, merriment, lovemaking, jilting, laughing, cheating, fighting and dancing, soon to be a major new ITV series from the producers of Poldark, Victoria and And Then There Were None.', 'vanityfair.jpg', 'Vanity Fair', '2018-10-29', 1, 200),
(4, 'Dopesick', 'Macy, Beth', '978-0-316-52317', '2018-01-01', 'Little Brown & Company', 'An instant New York Times and indie bestseller, Dopesick is the only book to fully chart the devastating opioid crisis in America: a harrowing, deeply compassionate dispatch from the heart of a national emergency (New York Times) from a bestselling author and journalist who has lived through it.\r\n', 'dopestick.jpg', 'Dopesick', '2018-10-29', 2, 200),
(5, 'House Rules', 'Picoult, Jodi', '978-1-72227-870', '2017-12-31', 'Pocket Books', 'The classic novel of villainy, crime, merriment, lovemaking, jilting, laughing, cheating, fighting and dancing, soon to be a major new ITV series from the producers of Poldark, Victoria and And Then There Were None.', 'houserules.jpg', 'Action Drama', '2018-10-29', 2, 400)");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `learner` (
`learnerId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  `visit_count` int(11) NOT NULL DEFAULT '0',
  `good_points` int(11) NOT NULL DEFAULT '0',
  `bad_points` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"INSERT INTO `learner` (`learnerId`, `name`, `email`, `password`, `login_count`, `visit_count`, `good_points`, `bad_points`) VALUES
(1, 'Suresh Rawal', 'sureshrawal21@gmail.com', 'suresh1', 0, 4, 0, 0),
(2, 'Ashish Shrestha', 'ashishshrestha@gmail.com', 'ashish1', 0, 5, 0, 0)");

mysqli_query($actualConnection,"CREATE TABLE IF NOT EXISTS `learner_details` (
`learnerdetail_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `education_level` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `details_oneself` varchar(10000) NOT NULL,
  `favorite_quotation` varchar(10000) NOT NULL,
  `learner_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1");

mysqli_query($actualConnection,"INSERT INTO `learner_details` (`learnerdetail_id`, `address`, `date_of_birth`, `gender`, `mobile_number`, `education_level`, `college`, `details_oneself`, `favorite_quotation`, `learner_id`) VALUES
(14, 'Gaighat', '2018-01-02', 'Male', '9808180204', '+2', 'Sagarmatha College', 'I love to learn books.', 'What She Ate', 2)");

mysqli_query($actualConnection,"ALTER TABLE `book`
 ADD PRIMARY KEY (`book_id`)");

mysqli_query($actualConnection,"ALTER TABLE `borrow`
 ADD PRIMARY KEY (`borrow_id`)");

mysqli_query($actualConnection,"ALTER TABLE `claim`
 ADD PRIMARY KEY (`claim_id`)");

mysqli_query($actualConnection,"ALTER TABLE `discussion`
 ADD PRIMARY KEY (`discussion_id`)");

mysqli_query($actualConnection,"ALTER TABLE `discussion_reply`
 ADD PRIMARY KEY (`reply_id`)");

mysqli_query($actualConnection,"ALTER TABLE `giveaway`
 ADD PRIMARY KEY (`giveaway_id`)");

mysqli_query($actualConnection,"ALTER TABLE `learner`
 ADD PRIMARY KEY (`learnerId`)");

mysqli_query($actualConnection,"ALTER TABLE `learner_details`
 ADD PRIMARY KEY (`learnerdetail_id`)");

mysqli_query($actualConnection,"ALTER TABLE `book`
MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18");

mysqli_query($actualConnection,"ALTER TABLE `borrow`
MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3");

mysqli_query($actualConnection,"ALTER TABLE `claim`
MODIFY `claim_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2");

mysqli_query($actualConnection,"ALTER TABLE `discussion`
MODIFY `discussion_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9");

mysqli_query($actualConnection,"ALTER TABLE `discussion_reply`
MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8");

mysqli_query($actualConnection,"ALTER TABLE `giveaway`
MODIFY `giveaway_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6");

mysqli_query($actualConnection,"ALTER TABLE `learner`
MODIFY `learnerId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8");

mysqli_query($actualConnection,"ALTER TABLE `learner_details`
MODIFY `learnerdetail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15");

mysqli_query($actualConnection,"Commit");

header("location:index.php");