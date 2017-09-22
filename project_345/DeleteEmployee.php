<?php
$servername='localhost';
$username='root';
$dbName='ccc';
$password='';

$conn = mysqli_connect($servername,$username,$password,$dbName);

if(!$conn){
	die("Connection failed: " . mysqli_error());
}


if(isset($_POST['delete_btn'])){
	$zero=0;
	session_start();
	$id=mysql_real_escape_string($_POST['id']);
	
	$sql="DELETE  FROM employee WHERE id= $id ";
	if(mysqli_query($conn,$sql)){
	echo "Employee  has been deleted  <br>";
	}
	
	else{
		echo "Error" . $sql . "<br>" . mysqli_error($conn);
	}
}



?>
<!DOCTYPE html>
<html>
<head>
<title>Register Customer</title>
<link rel="stylesheet" type="text/css" href="Style.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<script src="script.js"></script>
</head>
<title>Register</title>
<body>
<nav class="w3-sidenav w3-white w3-card-2 w3-animate-left" style="display:none" id="mySidenav">
		<a href="javascript:void(0)" 
		onclick="w3_close()"
		class="w3-closenav w3-large">Close &times;</a>
			<a href="HomePage.php">Home</a>
		<a href="CreateUser.php">Create customer</a>
		<a href="CreateDealer.php">Create dealer</a>
		<a href="CreateCompany.php">Create company</a>
		<a href="CreateEmployee.php">Create employee</a>
		<a href="DeleteUser.php">Delete customer</a>
		<a href="DeleteDealer.php">Delete dealer</a>
		<a href="DeleteCompany.php">Delete company</a>
		<a href="DeleteEmployee.php">Delete employee</a>
        <a href="Buy.php">Buy</a>
		<a href="Retail.php">Retail</a>
		<a href="Pay.php">Pay</a>
		<a href="Questions.php">Question</a>
		<a href="ShowGoodUser.php">Show good customers</a>
		<a href="ShowBadUser.php">Show bad customers</a>
		<a href="DealerOfTheMonth.php">Dealer of the month !</a>

	</nav>
	<div id="main">
	<header class="w3-container w3-teal">
		<span class="w3-opennav w3-xlarge" onclick="w3_open()" id="openNav">&#9776;</span>
	<h1>Delete Dealer from CCC bank </h1>
	</div>
	<br>
	<h2 style="color: #196666;text-align:center;">Delete a Dealer</h2>
	<div class="forms">
		<form method="post" action="DeleteEmployee.php">
			Employee id : 
			<input type="number" name ="id" classid="textInput"> <br>
			<input type="submit" name="delete_btn" value="Delete" ><br>
			
			<div align="center" class="dealer">
			<?php 
				$sql = "SELECT * FROM employee ";
				$result = mysqli_query($conn, $sql);
				echo "The employees are :  ";
				if (mysqli_num_rows($result) > 0) {
			    
			    
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "<br>Name: " . $row["name"]. "<br>ID : ".$row["id"]."<br>";
			        
			    }
				} else {
			    	echo "There are 0 Employees";
				}
			?>
		</div>	
		</form>
		
	</div>
</body>
</html>

