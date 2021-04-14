-- Triggers on ADMIN Table

DELIMITER $$
CREATE TRIGGER beforeInsertAdmin -- for automatic insertion of admin_id
  BEFORE INSERT ON admin 
  FOR EACH ROW
  SET new.admin_id = LEFT(uuid(),8);
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER afterInsertAdmin
	AFTER INSERT ON admin
    FOR EACH ROW
    INSERT INTO id_log VALUES(new.admin_id);
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER afterDeleteAdmin
	AFTER DELETE ON admin
    FOR EACH ROW
    DELETE FROM id_log WHERE id = old.admin_id;
$$
DELIMITER ;

-- Triggers on Alumni Table

DELIMITER $$
CREATE TRIGGER afterInsertAlumni
	AFTER INSERT ON alumni
    FOR EACH ROW
    INSERT INTO id_log VALUES(new.alumni_id);
$$
DELIMITER ;

CREATE TRIGGER afterDeleteAlumni
	AFTER DELETE ON alumni
    FOR EACH ROW
    DELETE FROM id_log WHERE id = old.alumni_id;
$$
DELIMITER ;
