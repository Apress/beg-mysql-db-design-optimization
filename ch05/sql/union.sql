# 
# Table structure for table `sales`
# 

DROP TABLE IF EXISTS sales;
CREATE TABLE IF NOT EXISTS sales (
  lastname VARCHAR(50) DEFAULT NULL,
  firstname VARCHAR(50) DEFAULT NULL
) COMMENT='For Ch. 5 UNION examples';

# 
# Dumping data for table `sales`
# 

INSERT INTO sales (lastname, firstname) VALUES ('Anderson', 'Jane');
INSERT INTO sales (lastname, firstname) VALUES ('Williams', 'Franklin');
INSERT INTO sales (lastname, firstname) VALUES ('Thomas', 'Jerry');
INSERT INTO sales (lastname, firstname) VALUES ('Miller', 'Lisette');
INSERT INTO sales (lastname, firstname) VALUES ('Roberts', 'Peter');
INSERT INTO sales (lastname, firstname) VALUES ('Yates', 'Mandy');
INSERT INTO sales (lastname, firstname) VALUES ('Bridges', 'Lucinda');
INSERT INTO sales (lastname, firstname) VALUES ('Griffith', 'George');
INSERT INTO sales (lastname, firstname) VALUES ('Fields', 'Hope');

# 
# Table structure for table `service_techs`
# 

DROP TABLE IF EXISTS service_techs;
CREATE TABLE IF NOT EXISTS service_techs (
  lastname VARCHAR(50) DEFAULT NULL,
  firstname VARCHAR(50) DEFAULT NULL
) COMMENT='For Ch. 5 UNION examples';

# 
# Dumping data for table `service_techs`
# 

INSERT INTO service_techs (lastname, firstname) VALUES ('Anderson', 'Jane');
INSERT INTO service_techs (lastname, firstname) VALUES ('Roberts', 'Denise');
INSERT INTO service_techs (lastname, firstname) VALUES ('Thomas', 'Jerry');
INSERT INTO service_techs (lastname, firstname) VALUES ('Norton', 'Steve');
INSERT INTO service_techs (lastname, firstname) VALUES ('Nelson', 'Mike');
INSERT INTO service_techs (lastname, firstname) VALUES ('Griffith', 'George');
