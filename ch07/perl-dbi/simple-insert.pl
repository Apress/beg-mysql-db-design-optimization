#!/usr/bin/perl -w
# change to match your system's path to perl if/as needed

# FILE: simple-insert.pl
# Shows how to use the do() method to perform an INSERT query (Ch 7)

use strict;

use CGI qw(:standard);
use DBI;

my $db = "mdbd_ch8";
my $host = "gojira";
my $port = "3306";
my $user = "jon";
my $pass = "eleanor";
my $dsn = "DBI:mysql:database=$db;$host:$port";

# make connection
my $dbh = DBI->connect($dsn, $user, $pass)
  or die("Cannot Connect");
  
my $rows = $dbh->do(
                    qq{
                        INSERT INTO members
                          (firstname, lastname, dob)
                        VALUES
                          ('Janet', 'Sloan', '1978-12-05'),
                          ('Steven', 'Jones', '1981-08-16'),
                          ('Alison', 'Kassel', '1977-10-22')
                      }
                   );

# terminate connection                   
$dbh->disconnect();

# end simple-insert.pl