-- --------------------------------------------------------
-- Хост:                         91.227.140.69
-- Версия сервера:               5.0.84 - Source distribution
-- Операционная система:         redhat-linux-gnu
-- HeidiSQL Версия:              9.5.0.5269
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

-- Дамп данных таблицы templategen.tg_attributes: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `tg_attributes` DISABLE KEYS */;
INSERT INTO `tg_attributes` (`aid`, `aname`, `atype`, `adesc`, `title`, `test`) VALUES
	(2, 'APP_INN_DEF', 1, 'ИНН Ответчика', 'Инн ответчика', '222333111'),
	(3, 'APP_INN_CLAIMANT', 1, 'ИНН Истца', 'ИНН Истца', '222333779'),
	(4, 'APP_NAME_DEF', 1, 'Название ответчика', 'Название ответчика', 'Иванов Иванович'),
	(5, 'APP_NAME_CLAIMANT', 1, 'Название истца', 'Название истца', 'Петров Петр');
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

-- Дамп данных таблицы templategen.tg_attributes_type: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `tg_attributes_type` DISABLE KEYS */;
INSERT INTO `tg_attributes_type` (`tid`, `tname`, `ttype`) VALUES
	(1, 'Текстовое поле', 'TINPUT'),
	(2, 'Календарь', 'TCALENDAR'),
	(3, 'Выпадающий список', 'TDROPDOWN'),
	(4, 'Выбор элемента', 'TSELECT');
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
  PRIMARY KEY  (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица сгенерированных документов';

-- Дамп данных таблицы templategen.tg_documents: ~17 rows (приблизительно)
/*!40000 ALTER TABLE `tg_documents` DISABLE KEYS */;
INSERT INTO `tg_documents` (`did`, `dkey`, `tid`, `aid`, `val`, `cdate`) VALUES
	(1, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 2, '1', '2018-12-26 14:45:09'),
	(2, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 5, '2', '2018-12-26 14:45:19'),
	(3, 'F5F1EDB6A98FDD3BBAF1319EA613097D', 1, 2, '3', '2018-12-26 14:45:23'),
	(4, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 2, '22222222', '2018-12-26 15:13:21'),
	(5, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 5, 'Сидор Сидоров', '2018-12-26 15:13:21'),
	(6, '70D7DFDA9504BFF02B08ACC2E5ED02FE', 1, 2, '23423423423423', '2018-12-26 15:13:21'),
	(7, '8C106BAE3118B312F93FE4758E7F56D9', 1, 2, '22222222', '2018-12-26 15:13:59'),
	(8, '8C106BAE3118B312F93FE4758E7F56D9', 1, 5, 'Сидор Сидоров', '2018-12-26 15:13:59'),
	(9, '8C106BAE3118B312F93FE4758E7F56D9', 1, 2, '454545435345345', '2018-12-26 15:13:59'),
	(10, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 4, 'Иванов Иван', '2018-12-26 15:27:16'),
	(11, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 2, '22222222', '2018-12-26 15:27:16'),
	(12, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 5, 'Сидор Сидоров', '2018-12-26 15:27:16'),
	(13, 'C36746EE1DDD09FFB9C23037425B3B26', 6, 3, '55555555', '2018-12-26 15:27:16'),
	(14, 'AD3EEA8084FB9A68B9A6CF49A388A418', 7, 4, 'Иванов Иван', '2018-12-26 15:51:42'),
	(15, 'AD3EEA8084FB9A68B9A6CF49A388A418', 7, 2, '1111111111', '2018-12-26 15:51:42'),
	(16, 'AD3EEA8084FB9A68B9A6CF49A388A418', 7, 5, 'Сидоров Сидор', '2018-12-26 15:51:42'),
	(17, 'AD3EEA8084FB9A68B9A6CF49A388A418', 7, 3, '222222', '2018-12-26 15:51:42'),
	(18, '6F19CC794039BF28926D88F35933BF20', 10, 2, '23324234234', '2018-12-27 10:16:28'),
	(19, '9EE13B81998A62E89724E282B852AF53', 7, 4, 'ООО Колбаса', '2018-12-27 10:40:37'),
	(20, '9EE13B81998A62E89724E282B852AF53', 7, 2, '0000000', '2018-12-27 10:40:37'),
	(21, '9EE13B81998A62E89724E282B852AF53', 7, 5, 'ООО Батон', '2018-12-27 10:40:37'),
	(22, '9EE13B81998A62E89724E282B852AF53', 7, 3, '66666', '2018-12-27 10:40:37'),
	(23, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 4, '', '2018-12-27 11:21:35'),
	(24, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 2, '', '2018-12-27 11:21:35'),
	(25, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 5, '', '2018-12-27 11:21:35'),
	(26, '5A054EF3A5F60F2A46ECA97D4E864DA5', 7, 3, '', '2018-12-27 11:21:35');
/*!40000 ALTER TABLE `tg_documents` ENABLE KEYS */;

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

-- Дамп данных таблицы templategen.tg_templates: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `tg_templates` DISABLE KEYS */;
INSERT INTO `tg_templates` (`tid`, `cdate`, `edate`, `tname`, `tbody`, `tvars`) VALUES
	(5, '2018-12-21 16:22:03', NULL, 'Новый шаблон', '<p>Новый текст...</p>', ''),
	(7, '2018-12-26 15:48:01', NULL, 'Договор 14', '<p style="text-align: center;">Исковое заявление №234 от 29 декабря 2018 г.</p><p style="text-align: center;">аааа</p><p style="margin-left: 20px;">ФИО Ответчика {APP_NAME_DEF}</p><p style="margin-left: 20px;">ИНН Ответчика {APP_INN_DEF}</p><p style="margin-left: 20px;">ФИО Истца {APP_NAME_CLAIMANT}</p><p style="margin-left: 20px;">ИНН Истца {APP_INN_CLAIMANT}</p><hr><p><br></p>', '3,5,2,4'),
	(10, '2018-12-27 10:14:35', NULL, 'Новый шаблон 11', '<p><br></p><p><br></p><p>Привет! Привет! Новый шаблон документа!!!</p><p>{APP_INN_DEF}</p>', '2');
/*!40000 ALTER TABLE `tg_templates` ENABLE KEYS */;

-- Дамп структуры для таблица templategen.tg_wizard
DROP TABLE IF EXISTS `tg_wizard`;
CREATE TABLE IF NOT EXISTS `tg_wizard` (
  `wid` int(11) NOT NULL auto_increment COMMENT 'Идентификатор',
  `tid` int(11) default '0' COMMENT 'Идентификатор шаблона',
  `step` int(11) default '0' COMMENT 'Номер шага',
  `pos` int(11) default '0' COMMENT 'Позиция переменной',
  `attr` int(11) default '0' COMMENT 'Переменные',
  PRIMARY KEY  (`wid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Мастер настройки заполнения шаблона';

-- Дамп данных таблицы templategen.tg_wizard: 11 rows
/*!40000 ALTER TABLE `tg_wizard` DISABLE KEYS */;
INSERT INTO `tg_wizard` (`wid`, `tid`, `step`, `pos`, `attr`) VALUES
	(20, 1, 2, 1, 2),
	(19, 1, 1, 2, 5),
	(18, 1, 1, 1, 2),
	(32, 6, 2, 2, 3),
	(31, 6, 2, 1, 5),
	(30, 6, 1, 2, 2),
	(29, 6, 1, 1, 4),
	(33, 7, 1, 1, 4),
	(34, 7, 1, 2, 2),
	(35, 7, 2, 1, 5),
	(36, 7, 2, 2, 3),
	(37, 10, 1, 1, 2);
/*!40000 ALTER TABLE `tg_wizard` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
