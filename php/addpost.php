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
$imageurl1 = $_POST['imageurl1'];
$imageurl2 = $_POST['imageurl2'];
$imageurl3 = $_POST['imageurl3'];

$sql = "INSERT INTO Articles (Title, TextBody, ImageURL1,ImageURL2,ImageURL3)
VALUES ('$title','$article','$imageurl1','$imageurl2','$imageurl3')";

if ($conn->query($sql) === TRUE) 
{
	echo $conn->insert_id;
} 
else 
{
    echo json_encode("We encountered an error adding this article.");
}

$conn->close();

?>