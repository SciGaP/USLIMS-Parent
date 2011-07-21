<?php
/*
 * index.php
 *
 * An index for LIMS III Instances
 *
 */

include 'config.php';

// Log into db
$link = mysql_connect( $dbhost, $dbusername, $dbpasswd ) 
        or die("Could not connect to database server.");

mysql_select_db($dbname, $link) 
        or die("Could not select database. " .
               "Please ask your Database Administrator for help.");

// Get instances
$query  = "SELECT institution, dbname, location " .
          "FROM metadata " .
          "WHERE status = 'completed' " .
          "ORDER BY UPPER( institution ) ";
$result = mysql_query( $query )
          or die( "Query failed : $query<br />\n" . mysql_error());

$instance_text = "<ol>\n";
while ( list( $instance, $db, $location ) = mysql_fetch_array( $result ) )
{
  $instance_text .= "  <li><a href='http://uslims3.uthscsa.edu/$db'>$instance</a>" .
                    " ($location)</li>\n";
}
$instance_text .= "  <li><a href='http://uslims3.uthscsa.edu/lims3'>Old LIMS3 Test Database</a>" .
                  " (San Antonio, TX)</li>\n";
$instance_text .= "</ol>\n";

// Now write out index

include 'header.php';

echo <<<HTML
<div id='content'>
	<h1 class="title">Welcome to the UltraScan III LIMS Portal...</h1>

  <h4>Below please find the link to your institution&rsquo;s <b><i>UltraScan III LIMS Portal:</i></b></h4>

  $instance_text

  <h4><a href='http://uslims3.uthscsa.edu/uslims3_newlims/request_new_instance.php'>
        Request a new UltraScan III LIMS Instance</a></h4>
  
</div>

HTML;

include 'footer.php';
exit();
