CREATE TABLE `vendor_schedule_backup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint(20) DEFAULT NULL,
  `weekday` tinyint(4) DEFAULT NULL,
  `all_day` tinyint(3) DEFAULT NULL,
  `start_hour` time DEFAULT NULL,
  `stop_hour` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendor_backup` (`vendor_id`),
  CONSTRAINT `fk_vendor_backup` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


