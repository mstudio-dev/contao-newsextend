-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

--
-- Table `tl_module`
--

CREATE TABLE `tl_module` (
  `skipX` smallint(5) unsigned NOT NULL default '0',
  `invertSortOrder` char(1) NOT NULL default '0',
  `sortBy` varchar(50) NOT NULL default 'date',
  `filterBy` varchar(50) NOT NULL default '-',
  `filterTerm` varchar(255) NOT NULL default '',
  `newsListedEndDate` char(11) NOT NULL default '',
  `newsListedInterval` varchar(200) NOT NULL default '',
  `addVisibilityPeriods` char(1) NOT NULL default '',
  `skipPeriod` varchar(200) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------