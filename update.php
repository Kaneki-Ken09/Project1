<?php
// Include config file
require_once "includes/config.php";
// Define variables and initialize with empty values
$employeename = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
 // Get hidden input value
 $id = $_POST["id"];
 
 // Validate name
 $input_name = trim($_POST["employeename"]);
 if(empty($input_name)){
 $name_err = "Please enter a name.";
 } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, 
array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
 $name_err = "Please enter a valid name.";
 } else{
 $employeename = $input_name;
 }
 
 // Validate address address
 $input_address = trim($_POST["address"]);
 if(empty($input_address)){
 $address_err = "Please enter an address."; 
 } else{
 $address = $input_address;
 }
 
 // Validate salary
 $input_salary = trim($_POST["salary"]);
 if(empty($input_salary)){
 $salary_err = "Please enter the salary amount."; 
 } elseif(!ctype_digit($input_salary)){
 $salary_err = "Please enter a positive integer value.";
 } else{
 $salary = $input_salary;
 }
 // Check input errors before inserting in database
 if(empty($name_err) && empty($address_err) && empty($salary_err)){
 // Prepare an update statement
 $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
 if($stmt = $mysqli->prepare($sql)){
 // Bind variables to the prepared statement as parameters
 $stmt->bind_param("sssi", $param_name, $param_address, $param_salary, 
$param_id);
 
 // Set parameters
 $param_name = $employeename;
 $param_address = $address;
 $param_salary = $salary;
 $param_id = $id;
 
 // Attempt to execute the prepared statement
 if($stmt->execute()){
 // Records updated successfully. Redirect to landing page
 header("location: view.php");
 exit();
 } else{
 echo "Something went wrong. Please try again later.";
 }
 }
 
 // Close statement
 $stmt->close();
 }
 
 // Close connection
 $mysqli->close();
} else{
 // Check existence of id parameter before processing further
 if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
 // Get URL parameter
 $id = trim($_GET["id"]);
 // Prepare a select statement
 $sql = "SELECT * FROM employees WHERE id = ?";
 if($stmt = $mysqli->prepare($sql)){
 // Bind variables to the prepared statement as parameters
 $stmt->bind_param("i", $param_id);
 
 // Set parameters
 $param_id = $id;
 
 // Attempt to execute the prepared statement
 if($stmt->execute()){
 $result = $stmt->get_result();
 
 if($result->num_rows == 1){
 /* Fetch result row as an associative array. Since the result 
set
 contains only one row, we don't need to use while loop */
 $row = $result->fetch_array(MYSQLI_ASSOC);
 
 // Retrieve individual field value
 $employeename = $row["name"];
 $address = $row["address"];
 $salary = $row["salary"];
 } else{
 // URL doesn't contain valid id. Redirect to error page
 header("location: error.php");
 exit();
 }
 
 } else{
 echo "Oops! Something went wrong. Please try again later.";
 }
 }
 
 // Close statement
 $stmt->close();
 
 // Close connection
 $mysqli->close();
 } else{
 // URL doesn't contain id parameter. Redirect to error page
 header("location: error.php");
 exit();
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP Project 1</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<body>
<img src="assets/images/PHP PROJECT.jpg" style="width:100%" >
<?php include('includes/nav.php'); ?>
<div class="container">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
method="post">
<div class="row">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>
<div class="col-25" >
<label>Employee Name</label>
</div>
<div class="col-75">
<input type="text" name="employeename" placeholder="Employee 
Name" value="<?php echo $employeename; ?>" />
<span style="color:red;"><?php echo $name_err;?></span>
</div>
</div>
<div class="row">
<div class="col-25">
<label>Address</label>
</div>
<div class="col-75">
<input type="text" name="address" placeholder="Address" 
value="<?php echo $address; ?>" >
<span style="color:red;"><?php echo $address_err;?></span>
</div>
</div>
<div class="row">
<div class="col-25">
<label>Salary</label>
</div>
<div class="col-75">
<input type="text" name="salary" placeholder="00.00" 
value="<?php echo $salary; ?>" >
<span style="color:red;"><?php echo $salary_err;?></span>
</div>
</div>
<br />
<div class="row">
<input type="Submit" value="Update">
</div>
</form>
</div>
</body>
</html>