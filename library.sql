-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 10:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(99) NOT NULL,
  `isbn` varchar(99) NOT NULL,
  `author` varchar(99) NOT NULL,
  `publisher` varchar(99) NOT NULL,
  `quantity` int(99) NOT NULL,
  `date_published` date NOT NULL,
  `category` varchar(99) NOT NULL,
  `shelf_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `isbn`, `author`, `publisher`, `quantity`, `date_published`, `category`, `shelf_no`) VALUES
(2, 'php', '4141324234', 'jap', 'Paper works', 4, '2024-10-10', 'BSIT', 'Book Shelve 4'),
(3, 'mysql', '123', 'jasppppppp', 'a', 0, '2024-10-31', 'BSTM', 'Book Shelve 11'),
(4, 'Clean Code: A Handbook of Agile Software Craftsmanship', '978-0136083238', 'Robert C. Martin', 'Prentice Hall', 5, '2008-09-11', 'BSIT', 'Book Shelve 4'),
(5, 'The Pragmatic Programmer: Your Journey To Mastery', '978-0135957059', 'Andrew Hunt and David Thomas', 'Addison-Wesley', 3, '2019-12-20', 'BSP', 'Book Shelve 3');

-- --------------------------------------------------------

--
-- Table structure for table `borrowers`
--

CREATE TABLE `borrowers` (
  `id` int(11) NOT NULL,
  `student_id` int(50) NOT NULL,
  `student_name` varchar(99) NOT NULL,
  `book_title` varchar(99) NOT NULL,
  `borrowed_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowers`
--

INSERT INTO `borrowers` (`id`, `student_id`, `student_name`, `book_title`, `borrowed_date`, `due_date`, `status`) VALUES
(7, 21013040, 'Marialhiz Galagala', 'Clean Code: A Handbook of Agile Software Craftsmanship', '2024-10-31 12:56:47', '2024-11-02', ''),
(8, 21019759, 'Jasper Achuela', 'Clean Code', '2024-10-31 12:58:06', '2024-11-05', ''),
(13, 21019750, 'Jasper ', '2', '2024-11-01 05:51:20', '2024-11-06', ''),
(14, 21019750, 'Jasper ', '3', '2024-11-01 05:51:20', '2024-11-06', ''),
(16, 21013040, 'Marialhiz Galagala', 'php', '2024-11-01 08:49:43', '2024-11-06', ''),
(17, 21013040, 'Marialhiz Galagala', 'mysql', '2024-11-01 08:49:43', '2024-11-06', '');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_description` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_code`, `course_description`, `status`) VALUES
(1, 'BLIS', 'Bachelor in Library Information Science', 'Active'),
(2, 'BSCPE', 'Bachelor of Science in Computer Engineering', 'Active'),
(3, 'BSP', 'Bachelor of Science in Psychology', 'Active'),
(4, 'BSIT', 'Bachelor of Science in Information Technology', 'Active'),
(5, 'BSED', 'Bachelor of Science in Education', 'Active'),
(6, 'BSCRIM', 'Bachelor of Science in Criminology', 'Active'),
(7, 'BSAIS', 'Bachelor of Science in Accounting Information System', 'Active'),
(8, 'BSENTREP', 'Bachelor of Science in Entrepreneurship', 'Active'),
(9, 'BSBA', 'Bachelor of Science in Business Administration', 'Active'),
(10, 'BSOA', 'Bachelor of Science in Office Administration', 'Active'),
(11, 'BSTM', 'Bachelor of Science in Tourism Management', 'Active'),
(12, 'BSHM', 'Bachelor of Science in Hospitality Management', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`) VALUES
(1, 'John'),
(2, 'Riz'),
(3, 'Jasper Achuela');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `username` varchar(99) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` enum('student','librarian','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `student_id`, `name`, `role`) VALUES
(1, 's21013040', '$2y$10$NYBjtlHEP9epLMA8LNOILO3/zw8lJ6m7/bO4Drm.Ikw4Q9SGxds4G', 21013040, 'Marialhiz Galagala', 'student'),
(2, 'librarian 1', '$2y$10$TMBhlqLL2EHG0VCozUifaOAUHCv59WbSqIi52wzqbqenxRmBC3h.u', 0, 'Librarian 1', 'librarian'),
(3, 's21016925', '$2y$10$vf5CgEeTd31YNJ5YoLxwNOjr1P/k420AwI5iLJ63jWmGinR8.XEQi', 21016925, 'Joshua P. Nalaunan', 'student'),
(4, 's21019749', '$2y$10$RLyCAG.Pj/dy1OkGPyJKh.Hx183uKu9OOJ2tP9tDFs3NdyXcvqiuC', 21019749, 'Jaspher S. Achuela', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `search_items`
--

CREATE TABLE `search_items` (
  `id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_items`
--

INSERT INTO `search_items` (`id`, `item`) VALUES
(1, 'Clean Code'),
(2, 'Programming'),
(3, 'a'),
(4, 'Apple'),
(5, 'Banana'),
(6, 'Cherry'),
(7, 'Date'),
(8, 'Elderberry');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `std_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `processed_by` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `std_name`, `title`, `transaction_type`, `processed_by`, `timestamp`) VALUES
(1, 'Jasper S. Achuela', 'Php and MySQL', 'Borrow', 'Jaspher', '2024-10-31 10:08:15'),
(2, 'asas', 'Clean Code', 'Borrow', 'Jaspher', '2024-10-31 10:59:27'),
(3, '', '', 'Returned', '', '2024-10-31 10:59:37'),
(4, 'jjj', 'sadasd', 'Borrow', 'Jaspher', '2024-10-31 11:10:32'),
(5, 'sdasd', 'asdasd', 'Borrow', 'Jaspher', '2024-10-31 11:12:22'),
(6, 'sdasd', 'asdasd', 'Returned', 'Jaspher', '2024-10-31 11:12:26'),
(7, 'sdasd', 'asdasd', 'Returned', 'Jaspher', '2024-10-31 11:12:35'),
(8, 'sdasd', 'asdasd', 'Returned', 'Jaspher', '2024-10-31 11:13:04'),
(9, 'sdasd', 'asdasd', 'Returned', 'Jaspher', '2024-10-31 11:15:50'),
(10, 'sdasd', 'asdasd', 'Returned', 'Jaspher', '2024-10-31 11:16:45'),
(11, 'John Riz Herbosa', 'MySQL1', 'Borrow', 'Jaspher', '2024-10-31 11:17:39'),
(12, 'John Riz Herbosa', 'MySQL1', 'Returned', 'Jaspher', '2024-10-31 11:17:43'),
(13, 'Jasper Achuela', 'Php and MySQL 2', 'Borrow', 'Jaspher', '2024-10-31 11:19:06'),
(14, 'Jasper Achuela', 'Php and MySQL 2', 'Returned', 'Jaspher', '2024-10-31 11:19:09'),
(15, 'John Riz Herbosa', 'Php and MySQL', 'Borrow', 'Jaspher', '2024-10-31 12:56:47'),
(16, 'Jasper Achuela', 'Clean Code', 'Borrow', 'Jaspher', '2024-10-31 12:58:06'),
(17, 'briii', '2', 'Borrow', 'Jaspher', '2024-11-01 03:29:44'),
(18, 'briii', '1', 'Returned', 'Jaspher', '2024-11-01 03:31:02'),
(19, 'kulot', 'codinggssss', 'Borrow', 'Jaspher', '2024-11-01 03:46:19'),
(20, 'kulot', 'codinggssss', 'Returned', 'Jaspher', '2024-11-01 04:22:43'),
(21, 'briii', '2', 'Returned', 'Jaspher', '2024-11-01 04:23:50'),
(22, 'Jasper ', '3', 'Borrow', 'Jaspher', '2024-11-01 05:51:20'),
(23, 'Jasper ', '1', 'Returned', 'Jaspher', '2024-11-01 06:13:44'),
(24, 'aadad', 'aadaa', 'Borrow', 'Jaspher', '2024-11-01 06:17:02'),
(25, 'aadad', 'aadaa', 'Returned', 'Jaspher', '2024-11-01 06:21:09'),
(26, 'Marialhiz Galagala', 'mysql', 'Borrow', 'librarian 1', '2024-11-01 08:49:43'),
(27, 'Marialhiz Galagala', 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Returned', 's21013040', '2024-11-01 09:11:04'),
(28, 'Marialhiz Galagala', 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Returned', 's21013040', '2024-11-01 09:11:08'),
(29, 'Marialhiz Galagala', 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Returned', 's21013040', '2024-11-01 09:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'Alice'),
(2, 'Bob'),
(3, 'Charlie'),
(4, 'David');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowers`
--
ALTER TABLE `borrowers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `search_items`
--
ALTER TABLE `search_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `borrowers`
--
ALTER TABLE `borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `search_items`
--
ALTER TABLE `search_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
