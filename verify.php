<?php
  session_start();
  if((!isset($_SESSION['username'])) ||  (!isset($_SESSION['role'])) || ($_SESSION['role'] != 'guard')) {
      echo "<a href = 'login.php'>Login</a> as Guard First";
      return;
  }
  $rate = 20;
  mysql_connect("localhost", "root", "root");
  mysql_select_db("cycle");
  if(isset($_POST['verify'])){
    $query = 'select * from student where username ="'.$_POST['username'].'";';
    $result = mysql_fetch_assoc(mysql_query($query));
    $fi = $result['balance']*1 - ($_POST['timestamp']*1 - $result['timestamp']*1)*($rate/3600);
    $query = 'select * from place where id = "'.$result['extra'].'";';
          $rem = mysql_fetch_assoc(mysql_query($query));
          $query = 'update place SET quantity = "'.($rem["quantity"] + 1 ).'" where id = "'.$result['extra'].'";';
          mysql_query($query);
    $query = "update student set extra = 0, balance = '".$fi."' where username = '".$_POST['username']."';";
    mysql_query($query); 
    echo "Verified Successfully";
    Echo "total ride time = ".(($_POST['timestamp']*1 - $result['timestamp']*1))." seconds. Money deduced = ".intval($_POST['timestamp']*1 - $result['timestamp']*1)*($rate/3600)." ";
    echo '<a href = "verify.php" > Click here </a> To verify another account ';
    return;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="dbms project on mess extra allotment">
    <meta name="author" content=" mohit and bipul">

    <title>Admin Panel - Mess authority</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="navbar.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <!--nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin Panel</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li ><a href="admin_home.php">Home</a></li>
              <li><a href="#">Total Bookings</a></li>
              <li><a href="update.php">Update Extras</a></li>
              <li class = "active"><a href="verify.php">Verify Bookings</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav-->

      <!-- Main component for a primary marketing message or call to action -->
      <div class="carbonad" >
        <h1>Guard's Verification Portal</h1>
        <p>
		<a href = 'logout.php'><button class = 'btn btn-danger' style = "float : right" >Logout</button></a>
		</p>
        <form action = "" method = "post" >
          <div class = 'form-group'>
            <input type = "text" name = "username" placeholder = "Enter Username Here!" class = 'form-control' value = "<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" />
          </div>
      <?php 
          if(!isset($_POST['submit'])){
            echo "<input type = 'submit' name ='submit' class='btn btn-lg btn-success' value = 'Verify' />";
          }
        echo  "</form>";
        if(isset($_POST['submit'])){
        $query = 'select * from student where username = "'.$_POST['username'].'" and extra > 0;';
        $result = mysql_query($query);
        if( mysql_num_rows($result)){
          $results = mysql_fetch_assoc($result);
          echo "<h2>".$results['code']."</h2>";
          echo "<form action = '' method = 'post'>
            <input type = 'text' name = 'timestamp' style = 'display : none'  id = 'timestamp' value = '0'/>
            <input type = 'text' name = 'username' value = '".$results['username']."' style ='display : none' />
            <input type = 'submit' name ='verify' class='btn btn-lg btn-primary' value = 'Accept' />
          </form>";
        }
        else{
          echo "Sorry the above username has not registered for Cycle!";
        }
      }
      ?>
      </div>
    </div>
    <script>
        var dt = new Date();  
        var x = 3600*parseInt(dt.getHours()) + 60*parseInt(dt.getMinutes()) + parseInt(dt.getSeconds());
        document.getElementById("timestamp").value = x; 
    </script>
  </body>
</html>
