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
          "AND dbhost = '$org_site' " .
          "ORDER BY UPPER( institution ) ";
$result = mysql_query( $query )
          or die( "Query failed : $query<br />\n" . mysql_error());

$instance_text = "<ol>\n";
while ( list( $instance, $db, $location ) = mysql_fetch_array( $result ) )
{
  if ( $instance == "CAUMA3" || $instance == "cauma3d" )  continue;
  $instance_text .= "  <li><a href='http://uslims3.uthscsa.edu/$db'>$instance</a>" .
                    " ($location)</li>\n";
}
$instance_text .= "</ol>\n";

$instance_text .= "<p><a href='http://uslims3.fz-juelich.de/index.php'>";
$instance_text .= "Links to other institutions, using the Juelich LIMS/DB server</a></p><p/>";

// Now write out index

include 'header.php';

echo <<<HTML
<div id='content'>
	<h1 class="title">Welcome to the UltraScan III LIMS Portal...</h1>

<!--

<p class='message'>
Sat Apr 19: LIMS and desktop access to databases will be unavailable due to planned
maintenance to improve performance and reliability.
</p>

 -->

  <h4>Below please find the link to your institution&rsquo;s <b><i>UltraScan III LIMS Portal:</i></b></h4>

  $instance_text

  <h4><a href='http://uslims3.uthscsa.edu/uslims3_newlims/request_new_instance.php'>
        Request a new UltraScan III LIMS Instance</a></h4>
  
</div>

HTML;

include 'footer.php';
exit();
