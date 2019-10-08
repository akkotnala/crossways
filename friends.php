<?php 
include("header.php");
?>
<?php function numhash($n) {
return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n)>> 16));
    }

    $encoded = $userID; 
 

if(isset($_GET['userID']))
{
    
      $pUserID = $_GET['userID'];
}
else {
      $pUserID = $userID;
}



?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-10 col-lg-10 mx-auto">
                <div class="card card-sign-in my-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
            <div class="user-profile text-center">
                                    <div class="user-logo text-center">
                                        <div class="image-cropper mx-auto">
                                            <a class="colorOrange" href="profile.php?userID=<?php echo $encoded; ?>"><img class="img-fluid profile-image" alt="Responsive image" src="upload/<?php if(isset($userImage)) {echo $userImage; } ?>"></a>
                                        </div>
                                        <h3 class="text-capitalize">
                                            <?php if(isset($fName)) {echo $fName; } if(isset($lName)) {echo ' '.$lName; } ?>
                                        </h3>
                                    </div>
                                    <hr>
                                    
                                </div>
                            </div>
                            <div class="col-md-8 sign-in-inner">
                            <div class="user-profile text-center">
                                    <?php
                                
                                 $query3 = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? OR userTwoID = ?)  AND status != 3 ");
                                    $query3->execute(array($pUserID,$pUserID));

                                    $results3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    $friends_array = [];
                                    array_push($friends_array,$pUserID);
                                    foreach($results3 as $row) {
                                        if($row['userOneID'] == $userID ) {
                                            array_push($friends_array,$row['userTwoID']);
                                        }else if($row['userTwoID'] == $userID){
                                            array_push($friends_array,$row['userOneID']);
                                            }
                                    }
                                
                                echo "<ul class='message-users' >";
                                for($i=0; $i<count($friends_array); $i++){
                                    if($friends_array[$i]!=$userID){
                                        $query6 = $conn->prepare("SELECT * FROM personal_info WHERE userID=? ");
                                            $query6->execute(array($friends_array[$i]));
                                            $row6 = $query6->fetch(PDO::FETCH_BOTH);

                                           $ufName = $row6['userFirstName'];
                                            $ulName = $row6['userLastName'];
                                            $userImage = $row6['userImage'];
                                        
                                         ?>

                                    <li><a class="userName" data-id="<?php if(isset($row6['userID'])) { echo $row6['userID']; } ?>" href="profile.php?userID=<?php echo $row['userOneID'] ?>">
                                            <?php if(isset($row6['userFirstName'])) { echo $row6['userFirstName']; } ?>
                                            <?php if(isset($row6['userLastName'])) { echo ' '.$row6['userLastName']; } ?></a></li>

                                    <?php

                                    }
                                    
                                   
                                }
                                echo "</ul>";
                                ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php 
include("footer.php");
?>
