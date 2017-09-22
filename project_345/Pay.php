<?php 
	$servername='localhost';
	$username='root';
	$dbName='ccc';
	$password='';
	
	$flag=0;

	$conn = mysqli_connect($servername,$username,$password,$dbName);

	if(!$conn){
		die("Connection failed: " . mysqli_error());
	}
	if(isset($_POST['pay_btn'])){
		session_start();
		
		
		$acc=mysql_real_escape_string($_POST['acc_num']);
		$amount =mysql_real_escape_string($_POST['amount']);
		
		
		$sql_acc_of_customer ="SELECT * FROM customer  WHERE acc_num = $acc";
	    $sql_acc_of_dealer ="SELECT   * FROM dealer  WHERE acc_num = $acc";
	    $sql_acc_of_company ="SELECT   * FROM company  WHERE acc_num = $acc";
	    $result_acc_of_customer = mysqli_query($conn,$sql_acc_of_customer);
	    $result_acc_of_dealer = mysqli_query($conn,$sql_acc_of_dealer);
	    $result_acc_of_company = mysqli_query($conn,$sql_acc_of_company);

	    $account='';
	    $type='';
	    if($result_acc_of_customer && mysqli_num_rows($result_acc_of_customer) > 0){ 
            
            $type="Customer";              
	    }
	    if($result_acc_of_dealer && mysqli_num_rows($result_acc_of_dealer) > 0){
	    	
            $type="Dealer";
	    } 

	    if($result_acc_of_company && mysqli_num_rows($result_acc_of_company) > 0){
	    	
            $type="Company";
        } 

	   


	    if($type=="Customer"){
	    	
	    	$sql1="UPDATE customer SET rem_dept =rem_dept-$amount WHERE acc_num = $acc";
	    	$sql2 = "UPDATE customer SET cr_limit =1000 WHERE acc_num = $acc ";
	    	$sql3="UPDATE customer SET curr_amount=curr_amount-$amount WHERE acc_num = $acc";
	    	if(mysqli_query($conn,$sql1)&&mysqli_query($conn,$sql2)&&mysqli_query($conn,$sql3)){
	    		echo "Customer pay complete<br>";
	    	}else{
	    		echo "Customer pay failed<br>";
	    	}
	    }else if($type=="Dealer"){
	    	$sql4="UPDATE dealer SET dept =dept-$amount WHERE acc_num = $acc";
	    	$sql5="UPDATE dealer SET profit =profit-$amount WHERE acc_num = $acc";
	    	if(mysqli_query($conn,$sql4)&&mysqli_query($conn,$sql5)){
	    		echo "Dealer pay complete<br>";
	    	}else{
	    		echo "Dealer pay failed<br>";
	    	}
	    }else if($type=="Company"){
	    	$sql6="UPDATE company SET rem_dept =rem_dept-$amount WHERE acc_num = $acc";
	    	$sql7="UPDATE company SET cr_limit =10000 WHERE acc_num = $acc";
	    	$sql8="UPDATE company SET curr_amount=curr_amount-$amount WHERE acc_num = $acc";
	    	if(mysqli_query($conn,$sql6)&&mysqli_query($conn,$sql7)&&mysqli_query($conn,$sql8)){
	    		echo "Company pay complete<br>";
	    	}else{
	    		echo "Company pay failed<br>";
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
				<h1>Pay dept</h1>
			</header>
			<br>
			<h2 style="text-align: center;color: #196666">Pay your dept to CCC </h2>
			<div align="center" class="dealer">
				<br>

				<?php 
				$sql = "SELECT * FROM customer ";
				$result = mysqli_query($conn, $sql);
				echo "Customer depts :  ";
				if (mysqli_num_rows($result) > 0) {
				    // output data of each row

					echo "<br>";

					while($row = mysqli_fetch_assoc($result)) {
						echo "Customer-Name: " . $row["name"].","." Dept : ".$row["rem_dept"] . " Account : " .$row["acc_num"]. "<br>";

					}
				} else {
					echo "There are 0 customers";
				}
				?>
			</div>	
		</form>
		<br>
		<br>
		<div align="center" class="dealer">
			<?php 
			$sql = "SELECT * FROM dealer ";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				    // output data of each row
				echo "Dealer depts : ". "<br>";

				while($row = mysqli_fetch_assoc($result)) {
					echo "Dealer-Name: " . $row["name"]. " Account Number : ".$row["acc_num"]. " Dept : " .$row["dept"].   "<br>";

				}
			} else {
				echo "There are 0 dealers";
			}
			?>
		</div>
		<br>
		<div align="center" class="dealer">
			<?php 
			$sql = "SELECT * FROM company ";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				    // output data of each row
				echo "Company depts : ". "<br>";

				while($row = mysqli_fetch_assoc($result)) {
					echo "Company : " . $row["name"]. " Account Number : ".$row["acc_num"]. " Dept : " .$row["rem_dept"].   "<br>";
					$tmp=$row["acc_num"];
					$sql2="SELECT * FROM employee WHERE acc_num=$tmp";
					echo "Employees of the company : <br>";
					$r_em=mysqli_query($conn,$sql2);
					if (mysqli_num_rows($result) > 0) {
						while($row2 = mysqli_fetch_assoc($r_em)) {
                            echo "Employee Name : " .$row2["name"]. " Id : " .$row2['id']. "<br>";

						}

					}


				}
			} else {
				echo "There are 0 dealers";
			}
			?>
		</div>
		<br>
		
		<div class="forms">
			<form method="post" action="Pay.php">
				<table>
					
					<tr>
						<td>Account number :</td>
						<td><input type="Number" name="acc_num" class="textInput"></td>
					</tr>
					<tr>
						<td>Amount to pay :</td>
						<td><input type="Number" name="amount" class="textInput"></td>
					</tr>
					<tr>
						<td><br><br></td>
						<td><input type="submit" name="pay_btn" value="Pay" "></td>
					</tr>
				</table>
			</form>
		</div>



	</div>
</body>
</html>