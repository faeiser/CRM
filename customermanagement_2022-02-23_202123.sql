/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
CREATE DATABASE
/*!32312 IF NOT EXISTS*/
customermanagement
/*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE customermanagement;
DROP TABLE IF EXISTS customer;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `company` varchar(31) DEFAULT NULL,
  `contact` varchar(31) DEFAULT NULL,
  `telephone` varchar(31) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `user` varchar(31) DEFAULT NULL COMMENT 'User create',
  `note` varchar(150) DEFAULT NULL,
  `create_time` DATE DEFAULT NULL COMMENT 'Create Time',
  `update_time` DATE DEFAULT NULL COMMENT 'Update Time',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8;
DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `email` varchar(31) NOT NULL,
  `firstname` varchar(31) NOT NULL,
  `lastname` varchar(31) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userrights` varchar(5) NOT NULL,
  `create_time` DATE DEFAULT NULL,
  `update_time` DATE DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
INSERT INTO
  customer(
    id,
    company,
    contact,
    telephone,
    address,
    user,
    note,
    create_time,
    update_time
  )
VALUES(
    1,
    'Test AG',
    'Frau Testosteron',
    '0815/12312345',
    'Testdorf 99, 0404 Error',
    'fabian@gmx.at',
    NULL,
    '2022-02-18',
    '2022-02-23'
  ),(
    2,
    'Muster GmbH',
    'Herr Mustermann',
    '0676/9243256',
    'Musterstr. 7, 4863 Seewaclehn',
    'test',
    NULL,
    '2022-02-19',
    '2022-02-23'
  ),(
    3,
    'IKEA',
    'Herr Schwede, Alter',
    '+39 465/34526535',
    'Bijörensen 43, 3425 Sören, SWE',
    'test',
    NULL,
    '2022-02-04',
    NULL
  ),(
    4,
    'Aigner GmbH',
    'Herr Schmeißer',
    '+43676/8621248',
    'Vöcklabruckerstr. 7, A-4863 Seewalchen',
    'fabian@gmx.at',
    NULL,
    '2022-02-20',
    NULL
  ),(
    5,
    'Post AG Seewalchn',
    'Frau Uder',
    '+43 787/9244567',
    'Peter-Schütz-Str. 58-60, 4863 Lizelberg',
    'fabian@gmx.at',
    NULL,
    '2022-02-20',
    NULL
  ),(
    6,
    'Test AG',
    'Frau Testosteron',
    '0815/12312345',
    'Testdorf 99, 0404 Error',
    'fabian@gmx.at',
    NULL,
    '2022-02-18',
    '2022-02-23'
  ),(
    7,
    'Muster GmbH',
    'Herr Mustermann',
    '0676/9243256',
    'Musterstr. 7, 4863 Seewaclehn',
    'test',
    NULL,
    '2022-02-19',
    NULL
  ),(
    8,
    'IKEA',
    'Herr Schwede, Alter',
    '+39 465/34526535',
    'Bijörensen 43, 3425 Sören, SWE',
    'test',
    NULL,
    '2022-02-04',
    NULL
  ),(
    9,
    'Aigner',
    'Herr Schmeißer',
    '+43676/8621248',
    'Vöcklabruckerstr. 7, A-4863 Seewalchen',
    'fabian@gmx.at',
    NULL,
    '2022-02-20',
    '2022-02-23'
  );
INSERT INTO
  user(
    email,
    firstname,
    lastname,
    password,
    userrights,
    create_time
  )
VALUES(
    'fabian@gmx.at',
    'Fabian',
    'Gläßer',
    '4321',
    'CEO',
    '2022-01-23'
  ),(
    'test',
    'name',
    'nachname',
    '1234',
    'L1',
    '2022-02-15'
  );