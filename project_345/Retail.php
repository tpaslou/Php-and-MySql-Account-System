<?php 
$servername='localhost';
$username='root';
$dbName='ccc';
$password='';

$conn = mysqli_connect($servername,$username,$password,$dbName);

if(!$conn){
	die("Connection failed: " . mysqli_error());
}
if(isset($_POST['retail_btn'])){
//	echo"test01";
	session_start();
	$deal_id=-1;	
	$flag1=-1;
	$flag2=-1;
	$deal_id=NULL;
	$employee_id="";
	$cr_limit_cust=0;
	$cr_limit_comp=0;
	$deal_type=NULL;
	$name_costumer="";
	$name_dealer = ""; 
	$type="";
	$amount =0;
	$flag_deal=0;
	$acc_number_customer=mysql_real_escape_string($_POST['acc_num1']);
	$acc_number_dealer =mysql_real_escape_string($_POST['acc_num2']);
	$acc_number_company=mysql_real_escape_string($_POST['acc_num3']);
	$employee_id=mysql_real_escape_string($_POST['id']);
	$deal_id=mysql_real_escape_string($_POST['deal_id']);
	
	$sql_name_of_customer ="SELECT * FROM customer  WHERE acc_num =$acc_number_customer" ;
	$sql_name_of_dealer ="SELECT   * FROM dealer  WHERE acc_num =$acc_number_dealer" ;
	
	

	

	if($acc_number_customer !=NULL && $acc_number_dealer!=NULL && $acc_number_company==NULL ){
		$result_name_of_costumer = mysqli_query($conn,$sql_name_of_customer);

		$result_name_of_dealer = mysqli_query($conn,$sql_name_of_dealer);
		$flag1=0;
		if (mysqli_num_rows($result_name_of_costumer) > 0) {
	   
	    	while($row = mysqli_fetch_assoc($result_name_of_costumer)) {
	     		    $name_costumer= $row["name"];
	     		    
	     		    
	        
	    	}
	    
	    }
	    else{
		    	echo "Customer doesnt exist <br>";
		    	$flag1=1;
		}
	    if (mysqli_num_rows($result_name_of_dealer) > 0) {
	   
	    	while($row = mysqli_fetch_assoc($result_name_of_dealer)) {
	     		    $name_dealer= $row["name"];
	     		    
	        
	    	}
	    }
	    else{
		    	echo "Dealer doesnt exist <br>";
		    	$flag1=1;
		}

	    

	}else if($acc_number_customer==NULL && $acc_number_company!=NULL && $acc_number_dealer!=NULL){
		$flag2=0;

		if($employee_id==NULL){
			echo "Null employee_id";
		}
		else{
			$sql_name ="SELECT * FROM employee";
			$result_name_of_employee=mysqli_query($conn,$sql_name);
			$result_name_of_dealer = mysqli_query($conn,$sql_name_of_dealer);
			
			if (mysqli_num_rows($result_name_of_employee) > 0) {
	   
		    	while($row = mysqli_fetch_assoc($result_name_of_employee)) {
		    		if($employee_id==$row["id"]  && $acc_number_company==$row["acc_num"]){
		    	    	$name_costumer= $row["name"];
		        	}

		    	}
	    	}
	    	else{
		    	echo "Employee doesnt exist <br>";
		    	$flag2=1;
			}			

		}
		if (mysqli_num_rows($result_name_of_dealer) > 0) {
	   
	    	while($row = mysqli_fetch_assoc($result_name_of_dealer)) {
	     		    $name_dealer= $row["name"];
	        
	    	}
	    }
	    else{
		    	echo "Dealer doesnt exist <br>";
		    	$flag2=1;
		}

	}
	
		// Sql to get amount of deal
	if($flag1==0 || $flag2==0){
		
		$flag_deal=0;
		$sql1 = "SELECT *FROM deal  ";
		$result_exist = mysqli_query($conn,$sql1);
		if (mysqli_num_rows($result_exist) > 0) {
	   			
	    	while($row = mysqli_fetch_assoc($result_exist)) {
	    		if($row["cust_name"]==$name_costumer && $row["deal_name"]==$name_dealer &&$deal_id==$row["deal_id"]){
	    			
	     		    $amount= $row["amount"];
	     		    $type = $row["type"];
	     		    $deal_type = $row["type_deal"];
	     		    
	     			
	     			
	     		}
	    	}
	    }
	    else{
	    	echo "Deal doesn't exist !!!";
	    	$flag_deal=1;
	    }
	}    
	
	    
	
    if($flag1 == 0 && $flag_deal==0){
    	
    	if($type!="retail"){
    		
    		if($deal_id!=NULL){
    			if($deal_type=="Cash"){
		    		$sql2= "UPDATE customer  SET curr_amount =curr_amount+$amount WHERE acc_num = $acc_number_customer  ";   //Update the rem_dept of costumer
				}else if($deal_type=="Credit"){
					$sql3 = "UPDATE customer SET cr_limit =cr_limit+$amount WHERE acc_num = $acc_number_customer ";	  			//Update the cr_limit of costumer
					$sql7 = "UPDATE customer SET rem_dept =rem_dept-$amount WHERE acc_num = $acc_number_customer ";
				}
				$sql4 = "UPDATE dealer   SET profit=profit-$amount*(1-term) WHERE acc_num =$acc_number_dealer";	      			//Update the profit of dealer
				$sql5 = "UPDATE dealer   SET dept =dept-($amount*term) WHERE acc_num = $acc_number_dealer  ";         		//Update the debt of dealer
				$sql6 = "UPDATE deal     SET type='retail' WHERE deal_id =$deal_id";	//Update the type of deal
				if($deal_type == "Cash"){
					if(mysqli_query($conn,$sql2)){
			    		echo "Customer update complete <br>";
					 }
				}else if($deal_type=="Credit"){
					if(mysqli_query($conn,$sql3)&&mysqli_query($conn,$sql7)){
						echo "Customer update complete <br>";
					}

			    }else{
			    	echo "Customer update failed <br>";
			    }
			    if(mysqli_query($conn,$sql4)&&mysqli_query($conn,$sql5)){
			    	echo "Dealer update complete <br>";
			    }else{
			    	echo "Dealer update failed <br>";
			    }
			    if(mysqli_query($conn,$sql6)) {
			    	echo "Deal update complete <br>";
			    }else{
			    	echo "Failed to update deal 1";
			    }
			}
			else{
				echo "There isn't such deal1";
			}    
	
		}
		else{
			echo "You alerady have returned the product!!!";
		}

	
	}
	if($flag2 == 0 && $flag_deal==0){
    	
    	if($type!="retail"){
    		
    		if($deal_id!=NULL){
    			if($deal_type=="cash"){
		    		$sql2= "UPDATE company  SET curr_amount =curr_amount+$amount WHERE acc_num = $acc_number_company  ";   
				}else if($deal_type=="credit"){
					$sql3 = "UPDATE  company SET cr_limit =cr_limit+$amount WHERE acc_num = $acc_number_company ";	  			
					$sql7 = "UPDATE company SET rem_dept =rem_dept-$amount WHERE acc_num = $acc_number_company ";
				}		    	   																								//Update the rem_dept of company
					  																											//Update the cr_limit of company
				$sql4 = "UPDATE dealer   SET profit=profit-$amount*(1-term) WHERE acc_num =$acc_number_dealer";	      			//Update the profit of dealer
				$sql5 = "UPDATE dealer   SET dept =dept-($amount*term) WHERE acc_num = $acc_number_dealer  ";         		//Update the debt of dealer
				$sql6 = "UPDATE deal     SET type='retail' WHERE deal_id =$deal_id";	//Update the type of deal
				if($deal_type == "cash"){
					if(mysqli_query($conn,$sql2)){
			    		echo "Company  update complete <br>";
					 }
				}else if($deal_type=="credit"){
					if(mysqli_query($conn,$sql3)&&mysqli_query($conn,$sql7)){
						echo "Company update complete <br>";
					}

			    }else{
			    	echo "Customer update failed <br>";
			    }
			    if(mysqli_query($conn,$sql4)&&mysqli_query($conn,$sql5)){
			    	echo "Dealer update complete <br>";
			    }else{
			    	echo "Dealer update failed <br>";
			    }
			    if(mysqli_query($conn,$sql6)) {
			    	echo "Deal update complete <br>";
			    }else{
			    	echo "Failed to update deal 1";
			    }
			}
			else{
				echo "There isn't such deal2";
			}    
	
		}
		else{
			echo "You alerady have returned the product!!!";
		}

	
	}		
}	
?>

