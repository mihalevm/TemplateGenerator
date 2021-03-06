-- --------------------------------------------------------
-- Хост:                         91.227.140.69
-- Версия сервера:               5.0.84 - Source distribution
-- Операционная система:         redhat-linux-gnu
-- HeidiSQL Версия:              9.5.0.5447
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных templategen
DROP DATABASE IF EXISTS `templategen`;
CREATE DATABASE IF NOT EXISTS `templategen` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `templategen`;

-- Дамп структуры для таблица templategen.tg_attributes
DROP TABLE IF EXISTS `tg_attributes`;
CREATE TABLE IF NOT EXISTS `tg_attributes` (
  `aid` int(10) unsigned NOT NULL auto_increment COMMENT 'Идентификатор',
  `aname` varchar(50) NOT NULL COMMENT 'Ключ атрибута',
  `atype` int(11) NOT NULL COMMENT 'Тип атрибута',
  `adesc` varchar(100) default NULL COMMENT 'Описание атрибута',
  `title` varchar(100) default NULL COMMENT 'Название атрибута',
  `test` varchar(100) default NULL COMMENT 'Тестовое значение',
  PRIMARY KEY  (`aid`),
  UNIQUE KEY `unq_Aname` (`aname`),
  KEY `FK_atype` (`atype`),
  CONSTRAINT `FK_atype` FOREIGN KEY (`atype`) REFERENCES `tg_attributes_type` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Список уникальных атрибутов';

-- Дамп данных таблицы templategen.tg_attributes: ~20 rows (приблизительно)
/*!40000 ALTER TABLE `tg_attributes` DISABLE KEYS */;
INSERT INTO `tg_attributes` (`aid`, `aname`, `atype`, `adesc`, `title`, `test`) VALUES
	(2, 'DEF_INN', 1, 'ИНН Ответчика', 'Инн ответчика', '222333111'),
	(3, 'CLM_INN', 1, 'ИНН Истца', 'ИНН Истца', '222333779'),
	(4, 'DEF_ORG_NAME', 1, 'Название компании ответчика', 'Название организации', 'ООО Батон'),
	(5, 'CLM_ORG_NAME', 1, 'Название компании', 'Название компании', 'ООО Колбаса'),
	(6, 'APP_CHECK_LICENSE', 6, 'С условиями согласен', 'С условиями согласен', '1'),
	(7, 'APP_TEXT_AREA', 5, 'Условия соглашения', 'Условия соглашения', 'Колбаса и батон дружба на век.'),
	(8, 'APP_DATA_DOC', 2, 'Дата заключения договора', 'Дата заключения договора', '23.01.2019'),
	(9, 'DEF_TYPE', 3, 'Тип контрагента', 'Тип контрагента', 'Юридическое лицо;Физическое лицо;'),
	(10, 'APP_PAY_TYPE', 3, 'Тип оплаты', 'Тип оплаты', 'Наличный;Безналичный;'),
	(11, 'DEF_ADDR', 1, 'Адрес компании', 'Адрес', 'г. Новосибирск, ул. Попова, 34'),
	(12, 'DEF_CDATE', 2, 'Дата регистрации', 'Дата регистрации', '23.01.2007'),
	(13, 'DEF_KPP', 1, 'КПП', 'КПП', '232323232'),
	(14, 'DEF_OGRN', 1, 'ОГРН', 'ОГРН', '233423423'),
	(15, 'DEF_STATUS', 1, 'Статус,руководитель', 'Статус,руководитель', 'Управляющий Иванов Иван'),
	(16, 'CLN_ADDR', 1, 'Адрес компании', 'Адрес компании', '	г. Москва, ул. Восточная, 100'),
	(17, 'CLM_CDATE', 2, '	Дата регистрации', '	Дата регистрации', '10.02.2015'),
	(18, 'CLM_KPP', 1, 'КПП', 'КПП', '77686787686'),
	(19, 'CLM_OGRN', 1, 'ОГРН', 'ОГРН', '5467658568'),
	(20, 'CLM_TYPE', 3, 'Тип контрагента', 'Тип контрагента', 'Юридическое лицо;Физическое лицо;'),
	(21, 'CLM_STATUS', 1, 'Должность, руководитель', 'Должность, руководитель', 'Индивидуальный предприниматель Петр Петров');
/*!40000 ALTER TABLE `tg_attributes` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_attributes_type
DROP TABLE IF EXISTS `tg_attributes_type`;
CREATE TABLE IF NOT EXISTS `tg_attributes_type` (
  `tid` int(11) NOT NULL auto_increment COMMENT 'Идентификатор',
  `tname` varchar(50) NOT NULL COMMENT 'Название типа',
  `ttype` varchar(50) NOT NULL COMMENT 'Тип переменной',
  PRIMARY KEY  (`tid`),
  UNIQUE KEY `unq_tname` (`tname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы атрибутов';

-- Дамп данных таблицы templategen.tg_attributes_type: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `tg_attributes_type` DISABLE KEYS */;
INSERT INTO `tg_attributes_type` (`tid`, `tname`, `ttype`) VALUES
	(1, 'Текстовая строка', 'TINPUT'),
	(2, 'Календарь', 'TCALENDAR'),
	(3, 'Выпадающий список', 'TDROPDOWN'),
	(4, 'Выбор элемента', 'TSELECT'),
	(5, 'Текстовое поле', 'TAREA'),
	(6, 'Галочка', 'TCHECK');
/*!40000 ALTER TABLE `tg_attributes_type` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_documents
DROP TABLE IF EXISTS `tg_documents`;
CREATE TABLE IF NOT EXISTS `tg_documents` (
  `did` int(11) NOT NULL auto_increment COMMENT 'Идентификатор',
  `dkey` varchar(50) default '0' COMMENT 'Уникальный идентификатор документа',
  `tid` int(11) default '0' COMMENT 'Идентификатор шаблона',
  `aid` int(11) default '0' COMMENT 'Идентификатор атрибута',
  `val` varchar(255) default NULL COMMENT 'Значение атрибута',
  `cdate` timestamp NULL default CURRENT_TIMESTAMP COMMENT 'Дата создания документа',
  `uid` int(11) default NULL COMMENT 'Идентификатор пользователя',
  PRIMARY KEY  (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица сгенерированных документов';

-- Дамп данных таблицы templategen.tg_documents: ~195 rows (приблизительно)
/*!40000 ALTER TABLE `tg_documents` DISABLE KEYS */;
INSERT INTO `tg_documents` (`did`, `dkey`, `tid`, `aid`, `val`, `cdate`, `uid`) VALUES
	(1, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 2, '1', '2018-12-26 14:45:09', NULL),
	(2, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 5, '2', '2018-12-26 14:45:19', NULL),
	(3, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 2, '3', '2018-12-26 14:45:23', NULL),
	(4, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 2, '22222222', '2018-12-26 15:13:21', NULL),
	(5, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 5, 'Сидор Сидоров', '2018-12-26 15:13:21', NULL),
	(6, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 2, '23423423423423', '2018-12-26 15:13:21', NULL),
	(7, '8C106BAE3118B312F93FE4758E7F56D9', 1, 2, '22222222', '2018-12-26 15:13:59', NULL),
	(8, '8C106BAE3118B312F93FE4758E7F56D9', 1, 5, 'Сидор Сидоров', '2018-12-26 15:13:59', NULL),
	(9, '8C106BAE3118B312F93FE4758E7F56D9', 1, 2, '454545435345345', '2018-12-26 15:13:59', NULL),
	(10, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 4, 'Иванов Иван', '2018-12-26 15:27:16', NULL),
	(11, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 2, '22222222', '2018-12-26 15:27:16', NULL),
	(12, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 5, 'Сидор Сидоров', '2018-12-26 15:27:16', NULL),
	(13, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 3, '55555555', '2018-12-26 15:27:16', NULL),
	(23, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 4, '', '2018-12-27 11:21:35', NULL),
	(24, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 2, '', '2018-12-27 11:21:35', NULL),
	(25, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 5, '', '2018-12-27 11:21:35', NULL),
	(26, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 3, '', '2018-12-27 11:21:35', NULL),
	(27, 'FF97C85D79486A44E3B60D28378B386F', 7, 4, 'sfgsdgsdg', '2019-01-10 14:11:12', NULL),
	(28, 'FF97C85D79486A44E3B60D28378B386F', 7, 2, 'sdgsdgsdg', '2019-01-10 14:11:12', NULL),
	(29, 'FF97C85D79486A44E3B60D28378B386F', 7, 5, 'sdfgsdfgsdf', '2019-01-10 14:11:12', NULL),
	(30, 'FF97C85D79486A44E3B60D28378B386F', 7, 3, 'sdfgsdfgsdf', '2019-01-10 14:11:12', NULL),
	(31, 'FF97C85D79486A44E3B60D28378B386F', 7, 6, 'on', '2019-01-10 14:11:12', NULL),
	(32, '3790BA295070D4A15B03639E9E989754', 7, 4, 'gagsafgasg', '2019-01-10 14:25:05', NULL),
	(33, '3790BA295070D4A15B03639E9E989754', 7, 2, 'fsgsdfgsdfg', '2019-01-10 14:25:05', NULL),
	(34, '3790BA295070D4A15B03639E9E989754', 7, 5, 'regergerg', '2019-01-10 14:25:05', NULL),
	(35, '3790BA295070D4A15B03639E9E989754', 7, 3, 'regergerg', '2019-01-10 14:25:05', NULL),
	(36, '3790BA295070D4A15B03639E9E989754', 7, 6, 'on', '2019-01-10 14:25:05', NULL),
	(37, 'AE5117F744753C49C3270756790FE78D', 7, 4, 'jghjghjhj', '2019-01-10 14:52:39', NULL),
	(38, 'AE5117F744753C49C3270756790FE78D', 7, 2, 'fgjfjfghj', '2019-01-10 14:52:39', NULL),
	(39, 'AE5117F744753C49C3270756790FE78D', 7, 5, 'ghjhgjfg', '2019-01-10 14:52:39', NULL),
	(40, 'AE5117F744753C49C3270756790FE78D', 7, 3, 'fghjfgjg', '2019-01-10 14:52:39', NULL),
	(41, 'AE5117F744753C49C3270756790FE78D', 7, 6, 'on', '2019-01-10 14:52:39', NULL),
	(42, '6ABD6732065A5BC5ACEA599132D6021D', 7, 7, 'sgsdgsdgsd', '2019-01-10 14:56:48', NULL),
	(43, '6ABD6732065A5BC5ACEA599132D6021D', 7, 2, 'sdgsdgsdg', '2019-01-10 14:56:49', NULL),
	(44, '6ABD6732065A5BC5ACEA599132D6021D', 7, 5, 'sdgsdgsdg', '2019-01-10 14:56:49', NULL),
	(45, '6ABD6732065A5BC5ACEA599132D6021D', 7, 3, 'sdgsdgsdg', '2019-01-10 14:56:49', NULL),
	(46, '6ABD6732065A5BC5ACEA599132D6021D', 7, 6, 'on', '2019-01-10 14:56:49', NULL),
	(47, 'D64ECE061B8FADB6D035CE36BB09B386', 7, 7, 'sgsdgsdgsd', '2019-01-10 14:57:24', NULL),
	(48, 'D64ECE061B8FADB6D035CE36BB09B386', 7, 2, 'sdgsdgsdg', '2019-01-10 14:57:24', NULL),
	(49, 'D64ECE061B8FADB6D035CE36BB09B386', 7, 5, 'sdgsdgsdg', '2019-01-10 14:57:24', NULL),
	(50, 'D64ECE061B8FADB6D035CE36BB09B386', 7, 3, 'sdgsdgsdg', '2019-01-10 14:57:24', NULL),
	(51, 'D64ECE061B8FADB6D035CE36BB09B386', 7, 6, 'on', '2019-01-10 14:57:24', NULL),
	(52, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 7, 'цукпцукпуцкп', '2019-01-10 16:20:12', NULL),
	(53, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 2, 'укпукпуцкп', '2019-01-10 16:20:12', NULL),
	(54, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 5, 'укпукцпцукпцук', '2019-01-10 16:20:12', NULL),
	(55, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 3, 'укпцукпцукп', '2019-01-10 16:20:12', NULL),
	(56, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 6, 'on', '2019-01-10 16:20:12', NULL),
	(57, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 9, 'Юридическое лицо', '2019-01-10 16:20:12', NULL),
	(58, 'DE3F6A11591CCEDC07BB579BF91AAEDF', 7, 9, 'Физическое лицо', '2019-01-10 16:20:12', NULL),
	(59, '943B710BBD0712BF537D4F4B607F0831', 7, 7, 'цукпцукпуцкп', '2019-01-10 16:21:31', NULL),
	(60, '943B710BBD0712BF537D4F4B607F0831', 7, 2, 'укпукпуцкп', '2019-01-10 16:21:31', NULL),
	(61, '943B710BBD0712BF537D4F4B607F0831', 7, 5, 'укпукцпцукпцук', '2019-01-10 16:21:31', NULL),
	(62, '943B710BBD0712BF537D4F4B607F0831', 7, 3, 'укпцукпцукп', '2019-01-10 16:21:31', NULL),
	(63, '943B710BBD0712BF537D4F4B607F0831', 7, 6, 'on', '2019-01-10 16:21:31', NULL),
	(64, '943B710BBD0712BF537D4F4B607F0831', 7, 9, 'Юридическое лицо', '2019-01-10 16:21:32', NULL),
	(65, '943B710BBD0712BF537D4F4B607F0831', 7, 9, 'Физическое лицо', '2019-01-10 16:21:32', NULL),
	(66, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 7, '55', '2019-01-11 09:14:51', NULL),
	(67, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 2, '22', '2019-01-11 09:14:51', NULL),
	(68, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 5, '33', '2019-01-11 09:14:51', NULL),
	(69, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 3, '44', '2019-01-11 09:14:51', NULL),
	(70, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 6, 'on', '2019-01-11 09:14:51', NULL),
	(71, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 9, 'Юридическое лицо', '2019-01-11 09:14:51', NULL),
	(72, '1FA82E4543CD23DE0E0408122E6DDDF1', 7, 9, 'Физическое лицо', '2019-01-11 09:14:51', NULL),
	(73, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 7, '55', '2019-01-11 09:31:13', NULL),
	(74, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 2, '22', '2019-01-11 09:31:13', NULL),
	(75, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 5, '33', '2019-01-11 09:31:13', NULL),
	(76, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 3, '44', '2019-01-11 09:31:13', NULL),
	(77, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 6, 'on', '2019-01-11 09:31:13', NULL),
	(78, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 9, 'Юридическое лицо', '2019-01-11 09:31:13', NULL),
	(79, '6E70CD0EFE9F3CC1892583FE2FA63D9A', 7, 9, 'Физическое лицо', '2019-01-11 09:31:13', NULL),
	(80, '10A9A4054CC26938D412E040747AF872', 7, 7, '55', '2019-01-11 09:41:10', NULL),
	(81, '10A9A4054CC26938D412E040747AF872', 7, 2, '22', '2019-01-11 09:41:10', NULL),
	(82, '10A9A4054CC26938D412E040747AF872', 7, 5, '33', '2019-01-11 09:41:10', NULL),
	(83, '10A9A4054CC26938D412E040747AF872', 7, 3, '44', '2019-01-11 09:41:10', NULL),
	(84, '10A9A4054CC26938D412E040747AF872', 7, 6, 'on', '2019-01-11 09:41:10', NULL),
	(85, '10A9A4054CC26938D412E040747AF872', 7, 9, 'Юридическое лицо', '2019-01-11 09:41:10', NULL),
	(86, '10A9A4054CC26938D412E040747AF872', 7, 9, 'Физическое лицо', '2019-01-11 09:41:10', NULL),
	(87, '7658161C381A96BD5DBFB266351E030C', 7, 7, '55', '2019-01-11 09:42:23', NULL),
	(88, '7658161C381A96BD5DBFB266351E030C', 7, 2, '22', '2019-01-11 09:42:23', NULL),
	(89, '7658161C381A96BD5DBFB266351E030C', 7, 5, '33', '2019-01-11 09:42:23', NULL),
	(90, '7658161C381A96BD5DBFB266351E030C', 7, 3, '44', '2019-01-11 09:42:23', NULL),
	(91, '7658161C381A96BD5DBFB266351E030C', 7, 6, 'on', '2019-01-11 09:42:23', NULL),
	(92, '7658161C381A96BD5DBFB266351E030C', 7, 9, 'Юридическое лицо', '2019-01-11 09:42:23', NULL),
	(93, '7658161C381A96BD5DBFB266351E030C', 7, 9, 'Физическое лицо', '2019-01-11 09:42:23', NULL),
	(94, '022D436031889D67929ED05D84BA6C43', 7, 7, '55', '2019-01-11 09:44:13', NULL),
	(95, '022D436031889D67929ED05D84BA6C43', 7, 2, '22', '2019-01-11 09:44:13', NULL),
	(96, '022D436031889D67929ED05D84BA6C43', 7, 5, '33', '2019-01-11 09:44:13', NULL),
	(97, '022D436031889D67929ED05D84BA6C43', 7, 3, '44', '2019-01-11 09:44:13', NULL),
	(98, '022D436031889D67929ED05D84BA6C43', 7, 6, '1', '2019-01-11 09:44:13', NULL),
	(99, '022D436031889D67929ED05D84BA6C43', 7, 9, 'Юридическое лицо', '2019-01-11 09:44:13', NULL),
	(100, '022D436031889D67929ED05D84BA6C43', 7, 9, 'Физическое лицо', '2019-01-11 09:44:13', NULL),
	(101, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 7, '55', '2019-01-11 09:48:05', NULL),
	(102, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 2, '22', '2019-01-11 09:48:05', NULL),
	(103, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 5, '33', '2019-01-11 09:48:05', NULL),
	(104, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 3, '44', '2019-01-11 09:48:05', NULL),
	(105, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 6, '1', '2019-01-11 09:48:05', NULL),
	(106, 'ACBFE67F35BBF7A072FA753E007845D1', 7, 9, 'Юридическое лицо', '2019-01-11 09:48:05', NULL),
	(107, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 7, '55', '2019-01-11 09:49:50', NULL),
	(108, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 2, '22', '2019-01-11 09:49:50', NULL),
	(109, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 5, '33', '2019-01-11 09:49:50', NULL),
	(110, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 3, '44', '2019-01-11 09:49:50', NULL),
	(111, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 6, '1', '2019-01-11 09:49:50', NULL),
	(112, '59769FCD62C84CC1B47C5A7C3593CF58', 7, NULL, NULL, '2019-01-11 09:49:50', NULL),
	(113, '59769FCD62C84CC1B47C5A7C3593CF58', 7, 9, 'Физическое лицо', '2019-01-11 09:49:50', NULL),
	(114, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 7, '55', '2019-01-11 09:57:54', NULL),
	(115, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 2, '22', '2019-01-11 09:57:54', NULL),
	(116, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 5, '33', '2019-01-11 09:57:54', NULL),
	(117, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 3, '44', '2019-01-11 09:57:54', NULL),
	(118, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 6, '1', '2019-01-11 09:57:54', NULL),
	(119, 'F79FEF9EB184913223C337D2C16DB1CE', 7, NULL, NULL, '2019-01-11 09:57:54', NULL),
	(120, 'F79FEF9EB184913223C337D2C16DB1CE', 7, 9, 'Физическое лицо', '2019-01-11 09:57:54', NULL),
	(121, '58E13758FAFD528122C387B29F6E5E0C', 7, 7, '55', '2019-01-11 10:00:25', NULL),
	(122, '58E13758FAFD528122C387B29F6E5E0C', 7, 2, '22', '2019-01-11 10:00:25', NULL),
	(123, '58E13758FAFD528122C387B29F6E5E0C', 7, 5, '33', '2019-01-11 10:00:25', NULL),
	(124, '58E13758FAFD528122C387B29F6E5E0C', 7, 3, '44', '2019-01-11 10:00:25', NULL),
	(125, '58E13758FAFD528122C387B29F6E5E0C', 7, 6, '1', '2019-01-11 10:00:25', NULL),
	(126, '58E13758FAFD528122C387B29F6E5E0C', 7, NULL, NULL, '2019-01-11 10:00:25', NULL),
	(127, '58E13758FAFD528122C387B29F6E5E0C', 7, 9, 'Физическое лицо', '2019-01-11 10:00:25', NULL),
	(128, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 7, '55', '2019-01-11 10:03:25', NULL),
	(129, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 2, '22', '2019-01-11 10:03:25', NULL),
	(130, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 5, '33', '2019-01-11 10:03:25', NULL),
	(131, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 3, '44', '2019-01-11 10:03:25', NULL),
	(132, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 6, '1', '2019-01-11 10:03:25', NULL),
	(133, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, NULL, NULL, '2019-01-11 10:03:25', NULL),
	(134, '615F35487C9F2D2A08CDE3E9A612F3F8', 7, 9, 'Физическое лицо', '2019-01-11 10:03:25', NULL),
	(135, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 7, '55', '2019-01-11 10:10:40', NULL),
	(136, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 2, '22', '2019-01-11 10:10:40', NULL),
	(137, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 5, '33', '2019-01-11 10:10:40', NULL),
	(138, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 3, '44', '2019-01-11 10:10:40', NULL),
	(139, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 6, '1', '2019-01-11 10:10:40', NULL),
	(140, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, NULL, NULL, '2019-01-11 10:10:40', NULL),
	(141, 'AB86087D7403B0F71CD6FA45C3B93F51', 7, 9, 'Физическое лицо', '2019-01-11 10:10:40', NULL),
	(142, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 4, '11', '2019-01-11 10:11:10', NULL),
	(143, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 2, '22', '2019-01-11 10:11:10', NULL),
	(144, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 5, '33', '2019-01-11 10:11:10', NULL),
	(145, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 3, '44', '2019-01-11 10:11:10', NULL),
	(146, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 6, '1', '2019-01-11 10:11:10', NULL),
	(147, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 9, 'Физическое лицо', '2019-01-11 10:11:10', NULL),
	(148, 'ABAF3E8224F8F46FE26BE021874DB147', 7, 7, '55', '2019-01-11 10:11:10', NULL),
	(149, '8978D5372F4D133C37248C35E4002649', 7, 4, '11', '2019-01-11 10:47:02', NULL),
	(150, '8978D5372F4D133C37248C35E4002649', 7, 2, '22', '2019-01-11 10:47:02', NULL),
	(151, '8978D5372F4D133C37248C35E4002649', 7, 5, '33', '2019-01-11 10:47:02', NULL),
	(152, '8978D5372F4D133C37248C35E4002649', 7, 3, '44', '2019-01-11 10:47:02', NULL),
	(153, '8978D5372F4D133C37248C35E4002649', 7, 6, '1', '2019-01-11 10:47:02', NULL),
	(154, '8978D5372F4D133C37248C35E4002649', 7, 9, 'Юридическое лицо', '2019-01-11 10:47:02', NULL),
	(155, '8978D5372F4D133C37248C35E4002649', 7, 8, '11.01.2019', '2019-01-11 10:47:02', NULL),
	(156, '8978D5372F4D133C37248C35E4002649', 7, 7, '55', '2019-01-11 10:47:02', NULL),
	(157, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 4, '11', '2019-01-11 10:56:59', NULL),
	(158, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 2, '22', '2019-01-11 10:56:59', NULL),
	(159, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 5, '33', '2019-01-11 10:56:59', NULL),
	(160, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 3, '44', '2019-01-11 10:56:59', NULL),
	(161, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 6, '1', '2019-01-11 10:56:59', NULL),
	(162, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 9, 'Юридическое лицо', '2019-01-11 10:56:59', NULL),
	(163, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 8, '02.01.2019', '2019-01-11 10:56:59', NULL),
	(164, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 7, '55', '2019-01-11 10:56:59', NULL),
	(165, '8F9D72DAA6B2E3F1C24EB376C0A55325', 7, 10, 'Безналичный', '2019-01-11 10:56:59', NULL),
	(166, '877C86FBBE32FA235421373672D77E18', 7, 4, 'eqeq', '2019-01-11 16:04:28', NULL),
	(167, '877C86FBBE32FA235421373672D77E18', 7, 2, 'qweqwe', '2019-01-11 16:04:28', NULL),
	(168, '877C86FBBE32FA235421373672D77E18', 7, 5, '', '2019-01-11 16:04:28', NULL),
	(169, '877C86FBBE32FA235421373672D77E18', 7, 3, '', '2019-01-11 16:04:28', NULL),
	(170, '877C86FBBE32FA235421373672D77E18', 7, 6, '1', '2019-01-11 16:04:28', NULL),
	(171, '877C86FBBE32FA235421373672D77E18', 7, 8, '10.01.2019', '2019-01-11 16:04:28', NULL),
	(172, '877C86FBBE32FA235421373672D77E18', 7, 7, '', '2019-01-11 16:04:28', NULL),
	(173, '877C86FBBE32FA235421373672D77E18', 7, 10, 'Наличный', '2019-01-11 16:04:28', NULL),
	(174, '793A02735257BB20E18F17499DD533AE', 7, 4, 'fddsfdsf', '2019-01-14 12:26:43', NULL),
	(175, '793A02735257BB20E18F17499DD533AE', 7, 2, 'dsfdsfsdf', '2019-01-14 12:26:43', NULL),
	(176, '793A02735257BB20E18F17499DD533AE', 7, 5, 'fsdfsdfsd', '2019-01-14 12:26:43', NULL),
	(177, '793A02735257BB20E18F17499DD533AE', 7, 3, 'sdfsdfsd', '2019-01-14 12:26:43', NULL),
	(178, '793A02735257BB20E18F17499DD533AE', 7, 6, '1', '2019-01-14 12:26:43', NULL),
	(179, '793A02735257BB20E18F17499DD533AE', 7, 8, '03.01.2019', '2019-01-14 12:26:43', NULL),
	(180, '793A02735257BB20E18F17499DD533AE', 7, 7, '', '2019-01-14 12:26:43', NULL),
	(181, '793A02735257BB20E18F17499DD533AE', 7, 10, 'Наличный', '2019-01-14 12:26:43', NULL),
	(182, 'F40749AFEA274A3D54329AA1E5115D72', 7, 4, 'dfdfsdf', '2019-01-14 13:38:46', NULL),
	(183, 'F40749AFEA274A3D54329AA1E5115D72', 7, 2, 'sdfasdfasd', '2019-01-14 13:38:46', NULL),
	(184, 'F40749AFEA274A3D54329AA1E5115D72', 7, 5, 'sdfasdfa', '2019-01-14 13:38:46', NULL),
	(185, 'F40749AFEA274A3D54329AA1E5115D72', 7, 3, 'asdfasdf', '2019-01-14 13:38:46', NULL),
	(186, 'F40749AFEA274A3D54329AA1E5115D72', 7, 6, '1', '2019-01-14 13:38:46', NULL),
	(187, 'F40749AFEA274A3D54329AA1E5115D72', 7, 8, '03.01.2019', '2019-01-14 13:38:46', NULL),
	(188, 'F40749AFEA274A3D54329AA1E5115D72', 7, 7, 'asdfasdfdsaf', '2019-01-14 13:38:46', NULL),
	(189, 'F40749AFEA274A3D54329AA1E5115D72', 7, 10, 'Наличный', '2019-01-14 13:38:46', NULL),
	(190, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 4, 'asdfasd', '2019-01-14 13:39:23', NULL),
	(191, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 2, 'asdfasdfa', '2019-01-14 13:39:23', NULL),
	(192, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 5, 'fasdfasd', '2019-01-14 13:39:23', NULL),
	(193, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 3, 'dsafsadfa', '2019-01-14 13:39:23', NULL),
	(194, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 6, '1', '2019-01-14 13:39:23', NULL),
	(195, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 9, 'Юридическое лицо', '2019-01-14 13:39:23', NULL),
	(196, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 9, 'Физическое лицо', '2019-01-14 13:39:23', NULL),
	(197, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 8, '02.01.2019', '2019-01-14 13:39:23', NULL),
	(198, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 7, '', '2019-01-14 13:39:23', NULL),
	(199, '1C9D1941AB3AB66A3C9AD06C562AED82', 7, 10, 'Наличный', '2019-01-14 13:39:23', NULL),
	(200, '84D0C9C6D3DDA030C400E65331D65A67', 7, 4, 'asdfasd', '2019-01-14 14:16:59', NULL),
	(201, '84D0C9C6D3DDA030C400E65331D65A67', 7, 2, 'asdfasdfa', '2019-01-14 14:18:16', NULL),
	(202, '865FFB2AEFCD8F1B014F7CF81B08677A', 7, 4, 'asdfasd', '2019-01-14 14:26:33', NULL),
	(203, '079AEF333DAB69A557D3C0E7A7468A87', 7, 4, 'asdfasd', '2019-01-14 14:35:09', NULL),
	(204, '469F7C51154A62FD9067C4D955BD6C5A', 7, 4, 'asdfasd', '2019-01-14 14:36:26', NULL),
	(205, '9FFE74F26E0363354E791A582C14F817', 7, 4, 'asdfasd', '2019-01-14 14:38:24', NULL),
	(206, '9FFE74F26E0363354E791A582C14F817', 7, 2, 'asdfasdfa', '2019-01-14 14:38:47', NULL),
	(207, '9FFE74F26E0363354E791A582C14F817', 7, 5, 'fasdfasd', '2019-01-14 14:38:47', NULL),
	(208, '9FFE74F26E0363354E791A582C14F817', 7, 3, 'dsafsadfa', '2019-01-14 14:38:47', NULL),
	(209, '9FFE74F26E0363354E791A582C14F817', 7, 6, '1', '2019-01-14 14:38:47', NULL),
	(210, '9FFE74F26E0363354E791A582C14F817', 7, 9, 'Юридическое лицо', '2019-01-14 14:38:47', NULL),
	(211, '9FFE74F26E0363354E791A582C14F817', 7, 9, 'Физическое лицо', '2019-01-14 14:38:47', NULL),
	(212, '9FFE74F26E0363354E791A582C14F817', 7, 8, '02.01.2019', '2019-01-14 14:38:47', NULL),
	(213, '9FFE74F26E0363354E791A582C14F817', 7, 7, '', '2019-01-14 14:38:47', NULL),
	(214, '9FFE74F26E0363354E791A582C14F817', 7, 10, 'Наличный', '2019-01-14 14:38:47', NULL),
	(215, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 4, 'qqq', '2019-01-14 14:40:51', NULL),
	(216, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 2, 'www', '2019-01-14 14:40:51', NULL),
	(217, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 5, 'aaa', '2019-01-14 14:40:51', NULL),
	(218, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 3, 'sss', '2019-01-14 14:40:51', NULL),
	(219, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 6, '1', '2019-01-14 14:40:51', NULL),
	(220, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 8, '03.01.2019', '2019-01-14 14:40:51', NULL),
	(221, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 7, '', '2019-01-14 14:40:51', NULL),
	(222, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 10, 'Наличный', '2019-01-14 14:40:51', NULL),
	(223, '7BE1C3E9A5CF907316C740E53D5F6A72', 7, 9, '-', '2019-01-14 14:40:51', NULL),
	(224, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 2, '7706107510', '2019-01-17 14:30:26', NULL),
	(225, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 4, 'ПАО "НК "РОСНЕФТЬ"', '2019-01-17 14:30:26', NULL),
	(226, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 15, 'Главный Исполнительный Директор: Сечин Игорь Иванович', '2019-01-17 14:30:26', NULL),
	(227, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 11, '115035, МОСКВА ГОРОД, НАБЕРЕЖНАЯ СОФИЙСКАЯ,  26/1', '2019-01-17 14:30:26', NULL),
	(228, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 13, '770601001', '2019-01-17 14:30:26', NULL),
	(229, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 14, '1027700043502', '2019-01-17 14:30:26', NULL),
	(230, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 12, '19.07.2002', '2019-01-17 14:30:26', NULL),
	(231, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 3, '5504036333', '2019-01-17 14:30:26', NULL),
	(232, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 5, 'ПАО "ГАЗПРОМ НЕФТЬ"', '2019-01-17 14:30:26', NULL),
	(233, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 21, 'Генеральный Директор: Дюков Александр Валерьевич', '2019-01-17 14:30:26', NULL),
	(234, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 16, '190000, САНКТ-ПЕТЕРБУРГ ГОРОД, УЛИЦА ПОЧТАМТСКАЯ, ДОМ 3-5, ЛИТЕР А, Ч.ПОМ. 1Н КАБ. 2401', '2019-01-17 14:30:26', NULL),
	(235, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 18, '783801001', '2019-01-17 14:30:26', NULL),
	(236, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 19, '1025501701686', '2019-01-17 14:30:26', NULL),
	(237, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 17, '21.08.2002', '2019-01-17 14:30:26', NULL),
	(238, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 6, '1', '2019-01-17 14:30:26', NULL),
	(239, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 7, 'Продаю, покупаю, нефть качаю.', '2019-01-17 14:30:26', NULL),
	(240, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 9, 'Юридическое лицо', '2019-01-17 14:30:26', NULL),
	(241, '6965E628CF1C87F8AC9E1C8062CE35BB', 7, 20, 'Юридическое лицо', '2019-01-17 14:30:26', NULL),
	(242, 'DB55D9EAABB359124D1386024EADB46B', 7, 2, '7736050003', '2019-01-17 14:56:56', NULL),
	(243, 'DB55D9EAABB359124D1386024EADB46B', 7, 4, 'ПАО "ГАЗПРОМ"', '2019-01-17 14:56:56', NULL),
	(244, 'DB55D9EAABB359124D1386024EADB46B', 7, 15, 'Председатель Правления: Миллер Алексей Борисович', '2019-01-17 14:56:56', NULL),
	(245, 'DB55D9EAABB359124D1386024EADB46B', 7, 11, '117420, МОСКВА ГОРОД, УЛИЦА НАМЁТКИНА, ДОМ 16', '2019-01-17 14:56:56', NULL),
	(246, 'DB55D9EAABB359124D1386024EADB46B', 7, 13, '772801001', '2019-01-17 14:56:56', NULL),
	(247, 'DB55D9EAABB359124D1386024EADB46B', 7, 14, '1027700070518', '2019-01-17 14:56:56', NULL),
	(248, 'DB55D9EAABB359124D1386024EADB46B', 7, 12, '02.08.2002', '2019-01-17 14:56:56', NULL),
	(249, 'DB55D9EAABB359124D1386024EADB46B', 7, 3, '7706107510', '2019-01-17 14:56:56', NULL),
	(250, 'DB55D9EAABB359124D1386024EADB46B', 7, 5, 'ПАО "НК "РОСНЕФТЬ"', '2019-01-17 14:56:56', NULL),
	(251, 'DB55D9EAABB359124D1386024EADB46B', 7, 21, 'Главный Исполнительный Директор: Сечин Игорь Иванович', '2019-01-17 14:56:56', NULL),
	(252, 'DB55D9EAABB359124D1386024EADB46B', 7, 16, '115035, МОСКВА ГОРОД, НАБЕРЕЖНАЯ СОФИЙСКАЯ,  26/1', '2019-01-17 14:56:56', NULL),
	(253, 'DB55D9EAABB359124D1386024EADB46B', 7, 18, '770601001', '2019-01-17 14:56:56', NULL),
	(254, 'DB55D9EAABB359124D1386024EADB46B', 7, 19, '1027700043502', '2019-01-17 14:56:56', NULL),
	(255, 'DB55D9EAABB359124D1386024EADB46B', 7, 17, '19.07.2002', '2019-01-17 14:56:56', NULL),
	(256, 'DB55D9EAABB359124D1386024EADB46B', 7, 6, '1', '2019-01-17 14:56:56', NULL),
	(257, 'DB55D9EAABB359124D1386024EADB46B', 7, 7, '', '2019-01-17 14:56:56', NULL),
	(258, 'DB55D9EAABB359124D1386024EADB46B', 7, 9, 'Юридическое лицо', '2019-01-17 14:56:56', NULL),
	(259, 'DB55D9EAABB359124D1386024EADB46B', 7, 20, 'Юридическое лицо', '2019-01-17 14:56:56', NULL),
	(260, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 2, '7736050003', '2019-01-17 14:57:08', NULL),
	(261, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 4, 'ПАО "ГАЗПРОМ"', '2019-01-17 14:57:08', NULL),
	(262, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 15, 'Председатель Правления: Миллер Алексей Борисович', '2019-01-17 14:57:08', NULL),
	(263, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 11, '117420, МОСКВА ГОРОД, УЛИЦА НАМЁТКИНА, ДОМ 16', '2019-01-17 14:57:08', NULL),
	(264, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 13, '772801001', '2019-01-17 14:57:08', NULL),
	(265, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 14, '1027700070518', '2019-01-17 14:57:08', NULL),
	(266, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 12, '02.08.2002', '2019-01-17 14:57:08', NULL),
	(267, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 3, '7706107510', '2019-01-17 14:57:08', NULL),
	(268, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 5, 'ПАО "НК "РОСНЕФТЬ"', '2019-01-17 14:57:08', NULL),
	(269, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 21, 'Главный Исполнительный Директор: Сечин Игорь Иванович', '2019-01-17 14:57:08', NULL),
	(270, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 16, '115035, МОСКВА ГОРОД, НАБЕРЕЖНАЯ СОФИЙСКАЯ,  26/1', '2019-01-17 14:57:08', NULL),
	(271, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 18, '770601001', '2019-01-17 14:57:08', NULL),
	(272, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 19, '1027700043502', '2019-01-17 14:57:08', NULL),
	(273, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 17, '19.07.2002', '2019-01-17 14:57:08', NULL),
	(274, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 6, '0', '2019-01-17 14:57:08', NULL),
	(275, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 7, '', '2019-01-17 14:57:08', NULL),
	(276, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 9, 'Юридическое лицо', '2019-01-17 14:57:08', NULL),
	(277, '3F91018B3E77DE48EB47AA14FDFA7CEA', 7, 20, 'Юридическое лицо', '2019-01-17 14:57:08', NULL),
	(278, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 2, '7736050003', '2019-01-24 13:28:41', 1),
	(279, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 4, 'ПАО "ГАЗПРОМ"', '2019-01-24 13:28:41', 1),
	(280, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 15, 'Председатель Правления: Миллер Алексей Борисович', '2019-01-24 13:28:41', 1),
	(281, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 11, '117420, МОСКВА ГОРОД, УЛИЦА НАМЁТКИНА, ДОМ 16', '2019-01-24 13:28:41', 1),
	(282, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 13, '772801001', '2019-01-24 13:28:41', 1),
	(283, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 14, '1027700070518', '2019-01-24 13:28:41', 1),
	(284, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 12, '02.08.2002', '2019-01-24 13:28:41', 1),
	(285, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 3, '7708004767', '2019-01-24 13:28:41', 1),
	(286, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 5, 'ПАО "ЛУКОЙЛ"', '2019-01-24 13:28:41', 1),
	(287, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 21, 'Президент: Алекперов Вагит Юсуфович', '2019-01-24 13:28:41', 1),
	(288, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 16, '101000, МОСКВА ГОРОД, БУЛЬВАР СРЕТЕНСКИЙ,  11', '2019-01-24 13:28:41', 1),
	(289, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 18, '770801001', '2019-01-24 13:28:41', 1),
	(290, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 19, '1027700035769', '2019-01-24 13:28:41', 1),
	(291, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 17, '17.07.2002', '2019-01-24 13:28:41', 1),
	(292, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 6, '1', '2019-01-24 13:28:41', 1),
	(293, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 7, '1111', '2019-01-24 13:28:41', 1),
	(294, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 9, 'Юридическое лицо', '2019-01-24 13:28:41', 1),
	(295, 'ACBABCF3B9AF9BE7C89F8ADA2301460D', 7, 20, 'Юридическое лицо', '2019-01-24 13:28:41', 1);
/*!40000 ALTER TABLE `tg_documents` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_gallery
DROP TABLE IF EXISTS `tg_gallery`;
CREATE TABLE IF NOT EXISTS `tg_gallery` (
  `gkey` varchar(50) default NULL COMMENT 'Идентификатор изображения'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица загруженных изображений';

-- Дамп данных таблицы templategen.tg_gallery: 1 rows
/*!40000 ALTER TABLE `tg_gallery` DISABLE KEYS */;
INSERT INTO `tg_gallery` (`gkey`) VALUES
	('6c6bf76898f8cc77ba88e56bea2c476b');
/*!40000 ALTER TABLE `tg_gallery` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_plugin_egrul
DROP TABLE IF EXISTS `tg_plugin_egrul`;
CREATE TABLE IF NOT EXISTS `tg_plugin_egrul` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Уникальный идентификатор',
  `tid` int(10) unsigned NOT NULL default '0' COMMENT 'Идентификатор шаблона',
  `inn` int(10) unsigned NOT NULL default '0' COMMENT 'Ключевое поле для поиска. ИНН',
  `oname` int(10) unsigned NOT NULL default '0' COMMENT 'Название организации',
  `addr` int(10) unsigned NOT NULL default '0' COMMENT 'Адрес организации',
  `status` int(10) unsigned NOT NULL default '0' COMMENT 'Занимаемая должность',
  `ogrn` int(10) unsigned NOT NULL default '0' COMMENT 'ОГРН',
  `cdata` int(10) unsigned NOT NULL default '0' COMMENT 'Дата регистрации организации',
  `kpp` int(10) unsigned NOT NULL default '0' COMMENT 'КПП',
  `otype` int(10) unsigned NOT NULL default '0' COMMENT 'Форма организации',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unq_tid_inn` (`inn`,`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица плагина автозаполнения из ЕГРЮЛ';

-- Дамп данных таблицы templategen.tg_plugin_egrul: 2 rows
/*!40000 ALTER TABLE `tg_plugin_egrul` DISABLE KEYS */;
INSERT INTO `tg_plugin_egrul` (`id`, `tid`, `inn`, `oname`, `addr`, `status`, `ogrn`, `cdata`, `kpp`, `otype`) VALUES
	(6, 7, 3, 5, 16, 21, 19, 17, 18, 20),
	(5, 7, 2, 4, 11, 15, 14, 12, 13, 9);
/*!40000 ALTER TABLE `tg_plugin_egrul` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_templates
DROP TABLE IF EXISTS `tg_templates`;
CREATE TABLE IF NOT EXISTS `tg_templates` (
  `tid` int(10) unsigned NOT NULL auto_increment COMMENT 'Идентификатор',
  `cdate` timestamp NULL default CURRENT_TIMESTAMP COMMENT 'Дата создания шаблона',
  `edate` timestamp NULL default NULL COMMENT 'Последняя дата редактирования',
  `tname` varchar(200) default NULL COMMENT 'Название шаблона',
  `tbody` longtext COMMENT 'Тело шаблона',
  `tvars` text COMMENT 'Переменные используемы в шаблоне',
  PRIMARY KEY  (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица шаблонов';

-- Дамп данных таблицы templategen.tg_templates: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `tg_templates` DISABLE KEYS */;
INSERT INTO `tg_templates` (`tid`, `cdate`, `edate`, `tname`, `tbody`, `tvars`) VALUES
	(7, '2018-12-26 15:48:01', NULL, 'Лицензионное соглашение', '<p fr-original-style="text-align: center;" style="text-align: center; box-sizing: border-box; margin: 0px 0px 10px;">Лицензионное соглашение №1 от 29 декабря 2018 г.</p><p fr-original-style="text-align: center;" style="text-align: center; box-sizing: border-box; margin: 0px 0px 10px;"><br fr-original-style="" style="box-sizing: border-box;"></p><p fr-original-style="margin-left: 20px; line-height: 0.75;" style="margin: 0px 0px 10px 20px; line-height: 0.75; box-sizing: border-box;"><br fr-original-style="" style="box-sizing: border-box;"></p><table fr-original-style="width: 100%;" style="width: 100%; box-sizing: border-box; border-spacing: 0px; background-color: transparent; border: 0px none; border-collapse: collapse; empty-cells: show; max-width: 100%;"><tbody fr-original-style="" style="box-sizing: border-box;"><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Инн первой компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_INN}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Название первой компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_ORG_NAME}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Адрес компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_ADDR}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Дата регистрации</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_CDATE}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">КПП</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_KPP}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">ОГРН</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_OGRN}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Должность, руководитель</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_STATUS}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Тип контрагента</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{DEF_TYPE}</td></tr></tbody></table><hr fr-original-style="" style="height: 0px; box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-color: rgb(238, 238, 238) currentcolor currentcolor; border-style: solid none none; border-width: 1px 0px 0px; border-image: none 100% / 1 / 0 stretch; clear: both; -moz-user-select: none; page-break-after: always;"><table fr-original-style="width: 100%;" style="width: 100%; box-sizing: border-box; border-spacing: 0px; background-color: transparent; border: 0px none; border-collapse: collapse; empty-cells: show; max-width: 100%;"><tbody fr-original-style="" style="box-sizing: border-box;"><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Инн второй компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_INN}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Название второй компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_ORG_NAME}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Адрес компании</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLN_ADDR}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Дата регистрации</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_CDATE}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">КПП</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_KPP}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">ОГРН</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_OGRN}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Должность, руководитель</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_STATUS}</td></tr><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Тип контрагента</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{CLM_TYPE}</td></tr></tbody></table><hr fr-original-style="" style="height: 0px; box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-color: rgb(238, 238, 238) currentcolor currentcolor; border-style: solid none none; border-width: 1px 0px 0px; border-image: none 100% / 1 / 0 stretch; clear: both; -moz-user-select: none; page-break-after: always;"><table fr-original-style="width: 100%;" style="width: 100%; box-sizing: border-box; border-spacing: 0px; background-color: transparent; border: 0px none; border-collapse: collapse; empty-cells: show; max-width: 100%;"><tbody fr-original-style="" style="box-sizing: border-box;"><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Условия соглашения</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{APP_TEXT_AREA}</td></tr></tbody></table><p fr-original-style="" style="box-sizing: border-box; margin: 0px 0px 10px;"><br fr-original-style="" style="box-sizing: border-box;"></p><table fr-original-style="width: 100%;" style="width: 100%; box-sizing: border-box; border-spacing: 0px; background-color: transparent; border: 0px none; border-collapse: collapse; empty-cells: show; max-width: 100%;"><tbody fr-original-style="" style="box-sizing: border-box;"><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">С условиями согласен</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">{APP_CHECK_LICENSE}</td></tr></tbody></table><p fr-original-style="" style="box-sizing: border-box; margin: 0px 0px 10px;"><br fr-original-style="" style="box-sizing: border-box;"></p><table fr-original-style="width: 100%;" style="width: 100%; box-sizing: border-box; border-spacing: 0px; background-color: transparent; border: 0px none; border-collapse: collapse; empty-cells: show; max-width: 100%;"><tbody fr-original-style="" style="box-sizing: border-box;"><tr fr-original-style="" style="box-sizing: border-box; -moz-user-select: none;"><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);">Печать</td><td fr-original-style="width: 50.0000%;" style="width: 50%; box-sizing: border-box; padding: 0px; min-width: 5px; -moz-user-select: text; border: 1px solid rgb(221, 221, 221);"><div fr-original-style="text-align: center;" style="text-align: center; box-sizing: border-box;"><img src="/assets/img/6c6bf76898f8cc77ba88e56bea2c476b" style="width: 42px; display: block; vertical-align: top; margin: 5px auto; text-align: center; box-sizing: border-box; border: 0px none; cursor: pointer; position: relative; max-width: 100%;" fr-original-style="width: 42px; display: block; vertical-align: top; margin: 5px auto; text-align: center;" fr-original-class="fr-draggable"></div></td></tr></tbody></table>', '6,7,20,21,19,18,17,16,5,3,9,15,14,13,12,11,4,2');
/*!40000 ALTER TABLE `tg_templates` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_users
DROP TABLE IF EXISTS `tg_users`;
CREATE TABLE IF NOT EXISTS `tg_users` (
  `uid` int(11) NOT NULL auto_increment COMMENT 'Уникальный идентификатор ',
  `email` varchar(100) NOT NULL COMMENT 'Email ',
  `phone` varchar(100) default NULL COMMENT 'Номер телефона',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `unq_email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Таблица пользователей воспользовавшихся сервисом';

-- Дамп данных таблицы templategen.tg_users: 0 rows
/*!40000 ALTER TABLE `tg_users` DISABLE KEYS */;
INSERT INTO `tg_users` (`uid`, `email`, `phone`) VALUES
	(1, 'mmv@dialog-it.ru', '7-903-958-97-83');
/*!40000 ALTER TABLE `tg_users` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_wizard
DROP TABLE IF EXISTS `tg_wizard`;
CREATE TABLE IF NOT EXISTS `tg_wizard` (
  `wid` int(11) NOT NULL auto_increment COMMENT 'Идентификатор',
  `tid` int(11) default '0' COMMENT 'Идентификатор шаблона',
  `step` int(11) default '0' COMMENT 'Номер шага',
  `pos` int(11) default '0' COMMENT 'Позиция переменной',
  `attr` int(11) default '0' COMMENT 'Переменные',
  `req` int(10) unsigned default '0' COMMENT 'Требование валидации параметра',
  PRIMARY KEY  (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Мастер настройки заполнения шаблона';

-- Дамп данных таблицы templategen.tg_wizard: 25 rows
/*!40000 ALTER TABLE `tg_wizard` DISABLE KEYS */;
INSERT INTO `tg_wizard` (`wid`, `tid`, `step`, `pos`, `attr`, `req`) VALUES
	(20, 1, 2, 1, 2, 0),
	(19, 1, 1, 2, 5, 0),
	(18, 1, 1, 1, 2, 0),
	(32, 6, 2, 2, 3, 0),
	(31, 6, 2, 1, 5, 0),
	(30, 6, 1, 2, 2, 0),
	(29, 6, 1, 1, 4, 0),
	(184, 7, 3, 2, 6, 0),
	(183, 7, 3, 1, 7, 0),
	(182, 7, 2, 8, 17, 0),
	(181, 7, 2, 7, 19, 1),
	(180, 7, 2, 6, 18, 1),
	(179, 7, 2, 5, 20, 0),
	(178, 7, 2, 4, 16, 1),
	(177, 7, 2, 3, 21, 1),
	(176, 7, 2, 2, 5, 1),
	(175, 7, 2, 1, 3, 1),
	(174, 7, 1, 8, 12, 0),
	(173, 7, 1, 7, 14, 1),
	(172, 7, 1, 6, 13, 1),
	(171, 7, 1, 5, 9, 0),
	(170, 7, 1, 4, 11, 1),
	(169, 7, 1, 3, 15, 1),
	(168, 7, 1, 2, 4, 1),
	(167, 7, 1, 1, 2, 1);
/*!40000 ALTER TABLE `tg_wizard` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
