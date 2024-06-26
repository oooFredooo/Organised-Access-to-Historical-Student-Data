<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../favicon.ico">
  <title>Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/dashboard1.css" rel="stylesheet">
</head>
<body>
  <div class="container">
<?php
include('../one_connection.php');

$from = $_GET['from'];
$to = $_GET['to'];
$user = $_GET['user'];
$SelectCourseId=$_GET['SelectCourseId'];
$SelectYearId=$_GET['SelectYearId'];
$SelectSemesterId=$_GET['SelectSemesterId'];
$SER='SER';
$user =substr_replace($user,$SER,1,0);// change U0019 to USER0019

// display context information
echo "Course: ".$SelectCourseId.", ".$SelectYearId.", ".$SelectSemesterId.'</br>';
echo "User: ".$user.'</br>';
echo "Start time: ".$from.'</br>';
echo "End time: ".$to.'</br>'.'</br>';
// provide hints and hyper links to the two tables in case the first table is too lengthy for the user to become aware of the existence of the second table
echo '<a href="#Event name">Event name and amount </a>'.'</br>'.'</br>';
echo '<a href="#Event context">Event context and amount </a>'.'</br>'.'</br>';

// table 1: "Event name" and "Amount of event"
echo '<table class="table table-striped" id="Event name">';
echo "<tr><th>Event name</th><th>Amount of event</th></tr>";
$sql = "SELECT Name, COUNT(  `Id` ) count
FROM event
WHERE FKUserId='{$user}' and EventTime between '{$from}' and '{$to}' and CourseName='{$SelectCourseId}' and DataSourceType=1  
GROUP BY Name
ORDER BY count desc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	echo '<tr><td>'.$row['Name'].'</td><td>'.$row['count'].'</td></tr>';
}
echo "</table></br>";

// table 2: "Event context" and "Amount of event"
echo '<table class="table table-striped" id="Event context">';
echo "<tr><th>Event context</th><th>Amount of event</th></tr>";
$sql = "SELECT Prefix, Context, COUNT(  `Id` ) count
FROM event
WHERE FKUserId='{$user}' and EventTime between '{$from}' and '{$to}' and CourseName='{$SelectCourseId}' and DataSourceType=1  
GROUP BY Context
ORDER BY count desc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	echo '<tr><td>'.$row['Prefix'].':'.$row['Context'].'</td><td>'.$row['count'].'</td></tr>';
}
echo "</table>";

mysql_close($link);
?>
  </div>

  <script type="text/javascript" src="../js/jquery-3.2.1.js"></script>
</body>
</html>