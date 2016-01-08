-- ----------
-- Warehouse by Encrypted.pl
-- Table: log
-- ----------
DROP TABLE log;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `comment` text NOT NULL,
  `id_product` int(11) NOT NULL,
  `name_product` text NOT NULL,
  `id_packing` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=357 DEFAULT CHARSET=latin2;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: log_history
-- ----------
DROP TABLE log_history;

CREATE TABLE `log_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_packing` int(11) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=338 DEFAULT CHARSET=latin2;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: notes
-- ----------
DROP TABLE notes;

CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin2;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: orders
-- ----------
DROP TABLE orders;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: packings
-- ----------
DROP TABLE packings;

CREATE TABLE `packings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin2;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: products
-- ----------
DROP TABLE products;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `lat` FLOAT NOT NULL,
  `lng` FLOAT NOT NULL,
  `description` text NOT NULL,
  `status` text NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin2;

-- ----------
-- Warehouse by Encrypted.pl
-- Table: users
-- ----------
DROP TABLE users;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `level` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Table with users data.';

INSERT INTO users VALUES("1","root","63a9f0ea7bb98050796b649e85481845","2","0");

