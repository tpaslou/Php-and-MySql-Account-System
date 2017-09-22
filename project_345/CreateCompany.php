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
$exp_date=mysql_real_escape_string($_POST['exp_date']);
$cr_limit=mysql_real_escape_string($_POST['cr_limit']);
$curr_amount=mysql_real_escape_string($_POST['curr_amount']);
$rem_dept=0;

$sql="INSERT INTO company(name,acc_num,exp_date,cr_limit,curr_amount,rem_dept)VALUES('$name','$acc_number','$exp_date','$cr_limit','$curr_amount','$rem_dept')";
if(mysqli_query($conn,$sql)){
	echo "New company Created";
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
<title>Register company</title>
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
	<h2 style="color: #196666;text-align:center;">Register as Company</h2>
	<div class="forms">
	<form method="post" action="CreateCompany.php">
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
			<td>Expirtation Date :</td>
			<td><input type="date" name="exp_date" class="textInput"></td>
		</tr>
		<tr>
			<td>Credit limit :</td>
			<td><input type="number" name="cr_limit" class="textInput"></td>
		</tr>
		<tr>
			<td>Current amount :</td>
			<td><input type="number" name="curr_amount" class="textInput"></td>
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

