DROP TABLE IF EXISTS `#__hbpro_estates`;
CREATE TABLE IF NOT EXISTS `#__hbpro_estates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(1000) not null,
  `longitude` float(10,6) not null,
  `latitude` float(10,6) not null,
  `district` int(11) not null,
  `province` int(11) not null,
  `street` varchar(1000) not null,
  `price` decimal(15,0) not null,
  `host` int(1) not null,
  `house_qty` int(11) not null,
  `rating` tinyint(1) not null,
  `ordering` tinyint(1) not null,
  `date_start` date not null,
  `deadline` date not null,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__hbpro_estate_images`;
CREATE TABLE IF NOT EXISTS `#__hbpro_estate_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estate_id` int(11) NOT NULL,
  `path` varchar(300) not NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__hbpro_estate_houses`;
CREATE TABLE IF NOT EXISTS `#__hbpro_estate_houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estate_id` int(11) not null,
  `name` varchar(300) NOT NULL,
  `exceprt` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `position` varchar(1000) not null,
  `qty` int(11) not null,
  `square` int(11) not null,
  `width` tinyint(1) not null,
  `long` tinyint(1) not null,
  `price` decimal(15,0) not null,
  `floor` tinyint(1) not null,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__hbpro_estate_hosts`;
CREATE TABLE IF NOT EXISTS `#__hbpro_estate_hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;