<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Author" content="jon stephens">
<title>SIMPLE MySQLI SELECT :: PROCEDURAL STYLE</title>
</head>
<body>
<?php
  $link = mysqli_init();
  mysqli_real_connect($link, 'localhost', 'zontar', '', 'test');
  
  if( mysqli_connect_errno() )
    die("Connect failed: " . mysqli_connect_error());
  
  $query = "SELECT empid, firstname, lastname 
            FROM employees
            ORDER BY lastname";
  
  mysqli_real_query($link, $query);
  if($result = mysqli_store_result($link))
  {
?>
<table border="1" width="50%">
<tr>
  <th>Employee #</th>
  <th>First Name</th>
  <th>Last Name</th>
</tr>
<?php
    while($row = mysqli_fetch_assoc($result))
    {
      extract($row);
      printf("<tr>\n  <td>%s</td>
            <td>%s</td>\n
            <td>%s</td>\n</tr>",
            $empid, $firstname, $lastname);
    }
?>
</table>
<?php
  }
  else
    echo mysqli_error();
  
  mysqli_free_result($result);
  mysqli_close($link);
?>
</body>
</html>