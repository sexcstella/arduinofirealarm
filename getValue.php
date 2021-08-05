<?php 
  include("database.php");

    if(!$connect){
        echo "Error: " . mysqli_connect_error();
        exit();
    }

    $query = "SELECT sirenState FROM siren";
    $result=mysqli_query($connect,$query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo  $row["sirenState"];
}
}

?>