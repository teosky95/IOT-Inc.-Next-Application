<?php
include('core.php');
extract($_POST);
session_start();
if(isset($_POST['login'])) {
	$username = isset($_POST['username']) ? clear($_POST['username']) : false;
	$password = isset($_POST['password']) ? clear($_POST['password']) : false;
	if(empty($username) || empty($password)) {
		echo 'Riempi tutti i campi.<br /><br /><a href="javascript:history.back();">Indietro</a>';
	} elseif(mysql_num_rows(mysql_query("SELECT * FROM users WHERE username LIKE '$username'")) == 0) {
		echo 'Username non trovato.<br /><br /><a href="javascript:history.back();">Indietro</a>';
	} elseif(mysql_num_rows(mysql_query("SELECT * FROM users WHERE password LIKE '$password'")) == 0) {
				echo 'Password non trovata.<br /><br /><a href="javascript:history.back();">Indietro</a>';
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
		if(mysql_num_rows(mysql_query("SELECT * FROM users WHERE username LIKE '$username' AND password='$password'")) > 0) {
			$username = mysql_result(mysql_query("SELECT username FROM users WHERE username LIKE '$username'"), 0);
			$userid = mysql_result(mysql_query("SELECT id FROM users WHERE username LIKE '$username'"), 0);
			$tipo = mysql_result(mysql_query("SELECT tipo FROM users WHERE username LIKE '$username'"), 0);
			mysql_query("UPDATE users SET last_login='".time()."', last_ip='$ip' WHERE id='$userid'") or die(mysql_error());
			if ($tipo==0){
				header("Location: Gestioneproprieta.php");
			} elseif($tipo == 1) {
				header("Location: Casella_amministratore.php");
			}
		}
	}
} else {
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Your Website</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript"></script>
</head>
<body>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<div class="container">
	<section id="content">
		<h1>NEXT</h1>
		<form>
			<div class="wrapper">
				<i class="fa fa-user"></i>
				<input type="text" name="username" placeholder="Username" required maxlength="16"/>
			</div>
			<div class="wrapper">
				<i class="fa fa-lock"></i>
				<input type="password" name="password" placeholder="Password" required maxlength="20"/>
			</div>
			<div>
				<input type="submit" name="login" value="Accedi"/>
			</div>
		</form>
	</section>
</div>
</form>
</body>
</html>
<?php
}
?>
