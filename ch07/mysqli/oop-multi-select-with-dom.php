<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<?php
  # file: oop-multi-select-with-dom.php
  # ext/mysqli multiple statements example #2 (Ch 7)
  # provides object-oriented exception handling,
  # uses ext/dom for object-oriented markup element creation 

  # contains class definitions for AP_Mysqli,
  # AP_MysqliResult, and AP_MysqliException classes  
  require('AP_Mysqli_classes.inc.php');
  
  # contains definitions for $queries and $sql arrays (text of queries)
  require('queries.inc.php')

  # throws an exception when a user error is encountered
  function ErrorsToExceptions($code, $message)
  {
    throw new Exception($message, $code);
  }

  # sets the ErrorsToExceptions function as the error handler
  set_error_handler("ErrorsToExceptions");

  # we place all code likely to throw an exception into a try block
  try
  {
    # connect to MySQL...
    # we can't override the mysqli class constructor,
    # but we can override its connect() method, so we call
    # the AP_Mysqli class constructor and then its connect()
    # method, which overrides the parent class connect()
    # so we can throw an exception in case of failure
    $link = new AP_Mysqli();

    # no if() block here... the try block takes care
    # catching any errors/exceptions
    $link->connect('localhost', 'root', '', 'world');

    # set LIMIT value for all queries
    $limit = 5;

    # create a new DOMDocument object (this is the
    # the basis for the HTML document that we'll display
    # to the user when we're done)
    $doc = new DOMDocument;

    # create new DOMElement objects
    # corresponding to <html> and <head> tags
    $html = $doc->createElement("html");
    $head = $doc->createElement("head");

    # create new DOMElement (tag name: meta) and set
    # its http_equiv and content attributes
    $meta = $doc->createElement("meta");
    $meta->setAttribute("http-equiv", "Content-Type");
    $meta->setAttribute("content", "text/html; charset=iso-8859-15");

    # append the <meta> to the <head>
    $head->appendChild($meta);

    # create DOMElement object for the <title> tag, a DOMText (text node)
    # object containing the <title> tag text, and insert the text into
    # the <title>
    $title = $doc->createElement("title");
    $title_text = "MYSQLI MULTIPLE STATEMENTS :: O-O STYLE W/ DOM";
    $title->appendChild( $doc->createTextNode($title_text) );

    # now append the <title> to the <head>, and the <head> to the <html>
    $head->appendChild($title);
    $html->appendChild($head);

    # create a <body> element for this page
    $body = $doc->createElement("body");

    # the $sql array contains as its elements the text of each
    # of the queries we want to execute; defined in queries.inc.php

    # here we join all the queries together into a single string, using
    # the semicolon character as the delimiter, and then send this string
    # to MySQL in a single request
    $link->multi_query( implode(";", $sql) );

    # counter used for tracking the table headings
    # associated with each query's results
    $n = 0;

    # do{ ... } while( $link->next_result() ) --
    # run the code inside the do block so long as there is
    # another result set to be retrieved from the
    # multiple result set sent back by MySQL in response
    # to the multiple query
    do
    {
      # get the result set
      $result = $link->store_result();

      # since each result set may have a different
      # number of fields/columns, we need to get
      # the number of fields in this result set
      $c = $link->field_count;

      # get the fields array associated with this result set
      # note: we could also have used the following...
      #       $fields = $result->fetch_fields();
      #       $c = count($fields);
      # ... to obtain this information
      $fields = $result->fetch_fields();

      # we display the data from each result set
      # in a separate table; here we start the table
      # by creating a DOMElement object corresponding
      # to a HTML <table> tag, then set its align, width,
      # border, cellpadding, and cellspacing attributes to
      # the desire values -- this is the equivalent of writing
      # <table align="center" width="475" border="1"
      #        cellpadding="3" cellspacing="0">
      $table = $doc->createElement("table");
      $table->setAttribute("align", "center");
      $table->setAttribute("width", "475");
      $table->setAttribute("border", "1");
      $table->setAttribute("cellpadding", "3");
      $table->setAttribute("cellspacing", "0");

      # now we'll create the HTML table row containing the table title
      # first a DOMElement for the <tr>
      $tr = $doc->createElement("tr");

      # now a table heading cell (<th>), setting its colspan attribute
      # equal to the number of columns in the result, and then inserting
      # a DOMText node containg the title text describing the query
      $th = $doc->createElement("th");
      $th->setAttribute("colspan", $c);
      $th->appendChild( $doc->createTextNode($queries[$n++]["title"]) );

      # append the heading cell to the row, and the row to the table
      $tr->appendChild($th);
      $table->appendChild($tr);

      # next row: contains HTML table column headings; the text for
      # these will be the field names or aliases from the result set
      $tr = $doc->createElement("tr");

      # for each result set column...
      for($i = 0; $i < $c; $i++)
      {
        # create a new heading cell...
        $th = $doc->createElement("th");
        # ...into which we insert the name of the field
        $th->appendChild( $doc->createTextNode( ucwords($fields[$i]->name) ) );

        # insert the heading cell into the row
        $tr->appendChild($th);
      }

      # after all the column headings have been created,
      # append the row containing the them to the table
      $table->appendChild($tr);

      # now display the result set data
      # for each row in the result set...
      while($row = $result->fetch_row())
      {
        # start a new HTML table row
        $tr = $doc->createElement("tr");

        # for each column in the result set...
        for($j = 0; $j < $c; $j++)
        {
          # get the value stored in this column
          $value = $row[$j];

          # create a HTML table cell in which to display this value
          $td = $doc->createElement("td");

          # if the value's a number, format it nicely and
          # right-align it in the table cell
          if( is_numeric($value) )
          {
            $value = number_format($value);

            $td->setAttribute("align", "right");
            $td->appendChild( $doc->createTextNode($value) );
          }
          else  # if the value consists of text, we have
          {     # to handle things a bit differently...
            # convert any special characters in the value to
            # their HTML entity equivalents, because you can't
            # create a DOMText node containing any special
            # characters; instead you must create a DOMEntityReference
            $value = htmlentities($value);

            # $matches will contain all bits of text coming between
            # a pair of "&" and ";" characters are used to delimit a
            # HTML character entity
            preg_match_all("/&([^;]*);/", $value, $matches);

            # $parts will contain all bits of text in the original string
            # separated by a "&" or ";"
            $parts = preg_split("/&|;/", $value, -1, PREG_SPLIT_NO_EMPTY);

            # now check each substring in $parts
            foreach($parts as $part)                                
              # ...and append the correct node type...
              $td->appendChild(  # is there a match in $matches?
                                in_array($part, $matches[1])
                                
                                # yes: create an entity reference node
                                ? $doc->createEntityReference($part)
                                
                                # no: create a text node
                                : $doc->createTextNode($part)
                              );

          }
          
          # once all the content nodes have been created and appended
          # to the table cell, append the cell to the table row
          $tr->appendChild($td);
        }
        
        # append the row to the HTML table
        $table->appendChild($tr);
      }
      
      # free the memory used for this result set
      $result->close();

      # append the <table> to the <body>
      $body->appendChild($table);

      # if there's another result set to be processed,
      # create a <hr>, set its width, and then append
      # it to be body of the document
      if( $link->more_results() )
      {
        $hr = $doc->createElement("hr");
        $hr->setAttribute("width", "350");

        $body->appendChild($hr);
      }
    } while( $link->next_result() ); # end of the do loop

    # no more result sets: close the connection
    $link->close();

    # append the <body> to the <html>
    # append the <html> to the DOMDocument
    $html->appendChild($body);
    $doc->appendChild($html);

    # call the saveHTML() method to convert the DOM tree
    # to a string of HTML, and output this to the client
    print $doc->saveHTML();
  } # ends the try block, now to handle errors/exceptions
  
  # handle exceptions thrown by mysqli or mysql_result
  # AP_MysqliException class is defined in AP_Mysqli_classes.inc.php
  catch(AP_MysqliException $e)
  { 
    print "<b>- MYSQLI ERROR -</b><br>";
    printf("SQLSTATE %s -- %s", $e->getCode(), $e->getMessage());
  }
  
  # handle exceptions thrown by DOM objects
  # DOMException class is defined as part of ext/dom (per W3C spec)
  catch(DOMException $e)
  {
    print "<b>- DOM ERROR -</b><br>";
    printf("DOM Error #%s -- %s", $e->getCode(), $e->getMessage());
  }
  
  # any other exceptions? deal with them here
  catch(Exception $e)
  {
    print "<b>- GENERAL ERROR -</b> ";
    printf("PHP Error #%s -- %s", $e->getCode(), $e->getMessage());
  }
?>