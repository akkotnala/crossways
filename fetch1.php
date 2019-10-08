<?php
include('config.php');

if(isset($_POST['userID'])){
 $userID = $_POST["userID"];

 
$queryF = $conn->prepare("SELECT * FROM post_comment WHERE status = '0'");
$queryF->execute(array($userID));
$result = $queryF -> fetchAll();

$count = count($result);
 
$data = array(
   'unseen_notification1'  => $count
);
 
echo json_encode($data);
}
?>
