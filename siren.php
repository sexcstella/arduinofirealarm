
<?php
include("database.php");

if(!$connect){
	echo "Error: " . mysqli_connect_error();
	exit();
}

echo "Connection Success!<br><br>";


$query = "INSERT INTO flame_sensor (stat) VALUES (1)";
$result = mysqli_query($connect,$query);

echo "Insertion Success!<br>";

?>
