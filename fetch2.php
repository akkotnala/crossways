<?php
include('config.php');

if(isset($_POST['userID'])){
 $userID = $_POST["userID"];
    

$queryF = $conn->prepare("DELETE FROM post WHERE postID =  ");
$queryF->execute(array($userID));
$result = $queryF -> fetchAll();

$count = count($result);
 
$data = array(
   'unseen_notification'  => $count
);
 
echo json_encode($data);
}
?>
