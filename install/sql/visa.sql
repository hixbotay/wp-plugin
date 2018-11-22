DROP TABLE IF EXISTS `#__hbpro_register_email`;
CREATE TABLE IF NOT EXISTS `#__hbpro_register_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `checked` tinyint(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `country` varchar(2) NOT NULL,
  `job` varchar(20) not null,
  `job_desc` varchar(150) not null,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

