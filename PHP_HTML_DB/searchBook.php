<?php
//log on to server
//Jared Smith-Weston
//call a function to log on to server
//or best is to include the file to login to fucntion to secure 
//my sqli-connect.php( look it up )
//include('../../logininfo/login.php');
echo "<h1> BOOK Result </h1>";
define ('DB_USER','raza');
define ('DB_PASSWORD','Sm533008');
define ('DB_HOST','localhost');
define ('DB_NAME','bookOrama');
$dbc=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR 
die('Could not connect to DB!'.mysqli_connect_error());
$searchtype=$_POST['searchtype'];
$searchterm=trim($_POST['searchterm']);
//check if thet are did not type anything
if (!$searchtype || !$searchterm)
{
	echo "No Proper Input!";
	exit;
}
//check $searchtype//whiteListing
switch($searchtype)
{
	case 'Tile':
	case 'Author':
	case 'ISBN':
	break;
	default: 
	echo "That is not a legal Input!";
	exit;
}

//continue error checking post input next week;
// ?-means prepared querry
$query="SELECT ISBN,Author,Title,Price FROM Books where $searchtype=?";
$stmt=$dbc->prepare($query);
$stmt->bind_param('s',$searchterm);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($ISBN,$Author,$Title,$Price);
echo "<P> Number of Books:". $stmt->num_rows. "</p>";
while ($stmt->fetch())
{
	echo $ISBN. "</br>". $Author."</br>".$Title ."</br>".number_format($Price,2)."</br>";
}
?>






































