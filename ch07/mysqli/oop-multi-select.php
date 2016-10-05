<!DOCTYPE HTML PUBLIC "-#W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>MYSQLI MULTIPLE STATEMENTS :: OBJECT-ORIENTED STYLE</title>
</head>
<body>
<?php
  # file: oop-multi-select.php
  # ext/mysqli multiple statements example #1

  # contains definitions for $queries and $sql arrays (text of queries)
  require('queries.inc.php');

  #  connect to MySQL
  $link = new mysqli('localhost', 'root', '', 'world');

  #  notify us of connection error, and exit
  if( mysqli_connect_errno() )
    die("Connect failed: " . mysqli_connect_error());

  #  limit for number of rows returned from each query
  $limit = 5;

  #  join queries together using semicolon as delimiter
  #  character send as a multiple query
  if( $link->multi_query( implode(";", $sql) ) )
  {
    $n = 0; #  counter for table headings

    do
    {
      #  fetch result of first query
      if($result = $link->store_result())
      {
        #  get number and names of the columns in the result set
        $c = $link->field_count;
        $fields = $result->fetch_fields();

        #  start output HTML table with heading
        printf("<table border=\"1\" cellpadding=\"3\" cellspacing=\"0\"
                       align=\"center\" width=\"275\">\n
                <tr><th colspan=\"%s\">%s</th></tr>\n",
                  $c, $queries[$n++]["title"]);

        #  second row of table contains column names
        print "<tr>";

        for($i = 0; $i < $c; $i++)
          printf("<th>%s</th>", ucwords($fields[$i]->name));

        print "</tr>\n";

        #  for each row in result set...
        while($row = $result->fetch_row())
        {
          print "<tr>"; #  start a new HTML table row

          #  for each column in this row...
          for($j = 0; $j < $c; $j++)
          {
            $val = $row[$j];  #  column value

            #  queries are arranged so that last column
            #  contains numeric output: if this is last
            #  column then add commas, e.g. 1000000 gets displayed
            #  as 1,000,000; also right-align table cell
            if($j == $c - 1)
            {
              $val = number_format($val);
              $align = " align=\"right\"";
            }
            else
            {
              $val = htmlentities($val);
              $align = "";
            }

            #  output column value in HTML table cell
            printf("<td%s>%s</td>", $align, $val);
          }

          print "</tr>\n";  #  close HTML table row
        }

        #  when all row are retrieved, close the result object...
        $result->close();
      }

      #  ...and close HTML table
      print "</table>\n";

      #  if there's another result set, write HTML
      #  horizontal rule to separate next HTML table
      if( $link->more_results() )
        print "<hr width=\"200\">\n";
    }

    #  get next result set, if there is one
    while( $link->next_result() );
  }

  #  when there are no more result sets, close the connection
  $link->close();

  #  let user know we're done
  print "<p>Script completed.</p>\n";
?>
</body>
</html>