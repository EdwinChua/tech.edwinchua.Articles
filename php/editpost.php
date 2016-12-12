<?php
include 'connectioninformation.php';

$success;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$title = mysqli_real_escape_string($conn, $_POST['title']);
//$title = $_POST['title'];
$article = mysqli_real_escape_string($conn, $_POST['article']);
$articleid = mysqli_real_escape_string($conn, $_POST['articleid']);


$sql = "UPDATE Articles 
SET
Title = '$title', 
TextBody = '$article'
WHERE ArticleID = '$articleid'";

if ($conn->query($sql) === TRUE) 
{
	echo "Success";
} 
else 
{
    echo json_encode("We encountered an error updating this article.");
}

$conn->close();

?>