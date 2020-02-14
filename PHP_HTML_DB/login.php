<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	</head>
<body>
<?php # Script 12.8 - login.php #3
include('includes/header.html');
echo"<br> <br/>";
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	// Need two helper files:
	require('login_functions.inc.php');
	require('mysqli_connect1.php');
	//after the above code $dbc is the database connection
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass'],);
	if ($check) { // OK!
		// Set the session data:
        session_start();
		
		$_SESSION['user_id'] = $data['email'];
		$_SESSION['username'] = $data['password'];
		$_SESSION['id'] = $data['userid'];
		$_SESSION['nick'] = $data['nickname'];
		redirect_user('loggedin.php');
	} else { // Unsuccessful!
		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;
		
	}
	mysqli_close($dbc); // Close the database connection.
} // End of the main submit conditional.
// Create the page:
include('login_page.inc.php');
?>
</body>
</html>






