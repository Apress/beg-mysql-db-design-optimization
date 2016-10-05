#!user/bin/local/python

# FILE: simple-transaction.py
# demonstrates a simple transaction using MySQLdb
# NOTE: assumes that the accounts table is an InnoDB or
# other table type supporting transactions

# import the MySQLdb library
import MySQLdb

# the account numbers for the accounts we’ll be transferring funds between
account1 = "6557"
account2 = "8510"

# store these in an array (tuple)
accounts = [account1, account2]

# the amount to be transferred
amount = "75.00"

# query to obtain account balances
balance_query = "SELECT CONCAT(firstname, ' ', lastname), balance \
                 FROM accounts WHERE account_number = %s"

# queries to transfer funds
add_query = "UPDATE accounts SET balance = balance + %s \
             WHERE account_number=%s"

subtract_query = "UPDATE accounts SET balance = balance - %s \
                  WHERE account_number=%s"

# store these in an array (tuple)
transfer_queries = [add_query, subtract_query]

# connect to the database and select the accounts table
db = MySQLdb.connect(host="localhost", user="jon", passwd="eleanor", db="mdbd")

# check to see if AUTOCOMMIT is turned on; if it is, disable it for
# the duration of the transaction
cursor = db.cursor()
cursor.execute("SELECT @@AUTOCOMMIT", )
row = cursor.fetchone()
if row[0] == 1:
  db.begin()

# get the starting balances
print "-STARTING BALANCES-\n"
for account in accounts:
  cursor.execute(balance_query, (account,))
  row = cursor.fetchone()
  print "ACCOUNT #:%s\tNAME: %s\tBALANCE:%s" % (account, row[0], row[1])

print

# now perform the transfer
# if all goes well, do a commit and display the new balances;
# if any exception is raised, report it and do a rollback instead
try:
  for transfer_query, account in zip(transfer_queries, accounts):
    cursor.execute(transfer_query, (amount, account))
except Exception, e:
  print "Database error — transfer cancelled due to ", e
  db.rollback()
else:
  print "Transfer of %s was successful" % amount
  db.commit()

print "-ENDING BALANCES-\n"
for account in accounts:
  cursor.execute(balance_query, (account,))
  row = cursor.fetchone()
  print "ACCOUNT #:%s\tNAME: %s\tBALANCE:%s" % (account, row[0], row[1])

# close the cursor and the database connection
cursor.close()
db.close()

# end