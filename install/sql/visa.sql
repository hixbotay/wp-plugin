CREATE TABLE `#__fvn_airports` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `iata` varchar(3) NOT NULL,
  `country_code` varchar(100) NOT NULL,
  `params` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `#__fvn_countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  `phone_code` varchar(5) DEFAULT NULL,
  `region_id` varchar(45) DEFAULT NULL,
  `intro` text NOT NULL,
  `flag` varchar(200) NOT NULL,
  `image_map` varchar(200) NOT NULL,
  `continent_code` varchar(2) DEFAULT NULL,
  `description` text,
  `params` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__fvn_countries` (`id`, `country_code`, `country_name`, `phone_code`, `region_id`, `intro`, `flag`, `image_map`, `continent_code`, `description`, `params`) VALUES
(1, 'US', 'United States', NULL, NULL, '<p>sdas</p>', '', '', 'NA', NULL, NULL),
(2, 'CA', 'Canada', '2', NULL, '', '', '', 'NA', NULL, NULL),
(3, 'AF', 'Afghanistan', '', '13', '', '', '', 'AS', NULL, NULL),
(4, 'AL', 'Albania', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(5, 'DZ', 'Algeria', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(6, 'DS', 'American Samoa', NULL, NULL, '', '', '', '', NULL, NULL),
(7, 'AD', 'Andorra', NULL, NULL, '', '', '', '', NULL, NULL),
(8, 'AO', 'Angola', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(9, 'AI', 'Anguilla', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(10, 'AQ', 'Antarctica', NULL, NULL, '', '', '', '', NULL, NULL),
(11, 'AG', 'Antigua and Barbuda', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(12, 'AR', 'Argentina', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(13, 'AM', 'Armenia', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(14, 'AW', 'Aruba', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(15, 'AU', 'Australia', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(16, 'AT', 'Austria', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(17, 'AZ', 'Azerbaijan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(18, 'BS', 'Bahamas', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(20, 'BD', 'Bangladesh', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(21, 'BB', 'Barbados', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(22, 'BY', 'Belarus', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(23, 'BE', 'Belgium', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(24, 'BZ', 'Belize', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(25, 'BJ', 'Benin', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(26, 'BM', 'Bermuda', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(27, 'BT', 'Bhutan', NULL, NULL, '', '', '', '', NULL, NULL),
(28, 'BO', 'Bolivia', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(29, 'BA', 'Bosnia Herzegovina', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(30, 'BW', 'Botswana', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(31, 'BV', 'Bouvet Island', NULL, NULL, '', '', '', '', NULL, NULL),
(32, 'BR', 'Brazil', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(33, 'IO', 'British lndian Ocean Territory', NULL, NULL, '', '', '', '', NULL, NULL),
(34, 'BN', 'Brunei', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(35, 'BG', 'Bulgaria', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(36, 'BF', 'Burkina Faso', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(37, 'BI', 'Burundi', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(38, 'KH', 'Cambodia', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(39, 'CM', 'United Republic Of Cameroon', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(40, 'CV', 'CAPE VERDE', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(41, 'KY', 'Cayman Islands', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(42, 'CF', 'Central African Republic', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(43, 'TD', 'Chad', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(44, 'CL', 'Chile', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(45, 'CN', 'China', NULL, NULL, '', '', '', 'DB', NULL, NULL),
(46, 'CX', 'Christmas Island', NULL, NULL, '', '', '', '', NULL, NULL),
(47, 'CC', 'Cocos (Keeling) Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(48, 'CO', 'Colombia', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(49, 'KM', 'Comoros', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(50, 'CG', 'Congo', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(51, 'CK', 'Cook Islands', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(52, 'CR', 'COSTA RICA', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(53, 'HR', 'Croatia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(54, 'CU', 'Cuba', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(55, 'CY', 'Cyprus', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(56, 'CZ', 'Czech Republic', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(57, 'DK', 'Denmark', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(58, 'DJ', 'Djibouti', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(59, 'DM', 'Dominican Republic', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(60, 'DO', 'Dominican Republic', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(61, 'TP', 'East Timor', NULL, NULL, '', '', '', '', NULL, NULL),
(62, 'EC', 'Ecuador', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(63, 'EG', 'Egypt', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(64, 'SV', 'El Salvador', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(65, 'GQ', 'Equatorial Guinea', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(66, 'ER', 'Eritrea', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(67, 'EE', 'Estonia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(68, 'ET', 'Ethiopia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(69, 'FK', 'FALKLAND ISLANDS', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(70, 'FO', 'Faroe Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(71, 'FJ', 'Fiji Islands', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(72, 'FI', 'Finland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(73, 'FR', 'France', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(74, 'FX', 'France, Metropolitan', NULL, NULL, '', '', '', '', NULL, NULL),
(75, 'GF', 'French Guiana', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(76, 'PF', 'French Polynesia', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(77, 'TF', 'French Southern Territories', NULL, NULL, '', '', '', '', NULL, NULL),
(78, 'GA', 'Gabon', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(79, 'GM', 'Gambia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(80, 'GE', 'Georgia', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(81, 'DE', 'Germany', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(82, 'GH', 'Ghana', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(83, 'GI', 'Gibraltar', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(84, 'GR', 'Greece', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(85, 'GL', 'Greenland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(86, 'GD', 'Grenada', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(87, 'GP', 'Guadeloupe', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(88, 'GU', 'Guam', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(89, 'GT', 'Guatemala', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(90, 'GN', 'Guinea', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(91, 'GW', 'Guinea Bissau', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(92, 'GY', 'Guyana', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(93, 'HT', 'HAITI', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(94, 'HM', 'Heard and Mc Donald Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(95, 'HN', 'Honduras', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(96, 'HK', 'Hong Kong', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(97, 'HU', 'Hungary', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(98, 'IS', 'Iceland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(99, 'IN', 'India', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(100, 'ID', 'Indonesia', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(101, 'IR', 'Iran', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(102, 'IQ', 'Iraq', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(103, 'IE', 'Republic of Ireland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(104, 'IL', 'Israel', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(105, 'IT', 'Italy', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(106, 'CI', 'Ivory Coast', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(107, 'JM', 'Jamaica', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(108, 'JP', 'Japan', NULL, NULL, '', '', '', 'DB', NULL, NULL),
(109, 'JO', 'Jordan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(110, 'KZ', 'Kazakstan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(111, 'KE', 'Kenya', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(112, 'KI', 'Kiribati', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(113, 'KP', 'Korea (North)', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(114, 'KR', 'Korea', NULL, NULL, '', '', '', 'DB', NULL, NULL),
(115, 'KW', 'Kuwait', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(116, 'KG', 'Kyrgyzstan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(117, 'LA', 'Lao, People\'s Dem. Rep.', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(118, 'LV', 'Latvia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(119, 'LB', 'Lebanon', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(120, 'LS', 'Lesotho', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(121, 'LR', 'Liberia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(122, 'LY', 'Libya', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(123, 'LI', 'Liechtenstein', NULL, NULL, '', '', '', '', NULL, NULL),
(124, 'LT', 'Lithuania', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(125, 'LU', 'Luxembourg', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(126, 'MO', 'Macau', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(127, 'MK', 'Macedonia F Y R O M', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(128, 'MG', 'Madagascar', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(129, 'MW', 'Malawi', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(130, 'MY', 'Malaysia', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(131, 'MV', 'Maldives', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(132, 'ML', 'Mali', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(133, 'MT', 'Malta', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(134, 'MH', 'MARSHALL ISLANDS', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(135, 'MQ', 'Martinique', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(136, 'MR', 'Mauritania', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(137, 'MU', 'Mauritius', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(138, 'TY', 'Mayotte', NULL, NULL, '', '', '', '', NULL, NULL),
(139, 'MX', 'MEXICO', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(140, 'FM', 'Micronesia', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(141, 'MD', 'Moldova', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(142, 'MC', 'MONACO', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(143, 'MN', 'Mongolia', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(144, 'MS', 'Montserrat', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(145, 'MA', 'Morocco', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(146, 'MZ', 'Mozambique', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(147, 'MM', 'Myanmar', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(148, 'NA', 'Namibia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(149, 'NR', 'Nauru', NULL, NULL, '', '', '', '', NULL, NULL),
(150, 'NP', 'Nepal', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(151, 'NL', 'Netherlands', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(152, 'AN', 'Netherland Antilles', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(153, 'NC', 'New Caledonia', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(154, 'NZ', 'New Zealand', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(155, 'NI', 'Nicaragua', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(156, 'NE', 'Niger', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(157, 'NG', 'Nigeria', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(158, 'NU', 'Niue', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(159, 'NF', 'Norfork Island', NULL, NULL, '', '', '', '', NULL, NULL),
(160, 'MP', 'Northern Mariana Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(161, 'NO', 'Norway', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(162, 'OM', 'Oman', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(163, 'PK', 'Pakistan', '', '13', '', '', '', 'AS', NULL, NULL),
(164, 'PW', 'Palau', NULL, NULL, '', '', '', '', NULL, NULL),
(165, 'PA', 'Panama', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(166, 'PG', 'Papua New Guinea (Niugini)', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(167, 'PY', 'Paraguay', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(168, 'PE', 'Peru', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(169, 'PH', 'Philippines', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(170, 'PN', 'Pitcairn', NULL, NULL, '', '', '', '', NULL, NULL),
(171, 'PL', 'Poland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(172, 'PT', 'Portugal', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(173, 'PR', 'PUERTO RICO', NULL, NULL, '', '', '', 'NA', NULL, NULL),
(174, 'QA', 'Qatar', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(175, 'RE', 'Reunion', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(176, 'RO', 'Romania', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(177, 'RU', 'Russia', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(178, 'RW', 'Rwanda', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(179, 'KN', 'Saint Kitts and Nevis', NULL, NULL, '', '', '', '', NULL, NULL),
(180, 'LC', 'Saint Lucia', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(181, 'VC', 'Saint Vincent and the Grenadines', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(182, 'WS', 'Independent State Of Samoa', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(183, 'SM', 'San Marino', NULL, NULL, '', '', '', '', NULL, NULL),
(184, 'ST', 'Sao Tome and Principe', NULL, NULL, '', '', '', '', NULL, NULL),
(185, 'SA', 'Saudi Arabia', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(186, 'SN', 'Senegal', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(187, 'SC', 'Seychelles Islands', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(188, 'SL', 'Sierra Leone', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(189, 'SG', 'Singapore', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(190, 'SK', 'Slovakia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(191, 'SI', 'Slovenia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(192, 'SB', 'Solomon Islands', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(193, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(194, 'ZA', 'South Africa', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(195, 'GS', 'South Georgia South Sandwich Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(196, 'ES', 'Spain', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(197, 'LK', 'Sri Lanka', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(198, 'SH', 'St. Helena', NULL, NULL, '', '', '', '', NULL, NULL),
(199, 'PM', 'St. Pierre and Miquelon', NULL, NULL, '', '', '', '', NULL, NULL),
(200, 'SD', 'Sudan', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(201, 'SR', 'Suriname', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(202, 'SJ', 'Svalbarn and Jan Mayen Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(203, 'SZ', 'Swaziland', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(204, 'SE', 'Sweden', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(205, 'CH', 'Switzerland', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(206, 'SY', 'Syria', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(207, 'TW', 'Taiwan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(208, 'TJ', 'Tajikistan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(209, 'TZ', 'Tanzania', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(210, 'TH', 'Thailand', NULL, NULL, '', '', '', 'DA', NULL, NULL),
(211, 'TG', 'Togo', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(212, 'TK', 'Tokelau', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(213, 'TO', 'Tonga', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(214, 'TT', 'Trinidad and Tobago', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(215, 'TN', 'Tunisia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(216, 'TR', 'Turkey', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(217, 'TM', 'Turkmenistan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(218, 'TC', 'Turks and Caicos Islands', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(219, 'TV', 'Tuvalu', NULL, NULL, '', '', '', '', NULL, NULL),
(220, 'UG', 'Uganda', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(221, 'UA', 'Ukraine', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(222, 'AE', 'United Arab Emirates', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(223, 'GB', 'United Kingdom', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(224, 'UM', 'United States minor outlying islands', NULL, NULL, '', '', '', '', NULL, NULL),
(225, 'UY', 'Uruguay', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(226, 'UZ', 'Uzbekistan', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(227, 'VU', 'Vanuatu', NULL, NULL, '', '', '', 'OC', NULL, NULL),
(228, 'VA', 'Vatican City State', NULL, NULL, '', '', '', '', NULL, NULL),
(229, 'VE', 'Venezuela', '', '14', '', '', '', 'SA', NULL, NULL),
(230, 'VN', 'Viá»‡t Nam', '', '84', '', '', '', 'VN', NULL, NULL),
(231, 'VG', 'British Virgin Islands', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(232, 'VI', 'Virgin Islands', NULL, NULL, '', '', '', 'SA', NULL, NULL),
(233, 'WF', 'Wallis and Futuna Islands', NULL, NULL, '', '', '', '', NULL, NULL),
(234, 'EH', 'Western Sahara', NULL, NULL, '', '', '', '', NULL, NULL),
(235, 'YE', 'Yemen', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(236, 'YU', 'Yugoslavia', NULL, NULL, '', '', '', '', NULL, NULL),
(237, 'ZR', 'Zaire', NULL, NULL, '', '', '', '', NULL, NULL),
(238, 'ZM', 'Zambia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(239, 'ZW', 'Zimbabwe', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(240, 'BH', 'Bahrain', NULL, NULL, '', '', '', 'AS', NULL, NULL),
(241, 'CD', 'Democratic Republic Of Congo', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(243, 'ME', 'Montenegro', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(244, 'RS', 'Serbia', NULL, NULL, '', '', '', 'EU', NULL, NULL),
(245, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(246, 'YT', 'Mayotte', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(248, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(250, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(252, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(254, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(256, 'SO', 'Somalia', NULL, NULL, '', '', '', 'AF', NULL, NULL),
(258, 'SO', 'SOTO', NULL, NULL, '', '', '', 'SO', NULL, NULL);


CREATE TABLE `#__fvn_orders` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `order_number` varchar(32) DEFAULT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) DEFAULT NULL,
  `pay_method` varchar(100) NOT NULL,
  `pay_status` varchar(20) DEFAULT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(4) NOT NULL,
  `notes` text NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  `tax` varchar(45) DEFAULT NULL,
  `service_fee` varchar(2000) DEFAULT NULL,
  `order_status` varchar(20) NOT NULL,
  `tx_id` varchar(100) NOT NULL,
  `deposit` decimal(15,2) DEFAULT NULL,
  `params` text NOT NULL,
  `agent_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL DEFAULT '',
  `country_id` int(11) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  `start` date NOT NULL,
  `end` varchar(5) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `adult` tinyint(11) NOT NULL DEFAULT '0',
  `period_id` int(11) NOT NULL,
  `purpose_of_visit` varchar(10) NOT NULL,
  `processing_time` tinyint(1) NOT NULL DEFAULT '0',
  `country_code` varchar(2) DEFAULT '',
  `private_later` tinyint(1) NOT NULL,
  `airport_id` int(11) NOT NULL,
  `start_time` varchar(5) NOT NULL,
  `title` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `#__fvn_passengers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `passport` varchar(50) NOT NULL,
  `ppvalid` date NOT NULL,
  `birthday` date NOT NULL,
  `order_id` int(11) NOT NULL,
  `country_code` varchar(2) DEFAULT '',
  `group_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `passport_image` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `#__fvn_periods` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `params` text,
  `description` varchar(5000) NOT NULL,
  `price_tour` decimal(10,2) DEFAULT NULL,
  `price_bus` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `#__fvn_periods` (`id`, `name`, `params`, `description`, `price_tour`, `price_bus`) VALUES
(1, '1 month single', '', '', '12.00', '60.00'),
(2, '1 month multi', '', '', '23.00', '73.00'),
(5, '3 month single', '', '', '25.00', '90.00'),
(6, '3 months multi', '', '', '32.00', '105.00');

-- --------------------------------------------------------

--
-- Table structure for table `#__fvn_processing_times`
--

CREATE TABLE `#__fvn_processing_times` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price_tour` decimal(15,2) DEFAULT NULL,
  `description` varchar(5000) NOT NULL,
  `price_bus` decimal(15,2) DEFAULT NULL,
  `verify_image` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `#__fvn_processing_times`
--

INSERT INTO `#__fvn_processing_times` (`id`, `name`, `price_tour`, `description`, `price_bus`, `verify_image`) VALUES
(8, 'Normal (Guaranteed 2 working days)', '0.00', 'We guarantee delivery of approval letter in 2 working days by email.', '0.00', 0),
(10, 'Urgent (Guaranteed 8 working hours)', '19.00', 'It is effective for who needs visa in emergency. We will send the approval letter by email in 8 hours. If you apply on a Saturday, Sunday or holiday, it will be processed the next business day.', '35.00', 1),
(11, 'Urgent (Guaranteed 4 working hours)', '35.00', 'It is effective for who needs visa in emergency. We will send the approval letter by email in 4 hours. If you apply on a Saturday, Sunday or holiday, it will be processed the next business day.', '45.00', 0),
(12, 'Urgent (Guaranteed 1 working hours)', '55.00', 'Similar to Urgent option except it only takes 60 minutes. You should call our hotline +84.911 413 937 to confirm the application has been received and acknowledged to process immediately. You are subject to pay stamping fee at the airports. (You can apply supper urgent case on weekend/holiday for arrival date is next Monday or next business day.)', '60.00', 1),
(13, 'Emergency (Within 30 minutes)', '90.00', 'Similar to Urgent option except it only takes 60 minutes. You should call our hotline +84.911 413 937 to confirm the application has been received and acknowledged to process immediately. You are subject to pay stamping fee at the airports. (You can apply supper urgent case on weekend/holiday for arrival date is next Monday or next business day.)', '100.00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__fvn_airports`
--
ALTER TABLE `#__fvn_airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `#__fvn_countries`
--
ALTER TABLE `#__fvn_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `#__fvn_orders`
--
ALTER TABLE `#__fvn_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `#__fvn_passengers`
--
ALTER TABLE `#__fvn_passengers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `#__fvn_periods`
--
ALTER TABLE `#__fvn_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `#__fvn_processing_times`
--
ALTER TABLE `#__fvn_processing_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__fvn_airports`
--
ALTER TABLE `#__fvn_airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `#__fvn_countries`
--
ALTER TABLE `#__fvn_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;
--
-- AUTO_INCREMENT for table `#__fvn_orders`
--
ALTER TABLE `#__fvn_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `#__fvn_passengers`
--
ALTER TABLE `#__fvn_passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `#__fvn_periods`
--
ALTER TABLE `#__fvn_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `#__fvn_processing_times`
--
ALTER TABLE `#__fvn_processing_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;COMMIT;
