#!user/bin/local/python
# modify above to match the path to python on your system if needed

# FILE: simple-select.py
# simple Python script using MySQLdb module to perform
# a SELECT query and retrieve the results

# tested using ActivePython 2.3.2.232 / MySQL 5.0.1-alpha / MySQLdb 1.0

# NOTE: MySQLdb doesn't yet (as of version 1.0) support the improved encryption
# used by MySQL 4.1+ for authenticating clients; see "Using Older Clients with
# MySQL 4.1 and 5.0" in Ch 7 of the book or consult the MySQL Manual if this is
# an issue for you

#import the MySQLdb module
import MySQLdb

# establish connection to MySQL
db = MySQLdb.connect(host="localhost", user="user", passwd="pass", db="mydb")

cursor = db.cursor() # create a new cursor

date = "1980-06-15"
query = "SELECT firstname, lastname, dob FROM members WHERE dob < %s"

cursor.execute(query, (date,)) # parameters must be passed as a sequence
result = cursor.fetchall() # obtain the result

# the result set is just a tuple of tuples:
print "%s columns in result set..." % len(result[0])
print "%s records were returned..." % len(result)

# now output the column values from each row, one row per line
for row in result:
  print "NAME: %s %s; DOB: %s" % (row[0], row[1], row[2])

# free cursor
cursor.close()

# free connection
db.close()

# end

# NOTE: Be sure to see the Python DB API specification at http://www.python.org/peps/pep-0249.html
# if you haven't worked with databases in Python before.