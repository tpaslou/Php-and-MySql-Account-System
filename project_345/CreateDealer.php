<?php
$servername='localhost';
$username='root';
$dbName='ccc';
$password='';

$conn = mysqli_connect($servername,$username,$password,$dbName);

if(!$conn){
	die("Connection failed: " . mysqli_error());
}
if(isset($_POST['create_btn'])){
	session_start();
$name=mysql_real_escape_string($_POST['name']);
$acc_number=mysql_real_escape_string($_POST['acc_number']);
$term=mysql_real_escape_string($_POST['term']);
$profit=mysql_real_escape_string($_POST['profit']);
$dept=0;

$sql="INSERT INTO dealer(name,acc_num,term,profit,dept)VALUES('$name','$acc_number','$term','$profit','$dept')";
if(mysqli_query($conn,$sql)){
	echo "New Dealer Created";
}else{
	echo "Error" . $sql . "<br>" . mysqli_error($conn);
}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Register Company</title>
<link rel="stylesheet" type="text/css" href="Style.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<script src="script.js"></script>
</head>
<title>Register dealer</title>
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
	<h1>Register to CCC bank </h1>
	</header>
	<br>
	<h2 style="color: #196666;text-align:center;">Register as dealer</h2>
	<div class="forms">
	<form method="post" action="CreateDealer.php">
	<table>
		<tr>
		<td>Name :</td>
		<td><input type="text" name="name" class="textInput"></td>
		</tr>
		<tr>
			<td>Account Number :</td>
			<td><input type="number" name="acc_number" class="textInput"></td>
		</tr>
		<tr>
			<td>Term :</td>
			<td><input type="number" step="any" name="term" class="textInput"></td>
		</tr>
		<tr>
			<td>Profir :</td>
			<td><input type="number" step="any" name="profit" class="textInput"></td>
		</tr>
		
		<tr>
			<td>Current amount :</td>
			<td><input type="submit" name="create_btn" value="create" "></td>
		</tr>
	</table>
	</form>
	</div>
	</div>
</body>
</html>

