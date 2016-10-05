# student-tables.sql
# 

CREATE TABLE classes (
  class_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  instructor_id INT(11) NOT NULL DEFAULT '0',
  name VARCHAR(50) NOT NULL DEFAULT '',
  hours INT(1) NOT NULL DEFAULT '0'
);


CREATE TABLE courses (
  course_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL DEFAULT ''
);

CREATE TABLE instructors (
  instructor_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  course_id INT(11) NOT NULL DEFAULT '0',
  firstname VARCHAR(50) NOT NULL DEFAULT '',
  lastname VARCHAR(50) NOT NULL DEFAULT ''
);

CREATE TABLE students (
  student_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(50) NOT NULL DEFAULT '',
  lastname VARCHAR(50) NOT NULL DEFAULT '',
  sex ENUM('M','F') NOT NULL DEFAULT 'M',
  dob DATE NOT NULL DEFAULT '0000-00-00'
);

CREATE TABLE students_classes (
  student_id INT(11) NOT NULL DEFAULT '0',
  class_id INT(11) NOT NULL DEFAULT '0',
  semester ENUM('FALL','SPRING','SUMMER') NOT NULL DEFAULT 'FALL',
  year INT(4) NOT NULL DEFAULT '2005',
  grade INT(1) DEFAULT NULL,
  PRIMARY KEY (student_id,class_id,semester,year)
);

# Note: For the grade column, we assume that the US system is being used:
# A = 4, B = 3, C = 2, D = 1, F = 0; for our purposes we'll assume that
# a value of NULL represents incomplete status (class in progress, etc.)

CREATE TABLE students_courses (
  student_id INT(11) NOT NULL DEFAULT '0',
  course_id INT(11) NOT NULL DEFAULT '0',
  type ENUM('MAJOR','MINOR') NOT NULL DEFAULT 'MAJOR',
  PRIMARY KEY (student_id,course_id)
);