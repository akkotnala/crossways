<?php
include('config.php');
//session_start();
include("header.php");

	if(isset($_POST['submitpic']))
	{

$id=$_SESSION["userID"];
$image=$_FILES['image']['name'];

move_uploaded_file($_FILES['image']['tmp_name'],"upload/".$_FILES['image']['name']);

//$data=mysqli_query("UPDATE `personal_info` SET `userImage`='$image' where `id`='$userID'");
	     $query = $conn->prepare("UPDATE `personal_info` SET `userImage`='$image' where `userID`='$id'");
     $query->execute(array($userImage));

    }	

if(isset($_POST['submitcover']))
	{

$id=$_SESSION["userID"];
$image1=$_FILES['image']['name'];

move_uploaded_file($_FILES['image']['tmp_name'],"upload/".$_FILES['image']['name']);

	     $query = $conn->prepare("UPDATE `personal_info` SET `userCover`='$image1' where `userID`='$id'");
     $query->execute(array($userImage));

	}
		
?>



