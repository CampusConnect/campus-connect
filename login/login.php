<?php
include_once ($_SERVER['DOCUMENT_ROOT']."/config/config.php");
$config = Config::singleton();
if(isset($_POST['request']))
switch ($_POST['request']){
	case "login":
		error_log("Case: login");
		include_once ($_SERVER['DOCUMENT_ROOT']."/utils/loginutils.inc");
		$uname = $_POST['uname'];
		$password=$_POST['password'];
		$user=login($uname, $password);
		error_log("Got username:".$uname);
		if($user['auth']==false){
			$error_login = "The username or password you entered is incorrect.";
			error_log("user authentication failed :".$uname.$error_login);
		}
		else{
			foreach ($user as $key => $value) {
				setcookie($key, $value, time()+(3600*24*7),"/");
			}
			if(isset($_COOKIE['id'])){
				header('Location: /user/account/home.php');
			}
			else{
				header('Location: /user/account/home.php?user_id='.$user['id']);
			}
		}
	case "register":
		
}
?>

<html>
<head>
<title>Welcome to College Connect-login page</title>
<link media="screen" type="text/css" href="/styles/style.css"
	rel="stylesheet">
</head>
<body>
	<div class="front-page">
		<div class="rightside">
			<form action="/login/login.php" method="post">
				<input type="hidden" name="request" value="login" /> <label>Login
					Name: <input name="uname" type="text" size="20"
						
					<?php if(isset($uname)) echo "value='".$uname."'";?> />
				</label><label>&nbsp;&nbsp;Password<input name="password"
					type="password" size="20" />
				</label><input type="submit" value="Login" /><br />	
					<?php 
					if(isset($error_login)){
					error_log("message is set".$error_login); ?>
					<p><font color="red"><?php echo $error_login;?></font></p>
					<?php
					}?>
			</form>
		</div>
		<div class="front-signup">
			<form action="/register/newuser.php" method="post">
				<input type="hidden" name="request" value="register" />
				<table>
					<tr>
						<td>Full Name:</td>
						<td><input type="text" name="fullname" /></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" name="email" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td>Confirm Password:</td>
						<td><input type="password" name="repassword" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="Register" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>
