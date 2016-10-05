#!user/bin/local/python
# change to match your system's path to Python if need be

# FILE: simple-select-2.py -- fetching one row at a time (Ch 7)

import MySQLdb

# connect to MySQL
db = MySQLdb.connect(host="localhost", user="jon", passwd="eleanor", db="mdbd")

# create a new cursor; use it to execute the query
cursor = db.cursor()

# define date value and query
date = "1980-06-15"
query = "SELECT firstname, lastname, dob FROM members WHERE dob < %s"

# execute the query
cursor.execute(query, (date,))

# fetch successive rows from the cursor, display them until none is returned
while 1:
  row = cursor.fetchone()
  if row is None:
    break
  print "NAME: %s %s; DOB: %s" % (row[0], row[1], row[2])

# close the cursor and the connection
cursor.close()
db.close()

# end