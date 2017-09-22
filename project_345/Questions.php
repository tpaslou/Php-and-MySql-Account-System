<?php 

$servername='localhost';
$username='root';
$dbName='ccc';
$password='';

$conn = mysqli_connect($servername,$username,$password,$dbName);

if(!$conn){
	die("Connection failed: " . mysqli_error());
}
if(isset($_POST['question_btn'])){
	session_start();
	$cust_name=NULL;
	$deal_name=NULL;
	$flag=0;
	$date_customer="";
	$result3="mpou`";
	$stack_of_dealers=array();
	$acc_number_customer=mysql_real_escape_string($_POST['acc_num1']);
	$acc_number_dealer =mysql_real_escape_string($_POST['acc_num2']);
	$acc_number_company =mysql_real_escape_string($_POST['acc_num3']);
	$date_transaction=mysql_real_escape_string($_POST['date_transaction']);
	$employee_id =mysql_real_escape_string($_POST['employee_id']);
	
	//Question for customer 
	if($acc_number_customer!=NULL&& $acc_number_dealer==NULL 
		&&$acc_number_company==NULL&& $date_transaction!=NULL){
		//Get name of Customer
		$sql1="SELECT * FROM customer WHERE acc_num=$acc_number_customer";
		
		$result1=mysqli_query($conn,$sql1);
		
		if (mysqli_num_rows($result1) > 0) {

	    	while($row = mysqli_fetch_assoc($result1)) {
	    		$cust_name= $row["name"];
	    		
	    	}
	    }else{
	    	echo "Customer doesnt exist <br>";
	    	
	    }
	    
	    if($cust_name!=NULL){
	    	$sql_deal = "SELECT * FROM deal ";
	    	

	    	$result3 = mysqli_query($conn,$sql_deal);
	    	
	    	if(mysqli_num_rows($result3) >0 ){
	    		
	    		while ($row = mysqli_fetch_assoc($result3)) {
	    			if($cust_name==$row["cust_name"]&&$date_transaction==$row["date"]){
	    				echo "Customer-name : ".$row["cust_name"]."<br>Dealer-name : ".$row["deal_name"]."<br>Amount : "
	    				.$row["amount"]."<br>Type : ".$row["type"]."<br>"; 
	    				$flag=1;
	    			}
	    			
	    		}
	    		if($flag==0){
	    			echo "Date or Customer Account is Wrong!!!";
	    		}
	    			
	    	}
	    	else{
	    		echo "There isn't such a transaction!!!";
	    	}
	    }	


	}else if($acc_number_customer==NULL&& $acc_number_dealer!=NULL
			&& $acc_number_company==NULL&& $date_transaction!=NULL){
			$sql2="SELECT * FROM dealer WHERE acc_num=$acc_number_dealer";
			$result2=mysqli_query($conn,$sql2);
			if (mysqli_num_rows($result2) > 0) {

	    		while($row = mysqli_fetch_assoc($result2)) {
	    			$deal_name= $row["name"];
	    			

	    		}
	    	}else{
	    
	    		echo "Dealer doesnt exist <br>";
	    	}
	    	if($deal_name!=NULL){
	    	$sql_deal = "SELECT * FROM deal ";
	    	

	    	$result3 = mysqli_query($conn,$sql_deal);
	    	
	    	if(mysqli_num_rows($result3) >0 ){
	    		
	    		while ($row = mysqli_fetch_assoc($result3)) {
	    			if($deal_name==$row["deal_name"]&&$date_transaction==$row["date"]){
	    				echo "Customer-name : ".$row["cust_name"]."<br>Dealer-name : ".$row["deal_name"].
	    				"<br>Amount : ".$row["amount"]."<br>Type : ".$row["type"]."<br>"; 
	    				$flag=1;
	    			}
	    			
	    		}
	    		if($flag==0){
	    			echo "Date or Dealer Account is Wrong!!!";
	    		}
	    			
	    	}
	    	else{
	    		echo "There isn't such a transaction!!!";
	    	}
	    }
		

	}
	else if($acc_number_customer==NULL&& $acc_number_dealer==NULL&& 
		$acc_number_company!=NULL&& $date_transaction!=NULL){

				
		$sql_deal = "SELECT * FROM deal ";
    	
		$array_of_employees=array();
    	$result3 = mysqli_query($conn,$sql_deal);
    	$sql_employee = "SELECT *FROM employee ";
    	$result4=mysqli_query($conn,$sql_employee);

    	if(mysqli_num_rows($result4)>0){
    		while($row=mysqli_fetch_assoc($result4)){
    			if($acc_number_company==$row["acc_num"]){
    				array_push($array_of_employees, $row["name"]);	
    			}
    		}
    	}
    	print_r($array_of_employees);
    	
    	if(mysqli_num_rows($result3) >0 ){
    		
    		while ($row = mysqli_fetch_assoc($result3)) {
    			if($employee_id!=NULL){
    				for( $i=0;$i<sizeof($array_of_employees);$i++){
		    			if($array_of_employees[$i]==$row["cust_name"]&&$date_transaction==$row["date"]){
		    				echo "<br>Einai enas<br>Customer-name : ".$row["cust_name"]."<br>Dealer-name : ".$row["deal_name"].
		    				"<br>Amount".$row["amount"]."<br>Type".$row["type"]."<br>"; 
		    				$flag=1;
		    			}
		    		}	
    			}else{
    				for($i=0;$i<sizeof($array_of_employees);$i++){
	    				if($array_of_employees[$i]==$row["cust_name"]&&$date_transaction==$row["date"] ){
		    				echo "<br>Mpika stous polloys<br>Customer-name : ".$row["cust_name"]."<br>Dealer-name : ".$row["deal_name"].
		    				"<br>Amount : ".$row["amount"]."<br>Type : ".$row["type"]."<br>"; 
		    				$flag=1;
		    			}
		    		}	
    			}
    			
    		}
    		if($flag==0){
    			echo "Date or Dealer Account is Wrong!!!";
    		}	
    	}
    	else{
    		echo "There isn't such a transaction!!!";
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

<title>Questions </title>
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
		<h1>Welcome to CCC bank</h1>
	</header>
	<h2 style="text-align: center;color: #196666">Press the menu above in order to navigate threw webpage</h2>
	<div class="forms">
		<form method="post" action="Questions.php">
			<div style="text-align: center; ">	
			<div style="text-align: center; ">See the Table Deal below to type correct!!! <br>
			<a href="#bottom">Press me to see How to ask </a>	
			</div>	

			<table align= "center">
				<tr>

					<td>Type Account Number of customer to check transaction :</td>
					<td><input type="number" name ="acc_num1" class="textInput"></td>
					
				</tr><br>
				<tr>
					
					<td>Type Account Number of dealer to check transaction : </td>
					<td><input type="number" name="acc_num2" class="textInput"></td>
					
				</tr><br>
				<tr>
					
					<td>Type Account Number of company to check transaction  all of employment:</td>
					<td><input type="number" name ="acc_num3" class="textInput"></td>
					
				</tr><br>
				<tr>
					<td>Type the date to see the transactions : </td>
					<td><input type="date" name ="date_transaction" class="textInput"></td>
				</tr><br>

				<tr>
					<td>Employee Id</td>
					<td><input type"number" name ="employee_id" class="TextInput" ></input></td></td>
				</tr>
				
				
			</table><br>
				
				<input type="submit" name="question_btn" value="Question" ><br>
				<div style="text-align: left">
				<?php
				echo "<h4>Table of Deal : </h4>"."<br>";

				 $sql1 = "SELECT * FROM deal";
				 $result = mysqli_query($conn, $sql1);
				 if (mysqli_num_rows($result) > 0) {
   
    				while($row = mysqli_fetch_assoc($result)) {
     		    		echo "Transaction id : ".$row["deal_id"]."<br>Customer-name : ". $row["cust_name"]."<br>"."Dealer-name : " .$row["deal_name"]."<br>".
     		    				 "Date : "	.$row["date"]."<br>" ."Amount : " .$row["amount"]."<br>"."Type : ".$row["type"]."<br><br>" ;
        
    				}
    			}
    			else{
			    	echo "Table of deal is EMPTY !!!";
			    	
			    } 
				?>
			</div><br><br>	
			<div style="text-align: left;">
				<?php
				echo "<h4>Table of Customer : </h4>"."<br>";

				 $sql1 = "SELECT * FROM customer";
				 $result = mysqli_query($conn, $sql1);
				 if (mysqli_num_rows($result) > 0) {
   
    				while($row = mysqli_fetch_assoc($result)) {
     		    		echo "Customer-name : ". $row["name"]."<br>"."Account number : " .$row["acc_num"]."<br>".
     		    				 "Limit : "	.$row["cr_limit"]."<br>" ."Amount : " .$row["curr_amount"]."<br>"."Remain Dept : ".$row["rem_dept"]."<br><br>";
        
    				}
    			}
    			else{
			    	echo "Table of costumer is EMPTY !!!";
			    	
			    } 
				?>
			</div><br><br>	
			<div style="text-align: left;">
				<?php
				echo "<h4>Table of Dealer : </h4>"."<br>";

				 $sql1 = "SELECT * FROM dealer";
				 $result = mysqli_query($conn, $sql1);
				 if (mysqli_num_rows($result) > 0) {
   
    				while($row = mysqli_fetch_assoc($result)) {
     		    		echo "Dealer-name : ". $row["name"]."<br>"."Account number : " .$row["acc_num"]."<br>".
     		    				 "Profit : "	.$row["profit"]."<br><br>";
        
    				}
    			}
    			else{
			    	echo "Table of Dealer is EMPTY !!!";
			    	
			    } 
				?>
			</div><br><br>	
			<div style="text-align: left;">
				<?php
				echo "<h4>Table of Company : </h4>"."<br>";

				 $sql1 = "SELECT * FROM company";
				 $result = mysqli_query($conn, $sql1);
				 if (mysqli_num_rows($result) > 0) {
   
    				while($row = mysqli_fetch_assoc($result)) {
     		    		echo "Company-name : ". $row["name"]."<br>"."Account number : " .$row["acc_num"]."<br>".
     		    				 "Limit : "	.$row["cr_limit"]."<br>Remain Dept : ".$row["rem_dept"]."<br><br>";
        
    				}
    			}
    			else{
			    	echo "Table of Dealer is EMPTY !!!";
			    	
			    } 
				?>
			</div><br><br>	
			<div style="text-align: left;">
				<?php
				echo "<h4>Table of Employee : </h4>"."<br>";

				 $sql1 = "SELECT * FROM employee";
				 $result = mysqli_query($conn, $sql1);
				 if (mysqli_num_rows($result) > 0) {
   
    				while($row = mysqli_fetch_assoc($result)) {
     		    		echo "Company-name : ". $row["name"]."<br>"."Account number : " .$row["acc_num"]."<br>".
     		    				 "Id : "	.$row["id"]."<br><br>";
        
    				}
    			}
    			else{
			    	echo "Table of Dealer is EMPTY !!!";
			    	
			    } 
				?>
			</div><br><br>	
			</div> 

		</form>
		<div id="bottom" style="text-align: center; ">How to use the Questions<br>
			<ul>
				<li>if you fill date  and acount of customer --> transcactions for this date and this costumer</li>
				<li>if you fill  and acount of dealer --> transcactions for this date and this dealer</li>
				<li>if you fill date and acount of company --> transcactions for this company and all of employee</li>
				<li>if you fill date and  acount of company and id --> transcactions for this company and this employee  employess</li>
			</ul>			
		</div>

	</div>

</div>
</body>
</html>
