
# Table structure for table `accounts`


DROP TABLE IF EXISTS accounts;
CREATE TABLE IF NOT EXISTS accounts (
  account_number INT(11) NOT NULL DEFAULT '0',
  firstname VARCHAR(50) NOT NULL DEFAULT '',
  lastname VARCHAR(50) NOT NULL DEFAULT '',
  balance DECIMAL(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY  (account_number)
) ENGINE=InnoDB COMMENT='For Ch 7 transactions examples';


# Dumping data for table `accounts`


INSERT INTO accounts (account_number, firstname, lastname, balance) VALUES (6557, 'Gerald', 'Roberts', 2052.92);
INSERT INTO accounts (account_number, firstname, lastname, balance) VALUES (8510, 'Morris', 'Johnson', 1726.21);
