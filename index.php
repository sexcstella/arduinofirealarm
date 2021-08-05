<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Fire Alarm System</title>
</head>
<body style="background-color:black;color:white">

<!-- Button trigger modal -->
<button id="alert" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="visibility:hidden">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 style="color:black">Danger!</h1>
      </div>
      <div class="modal-body">
        <center><p style="color:black">A fire has been detected. Contact nearest fire station immediately!</p></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color:red">Close</button>
      </div>
    </div>
  </div>
</div>





<script>
    let sirenState = 0;
</script>
<?php
    include("database.php");
    
if(!$connect){
	echo "Error: " . mysqli_connect_error();
	exit();
}

$query = "SELECT sirenState FROM siren";
$result = mysqli_query($connect,$query);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      ?>
        <script>
            sirenState = <?php echo $row["sirenState"] ?>;
           
        </script>
      <?php
      if($row["sirenState"] == 1){
          ?>
            
          <?php
      }
    }
  } 
?>
    <div style="width:15pc; height: 4.5pc;margin:auto;margin-top:5pc;padding:1pc; border:3px solid #2196F3;border-radius:5px">
        <div style="width:40%;float:left">
            <!-- Rounded switch -->
        <label class="switch">
            <input type="checkbox" id="switchBox">
            <span class="slider round"></span>
        </label>

        </div>
        <div>
            <!-- Rounded switch -->
        <label  style="font-weight:bold;font-size:22px">Fire Alarm</label>

        </div>
    </div>

<!-- Data Table-->
<div class="container" style="margin-top:5pc">
  <div class="row">
    <div class="col">
      <center><h4>Temperature Sensor</h4></center>
    <table class="table">
        <thead style="background-color: green;color:white">
            <tr>
            <th scope="col"> TEMP ID</th>
            <th scope="col">°Celsius</th>
            <th scope="col">Timestamp</th>
            </tr>
        </thead>
        <tbody style="background-color:white">
        <?php

            $query2 = "SELECT id, temperature, created_at FROM temp_sensor ORDER BY created_at DESC LIMIT 5";
            $result2 = mysqli_query($connect,$query2);
            
            if (mysqli_num_rows($result2) > 0) {
                // output data of each row
                while($row2 = mysqli_fetch_assoc($result2)) {

                  ?>
                    <tr>
                    <th scope="row"><?php echo  $row2["id"] ?></th>
                    <td><?php echo  $row2["temperature"] ?></td>
                    <td><?php echo  $row2["created_at"] ?></td>
                    </tr>
                  <?php
                  
                }
              } 
        ?>
            
        </tbody>
        </table>
    </div>
    <div class="col">
    <center><h4>Flame Sensor</h4></center>
    <table class="table">
        <thead style="background-color: red;color:white">
            <tr>
            <th scope="col">FLAME ID</th>
            <th scope="col">Status</th>
            <th scope="col">Timestamp</th>
            </tr>
        </thead >
        <tbody  style="background-color:white">
        <?php

            $query3 = "SELECT id, stat, created_at FROM flame_sensor ORDER BY created_at DESC LIMIT 5";
            $result3 = mysqli_query($connect,$query3);
            
            if (mysqli_num_rows($result3) > 0) {
                // output data of each row
                while($row3 = mysqli_fetch_assoc($result3)) {

                  ?>
                    <tr>
                    <th scope="row"><?php echo  $row3["id"] ?></th>
                    <td><?php  $text = ($row3["stat"]==1)? "Active":"Inactive"; echo $text ?></td>
                    <td><?php echo  $row3["created_at"] ?></td>
                    </tr>
                  <?php
                  
                }
              }
        ?>
            
        </tbody>
        </table>
    </div>
  </div>
</div>





    <script>

        let sirenBtn = document.getElementById('switchBox');

        sirenBtn.addEventListener("click", function(){
            if(sirenBtn.checked){
                window.location.href = "update.php?state=1";
              
            }else{
                window.location.href = "update.php?state=0";
            }
        });
            
        if(sirenState === 1){
                sirenBtn.checked = true;
                console.log("checked");
                document.getElementById("alert").click();
        }else{
                sirenBtn.checked = false;
                console.log("not checked");
        }

    </script>
</body>
</html>