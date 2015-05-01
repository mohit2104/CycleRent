<?php
	mysql_connect("localhost","root","root");	
	mysql_select_db("cycle");
	if(isset($_POST['register'])){
		$query = 'insert into student values ( "", "'.$_POST["name"].'", "'.$_POST["username"].'", 0, 0, "'.$_POST["balance"].'", 0);';
		mysql_query($query);
		$query = 'insert into login values ( "", "'.$_POST["username"].'", "'.$_POST["password"].'", "'.$_POST["role"].'");';
		mysql_query($query);
		echo "Successfully registered ".$_POST['username']."<br>Register more below!";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<style>
			.form-control{
				margin : 5px;
			}
			.btn{
				font-size : 20px;
				padding : 30px;
			}
		</style>
	</head>

	<body>
		<div class = "container">
			<h1> Cycle Rent </h1>
			<div class = "container">
				<h2></h2>
			</div>
			<div class = "container">
				<h1> Register </h1>
				<div class = "container">
				<form class= 'form' action = "" method = "post" >
					<input placeholder = "Name" class = 'form-control' type = 'text' name = "name"/>
					<input placeholder = "Username" class = 'form-control' type = 'text' name = "username"/>
					<input placeholder = "Password" class = 'form-control' type = 'password' name = "password"/>
					<input placeholder = "Balance" class = 'form-control' type = 'text' name = "balance"/>
					<input type = 'radio' value = 'user' name = 'role' />User
					<input type = 'radio' value = 'guard' name = 'role' />Guard
					<input class = 'btn'  style = "padding : 0px; background : lightblue" type = "submit" name = 'register' value = 'register' >
				</form>
				</div>
			</div>
		</div>
	</body>
</html>

