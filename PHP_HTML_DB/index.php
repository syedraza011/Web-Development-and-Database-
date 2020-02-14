
<?php 
session_start(); 
$page_title = 'CyberChamps!';
 //inlcuding header
include('includes/header.html');
//how you're gonna print the stuff
echo "<br>"."</br>";
if(!isset($_SESSION['user_id']))
{
	echo "<h1><br> Hello,Guest..!!</br></h1>";
}
else{
echo "<h1>Welcome!</h1>
<p>You are now logged in, <b>{$_SESSION['nick']}</b>!</p>";
}

//--------paging------------
require('mysqli_connect1.php');
/*define ('DB_USER','raza');
define ('DB_PASSWORD','Sm533008');
define ('DB_HOST','localhost');
define ('DB_NAME','raza_');

$dbc=@mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR 
die('Could not connect to DB!'.mysqli_connect_error());

  if (mysqli_connect_errno()) {
     echo 'Error: Could not connect to database.  Please try again later.';
     exit;
  }*/
//add in the following
  if (isset($_GET['page']))
	  $thispage = $_GET['page'];
  else
	  $thispage = 1;
  

	$query = "SELECT count(postbody) FROM post";
	$stmt = $dbc-> prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($totrecords);
	$stmt->fetch();
	$stmt->free_result();

$recordsperpage = 5;

$totalpages = ceil($totrecords / $recordsperpage);
$offset = ($thispage - 1) * $recordsperpage;

//---query--orional
$page_title = 'Welcome to this Site!';

$query="select userid,title,postbody,timedata,nickname from post,users where users.userid=post.userid_fk order by post.timedata desc limit ?,?"; //basic querry
$stmt=$dbc->prepare($query);
$stmt->bind_param('ss', $offset, $recordsperpage);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userid,$title,$postbody,$timedata,$author); //what is being printed
while ($stmt->fetch())
{
	echo "<b>Posted By:</b>".$author."</br>"."<b>Title:</b>".$title."</br>"."<b>Post Body:</b>". $postbody."</br>"."<b>Time & Date:</b>".$timedata ."</br>"."<br>"."</br>";
	
}
//--------

if ($thispage > 1)

   {

      $page = $thispage - 1;

      $prevpage= " <a href=\"index.php?page=$page\">$page</a> ";

   } else

   {

      $prevpage = "";

   }
$bar = "";
echo "total pages: ".$totalpages."<br />";
if ($totalpages > 1)

{ 

    for($page = 1; $page <= $totalpages; $page++)

    {

        if ($page == $thispage)      

       {$bar .= " $page ";}
	   else
		{ $bar .= " <a href=\"index.php?page=$page\">$page</a> ";}

    }
echo $bar;
}

//-------------------
// Call the function again:
include('includes/footer.html');


?>
</body></html>








