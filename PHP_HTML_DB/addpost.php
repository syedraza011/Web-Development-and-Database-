<?php session_start();
require('login_functions.inc.php');
if (!isset($_SESSION['user_id'])){
	
	
	redirect_user('login.php');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Add Post</title>
	</head>
<body>
<?php

include('includes/header.html');
echo "<br/><br/>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('mysqli_connect1.php'); // Connect to the db!!
	$errors = []; // Initialize an error array.
	// Check for a subject:
	if (empty($_POST['title'])) {
		$errors[] = 'You forgot to enter your subject.';
	} 
	else
	{
		$title = trim($_POST['title']);
	}
	// Check for the message:
	if (empty($_POST['body'])) {
		$errors[] = 'You forgot to enter the message.';
	} 
	else
	{
		$body= trim($_POST['body']);
	}
	
	if (empty($errors)) { // If everything's OK.
		// Here is the prepared query!
		//prepared queries can be made out of any INSERT, UPDATE, DELETE, SELECT
		//define the query making placeholders for the variables that you use
		//note: no quotes around the string
		$q = "INSERT INTO `post` (`title`,`postbody`,`userid_fk`,`timedata`) VALUES (?, ?,?,NOW())";
		//prepare the statement in mysql, assigning the results to a php variables
		//so the query is parsed but not executed
		$stmt = mysqli_prepare($dbc,$q);
		
		//bind php variables to the placeholders in the query, i.e. say what the ? in the query refer to
		mysqli_stmt_bind_param($stmt,'sss',$title,$body,$_SESSION['id'],);
		//execute the statement
		$num=mysqli_stmt_execute($stmt);
		
		if (mysqli_stmt_affected_rows($stmt)==1) { // If it ran OK.
		
			// Print a message:
			//echo "<h1>Thank you {$_SESSION['nick']}!</h1>
		//<p>Your post is added <br></p>";
		redirect_user('index.php');
		} else { // If it did not run OK.
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Your post could not be added due to a system error. We apologize for any inconvenience.</p>';
			// Debugging message:
			//echo '<p>' . mysqli_stmt_error($stmt) . '<br><br>Query: ' . $q . '</p>';
		} // End of if ($r) IF.
		//mysqli_close($dbc); // Close the database connection.
		// Include the footer and quit the script:
		exit();
	} else { // Report the errors.
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';
	} // End of if (empty($errors)) IF.
	mysqli_close($dbc); // Close the database connection.
} // End of the main Submit conditional.


?>
</body>

<h1>Add a Post</h1>
<form action="addpost.php" method="post">
	<p>SUBJECT <input type="text" name="title" size="15" maxlength="20" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>"></p>
	<p><textarea rows="4" cols="50" name="body" value="<?php if (isset($_POST['body'])) echo $_POST['body']; ?>">Enter your message...</textarea></p>
	<p><input type="submit" name="submit" value="Submit"></p>
</form>
</html>
<?php
echo "<br/><br/>";
echo "<br/><br/>";
echo "<br/><br/>";
echo "<br/><br/>";
echo "<br/><br/>";
echo "<br/><br/>";
 include('includes/footer.html');?>