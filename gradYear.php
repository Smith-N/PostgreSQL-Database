<?PHP
/* class Table
Nick Smith & Kyle Wyse
12/5/2018
http://jcsites.juniata.edu/students/smithnm16/gradYear.php
*/
echo "<h1>Class Is For Men, Swag Is For Boys</h1>";
// login to database
$link = pg_connect("host=itcsdbms user=rhodes password=guest dbname=univdonations")
  or die ("Could not connect to database");

// shows data entries if user enters report button
if($_GET['report'])
{
$query = "SELECT * FROM class ";
$result = pg_query ($query)
    or die ("Query failed");

// printing HTML result
print "<table border=1>\n";
while($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
print "\t<tr>\n";
while(list($col_name, $col_value) = each($line)){
  print "\t\t<td>$col_value</td>\n";
}
print "\t</tr>\n";
}
print "</table>\n";
}

// adds data to the database
if($_GET['add'])
{
  $gradYear = $_GET['gradYear'];
  $contribution = $_GET['contribution'];
  $query = "INSERT INTO class (gradYear, contribution) VALUES('$gradYear', '$contribution')";
  pg_query ($query);
}

if($_GET['edit'])
{
  $gradYear = $_GET['gradYear'];
  $query = "SELECT gradYear, contribution FROM class WHERE gradYear='$gradYear'";
  $result = pg_query($query);
  $editData = pg_fetch_array($result);

  $gradYear = $editData[0];
  $contribution = $editData[1];

  echo "<form action=\"http://jcsites.juniata.edu/students/smithnm16/database/gradYear.php\" method=\"get\" >
    <div>
      <div>
        <label for=\"gradYear\">Corporation Name:</label>
        <input type=\"text\" name=\"gradYear\" value='$gradYear' required/>
      </div>

      <div>
        <label for=\"contribution\">contribution:</label>
        <input type=\"text\" name=\"contribution\" value='$contribution' required/>
      </div>

      <div>
        <input type=\"submit\" name=\"save\" value=\"Save\" />
        <input type=\"submit\" name=\"cancel\" value=\"Cancel\" />
  </form>";
}

if($_GET['save'])
{
  $gradYear = $_GET['gradYear'];
  $contribution = $_GET['contribution'];

  $query = "UPDATE class SET gradYear='$gradYear', contribution='$contribution' WHERE gradYear='$gradYear'";
  pg_query($query);
}

if($_GET['cancel'])
{
  header("location: http://jcsites.juniata.edu/students/smithnm16/database/gradYear.php");
}

// deletes entries from the database, ordered to delete by gradYear
if($_GET['delete'])
{
$gradYear=$_GET['gradYear'];
$query = "DELETE FROM class WHERE gradYear='$gradYear'";
pg_query ($query);
}

pg_close($link);
?>
<html>
  <head>
      <title>Class</title>
  </head>
  <body>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/gradYear.php" method="get" >
      <div>
        <div>
          <label for="gradYear">Year of Graduation:</label>
          <input type="text" name="gradYear" required/>
        </div>

        <div>
          <input type="submit" name="add" value="Add" />
      </div>
    </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/gradYear.php" method="get">
      <div>
      <input type="submit" name="report" value="Report"/>
    </div>
  </form>
    <form action="http://jcsites.juniata.edu/students/smithnm16/database/gradYear.php" method="get">
      <div>
        <label for="gradYear">Corporation Name</lable>
        <input type="text" name="gradYear" required/>
        <input type="submit" name="edit" value="Edit" />
        <input type="submit" name="delete" value="Delete" />
      </div>
    </form>
  </body>
</html>
