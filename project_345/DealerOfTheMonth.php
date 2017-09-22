<?php 
	$servername='localhost';
	$username='root';
	$dbName='ccc';
	$password='';
	
	$amount=0;
	$num=0;

	$conn = mysqli_connect($servername,$username,$password,$dbName);

	if(!$conn){
		die("Connection failed: " . mysqli_error());
	}
	if(isset($_POST['show_btn'])){
		session_start();
		$deal_month="";
		$mydate=mysql_real_escape_string($_POST['date']);
		$dtc=strtotime($mydate);
        $mtc=date('m',$dtc);
		$cust="SELECT * FROM  deal  /*WHERE date  = $mydate*/";
		$result_cust = mysqli_query($conn,$cust);
		
		 if (mysqli_num_rows($result_cust) > 0) {
             while($row=mysqli_fetch_assoc($result_cust)){
             	
             	$curr_d=strtotime($row['date']);
             	$month=date('m',$curr_d);
             	$amnt=$row['amount'];


             	if($mtc==$month && $amnt>$amount){
             		$amount=$amnt;
             		$deal_month=$row['deal_name'];


             	}
             }
             
             $dealer="SELECT * FROM dealer WHERE name='$deal_month' ";
             $result_deal = mysqli_query($conn,$dealer);
             while($row=mysqli_fetch_assoc($result_deal)){
             $num=$row['acc_num'];
             }
              

            $sql5="UPDATE dealer SET dept =dept*0.95 WHERE acc_num = $num";
	    	if(mysqli_query($conn,$sql5)){
	    		echo "Dealer dept reduction completed<br>";
	    	}else{
	    		echo "Dealer dept reduction failed<br>";
	    	}
             

	     }
    }
?>




<!DOCTYPE html>
	<html>
	<head>
		<title>CCC bank</title>
		<link rel="stylesheet" type="text/css" href="Style.css">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<script src="script.js"></script>
	</head>

	<title>Welcome to CCC bank </title>
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
				<h1>Buy something</h1>
			</header>
			<br>
			<h2 style="text-align: center;color: #196666">Show dealer of the month acording to date </h2>
			<div align="center" class="dealer">
				<br>

		
		<div align="center" class="dealer">
			<?php 
			$sql = "SELECT * FROM dealer ";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				    // output data of each row
				echo "The complete list of dealers is : ". "<br>";

				while($row = mysqli_fetch_assoc($result)) {
					echo "dealer-Name: " . $row["name"]. "Account Number : ".$row["acc_num"]."<br>";

				}
			} else {
				echo "There are 0 dealers";
			}
			?>
		</div>
		<br>
		
		<div class="forms">
			<form method="post" action="DealerOfTheMonth.php">
				<table>
					
					<tr>
						<td>Select the date  :</td>
						<td><input type="date" name="date" class="textInput"></td>
					</tr>
					<tr>
						<td><br><br></td>
						<td><input type="submit" name="show_btn" value="Show" "></td>
					</tr>
				</table>
			</form>
		</div>
		<br>
		<div class="Dealer" align="center">
		<?php
		
		echo "Dealer of the month is : " .$deal_month. "<br>";
		?>
		</div>



	</div>
</body>
</html>