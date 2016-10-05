<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Getting Column Data From a Table (PHP4 / mysql)</title>
</head>
<body bgcolor="#DEDEDE">
<table cellpadding="3" cellspacing=\"1\" frame="box" rules="rows"
       bgcolor="#ABABAB" align="center">
<?php
  #  names of database and table
  $database = "mdbd";
  $table = "orders";

  #  connect to MySQL, select DB
  $connection = mysql_connect("localhost", "jon", "******");
  mysql_select_db($database, $connection);

  #  select all columns from the table
  $result = mysql_query("SELECT * FROM $table LIMIT 1")
    or die( mysql_error() );

  #  get the number of columns in the result
  $num_fields = mysql_num_fields($result);

  #  HTML table heading with name of adatabase and table, number of columns
  printf("<tr><th bgcolor=\"#FFFFFF\" colspan=\"%d\">
          Columns in table <em>%s</em>:</th></tr>\n<tr>",
          $num_fields, $table);

  #  counter to track columns
  $i = 0;

  # for each column...
  do
  {
    #  start a new nested HTML table in which to display this column
    printf("<td><table border=\"1\" cellspacing=\"0\"
                       cellpadding=\"2\" bgcolor=\"#FFFFFF\">\n
            <tr><th colspan=\"2\">Column %d</th></tr>\n", $i);

    #  get an object corresponding to the column
    $col = mysql_fetch_field($result, $i);
    #  convert this object into an associative array
    #  (in other words, we'll turn each $col->property into a
    #  $col_array["property"])
    $col_array = get_object_vars($col);

    #  for each element in the associative array, display the key and value
    #  the name of the key is a property of the column
    foreach($col_array as $property => $value)
      printf("<tr><td>%s</td><td>%s</td></tr>\n", $property, $value);

    #  close the nested HTML table
    print "</table>\n</td>\n";
  } while(++$i < $num_fields);  #  get the next column if there is one
?>
  </tr>
</table>
</body>
</html>
