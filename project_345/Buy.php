	<?php 
	$servername='localhost';
	$username='root';
	$dbName='ccc';
	$password='';
	$cust_name=-1;
	$exp_date='';
	$cr_limit=-1;
	$current_ammount=-1;
	$acc_dealer='';
	$flag=0;

	$conn = mysqli_connect($servername,$username,$password,$dbName);
	$time=date("Y/m/d");

	if(!$conn){
		die("Connection failed: " . mysqli_error());
	}
	if(isset($_POST['buy_btn'])){
		session_start();
		
		
		$customer=mysql_real_escape_string($_POST['cust_num']);
		$dealer =mysql_real_escape_string($_POST['deal_num']);
		$employee=mysql_real_escape_string($_POST['emp_name']);
		$Price =mysql_real_escape_string($_POST['Price']);
		$deal_type=mysql_real_escape_string($_POST['deal_type']);
		
		$type='';
		if($employee!=''){
			$type='employee';
		}else if($customer!='') {
			$type='customer';
		}
		echo $type."<br>";
		$sql_acc_of_customer ="SELECT * FROM customer  WHERE acc_num =$customer";
		$sql_acc_of_employee ="SELECT * FROM employee  WHERE name ='$employee'";
		$sql_acc_of_dealer ="SELECT   * FROM dealer  WHERE acc_num =$dealer";
		$result_acc_of_customer = mysqli_query($conn,$sql_acc_of_customer);
		$result_acc_of_employee= mysqli_query($conn,$sql_acc_of_employee);
		$result_acc_of_dealer = mysqli_query($conn,$sql_acc_of_dealer);



		if($type=='customer'){
			if (mysqli_num_rows($result_acc_of_customer) > 0) {


				while($row = mysqli_fetch_assoc($result_acc_of_customer)) {
					$cust_name= $row['name'];
					$exp_date=$row['exp_date'];
					$cr_limit=$row['cr_limit'];
					$current_amount=$row['curr_amount'];
				}
			}else{
				$flag=1;
				echo "Customer doesnt exist <br>";
			}

		}
		if($type=='employee'){
			if (mysqli_num_rows($result_acc_of_employee) > 0){

				while($row = mysqli_fetch_assoc($result_acc_of_employee)) {
					$emp_name= $row['name'];
					$emp_acc=$row['acc_num'];
				}
				$sql_company="SELECT * FROM company WHERE acc_num=$emp_acc";
				$result_company=mysqli_query($conn,$sql_company);
				if(mysqli_num_rows($result_company)>0){
					while($row=mysqli_fetch_assoc($result_company)){
						$comp_acc=$row['acc_num'];
						$comp_cr_limit=$row['cr_limit'];
						$comp_curr_am=$row['curr_amount'];
						$comp_exp_date=$row['exp_date'];

					}
				}else{
					echo "This employeer doesnt belong to company";
					$flag=1;
				}

			}else{	
				echo "Employee doesnt exist <br>";
				$flag=1;
			}
		}
		if (mysqli_num_rows($result_acc_of_dealer) > 0) {

			while($row = mysqli_fetch_assoc($result_acc_of_dealer)) {
				$acc_dealer= $row['name'];
				$acc_num=$row['acc_num'];


			}
		}else{
			$flag=1;
			echo "Dealer doesnt exist <br>";
		}

		if($type=='employee'&& $flag==0){
			if($time>=$comp_exp_date){
				echo "Your card has expired cannot complete deal <br>";
			}else{

				if($deal_type=='Credit'){
					if($Price>$comp_cr_limit){
						echo "Company's credit limit isnt enough to complete transcation<br>";
					}else{
						$sql1 = "UPDATE company SET rem_dept =rem_dept+$Price WHERE acc_num = $comp_acc ";
						$sql2 = "UPDATE company SET cr_limit =cr_limit-$Price WHERE acc_num = $comp_acc  ";
						$temp="SELECT deal_id FROM deal ORDER BY deal_id DESC LIMIT 1";
						$t_r=mysqli_query($conn,$temp);
						$id=mysqli_fetch_assoc($t_r)['deal_id']+1;

						$t=intval($id);
						
						$sql6="INSERT INTO deal(deal_id,cust_name,deal_name,date,amount,type,type_deal)VALUES('$t','$emp_name','$acc_dealer','$time','$Price','buy','$deal_type')";
						if(mysqli_query($conn,$sql6)){
							echo "Deal created<br>";
						}else{
							echo "Error" . $sql6 . "<br>" . mysqli_error($conn);
						}
					}


				}else{
					if($Price>$comp_curr_am){
						echo "Company's total ammount isnt enough to complete transaction,maybe try buying with credit";
					}else{
						$sql1 = "UPDATE company SET curr_amount =curr_amount-$Price WHERE acc_num = $comp_acc ";
						$temp="SELECT deal_id FROM deal ORDER BY deal_id DESC LIMIT 1";
						$t_r=mysqli_query($conn,$temp);
						$id=mysqli_fetch_assoc($t_r)['deal_id']+1;

						$t=intval($id);
						
						$sql6="INSERT INTO deal(deal_id,cust_name,deal_name,date,amount,type,type_deal)VALUES('$t','$emp_name','$acc_dealer','$time','$Price','buy','$deal_type')";
						if(mysqli_query($conn,$sql6)){
							echo "Deal created<br>";
						}else{
							echo "Error" . $sql6 . "<br>" . mysqli_error($conn);
						}


					}


				}
			}



		}else if($type=='customer'&& $flag==0){
			if($time>=$exp_date){
				echo "Your card has expired cannot complete deal <br>";
			}else{
				if($deal_type=='Credit'){
					if($Price>$cr_limit){
						echo "Your credit limit isnt enough";
					}else{
						$sql1 = "UPDATE customer SET rem_dept =rem_dept+$Price WHERE acc_num = $customer ";
						$sql2 = "UPDATE customer SET cr_limit =cr_limit-$Price WHERE acc_num = $customer  ";
						$temp="SELECT deal_id FROM deal ORDER BY deal_id DESC LIMIT 1";
						$t_r=mysqli_query($conn,$temp);
						$id=mysqli_fetch_assoc($t_r)['deal_id']+1;

						$t=intval($id);
						
						$sql6="INSERT INTO deal(deal_id,cust_name,deal_name,date,amount,type,type_deal)VALUES('$t','$cust_name','$acc_dealer','$time','$Price','buy','$deal_type')";
						if(mysqli_query($conn,$sql6)){
							echo "Deal created<br>";
						}else{
							echo "Error" . $sql6 . "<br>" . mysqli_error($conn);
						}
					}


				}else if($deal_type=='Cash'){
					if($Price>$current_amount){
						echo "Your current amount isnt enough,maybe try with credit";
					}else{
						$sql1 = "UPDATE customer SET curr_amount =curr_amount-$Price WHERE acc_num = $customer ";
						
						$temp="SELECT deal_id FROM deal ORDER BY deal_id DESC LIMIT 1";
						$t_r=mysqli_query($conn,$temp);
						$id=mysqli_fetch_assoc($t_r)['deal_id']+1;

						$t=intval($id);
						
						$sql6="INSERT INTO deal(deal_id,cust_name,deal_name,date,amount,type,type_deal)VALUES('$t','$cust_name','$acc_dealer','$time','$Price','buy','$deal_type')";
						if(mysqli_query($conn,$sql6)){
							echo "Deal created<br>";
						}else{
							echo "Error" . $sql6 . "<br>" . mysqli_error($conn);
						}
					}

				}
			}


		}

		/*if($cr_limit<$Price && $flag==0){
			echo "You exeed your credit limit , unable to complete transcation";

		}*/
		if($flag==0){

			
			$sql3 = "UPDATE dealer SET profit =profit+($Price*(1-term)) WHERE acc_num = $dealer  ";
			
			$sql5 = "UPDATE dealer SET dept =dept+$Price*term WHERE acc_num = $dealer  ";
			
			

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
			<a href="CreateEmployee.php">Create Employer</a>
			<a href="DeleteUser.php">Delete customer</a>
			<a href="DeleteDealer.php">Delete dealer</a>
			<a href="DeleteCompany.php">Delete company</a>
			<a href="Buy.php">Buy</a>
			<a href="Retail.php">Retail</a>
			<a href="Pay.php">Pay</a>
			<a href="Questions.php">Question</a>
			<a href="ShowGoodUser.php">Show good customers</a>
			<a href="ShowBadUser.php">Show bad customers</a>
			<a href="DealerOfTheMonth">Dealer of the month !</a>
		</nav>
		<div id="main">
			<header class="w3-container w3-teal">
				<span class="w3-opennav w3-xlarge" onclick="w3_open()" id="openNav">&#9776;</span>
				<h1>Buy something</h1>
			</header>
			<br>
			<h2 style="text-align: center;color: #196666">Choose a user's account or employer's name in order to buy from Dealer's account</h2>
			<div align="center" class="dealer">
				<br>

				<?php 
				$sql = "SELECT * FROM customer ";
				$result = mysqli_query($conn, $sql);
				echo "The names of customers are :  ";
				if (mysqli_num_rows($result) > 0) {
				    // output data of each row

					echo "<br>";

					while($row = mysqli_fetch_assoc($result)) {
						echo "Customer-Name: " . $row["name"].","." Limit : ".$row["cr_limit"] . " Account : " .$row["acc_num"]. "<br>";

					}
				} else {
					echo "There are 0 customers";
				}
				?>
			</div>
			<br>
			<br>
			<div align="center" class="dealer">
				<br>

				<?php 
				$sql = "SELECT * FROM employee ";
				$result = mysqli_query($conn, $sql);
				echo "The names of company employees are :  ";
				if (mysqli_num_rows($result) > 0) {
				    // output data of each row

					echo "<br>";

					while($row = mysqli_fetch_assoc($result)) {
						echo "Employee name : " . $row["name"]. " Account : " .$row["acc_num"]. "<br>";

					}
				} else {
					echo "There are 0 employees";
				}
				?>	

				<br>
				<br>
				<div align="center" class="dealer">
					<?php 
					$sql = "SELECT * FROM dealer ";
					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {
				    // output data of each row
						echo "The names are : ". "<br>";

						while($row = mysqli_fetch_assoc($result)) {
							echo "dealer-Name: " . $row["name"]. " Account Number : ".$row["acc_num"]."<br>";

						}
					} else {
						echo "There are 0 dealers";
					}
					?>
				</div>
				<br>

				<div class="forms">
					<form method="post" action="Buy.php">
						<table>
							<tr>
								<td>Customer account :</td>
								<td><input type="Number" name="cust_num" class="textInput"></td>
							</tr>
							<tr>
								<td>Employee name : </td>
								<td><input type="text" name="emp_name" class="textInput"></td>
							</tr>

							<tr>
								<td>Dealer account :</td>
								<td><input type="Number" name="deal_num" class="textInput"></td>
							</tr>
							<tr>
								<td>Price of the item :</td>
								<td><input type="Number" name="Price" class="textInput"></td>
							</tr>
							<tr>
								<td>Buy with credit or cash : </td>
								<td><input type="radio" name="deal_type" value="Cash">Cash
									<input type="radio" name="deal_type" value="Credit" checked>Credit</td>
								</tr>
								<tr>
									<td><br><br></td>
									<td><input type="submit" name="buy_btn" value="Buy" "></td>
								</tr>
							</table>
						</form>
					</div>




				</div>
			</body>
			</html>