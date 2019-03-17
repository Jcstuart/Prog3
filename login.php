<?php
session_start();
require "database.php";
if ($_GET)$errorMessage =$_GET['errorMessage'];
else $errorMessage= '';
if ($_POST){
	$sucess = false;
	$username = $_POST['username'];
	$password = $_POST['password'];
	//echo $username . ' ' . $password; exit();
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM customers WHERE email = '$username' AND password_hash = '$password' LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array());
	$data = $q->fetch(PDO::FETCH_ASSOC);
	//print_r($data); exit();
	
	if ($data){
		$_SESSION["username"] = $username;
		header("Location: index.php");
	}
	else{
		header("Location: login.php?errorMessage=Invalid");
		exit();
	}
}

?>
<h1>Log In</h1>
<form class="form-horizontal" action="login.php" method="post">
	<input name="username" type="text" placeholder="em@email.com" required>
	<input name="password" type="password" required>
	<button type="submit" class="btn btn-success">Log in</button>
	<a href='logout.php'>Log out</a>
	<a href='join.php'>Join Us</a>
	<p style='color: red;'><?php echo $errorMessage; ?></p>

	</form>