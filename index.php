<?php
include 'header.php';
include 'uslims3dbconfig.php';
?>
<div id='content'>
	<h1 class="title">Welcome to the UltraScan III LIMS Portal...</h1>
<p>Below please find the link to your institution's <b><i>UltraScan III LIMS Portal:</i></b></p>
<ul>
<?php
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
while ( list( $instance, $db, $location ) = mysql_fetch_array( $result ) )
{
  echo "  <li><a href='http://uslims3.uthscsa.edu/$db'>$instance</a>" .  " ($location)</li>\n";
}
echo "  <li><a href='http://uslims3.uthscsa.edu/lims3'>Old LIMS3 Test Database</a>" .
                  " (San Antonio, TX)</li>\n";
?>
  <h4><a href='http://uslims3.uthscsa.edu/uslims3_newlims'>
        Request a new UltraScan III LIMS Instance</a></h4>
</ul>
</div>

<?php include 'footer.php'; ?>
