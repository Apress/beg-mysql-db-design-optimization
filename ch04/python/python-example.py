#!/usr/bin/python
import cgi
import MySQLdb

# connect to MySQL and create a cursor
db = MySQLdb.connect(host="localhost", user="zontar", passwd="mypass", db="mdbd")
cursor = db.cursor(cursorclass=MySQLdb.cursors.DictCursor)

# the same query used in the "improved" PHP 4 example
query =  "SELECT \
            CONCAT(firstname, ' ', lastname) AS name, \
            CASE \
              WHEN (@age:=YEAR(CURRENT_DATE) - YEAR(dob)) > 65 THEN 'Over 65' \
              WHEN @age >= 45 THEN '45-64' \
              WHEN @age >= 30 THEN '30-44' \
              WHEN @age >= 18 THEN '18-29' \
              ELSE 'Under 18' \
              END AS age_range \
          FROM members \
          ORDER BY lastname, firstname"

# submit the query and store the resultset
cursor.execute(query)
result = cursor.fetchall()

# begin HTML output
print "Content-Type: text/html"
print
print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \
\"  http://www.w3.org/TR/html4/loose.dtd\">\n\
<html>\n<head>\n\
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n\
<title>List All Members With Age Ranges [Python-CGI / Logic in SQL]</title>\n\
</head>\n<body>”

# begin HTML table display
print "<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\">\n\
<tr><th colspan=\"2\">MEMBERS BY AGE GROUP</th></tr>\n\
<tr><th>Name</th><th>Age Group</th></tr>"

# display result rows in HTML table rows
for row in result:
  print "<tr><td>%s</td><td>%s</td></tr>" % (row[0], row[2])

# end table display
print "</table>"

# end HTML page
print "</body>n\</html>"

# end of script