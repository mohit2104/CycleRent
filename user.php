<?php

	session_start();
	if(!isset($_SESSION['username'])){
		echo "<a href = 'login.php'>Login</a> First";
		return;
	}
	mysql_connect("localhost","root","root");	
	mysql_select_db("cycle");
	if(isset($_POST['book'])){
		if($_POST['loc'] > 0){
		$num = (rand()*rand())%1000000;
		$query = 'update student SET extra = "'.$_POST["loc"].'", code = "'.$num.'", timestamp = "'.$_POST["timestamp"].'" where username = "'.$_SESSION['username'].'";';
		mysql_query($query);
		$query = 'select * from place where id = "'.$_POST['loc'].'";';
		$rem = mysql_fetch_assoc(mysql_query($query));
		$query = 'update place SET quantity = "'.($rem["quantity"] - 1 ).'" where id = "'.$_POST['loc'].'";';
		mysql_query($query);
		}
		else{
			$query = 'select * from student where username = "'.$_SESSION["username"].'";';
				$result = mysql_fetch_assoc(mysql_query($query));
				if( $result['extra'] != 0 ){
					$query = 'select * from place where id = "'.$result['extra'].'";';
					$rem = mysql_fetch_assoc(mysql_query($query));
					$query = 'update place SET quantity = "'.($rem["quantity"] + 1 ).'" where id = "'.$result['extra'].'";';
					mysql_query($query);	
					$query = 'update student SET extra = 0 where username = "'.$_SESSION['username'].'";';
					mysql_query($query);		
				}
		}	

	}
	
	$query = 'select * from student where username = "'.$_SESSION["username"].'";';
	$result = mysql_fetch_assoc(mysql_query($query));
	$query = 'select * from place;';
	$result1 = mysql_query($query);
//	$query = 'select * from cycle_detail where id = "'.$result["mess_id"].'";';
//	$result2 = mysql_fetch_assoc(mysql_query($query));
//	$start_date = $result1['start_book'];
//	$end_date = $result1['end_book'];

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class = "container">
			<h1> Cycle Rent </h1><a href = 'logout.php'><button class = 'btn' style = "float : right" >Logout</button></a>
			<div class = "container">
				<h2> Student Details </h2>
				Name : <?php echo $result['name']; ?><br>
				Username : <?php echo $result['username']; ?><br>
				balance : <?php echo $result['balance']; ?><br>
			</div>
			<style> .btn{ font-size : 40px; padding: 30px; margin : 5px; }  </style>
			<div class = "container">
				<h1> Cycle Spot Details </h1>
				<?php 
				while ( $row = mysql_fetch_assoc($result1) ){
					echo "<button type = 'submit' class='btn btn-lg btn-primary' onclick = setting('".$row['id']."')>".$row['location']."<br>".$row['quantity']."</button>";
				} 
				?>;
			<div class = "container">
				<form action = "" method = "post" >
					<input type = 'text' name = "loc" style = "display : none "  id = "loc" value = '0'/>
					<input type = 'text' name = "timestamp" style = "display : none "  id = "timestamp" value = '0'/>
					<input class = 'btn'  style = "padding : 0px; background : lightblue" type = "submit" name = 'book' value = '<?php if( $result['extra'] == 0 ) echo "Book"; else echo "Unbook"; ?>' 
					></form><br>
				<?php if($result['extra'] > 0) echo "Current Status : Booked with Code : ".$result['code']; ?>
			</div>
		</div>
		</div>
		<script>
			function setting(e){
				document.getElementById("loc").value = e;
			}
				var dt = new Date();	
				var x = 3600*parseInt(dt.getHours()) + 60*parseInt(dt.getMinutes()) + parseInt(dt.getSeconds());
				document.getElementById("timestamp").value = x;
			/*
			var tr = "<?php echo $end_date; ?>";
			var trs = "<?php echo $start_date; ?>";
			tr = tr.split(":");
			var dt = new Date();
			var x = compute(tr); var flag = 1, y = 35; var counter = 0;
			tr[0] = dt.getHours()%12;
			tr[1] = dt.getMinutes();
			tr[2] = dt.getSeconds();
			var y = compute(tr);
			tr = trs.split(":");
			var z = compute(tr);
			function back(e){
				console.log(e);
				document.getElementById("h").style.fontSize =  e + 'px';
				document.getElementById("m").style.fontSize =  e + 'px';
				document.getElementById("s").style.fontSize =  e + 'px';
				
			}
			var e = 45;
			function update(){
				if( counter%10 == 0){
					x = x - 1;
					e = 63;
				document.getElementById("h").value = parseInt(x/3600);
				document.getElementById("m").value = parseInt((x%3600)/60);
				document.getElementById("s").value = parseInt((x%60));
				document.getElementById("h").style.fontSize =  '65px';
				document.getElementById("m").style.fontSize =  '65px';
				document.getElementById("s").style.fontSize =  '65px';
				}
				else{
					e = e - 4;
					if(e > 35){
						document.getElementById("h").style.fontSize =  e + 'px';
						document.getElementById("m").style.fontSize =  e + 'px';
						document.getElementById("s").style.fontSize =  e + 'px';
					}
				}
				counter++;
			}
			if( z > y ){
				alert("Booking yet to start");
			}
			else{
				x = x - y;
			if( x < 0 ){
				alert("Booking time over");
			}
			else
				setInterval(update, 100);
		}
		*/
		</script>
	</body>
</html>

