<?php
include("config.php");

if(isset($_POST['type']))
{
if($_POST['type'] == "changeFriendStatus") {
     $currentUserID = $_POST['userID'];
     $req_status = $_POST['req_status'];
     $otherUserID = $_POST['otherUser'];
    
    $queryF = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? AND userTwoID = ?) OR (userOneID = ? AND userTwoID = ?)");
    $queryF->execute(array($currentUserID,$otherUserID,$otherUserID,$currentUserID));
    $rowF = $queryF->fetch(PDO::FETCH_BOTH);

    if($queryF->rowCount() > 0) {
            $queryF = $conn->prepare("UPDATE relationship set status=? , actionUserID =? WHERE (userOneID = ? AND userTwoID = ?) OR (userOneID = ? AND userTwoID = ?)");
            $queryF->execute(array($req_status,$currentUserID,$currentUserID,$otherUserID,$otherUserID,$currentUserID));
            $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    } else{
        
        $queryF = $conn->prepare("INSERT INTO relationship (userOneID, userTwoID, status, actionUserID) VALUES (?,?,?,?)");
        $queryF->execute(array($currentUserID,$otherUserID,$req_status,$currentUserID));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    }
}
    
    
if($_POST['type'] == "like") {
    
     $postID = $_POST['postID'];
     $userID = $_POST['userID'];
    
     $queryF = $conn->prepare("INSERT INTO post_likes (postID, likedUserID) VALUES (?,?)");
        $queryF->execute(array($postID,$userID));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
}
    
    
        
    if($_POST['type'] == "unlike") {

        $postID = $_POST['postID'];
        $userID = $_POST['userID'];

        $queryF = $conn->prepare("DELETE FROM post_likes WHERE postID=? AND likedUserID =?");
        $queryF->execute(array($postID,$userID));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
    }

    
    if($_POST['type'] == "comment") {

        $postID = $_POST['postID'];
        $userID = $_POST['userID'];
        $comment = $_POST['comment'];

        $queryF = $conn->prepare("INSERT INTO post_comment (postID, commentedUserID,comment) VALUES (?,?,?)");
        $queryF->execute(array($postID,$userID,$comment));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    }
     if($_POST['type'] == "status") {

        $status = $_POST['status'];
        $userID = $_POST['userID'];

        $queryF = $conn->prepare("INSERT INTO post (postType, userID,postContent) VALUES (?,?,?)");
        $queryF->execute(array("text",$userID,$status));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    }
     if($_POST['type'] == "image-post") {

        $dir = "img/";
         move_uploaded_file($_FILES["pictureFile"]["tmp_name"], $dir. $_FILES["pictureFile"]["name"]);
         
         $userID = $_POST['userID'];

        $queryF = $conn->prepare("INSERT INTO post (postType, userID,postContent) VALUES (?,?,?)");
        $queryF->execute(array("photo",$userID,$_FILES["pictureFile"]["name"]));
        $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    }
     if($_POST['type'] == "search") {

       $search = $_POST['search'];
       $userID = $_POST['userID'];
         
       $query2 = $conn->prepare("SELECT * FROM personal_info WHERE (userFirstName LIKE ? OR userLastName LIKE ?) AND userID!=?");
       $query2->execute(array("%$search%","%$search%",$userID));
         $result = $query2 -> fetchAll();
         

         
          $response = array();
         foreach( $result as $row ) {
                $queryF = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? AND userTwoID = ? AND status = 3 And actionUserID != ?) OR (userOneID = ? AND userTwoID = ? AND status = 3 AND actionUserID != ?)");
                $queryF->execute(array($row['userID'],$userID,$userID,$userID,$row['userID'],$userID));
                $rowF = $queryF->fetch(PDO::FETCH_BOTH);

                if($queryF->rowCount() > 0) {
                } else {
$response[] = array("id"=>$row['userID'],"fName"=>$row['userFirstName'],"lName"=>$row['userLastName'],"icon"=>$row['userImage']);                }
}
         echo json_encode($response);
        
    }
    
    
     if($_POST['type'] == "getMessages") {

       $otherID = $_POST['otherID'];
       $userID = $_POST['userID'];
         
       $query2 = $conn->prepare("SELECT * FROM message WHERE (senderID = ? AND receiverID = ?) OR (senderID = ? AND receiverID = ?)");
       $query2->execute(array($userID,$otherID,$otherID,$userID));
         $result = $query2 -> fetchAll();
         
         
           $query = $conn->prepare("SELECT * FROM personal_info WHERE 
userID=? ");
            $query->execute(array($otherID));
            $row2 = $query->fetch(PDO::FETCH_BOTH);
         
             
$fName = $row2['userFirstName'];
$lName = $row2['userLastName'];
$userImage = $row2['userImage'];
         
          $response = array();
         foreach( $result as $row ) {
                $response[] = array("messageID"=>$row['messageID'], "otherFName"=>$row2['userFirstName'],"otherID"=>$row2['userID'],
                                    "otherLName"=>$row2['userLastName'],
                                    "otherImage"=>$row2['userImage'],
                                    "senderID"=>$row['senderID'],"message"=>$row['message'],"status"=>$row['status'],"sentTime"=>$row['sentTime']);                }
         echo json_encode($response);
        
    }
    
     if($_POST['type'] == "addMessage") {

       $receiverID = $_POST['receiverID'];
       $userID = $_POST['userID'];
       $message = $_POST['message'];
         
         $queryF = $conn->prepare("INSERT INTO message (senderID, receiverID, message) VALUES (?,?,?)");
            $queryF->execute(array($userID,$receiverID,$message));
            $rowF = $queryF->fetch(PDO::FETCH_BOTH);
        
    }
     if($_POST['type'] == "addMessage") {

       $receiverID = $_POST['receiverID'];
       $userID = $_POST['userID'];
       $message = $_POST['message'];
	 }
       if($_POST["type"] == 'updateMessage')
 
	{
	    $userID = $_POST['userID'];
		$queryF = $conn->prepare("UPDATE message SET status = '1' WHERE status = '0' AND receiverID = ?");
		$queryF->execute(array($userID));
	}
}
?>
