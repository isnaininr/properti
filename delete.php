<?php 
require_once("connection.php"); 
if(isset($_GET['id'])) 
{
$id = $_GET['id']; 
mysqli_query($con,
	"DELETE FROM 
		properti 
	WHERE 
		id_properti = '$id'
	"); 

header("Location: index.php?success=1"); 
}