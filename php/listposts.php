<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'connectioninformation.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$str = $_SERVER['QUERY_STRING'];
parse_str($str);
$articleid;
$text;
$searchtype;

$where;
$columns;

if ($searchtype == "searchall")
{
	$columns = "Articles.ArticleID, Articles.Title, Users.Name";
}
else
{
	$columns = "Articles.ArticleID, Articles.Title, Users.Name, Articles.ArticlePostTimeStamp, Articles.TextBody, Articles.ImageURL1, Articles.ImageURL2,  Articles.ImageURL3";
}

if (!empty($str))
{
	$where = "and ";
	if (!empty($articleid))
	{
	$where = $where . "Articles.ArticleID = $articleid";
	//echo $where;
	}
	if (!empty($text))
	{
		if (strlen($where)>6)
		{
			$where = $where . " AND ";
		}
	$where = $where . "`Title` Like '%" . $text ."%' OR `TextBody` Like '%" . $text . "%'";
	//echo $where;
	}

	if (strlen($where) < 7)
	{
		$where = '';
	}
}
$sql = "SELECT $columns FROM `Articles`,`Users` WHERE Articles.UserID = Users.UserID $where GROUP BY Articles.ArticleID LIMIT 0, 1000 ";

$result = $conn->query($sql);
$num = $result->num_rows;

if ($num > 0) 
{
	$encode = array();

	while($row = mysqli_fetch_assoc($result)) 
	{
	   $encode[] = $row;
	}
} 
else 
{
    echo "0 results";
}
echo json_encode($encode);  

$conn->close();
?>

