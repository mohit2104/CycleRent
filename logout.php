<?php
	session_start();
	session_unset();
	echo "you have been logged out. <a href = 'login.php'>Login</a> here! ";
?>