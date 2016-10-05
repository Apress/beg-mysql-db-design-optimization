#!user/bin/local/python

# FILE: multi-insert.py
# demonstrates how to perform multiple inserts using executemany()

# import MySQLdb module
import MySQLdb

# connect to MySQL, create a cursor
db = MySQLdb.connect(host="localhost", user="user", passwd="pass", db="mydb")
cursor = db.cursor()

# define INSERT query
query =  "INSERT INTO orders (firstname, lastname, amount, date) \
          VALUES (%s, %s, %s, %s)"

# values to be used in successive INSERTs
values = (
          ("Jim", "Williams", 125.55, "2004-03-15"), \
          ("Rachel", "Lewis", 227.80, "2004-03-18"), \
          ("John", "Lee", 72.05, "2004-03-12") \
         )

# execute values
cursor.executemany(query, values)

# get the ID of the last record to be inserted
last = cursor.insert_id()

# get the number of rows inserted
num = db.affected_rows()

# output these values
print "Last inserted id: %s; number of rows inserted: %s" % (last, num)

# close the cursor and then the database connection
cursor.close()
db.close()
# end