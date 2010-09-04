CREATE TABLE IF NOT EXISTS `itsp_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `crdate` int(11) NOT NULL,
  `tstamp` int(11) NOT NULL,
  `deleted` int(1) NOT NULL default '0',
  `sorting` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `progress` int(3) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `deleted` (`deleted`),
  KEY `sorting` (`sorting`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `itsp_urls` (
  `id` int(11) NOT NULL auto_increment,
  `crdate` int(11) NOT NULL,
  `params` text NOT NULL,
  `url` text NOT NULL,
  `hash` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `params` (`params`(50),`url`(50)),
  FULLTEXT KEY `hash` (`hash`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `itsp_users` (
  `id` int(11) NOT NULL auto_increment,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `reset` text NOT NULL,
  `session` text NOT NULL,
  `realname` text NOT NULL,
  `email` text NOT NULL,
  `verified` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`(50),`password`(50)),
  KEY `session` (`session`(100))
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `itsp_usersettings` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `field` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `field` (`field`(25))
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `itsp_userstasks` (
  `userid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  KEY `userid` (`userid`),
  KEY `projectid` (`taskid`)
) ENGINE=MyISAM;
