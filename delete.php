<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
	// Include config file
	require_once "includes/config.php";
	
	// Prepare a delete statement
	$sql = "DELETE FROM employees WHERE id = ?";
	
	if($stmt = $mysqli->prepare($sql)){
		// Bind variables to the perpared statement as parameters
		$stmt->bind_param("i", $param_id);
		
		//Set parameters
		$param_id = trim($_POST["id"]);
		
		// Attempt to execute the prepared statement
		if($stmt->execute()){
			// Records deleted successfully. Redirect to landing page
			header("location: view.php");
			exit();
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
	}
	
	// Close statement
	$stmt->close();
	
	// Close connection
	$mysqli->close();
} else{
	//Check existence of id parameter
	if(empty(trim($_GET["id"]))){
		// URL doesen't contain id parameter. Redirect to error page
		header("location: error.php");
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Project 1</title>

<link rel="stylesheet" type="text/css" href="assets/css/style.css"/>

</head>
<body>
<img src="assets/images/PHP PROJECT.jpg" style="width:100%">

<?php include('includes/nav.php'); ?>

<div class="container">
	<div class="wrapper">
		
					<h1>Delete Records</h1>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					
					<input type="hidden" name="id" value="<?php echo trim($_GET["id"]);?>"/>
					<p>Are you sure you want to delete this record?</p><br>
					
					<div class="row">
					<a href="view.php"><input type="Submit" value="Yes" style="float: left;"></a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>