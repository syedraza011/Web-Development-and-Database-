<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Loged Out</title>
	</head>
<body>
<?php # Script 12.11 - logout.php #2
// This page lets the user logout.
// This version uses sessions.
        session_start(); 
     // Access the existing session.
// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {
	// Need the functions:
	require('login_functions.inc.php');
	require('mysqli_connect1.php');
	redirect_user();
}
else { // Cancel the session:
	$_SESSION = []; // Clear the variables.
	session_destroy(); // Destroy the session itself.
}
echo"<br/><br/>";
// Set the page title and include the HTML header:
$page_title = 'Logged Out!';

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";
include('index.php');
?>
</body>
</html>





