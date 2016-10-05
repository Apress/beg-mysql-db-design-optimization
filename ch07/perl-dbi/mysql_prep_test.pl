#!/usr/bin/perl -w
# change to match path to perl on your system if required

# file: mysql_prep_test.pl — select query and output,
# using a prepared statement (Ch 7)
# *NOTE* This is NOT the same as the Prepared Statements API in MySQL 4.1+;
# it works, but does not actually cause queries to be pre-compiled by MySQL

use strict;

use DBI; # include the DBI module
my $db = "mdbd_ch8"; # database name
my $host = "gojira"; # hostname (default is "localhost")
my $port = "3306"; # MySQL port (default is 3306)
my $user = "jon"; # username (default is current system user)
my $pass = "eleanor"; # password
my $dsn = "DBI:mysql:database=$db;$host:$port";
# $dsn = connection string; default is the DBI_DSN environment variable
my $sth; # SQL statement handle

# Make connection
my $dbh = DBI->connect($dsn, $user, $pass) or die("Cannot Connect");

# Prepare and execute query
my $query = "SELECT name FROM products WHERE id=?";
$sth = $dbh->prepare($query); # get a statement handle object

# Declare variables
my $id;
my $name;
$id = 3;

$sth->execute($id); # submit the query

# Assign fields to variables
$sth->bind_columns(undef, \$name);

# Now print query...
# the fetch() method retrieves the next row from the result set
# until there are no more rows to return
$sth->fetch();
print "ID: $id \r\nName: $name \r\n";

$id = 5;
$sth->execute($id); # submit the query
$sth->fetch();
print "ID: $id \r\nName: $name \r\n";

$id = 8;
$sth->execute($id); # submit the query
$sth->fetch();
print "ID: $id \r\nName: $name \r\n";

$sth->finish(); # free resources used by the query handle
$dbh->disconnect(); # disconnect from database
# end mysql_prep_test.pl