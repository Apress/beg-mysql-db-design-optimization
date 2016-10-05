<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>List All Members With Age Ranges [PHP4 / Logic In PHP Code]</title>
</head>
<body>
<?php
  // establish a connection to MySQL, and select the proper database...
  $connection = mysql_connect("localhost", "jon", "mypass");
  mysql_select_db("mydb", $connection);
  // get the current year for the age calculation below...
  $year = (int) date("Y");

  // submit a query...
  $query = "SELECT firstname, lastname, dob FROM members ORDER BY lastname";
  $result = mysql_query($query);
?>
<!-- begin table display -->
<table cellpadding="5" cellspacing="0" border="1">
  <tr><th colspan="2">MEMBERS BY AGE GROUP</th></tr>
  <tr><th>Name</th><th>Age Group</th></tr>
<?php
  // for each row returned from the database...
  while($row = mysql_fetch_assoc($result))
  {
    extract($row);

    // get the year of birth from the birthdate column
    // get the age by subtracting it from the current year
    $age = $year - (int) substr($dob, 0, 4);
    // determine the age range based on the year
    if($age >= 65)
      $age_range = "Over 65";
    elseif($age >= 45)
      $age_range = "45-64";
    elseif($age >= 30)
      $age_range = "30-44";
    elseif($age >= 18)
      $age_range = "18-29";
    else
      $age_range = "Under 18";

    // output the resulting age range along with the member's name
    echo "  <tr><td>$firstname $lastname</td><td>$age_range</td></tr>\n";
  }
?>
</table>
<!-- end table display -->
</body>
</html>