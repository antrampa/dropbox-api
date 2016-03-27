/*
SQLyog Community Edition- MySQL GUI v8.01 
MySQL - 5.1.31-community : Database - myamate_dropbox
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`myamate_dropbox` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `myamate_dropbox`;

/*Table structure for table `catched_errors` */

DROP TABLE IF EXISTS `catched_errors`;

CREATE TABLE `catched_errors` (
  `catched_errors_date` datetime DEFAULT '0000-00-00 00:00:00',
  `catched_errors_ip` varchar(255) DEFAULT NULL,
  `catched_errors_agent` varchar(255) DEFAULT NULL,
  `catched_errors_error` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `catched_errors` */

/*Table structure for table `upload` */

DROP TABLE IF EXISTS `upload`;

CREATE TABLE `upload` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_order_type` varchar(255) DEFAULT NULL,
  `upload_quantity` int(11) DEFAULT '0',
  `upload_firstname` varchar(255) DEFAULT NULL,
  `upload_lastname` varchar(255) DEFAULT NULL,
  `upload_company` varchar(255) DEFAULT NULL,
  `upload_phone` varchar(255) DEFAULT NULL,
  `upload_email` varchar(255) DEFAULT NULL,
  `upload_message` varchar(255) DEFAULT NULL,
  `upload_entry_date` datetime DEFAULT '0000-00-00 00:00:00',
  `upload_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upload_ip` varchar(255) DEFAULT NULL,
  `upload_agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `upload` */

insert  into `upload`(`upload_id`,`upload_order_type`,`upload_quantity`,`upload_firstname`,`upload_lastname`,`upload_company`,`upload_phone`,`upload_email`,`upload_message`,`upload_entry_date`,`upload_timestamp`,`upload_ip`,`upload_agent`) values (1,'Option1',1000,'','','','','','','2012-03-11 11:55:54','2012-03-11 23:55:54','127.0.0.1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.78 Safari/535.11'),(2,'Option3',5000,'Test','TestLastname','Myamatech','766393440','ambitos2000@yahoo.com','atetasdt atsd satd adt asd','2012-03-12 12:20:03','2012-03-12 00:20:03','127.0.0.1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.78 Safari/535.11'),(3,'Option3',5000,'Test','TestLastname','Myamatech','766393440','ambitos2000@yahoo.com','atetasdt atsd satd adt asd','2012-03-12 12:21:50','2012-03-12 00:21:50','127.0.0.1','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.78 Safari/535.11');

/*Table structure for table `upload_files` */

DROP TABLE IF EXISTS `upload_files`;

CREATE TABLE `upload_files` (
  `upload_files_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_files_upload_id` int(11) DEFAULT '0',
  `upload_files_filename` varchar(255) DEFAULT NULL,
  `upload_files_filetype` varchar(255) DEFAULT NULL,
  `upload_files_filesize` varchar(255) DEFAULT NULL,
  `upload_files_fileindex` int(11) DEFAULT '0',
  `upload_files_fileerror` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`upload_files_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `upload_files` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
