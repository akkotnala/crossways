<?php
if(isset($_GET['user_id']) && isset($_GET['post_id'])){
  include('config.php');
 $userID = $_GET["user_id"];
 $postID = $_GET["post_id"];
    
$data = array($postID, $userID);
$stmt = $conn->prepare("DELETE FROM post WHERE postID =  ? AND userID = ?");
$stmt->execute($data);
$data = array(
   'isError'  => false
);
 
echo json_encode($data);
}
?>