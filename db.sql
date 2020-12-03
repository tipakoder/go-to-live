-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 04 2020 г., 02:20
-- Версия сервера: 10.3.22-MariaDB-log
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `live`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accs`
--

CREATE TABLE `accs` (
  `id` int(11) NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `accs`
--

INSERT INTO `accs` (`id`, `firstname`, `lastname`, `middlename`, `email`, `password`, `who`) VALUES
(1, 'фыв', 'фыв', 'фыв', 'sarychev.nikita.nn808@gmail.com', '$2y$10$J6S3Z3UocDUuHKFBp1A3AO4uM1IR8pH7orDUM2zHAoJnr.bEszHHm', 'user'),
(2, 'admin', 'admin', 'admin', 'admin', '$2y$10$ngUXW8yiRCgA4BwhiColVO5ZL2E7GXtvkL.tMW5wmnpgbMhqIvJxW', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `accs_sess`
--

CREATE TABLE `accs_sess` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `key_sess` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `accs_sess`
--

INSERT INTO `accs_sess` (`id`, `aid`, `key_sess`, `ip`) VALUES
(1, 1, 'b0ca664288617f830ecb76b791859a7f60e5baa9', '127.0.0.1'),
(2, 2, '291ef67cba3bf43ad64c5f712d98fbff9161fb32', '127.0.0.1'),
(3, 2, '3dfd78820316becebba6980c6775b79ac77f350f', '127.0.0.1'),
(4, 2, 'e8e0fa6abcec0eda5bc410b5f6ddecee38e5d3d9', '127.0.0.1'),
(5, 1, 'da135fffd9be0f8f503b22baf0a1fc0da5801940', '127.0.0.1'),
(6, 1, '2b020b34ed3c5d0eb5c9285821e4a741b81a384a', '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `fullname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `doctor`
--

INSERT INTO `doctor` (`id`, `tid`, `fullname`) VALUES
(1, 2, 'Попов Николай Дмитриевич'),
(2, 1, 'Лапин Владислав Евгеньевич'),
(3, 2, 'Фраор Дарья Андреевна'),
(4, 4, 'Скалкин Андрей Вячеславович');

-- --------------------------------------------------------

--
-- Структура таблицы `doctor_types`
--

CREATE TABLE `doctor_types` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `doctor_types`
--

INSERT INTO `doctor_types` (`id`, `name`, `description`) VALUES
(1, 'Дантист', 'Специалисты, окончившие среднее медицинское учреждение, проучившись в нем 3 года, получают квалификацию «зубной врач» и имеют право лечить зубы и ротовую полость по следующим проявлениям — кариес, пародонтоз, стоматит. Также зубных врачей иногда на западный манер называют дантистами.'),
(2, 'Психиатр', 'Врач-психиатр может консультировать и лечить психически здоровых и психически больных людей, выписывать лекарства, проводить освидетельствование людей и определять степень их психического здоровья и дееспособности.'),
(3, 'Терапевт', 'Многопрофильный врач-терапевт занимается диагностикой и лечением целого ряда заболеваний человека. Он принимает пациентов, достигших возраста 18-ти лет. Все, что делает врач-терапевт, относится к заболеваниям и патологиям внутренних органов человека.'),
(4, 'Эндокринолог', 'Эндокринолог – узкопрофильный специалист, в сферу компетенций которого входит диагностика и лечение болезней эндокринной системы и ее органов, которые вырабатывают гормоны.');

-- --------------------------------------------------------

--
-- Структура таблицы `writes`
--

CREATE TABLE `writes` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `date` date NOT NULL,
  `option_time` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL,
  `did` int(11) NOT NULL,
  `remove` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `writes`
--

INSERT INTO `writes` (`id`, `aid`, `date`, `option_time`, `did`, `remove`) VALUES
(1, 1, '2020-12-04', '1', 1, 0),
(2, 1, '2020-12-04', '2', 1, 0),
(3, 1, '2020-12-04', '5', 1, 0),
(4, 1, '2020-12-04', '3', 3, 0),
(5, 1, '2020-12-04', '5', 3, 0),
(6, 1, '2020-12-04', '3', 2, 0),
(7, 1, '2020-12-05', '2', 4, 1),
(8, 1, '2020-12-03', '1', 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accs`
--
ALTER TABLE `accs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `accs_sess`
--
ALTER TABLE `accs_sess`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `doctor_types`
--
ALTER TABLE `doctor_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `writes`
--
ALTER TABLE `writes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accs`
--
ALTER TABLE `accs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `accs_sess`
--
ALTER TABLE `accs_sess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `doctor_types`
--
ALTER TABLE `doctor_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `writes`
--
ALTER TABLE `writes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
