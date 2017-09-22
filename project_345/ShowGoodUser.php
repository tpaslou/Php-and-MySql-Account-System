<?php
$servername='localhost';
$username='root';
$dbName='ccc';
$password='';

$conn = mysqli_connect($servername,$username,$password,$dbName);

if(!$conn){
	die("Connection failed: " . mysqli_error());
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
	<h1>Show good customers from CCC bank </h1>
	</div>
	<br>
	<h2 style="color: #196666;text-align:center;">Show good customers</h2>
	<div class="forms">
		<form method="post" action="ShowGoodUser.php">
			
			<div style="text-align: center" class="textInput">
			<?php 
				$sql = "SELECT * FROM customer WHERE rem_dept=0 ";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    	echo "The Citizens are :  ";
				    
				    
				    while($row = mysqli_fetch_assoc($result)) {
				        echo "<br>Customer-Name : " . $row["name"] . " <br>Account Number : " .
				         $row["acc_num"] . "<br>exp_date : " . $row["exp_date"] . "<br>cr_limit : " . $row["cr_limit"] . 
				         "<br> curr_ammount " . $row["curr_amount"] . "<br> rem_dept " . $row["rem_dept"] .  "<br>";

				        
				    }
				} else {
			    	echo "There are 0 customers";
				}
			?>
			
		</div><br><br>	
		<div style="text-align: center" class="textInput">
			<?php 
				$sql = "SELECT * FROM company WHERE rem_dept=0 ";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    	echo "The Companies are :  ";
				    
				    
				    while($row = mysqli_fetch_assoc($result)) {
				        echo "<br>Company-Name : " . $row["name"] . " <br>Account Number : " .
				         $row["acc_num"] . "<br>exp_date : " . $row["exp_date"] . "<br>cr_limit : " . $row["cr_limit"] . 
				         "<br> curr_ammount " . $row["curr_amount"] . "<br> rem_dept " . $row["rem_dept"] .  "<br>";

				        
				    }
				} else {
			    	echo "There are 0 companies";
				}
			?>
			
		</div><br><br>
		<div style="text-align: center" class="textInput">
			<?php 
				$sql = "SELECT * FROM dealer WHERE dept<=0 ";
				$result = mysqli_query($conn, $sql);
				
				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    	echo "The Dealers are :  <br>";
				    
				    
				    while($row = mysqli_fetch_assoc($result)) {
				        echo "<br>Dealer-Name : " . $row["name"] . " <br>Account Number : " .
				         $row["acc_num"] . "<br>Term : " . $row["term"] . "<br>Profit : " . $row["profit"] . 
				          "<br> rem_dept "  .  "<br>";

				        
				    }
				} else {
			    	echo "There are 0 dealers";
				}
			?>
			
		</div>
	</div>
</body>
</html>

