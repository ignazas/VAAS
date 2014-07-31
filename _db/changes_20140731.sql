-- phpMyAdmin SQL Dump
-- version 2.11.10
-- http://www.phpmyadmin.net
--
-- Darbinë stotis: localhost
-- Atlikimo laikas:  2014 m. Liepos 31 d.  08:42
-- Serverio versija: 4.0.27
-- PHP versija: 4.4.9


--
-- Duombazë: `mindaug_vak`
--

-- --------------------------------------------------------

--
-- Sukurta duomenø struktûra lentelei `vak_aircrafts`
--

CREATE TABLE IF NOT EXISTS `vak_aircrafts` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `reg_num` varchar(20) NOT NULL default '',
  `manuf_date` date default NULL,
  `serial_num` varchar(15) NOT NULL default '',
  `first_pilot` varchar(40) NOT NULL default '',
  `second_pilot` varchar(40) NOT NULL default '',
  `third_pilot` varchar(40) NOT NULL default '',
  `remarks` varchar(200) NOT NULL default '',
  `moh_date` date default NULL,
  `time_since_new` decimal(10,2) NOT NULL default '0.00',
  `flights_since_new` decimal(10,0) NOT NULL default '0',
  `time_since_mo` decimal(10,2) default NULL,
  `flights_since_mo` decimal(10,0) default NULL,
  `time_left` decimal(10,2) default NULL,
  `flights_left` decimal(10,0) default NULL,
  `time_last_year` decimal(10,2) default NULL,
  `flights_last_year` decimal(10,0) default NULL,
  `coa_expiry_date` date default NULL,
  `civ_insur_expiry_date` date default NULL,
  `kasko_insur_expiry_date` date default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=40 ;

--
-- Sukurta duomenø kopija lentelei `vak_aircrafts`
--

