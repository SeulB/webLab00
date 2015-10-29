<!DOCTYPE html>
<html>
	<head>
		
	</head>
	<body>
		<form action="customer.php" method="post">
			<div>
				<div>
					dbname: <input type="text" name="dbname" />
					<br />
					<br />
					query: <input type="text" name="query" />
					<br />
					<?php 
						$dbname = $_POST["dbname"];
						$query = $_POST["query"];
						//$db = new PDO("mysql:dbname=$dbname;host=localhost", )
					?>
				</div>
			</div>
		</form>
	</body>
</html>