# table creation and population script for products/catepories, Ch 8

# Table structure for table `categories`
# 

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
  id int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# 
# Data for table `categories`
# 

INSERT INTO categories (id, name) VALUES ('', 'Home Study');
INSERT INTO categories (id, name) VALUES ('', 'Kitchen and Cookware');
INSERT INTO categories (id, name) VALUES ('', 'Sporting Equipment');
INSERT INTO categories (id, name) VALUES ('', 'Entertainment');

# 
# Table structure for table `products`
# 

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
  id int(11) NOT NULL auto_increment,
  category_id int(11) NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  price decimal(6,2) NOT NULL default '0.00',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# 
# Data for table `products`
# 

INSERT INTO products (id, category_id, name, price) VALUES ('', 2, 'Souper Soup Dehydrator', 24.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 4, 'Ants Ants Revolution', 16.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 2, 'Churn-O-Bill Butter Churn', 18.00);
INSERT INTO products (id, category_id, name, price) VALUES ('', 2, 'Congeal-O-Meal', 22.50);
INSERT INTO products (id, category_id, name, price) VALUES ('', 3, 'Thrash-O-Matic', 49.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 2, 'Gas-Powered Turnip Slicer', 22.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 4, 'Personal Breathalyser', 68.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 1, 'INTERCAL Home Study Course', 39.95);
INSERT INTO products (id, category_id, name, price) VALUES ('', 3, 'Bass Blaster Fishing Mortar', 79.95);