INSERT INTO `vak_aircrafts` (`id`, `name`, `reg_num`, `manuf_date`, `serial_num`, `first_pilot`, `second_pilot`, `third_pilot`, `remarks`, `moh_date`, `time_since_new`, `flights_since_new`, `time_since_mo`, `flights_since_mo`, `time_left`, `flights_left`, `time_last_year`, `flights_last_year`, `coa_expiry_date`, `civ_insur_expiry_date`, `kasko_insur_expiry_date`) VALUES
(1, 'L-13 Blanik', 'LY-GAU', '1978-06-20', '027151', '', '', '', '', '1990-03-26', 1735.41, 5366, 1072.04, 1778, NULL, NULL, 45.48, 51, '2007-05-06', NULL, NULL),
(2, 'SZD-48-3 Jant Std. 3', 'LY-GBG', '1983-04-29', 'B-1283', 'A.Radþiûnas', 'T. Kuzmickas', '', '', NULL, 1723.07, 798, NULL, NULL, 1276.53, NULL, 71.88, 22, '2007-05-06', NULL, NULL),
(3, 'L-13 Blanik', 'LY-GJF', '1978-01-01', '027311', '', '', '', '', '1988-01-01', 1414.27, 2101, 414.27, NULL, 585.33, NULL, 53.36, 69, '2007-07-03', NULL, NULL),
(4, '', '', '1978-06-09', '', '', '', '', '', '1985-11-30', 1472.49, 2957, 653.44, NULL, 346.16, NULL, 12.14, 16, '2007-07-03', NULL, NULL),
(5, 'SZD-48-2 Jant Std. 2', 'LY-GBF', '1982-08-28', 'B-1235', 'M.Milaðauskas', 'A.Lebedev', '', '', NULL, 1576.50, 618, NULL, NULL, 1423.10, NULL, 75.53, 20, '2007-05-06', NULL, NULL),
(6, 'SZD-48-3 Jant Std. 3', 'LY-GBI', '1984-08-24', 'B-1423', 'J.Vainius', '', '', '', NULL, 1014.20, 563, NULL, NULL, 1985.40, NULL, 107.88, 32, '2007-05-06', NULL, NULL),
(27, 'LAK-12 Lietuva', 'LY-GBB', '1988-01-01', '6147', 'G.Ðlepikas', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'SZD-48-3 Jant Std. 3', 'LY-GBK', '1988-10-28', 'B-1763', 'V. Berþinskas', 'D.Povilionis', '', '', NULL, 800.21, 309, NULL, NULL, 2199.39, NULL, 95.27, 28, '2007-05-06', NULL, NULL),
(8, 'SZD-48-3 Jant Std. 3', 'LY-GBH', '1984-08-25', 'B-1422', '', '', '', 'Palauþtas', NULL, 993.19, 464, NULL, NULL, 2006.41, NULL, 64.95, 20, '2007-05-06', NULL, NULL),
(9, 'G-103 Twin Astir', 'LY-GTA', '1978-01-01', '3135', '', '', '', 'Parodomasis / Treniruoèiø', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'L-13 Blanik', 'LY-GAK', '1970-05-29', '174513', '', '', '', '', '1982-12-02', 1443.17, 2371, 445.07, NULL, 554.53, NULL, 13.32, 10, '2007-07-03', NULL, NULL),
(11, 'SZD-50-3 Puchacz', 'LY-GBM', '1983-01-06', 'B-1078', 'A.Paradnikas', 'V.Januðonis', '', '', NULL, 584.31, 582, NULL, NULL, 2415.29, NULL, 38.42, 21, '2007-05-06', NULL, NULL),
(12, 'SZD-41-A Jant Std. 1', 'LY-GJU', '1977-01-01', 'B-748', 'J. Kazlauskas', 'D.Gudþiûnas', '', '', '1992-06-16', 949.58, 441, 512.38, 231, 2050.02, NULL, 69.30, 32, '2007-05-13', NULL, NULL),
(13, 'SZD-42-2  Jantar 2B', 'LY-GBL', '1984-01-01', 'B-868', 'Vl. Bivainis', 'E.Barkauskas', '', '', NULL, 903.42, 434, NULL, NULL, 2096.18, NULL, 11.70, 4, '2007-05-06', NULL, NULL),
(14, 'L-13 Blanik', 'LY-GAE', '1978-06-09', '027148', '', '', '', '', '1985-11-30', 2190.00, 2766, 998.51, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'L-13 Blanik', 'LY-GAL', '1975-10-20', '026444', '', '', '', '', '1992-03-10', 1695.04, 2720, 394.54, NULL, 605.06, NULL, 123.19, 577, '2006-10-01', NULL, NULL),
(16, 'L-13 Blanik', 'LY-GAQ', '1967-11-08', '173525', '', '', '', 'ruoðiamas', '1985-10-30', 2816.00, 3149, 322.59, NULL, 677.01, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'L-13 Blanik', 'LY-GAO', '1968-01-27', '173708', '', '', '', 'ruoðiamas', '1983-03-15', 1621.00, 3125, 111.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'LAK-12 Lietuva', 'LY-GAX', '1986-01-01', '675', '', '', '', 'neparuoðtas', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'LAK-12 Lietuva', 'LY-GBA', '1989-03-31', '6140', 'E.Jurkoit', 'R.Notkus', '', '', NULL, 292.00, 132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'L13 Blanik', 'LT-GAJ', '1970-05-28', '174514', '', '', '', 'neskraidantis', '1987-04-20', 1862.00, 3738, 366.12, NULL, 633.48, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'L13 Blanik', 'LY-GAG', '1970-05-15', '174508', '', '', '', 'neskraidantis', '1981-03-29', 1780.00, 3267, 588.00, NULL, 412.00, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'L13 Blanik', 'LY-GAH', '1970-05-15', '174511', '', '', '', 'neskraidantis', '1982-12-19', 1420.00, 928, 440.07, NULL, 559.53, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'L13 Blanik', 'LY-GAD', '1969-11-28', '174304', '', '', '', 'neskraidantis', '1982-12-13', 2195.00, 3925, 699.00, 301, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'L13 Blanik', 'LY-GAC', '1969-11-14', '174230', '', '', '', 'neskraidantis', '1982-12-10', 2223.00, 3850, 624.00, 376, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'L13 Blanik', 'LY-GAS', '1978-06-09', '027149', '', '', '', 'neskraidantis', '1984-01-01', 879.00, 1967, 283.31, NULL, 719.26, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'L13 Blanik', 'LY-GAM', '1975-10-20', '026445', '', '', '', 'neskraidantis', '1983-06-24', 1126.00, 3258, 576.25, NULL, 423.35, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'L13 Blanik', 'LY-GAN', '1975-06-27', '026446', '', '', '', 'neskraidantis', '1985-11-29', 1100.00, 1902, 300.30, 699, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'LAK-12 Lietuva', 'LY-GBC', '1989-01-01', '6151', 'A.Masiulis', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'LAK-12 Lietuva', 'LY-GAZ', '1988-01-01', '6118', 'A.Tamulënas', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'LAK-12 Lietuva', 'LY-GAW', '1985-01-01', '669', '', '', '', 'neparuoðtas', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Wilga 35A', 'LY-AGB', NULL, '15810581', '', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'Wilga 35A', 'LY-AGD', NULL, '18830743', '', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Wilga 35A', 'LY-AGE', NULL, '18840793', '', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'L-13 Blanik', 'LY-GAV', NULL, '', '', '', '', 'nuraðymui', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'Lak-12 Lietuva', 'LY-GJG', NULL, '6012', 'R.Urbonavièius', '', '', '', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'SZD-9bis 1E Bocian', 'LY-BOC', NULL, 'P-559', '', '', '', 'palauþtas', NULL, 0.00, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

ALTER TABLE `flights` CHANGE `airplane_registration` `airplane_id` INT NULL;

DROP TABLE `zadmin_vanza2`.`aircrafts`;