<!DOCTYPE html>
<html>
<head>
<title>Retail</title>
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
	</header>
	</div>
	<br>
	<h2 style="color: #196666;text-align:center;">Retail</h2>
	<div class="forms">
		<div style="text-align: center;">
			<?php 
				$sql = "SELECT * FROM deal ";
				$result = mysqli_query($conn, $sql);
				echo "The deals are :   <br>";
				if (mysqli_num_rows($result) > 0) {
			    
			    	while($row = mysqli_fetch_assoc($result)) {
			        	echo "Customer-Name: " . $row["cust_name"]."<br>Dealer Name : ".$row["deal_name"] 
			        	."<br>Date : ".$row["date"]."<br>Deal id : ".$row["deal_id"]."<br><br><br>";
			        
			    	}
				} else {
			    	echo "There are 0 deals<br><br><br>";
				}
			?>
		</div>
		<div align="center" class="dealer">
			<?php 
				$sql = "SELECT * FROM customer ";
				$result = mysqli_query($conn, $sql);
				echo "The Customers are :  ";
				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    
			    echo "<br>";
			    
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "Customer-Name: " . $row["name"].","."Remain dept : ".$row["rem_dept"] ."<br><br><br>";
			        
			    }
				} else {
			    	echo "There are 0 Customers<br><br><br>";
				}
			?>
		</div>	
		<div align="center" class="dealer">
			<?php 
				$sql = "SELECT * FROM dealer ";
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    echo "The Dealers are : ". "<br>";
			    
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "dealer-Name: " . $row["name"]. "<br>"."Account Number : ".$row["acc_num"]."       
			        <br>term : ".$row["term"]."<br>Profit : ". $row["profit"]." <br>Dept : ". $row["dept"].  "<br><br><br>";
			        
			    }
				} else {
			    	echo "There are 0 Dealers<br><br><br>";
				}
			?>
		</div>
		<div align="center" class="dealer">
			<?php 
				$sql = "SELECT * FROM company ";
				$result = mysqli_query($conn, $sql);

				if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    echo "The Companies are : ". "<br>";
			    
			    while($row = mysqli_fetch_assoc($result)) {
			        echo "Company-Name: " . $row["name"]. "<br>"."Account Number : ".$row["acc_num"]."<br><br><br>";
			        
			    }
				} else {
			    	echo "There are 0 Companies<br><br><br>";
				}
			?>
		</div>					
		<form method="post" action="Retail.php">
			
			Account Number  for customer: 
			<input type="number" name ="acc_num1" class="textInput"> <br>
			Acount Number for dealer :
			<input type="number" name ="acc_num2" class="textInput"> <br>
			Acount number for Company
			<input type="numer" name="acc_num3" class="textInput"><br>
			Employee id :
			<input type="number" name ="id" class="textInput"> <br>
			Deal id : 
			<input type="number" name ="deal_id" class="textInput"> <br>
			<input type="submit" name="retail_btn" value="Retail" ><br>
			
			
		</form>
		
	</div>
</body>
</html>

		
