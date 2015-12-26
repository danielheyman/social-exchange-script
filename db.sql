CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `coupon_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coins` int(255) NOT NULL DEFAULT '0',
  `uses` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

CREATE TABLE IF NOT EXISTS `packs` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coins` int(255) NOT NULL DEFAULT '0',
  `price` decimal(5,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;


INSERT INTO `packs` (`id`, `name`, `coins`, `price`) VALUES
(1, '200 Points', 200, '1.00'),
(3, '1,000 Points', 1000, '3.75'),
(4, '2,500 Points', 2500, '7.50'),
(5, '5,000 Points', 5000, '12.50'),
(6, '10,000 Points', 10000, '21.25'),
(2, '500 Points', 500, '2.00'),
(7, '20,000 Points', 20000, '35.00'),
(8, '50,000 Points', 50000, '70.00'),
(9, '100,000 Points', 100000, '125.00'),
(11, '200 Point Pack', 200, '1.00'),
(12, '200 Point Pack', 200, '1.00'),
(13, '200 Point Pack', 200, '1.00'),
(14, '200 Point Pack', 200, '1.00');


CREATE TABLE IF NOT EXISTS `referals` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE utf8_unicode_ci NOT NULL,
  `referal` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registered` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;


CREATE TABLE IF NOT EXISTS `settings` (
  `site_name` text NOT NULL,
  `site_description` text NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `site_email` varchar(255) NOT NULL,
  `paypal` varchar(64) NOT NULL,
  `cpc` varchar(50) NOT NULL DEFAULT '10',
  `refbonus` varchar(50) NOT NULL DEFAULT '0.1',
  `sale` varchar(50) NOT NULL DEFAULT '0.1',
  `socialhiccup` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `settings` (`site_name`, `site_description`, `site_url`, `site_email`, `paypal`, `cpc`, `refbonus`, `sale`) VALUES
('Exchange System', 'The best exchange system', 'http://mywebsite.com', 'admin@mywebsite.com', 'admin@mywebsite.com', '10', '0.1', '0.15');


CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `pack` text COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(5,2) NOT NULL DEFAULT '0.00',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE latin1_german1_ci DEFAULT NULL,
  `username` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  `coins` float(255,2) NOT NULL DEFAULT '50.00',
  `IP` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `pass` varchar(32) COLLATE latin1_german1_ci DEFAULT NULL,
  `passdecoded` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `ref` int(255) DEFAULT NULL,
  `signup` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `online` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promote` int(255) NOT NULL DEFAULT '0',
  `activate` int(255) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=98 ;


INSERT INTO `users` (`id`, `email`, `username`, `coins`, `IP`, `pass`, `passdecoded`, `ref`, `signup`, `online`, `promote`, `activate`, `banned`, `admin`) VALUES
(1, 'admin@mywebsite.com', 'admin', 1000.00, '127.0.0.1', '5f4dcc3b5aa765d61d8327deb882cf99', 'password', 0, '2012-01-01 01:00:00', '2012-01-01 01:00:00', 0, 0, 0, 1);


CREATE TABLE IF NOT EXISTS `visits` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user` int(255) NOT NULL,
  `ip` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `referer` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;