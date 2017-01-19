# Changing missed_parts table to use groups_id instead of group_id.
#
DROP PROCEDURE IF EXISTS change_missed_parts;
DELIMITER $$
CREATE PROCEDURE change_missed_parts()
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE _table CHAR(255);
    DECLARE _stmt VARCHAR(1000);
    DECLARE cur1 CURSOR FOR
      SELECT TABLE_NAME
      FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = DATABASE()
            AND (TABLE_NAME LIKE "missed_parts\_%" OR TABLE_NAME = "missed_parts");
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN cur1;
    myloop: LOOP FETCH cur1
    INTO _table;
      IF done
      THEN LEAVE myloop; END IF;
      SET @sql1 := CONCAT("ALTER TABLE ", _table,
                          " CHANGE COLUMN group_id groups_id INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to groups.id'");
      PREPARE _stmt FROM @sql1;
      EXECUTE _stmt;
      DROP PREPARE _stmt;
    END LOOP;
    CLOSE cur1;
  END $$
DELIMITER ;

CALL change_missed_parts();
DROP PROCEDURE change_missed_parts;

