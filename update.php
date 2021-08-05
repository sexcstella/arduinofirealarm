<?php 
  include("database.php");
        
    if(!$connect){
        echo "Error: " . mysqli_connect_error();
        exit();
    }

    $query = "Update siren SET sirenState =".$_GET['state'];
    echo  $query;
    mysqli_query($connect,$query);

    header("Location: index.php");

?>