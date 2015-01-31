create table `t_user`(
	`username` varchar(10) NOT NULL,
	`password` char(32) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `t_order`(
	`id` int(10) NOT NULL,
	`item` varchar(40) NOT NULL,
	`create_time` DATETIME NOT NULL,
	`username` varchar(10) NOT NULL,
	PRIMARY KEY (`item`),
	key `username` (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `t_char`(
	`id` int(10) NOT NULL,
	`chars` varchar(40) NOT NULL,
	`create_time` DATETIME NOT NULL,
	`username` varchar(10) NOT NULL,
	PRIMARY KEY (`chars`),
	key `username` (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `t_user` VALUES('admin','21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `t_user` VALUES('test','098f6bcd4621d373cade4e832627b4f6');
INSERT INTO `t_user` VALUES('demo','fe01ce2a7fbac8fafaed7c982a04e229');