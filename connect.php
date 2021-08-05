<html>
<body>

<?php
include("database.php");

if(!$connect){
	echo "Error: " . mysqli_connect_error();
	exit();
}

echo "Connection Success!<br><br>";

$temperature = $_GET["temperature"];


$query = "INSERT INTO temp_sensor (temperature) VALUES ('$temperature')";
$result = mysqli_query($connect,$query);

echo "Insertion Success!<br>";

?>
</body>
</html>