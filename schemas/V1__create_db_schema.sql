CREATE TABLE `db_schema` (
    `version` bigint(20) NOT NULL,
    `timestamp` datetime NOT NULL DEFAULT NOW(),
    PRIMARY KEY (`version`)
) ENGINE=InnoDB CHARSET=utf8;

