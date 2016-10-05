<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title></title>
<style type="text/css"></style>
<script type="text/javascript"></script>
</head>
<body>

<?php
	#	Simple transactions example
	# Assumes that the accounts table is of a type that supports transactions
	#	Filename: simple-transaction.php

  #  amount to be transferred
  $amt = 50.00;

  #  account numbers
  $acct1 = '14532';
  $acct2 = '30041';

  #  connect and verify connection...
  $link = new mysqli('localhost', 'zontar', '', 'test');

  if( mysqli_connect_errno() )
    die("Connect failed: " .
        mysqli_connect_error());

  #  display beginning balances
  $bal_query = "SELECT acctid, balance
                FROM checking
                ORDER BY acctid";

  if($result = $link->query($bal_query))
  {
?>
<table>
  <tr><th colpsan=\"2\">Starting Balances:</th></tr>
  <tr><td>Acct #:</td><td>Balance:</td></tr>
<?php
    while($row = $result->fetch_object())
      printf("<tr><td>%s</td><td align=\"right\">\$%s</td></tr>\n", $row->acctid, $row->balance);
  }
?>
</table>
<?php
  #  turn off auto-commit
  $link->autocommit(FALSE);

  #  subtract sum from first account
  $subtract_query = "UPDATE checking
                     SET balance = balance - $amt
                     WHERE acctid = $acct1";
  if($result = $link->query($subtract_query))
  {
    echo "<p>Subtracting \$$amt from account #$acct1...</p>\n";
    #  if subtraction is successful,
    #  add amount to second account
    $add_query =
      "UPDATE checking
       SET balance = balance - $amt
       WHERE acctid = $acct2";

    #  if subtraction is also successful,
    #  commit the transaction;
    #  otherwise do a rollback
    if($result = $link->query($add_query))
    {
      print "<p>Adding \$$amt to account #$acct2...</p>\n";
      $link->commit();
    }
    else
    {
      print "<p>Error -- rolling back transaction.</p>\n";
      $link->rollback();
    }
  }


  #  display ending balances
  if($result = $link->query($bal_query))
  {
?>
<table>
  <tr><th colpsan=\"2\">Ending Balances:</th></tr>
  <tr><td>Acct #:</td><td>Balance:</td></tr>
<?php
    while($row = $result->fetch_object())
      printf("<tr><td>%s</td><td align=\"right\">\$%s</td></tr>\n", $row->acctid, $row->balance);
  }
?>
</table>
<?php
  #  clean up...
  $result->close();
  $link->close();

  print "<p>Script complete.</p>\n";
?>
</body>
</html>


