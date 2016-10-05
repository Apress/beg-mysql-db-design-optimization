<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>List All Members With Age Ranges [PHP4 / Logic in SQL]</title>
</head>
<body>
<?php
  // connect and select...
  $connection = mysql_connect("localhost", "jon", "mypass");
  mysql_select_db("mydb", $connection);

  // new and improved query, which handles the logic and formatting
  $query = "SELECT
              CONCAT(firstname, ' ', lastname) AS name,
              CASE
                WHEN (@age := YEAR(CURRENT_DATE) - YEAR(dob)) > 65
                  THEN 'Over 65'
                WHEN @age >= 45 THEN '45-64'
                WHEN @age >= 30 THEN '30-44'
                WHEN @age >= 18 THEN '18-19'
                ELSE 'Under 18'
              END AS age_range
            FROM members ORDER BY lastname";

  $result = mysql_query($query);
?>
<!-- begin table display -->
<table cellpadding="5" cellspacing="0" border="1">
<tr><th colspan="2">MEMBERS BY AGE GROUP</th></tr>
<tr><th>Name</th><th>Age Group</th></tr>
<?php
// for each record returned by the query...
while($row = mysql_fetch_assoc($result))
{
  // extract and output the data
  extract($row);
  echo "<tr><td>$name</td><td>$age_range</td></tr>\n";
}
?>
</table>
<!-- end table display -->
</body>
</html>