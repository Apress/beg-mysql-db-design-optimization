#!/usr/bin/perl -w
# change the preceding line to match your system's path to perl if necessary

# file: mysql_test.pl
# basic example showing how to send a query and retrieve the results
# using Perl-DBI with MySQL
# tested with ActivePerl 5.8.1.807 / MySQL 5.0.1-alpha

# *NOTE* -- the mysql::dbd driver does not yet support the new-style
# encryption used by MySQL 4.1 and newer; see "Using Older Clients with 
# MySQL 4.1 and 5.0" in Ch 7 of the book or consult the MySQL Manual if 
# this is an issue for you

use strict;
use DBI; # include the DBI module

my $db = "mdbd_ch8"; # database name
my $host = "gojira"; # hostname (default is "localhost")
my $port = "3306"; # MySQL port (default is 3306)
my $user = "jon"; # username (default is current system user)
my $pass = "eleanor"; # password
my $dsn = "DBI:mysql:database=$db;$host:$port"; # $dsn = connection string; default is the DBI_DSN environment variable
my $sth; # SQL statement handle

# make connection
my $dbh = DBI->connect($dsn, $user, $pass) or die("Cannot Connect");

# prepare and execute query
my $query = "SELECT id, name FROM tbl";
$sth = $dbh->prepare($query); # get a statement handle object
$sth->execute(); # submit the query

# declare variables
my $id;
my $name;

# assign fields to variables
$sth->bind_columns(undef, \$id, \$name);

# the fetch() method retrieves the next row from the result set
# until there are no more rows to return
while( $sth->fetch() )
{
  print "ID: ";
  print "$id \r\n";
  print "Name: ";
  print "$name \r\n";
}

$sth->finish(); # free resources used by the query handle
$dbh->disconnect(); # disconnect from database
# end mysql_test.pl