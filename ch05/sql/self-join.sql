# 
# Table structure for table `employees`
# 

DROP TABLE IF EXISTS employees;
CREATE TABLE IF NOT EXISTS employees (
  employee_id INT(11) NOT NULL AUTO_INCREMENT,
  supervisor_id INT(11) DEFAULT NULL,
  firstname VARCHAR(50) NOT NULL DEFAULT '',
  lastname VARCHAR(50) NOT NULL DEFAULT '',
  PRIMARY KEY  (employee_id)
) COMMENT='Table for Ch. 5 self-join example';

# 
# Dumping data for table `employees`
# 

INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (1, NULL, 'Nora', 'Doe');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (2, 1, 'James', 'Wu');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (3, 1, 'Nancy', 'Beck');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (4, 2, 'Al', 'Smith');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (5, 2, 'Mary', 'Lester');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (6, 3, 'Alice', 'Ramone');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (7, 4, 'Bernie', 'Jones');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (8, 6, 'Ted', 'Knight');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (9, 8, 'Jill', 'Davis');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (10, 8, 'Anne', 'Cantor');
INSERT INTO employees (employee_id, supervisor_id, firstname, lastname) VALUES (11, 8, 'Scott', 'Mason');
