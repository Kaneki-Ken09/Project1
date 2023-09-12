<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Project 1</title>

<link rel="stylesheet" type="text/css" href="assets/css/style.css" />

</head>
<body>

<img src="assets/images/banner2.jpg" style="width:100%" >

<?php include('includes/nav.php'); ?>

<div class="container">
        <div class="wrapper">
		                <h2>Employees Details</h2>
						<a href="index.php"><button type="button">Add New Employee</button></a>
						
					<?php
					// Include config file
					require_once "includes/config.php";
					
					// Attemp select query execution
					$sql = "SELECT * FROM employees";
					if($result = $mysqli->query($sql)){
						if($result->num_rows > 0){
							echo "<table>";
							   echo "<thead>";
							      echo "<tr>";
								     echo "<th>Name</th>";
									 echo "<th>Address</th>";
									 echo "<th>Salary</th>";
									 echo "<th>Action</th>";
								  echo "</tr>";
								  
						   echo "</thead>";
						   echo "<tbody>";
						   while($row = $result->fetch_array()){
							   echo "<tr>";
							   echo "<td>" . $row['name'] . "</td>";
							   echo "<td>" . $row['address'] . "</td>";;
							   echo "<td>" . $row['salary'] . "</td>";;
							   echo "<td>";
							   echo "<a href='read.php?id=". $row['id'] ."'><span>View &nbsp</span></a>";
							   echo "<a href='update.php?id=". $row['id'] ."'><span>Update &nbsp</span></a>";
							   echo "<a href='delete.php?id=". $row['id'] ."'><span>Delete</span></a>";
							   echo "<td>";
							   echo "<tr>";
							   
						   }
						   echo "</tbody>";
						 echo "</table>";
						  // Free result set 
						  $result->free();
						} else{
							echo "<p class='lead'><em>No records were founds.</em></p>";
						}
					} else{
						echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
					}
					
					// Close connection
					$mysqli->close();
					?>
				</div>
		</div>
</body>
</html>