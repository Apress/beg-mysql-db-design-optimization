<?php
	#	Filename: oop-prep-statments.php

  # Example of inserting records 
  #	using prepared statements

  # connect to database
  $link = new mysqli("localhost", 
              "zontar", "", "test");

  if( mysqli_connect_errno() )               
    die("Could not connect: " . 
         mysqli_connect_error());

  $query = "SELECT firstname, lastname 
  					FROM employees 
  					WHERE empid < ?";

  #  string containing parameter 
  #  datatype characters
  $types = 'i';
  
  #  Note: Valid datatypes are
  #  i = INTEGER 
  #  d = DOUBLE
  #  s = STRING
  #  b = BLOB
  #  (This has changed since PHP5-RC1)

  #  prepare statement
  #  (instantiate mysqli_stmt object)
  $stmt = $link->prepare($query)
    or die("ERROR: " . $stmt->error);

  #  bind parameters to prepared 
  #  statement (arguments to this 
  #  function are: an array of 
  #  datatypes and the variables to be 
  #  bound as parameters)
  $stmt->bind_param($types, $empid);

  #  set values for bound parameter

  $empid = 4;

  # execute prepared statement
  $stmt->execute()
    or die("Execution failed: " . 
           $stmt->error);
           
  $stmt->bind_result($fname, $lname);

  while( $stmt->fetch() )
    printf("<p>Name: %s %s</p>", $fname, $lname);

  #  set values for bound parameter

  $empid = 2;

  # execute prepared statement
  $stmt->execute()
    or die("Execution failed: " . 
           $stmt->error);
           
  $stmt->bind_result($fname, $lname);
  
  while( $stmt->fetch() )
    printf("<p>Name: %s %s</p>", $fname, $lname);

  #  close prepared statement
  $stmt->close();

  #  close database connection
  $link->close();

  printf("Script completed.\n");
?>
