<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		# if (isset($_POST["name"])){

		?>

		<!-- Ex 4 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. Try again?</p>
		--> 

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		# } elseif () { 
		?>

		<!-- Ex 5 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. Try again?</p>
		--> 

		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		# } elseif () {
		?>

		<!-- Ex 5 : 
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. Try again?</p>
		--> 

		<?php
		# if all the validation and check are passed 
		# } else {
		?>

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<?php
			$name = $_POST["name"];
			$MembershipNumber = $_POST["membership"];
			$option = array();
			
			if(isset($_POST["organic"]))
				array_push($option,"organic");
			if(isset($_POST["domestic"]))
				array_push($option,"domestic");
			if(isset($_POST["Genetic"]))
				array_push($option,"Genetic");
			if(isset($_POST["harvest"]))
				array_push($option,"harvest");
			$options = processCheckbox($option);
			$fruits = $_POST["fruits"];
			$quantity = $_POST["quantity"];
			$card = $_POST["card"];
			$cc = $_POST["cc"];
			
		?>
		<ul> 
			<li>Name: <?= $name ?></li>
			<li>Membership Number: <?= $MembershipNumber ?></li>
			<li>Options: <?= $options ?></li>
			<li>Fruits: <?= $fruits." - ".$quantity ?></li>
			<li>Credit <?= $card." (".$cc.")" ?></li>
		</ul>

		<?php 
			function processCheckbox($option){
				$options=implode(", ",$option);
				return $options;
			}
		?>
		
<!-- 		Ex 3 : -->			
		<p>This is the sold fruits count list:</p>
		<?php
			$filename = "customers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
			 * For example, "Scott Lee;20110115238;apple;3"
			 */
			$inform="\n".$name.";".$MembershipNumber.";".$fruits.";".$quantity;
			file_put_contents($filename, $inform, FILE_APPEND);
		?>
		
		<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
			Create unordered list to show the number of fruit sold -->
		<ul>
			<?php 
			$fruitcounts = soldFruitCount($filename);
			foreach($fruitcounts as $key => $value) {
			?>
				<li><?= $key." - ".$value ?></li>
			<?php
			}
			?>
		</ul>
		
		<?php
		# }
		?>
		
		<?php
			/* Ex 3 :
			* Get the fruits species and the number from "customers.txt"
			* 
			* The function parses the content in the file, find the species of fruits and count them.
			* The return value should be an key-value array
			* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
			*/
			function soldFruitCount($filename) { 
				foreach (file($filename) as $files) {
					$split = explode(";", $files);
					$fruitss = $split[2];
					$fruitss[$split[2]] += (int)$split[3];
				}

				return $fruitss;
			}
		?>
		
	</body>
</html>
