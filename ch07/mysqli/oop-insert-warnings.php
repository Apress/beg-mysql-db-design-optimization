<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>MySQLI INSERT WARNINGS :: OBJECT-ORIENTED STYLE</title>
</head>
<body>
<?php
  $link = new mysqli('localhost', 'root', '', 'test');

  if( mysqli_connect_errno() )
    die("Connect failed: " . mysqli_connect_error());

  $query = "INSERT INTO employees
              (empid, firstname, lastname)
            VALUES
              ('', 'Peter', 'Parker'),
              ('', 'Bruce', 'Wayne'),
              ('', 'Clark', 'Kent')";

  if($result = $link->query($query))
  {
    $query = "SHOW WARNINGS";

    if($result = $link->query($query))
    {
      if($result->num_rows > 0)
      {
        printf("<table border=\"1\" width=\"400\" align=\"center\" 
                       cellpadding=\"3\" cellspacing=\"0\">
                  <tr><th colspan=\"3\">Warnings: %s</th></tr>
                  <tr><th>Level</th><th>Code</th><th>Message</th></tr>",
                $result->num_rows);

        while($row = $result->fetch_assoc())
        {
          extract($row);
          printf("<tr>\n<td>%s</td><td>%s</td>\n<td>%s</td>\n</tr>",
                  $Level, $Code, $Message);
        }

        print "</table>\n";
      }
      else
        printf("<p>No warnings issued.</p>\n");
    }
    else
      printf("<p>Error number #%s: %s.</p>",
              $link->mysqli_errno, $link->mysqli_error);

    printf("<p>Affected rows: %s</p>\n", $link->affected_rows);

    $result->close();
  }
  else
    printf("<p>Error number #%s: %s.</p>",
            $link->mysqli_errno, $link->mysqli_error);

  $link->close();

  print "<p>Script completed.</p>";
?>
</body>
</html>