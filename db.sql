-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 04 2020 г., 09:48
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
(1, 'admin', 'admin', 'admin', 'admin', '$2y$10$ngUXW8yiRCgA4BwhiColVO5ZL2E7GXtvkL.tMW5wmnpgbMhqIvJxW', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `accs_sess`
--

CREATE TABLE `accs_sess` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `key_sess` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `fullname` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `accs_sess`
--
ALTER TABLE `accs_sess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `doctor_types`
--
ALTER TABLE `doctor_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `writes`
--
ALTER TABLE `writes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
