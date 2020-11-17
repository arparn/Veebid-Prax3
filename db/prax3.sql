-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 17 2020 г., 21:33
-- Версия сервера: 10.4.14-MariaDB
-- Версия PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prax3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `username`, `content`, `created_at`, `updated_at`) VALUES
(8, 25, 5, 'Artur Pärn', 'aaaa', '2020-11-16 20:24:06', '2020-11-16 20:24:06'),
(9, 25, 5, 'Artur Pärn', 'sssxsxdscere', '2020-11-16 20:24:14', '2020-11-16 20:24:14'),
(10, 26, 5, 'Artur Pärn', 'wwwxxsw', '2020-11-16 20:24:59', '2020-11-16 20:24:59'),
(14, 27, 4, 'Artur Pärnoja', 'asxaxa', '2020-11-16 22:18:50', '2020-11-16 22:18:50'),
(16, 26, 4, 'Artur Pärnoja', 'heyyyy', '2020-11-17 11:05:54', '2020-11-17 11:05:54'),
(17, 24, 4, 'Artur Pärnoja', 'asasdas', '2020-11-17 12:46:16', '2020-11-17 12:46:16'),
(21, 25, 4, 'Artur Pärnoja', 'wswqsqw', '2020-11-17 21:24:12', '2020-11-17 21:24:12'),
(23, 28, 4, 'Artur Pärnoja', 'qzqxzwaxz', '2020-11-17 21:50:49', '2020-11-17 21:50:49');

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `first_user_id` int(11) NOT NULL,
  `second_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `first_user_id`, `second_user_id`, `created_at`, `updated_at`) VALUES
(9, 4, 5, '2020-11-17 21:00:06', '2020-11-17 21:00:06'),
(10, 4, 7, '2020-11-17 21:22:28', '2020-11-17 21:22:28');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `username`, `content`, `created_at`, `updated_at`) VALUES
(23, 4, 'Artur Pärnoja', 'qsqxsqxqsx', '2020-11-15 23:44:33', '2020-11-15 23:44:33'),
(25, 5, 'Artur Pärn', 'dscsddfvfdv', '2020-11-16 20:08:29', '2020-11-16 20:08:29'),
(26, 5, 'Artur Pärn', 'exwexwexd', '2020-11-16 20:24:52', '2020-11-16 20:24:52'),
(27, 7, 'Ilya', 'ds d cecec', '2020-11-16 21:37:47', '2020-11-16 21:37:47'),
(28, 4, 'Artur Pärnoja', 'sxwqsqwxq', '2020-11-17 20:30:05', '2020-11-17 20:30:05'),
(31, 4, 'Artur Pärnoja', 'xwsxwxw', '2020-11-17 22:28:21', '2020-11-17 22:28:21');

-- --------------------------------------------------------

--
-- Структура таблицы `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reactions`
--

INSERT INTO `reactions` (`id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(44, 24, 4, '2020-11-17 20:24:18', '2020-11-17 20:24:18'),
(48, 27, 4, '2020-11-17 21:22:33', '2020-11-17 21:22:33'),
(49, 25, 4, '2020-11-17 21:22:37', '2020-11-17 21:22:37'),
(52, 28, 4, '2020-11-17 21:50:44', '2020-11-17 21:50:44');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `description` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `description`, `city`, `created_at`, `updated_at`) VALUES
(4, 'Artur Pärnoja', 'arthurp200149@gmail.com', '$2y$10$OOkfckI7X0jmqa6U8wsgPeEcFgy6ZFTfpeief7N79aT8dtPIr958m', 'narva boi', 'Tallinn', '2020-11-14 14:26:26', '2020-11-17 21:50:23'),
(5, 'Artur Pärn', 'arparn@ttu.ee', '$2y$10$k8tS7Pb1dEZ5uA9LFgWCEOHWrbmiE6XnudC/PR88V7y53C9I69ALK', 'Tallinn boi :)', 'Narva', '2020-11-14 14:35:31', '2020-11-16 16:18:07'),
(6, 'no_name', 'rutrum@sapien.net', '$2y$10$B0TjbaFea3JGzzzxvGkYA.8iYkpiRXKvybnxKDSMlKMlmQvu7GVpy', NULL, NULL, '2020-11-14 21:08:28', '2020-11-14 21:08:28'),
(7, 'Ilya', 'Ilya@gmail.com', '$2y$10$/I8TqgstMyZAinDo7gzm3eZDxP7On0ayqJkUk4UC8ZIImda9TGSbS', 'sdfgh', 'Johvi', '2020-11-16 15:28:58', '2020-11-16 16:18:46'),
(8, 'frog', 'mail@mail.com', '$2y$10$rHqoSxBJIOr7XHIe1YYvUe0YBPDYi/.vOvX7xCIajymkLqo0/HGq.', NULL, NULL, '2020-11-17 21:46:19', '2020-11-17 21:46:19'),
(9, 'Artur ', 'volutpat.nunc.sit@Integereu.ca', '$2y$10$nzDSoVFDi2J/Jzhv5JeaJOjMeUfL0gSV3pPqUHBVNDSt5bDjLO0CS', NULL, NULL, '2020-11-17 22:01:20', '2020-11-17 22:01:20');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
