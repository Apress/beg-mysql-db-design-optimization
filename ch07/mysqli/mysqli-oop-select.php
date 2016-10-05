<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SIMPLE MySQLI SELECT :: OBJECT_ORIENTED STYLE</title>
</head>
<body>
<?php
  //  connect to MySQL
  $link = new mysqli('localhost', 'jon', '******', 'test');
  
  //  notify us in the event of a connection error
  if( mysqli_connect_errno() )
    die("Connect failed: " . mysqli_connect_error());
  
  $query = "SELECT empid, firstname, lastname 
            FROM employees
            ORDER BY lastname";
  
  //  submit query
  if($result = $link->query($query))
  {
?>
<table border="1" width="30%">
<tr>
  <th width="10%">Employee #</th>
  <th>First Name</th>
  <th>Last Name</th>
</tr>
<?
    while($row = $result->fetch_object())
    {
      //  display the rows
      printf("<tr>\n<td>%s</td><td>%s</td>\n<td>%s</td>\n</tr>",
              $row->empid, $row->firstname, $row->lastname);
    }
?>
</table>
<?
    printf("<p>Number of rows returned: %s.</p>\n", $link->num_rows);  
  }
  else  //  notify us if the query failed
    printf("<p>Error #%s: %s.</p>", $link->mysqli_errno(), $link->mysqli_error());
  
  //  free result memory, and close the connection
  $result->close();
  $link->close();
?>
</body>
</html>