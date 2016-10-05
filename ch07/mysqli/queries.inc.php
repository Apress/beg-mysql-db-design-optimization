<?php
  # file: queries-inc.php
  # used in Ch 7 PHP5 - ext/mysqli multiple statements examples
  
  $queries = array();

  # array containing each query and its title/heading for display
  # the title element is the title/heading, the text element is
  # the text of the query
  $queries[]
    = array(
            "title" => "$limit Most Populous Countries",
            "text" => "SELECT Name AS name, Continent AS continent,
                         Population AS population
                       FROM Country
                       ORDER BY population DESC LIMIT $limit"
           );

  $queries[]
    = array(
            "title" => "$limit Most Populous Cities",
            "text" =>  "SELECT ci.Name AS city, co.Name AS country,
                          ci.Population AS population
                        FROM City ci
                        JOIN Country co
                        ON ci.CountryCode = co.Code
                        ORDER BY population DESC LIMIT $limit"
           );

  $queries[]
    = array(
            "title" => "$limit Most Widely-Spoken Languages",
            "text" => "SELECT cl.Language AS language,
                         FLOOR( SUM(co.Population * cl.Percentage * .01) )
                          AS speakers
                       FROM CountryLanguage cl
                       JOIN Country co
                       ON cl.CountryCode = co.Code
                       GROUP BY language
                       ORDER BY speakers DESC LIMIT $limit"
           );

  #  make an array of just the queries
  $sql = array();
  foreach($queries as $query)
    $sql[] = $query["text"];
?>