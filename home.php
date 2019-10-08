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
$query = $conn->prepare("SELECT u.*, p.* ,a.* FROM user u 
LEFT JOIN personal_info p ON u.userID = p.userID  
LEFT JOIN address a ON p.addressID = a.addressID WHERE 
u.userID=? ");
    $query->execute(array($pUserID));
    $row = $query->fetch(PDO::FETCH_BOTH);

if($query->rowCount() > 0) {


} else{
    header("location:profile.php");
}


$query2 = $conn->prepare("SELECT e.*, a.* FROM education e
LEFT JOIN address a ON e.addressID = a.addressID WHERE 
e.userID=? ");
    $query2->execute(array($pUserID));

    $results = $query2->fetchAll(PDO::FETCH_ASSOC);
    



    $queryF = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? AND userTwoID = ?) OR (userOneID = ? AND userTwoID = ?)");
    $queryF->execute(array($pUserID,$userID,$userID,$pUserID));
    $rowF = $queryF->fetch(PDO::FETCH_BOTH);

    if($queryF->rowCount() > 0) {

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
                                         <a class="colorOrange" href="match.php?userID=<?php echo $encoded; ?>">Match With Hobbies</a> <br>
                                        <a class="colorOrange" href="matching_feelings.php?userID=<?php echo $encoded; ?>">Match With Feelings</a>
                                    </div>
                                    <hr>
                                    
                                </div>
                            </div>
                            <div class="col-md-8 sign-in-inner">
                                <div class="status">
                                    <ul class="nav nav-tabs mt-2 text-center custom-log-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="singin-tab" data-toggle="tab" href="#sign-in" role="tab" aria-controls="signin" aria-selected="true">Text</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="singup-tab" data-toggle="tab" href="#sign-up" role="tab" aria-controls="signup" aria-selected="true">Image</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="statusContent">
                                        <div class="tab-pane fade show active" id="sign-in" role="tabpanel" aria-labelledby="signin-tab">
                                            <form class="form-sign-in" method="post" novalidate>
                                                <div class="form-label-group">
                                                    <div class=" mb-2">
                                                        <textarea rows="3" required id="inputStatus" name="inputStatus" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-block mr-auto add-post" type="submit">Post</button>
                                            </form>
                                        </div>


                                        <div class="tab-pane fade" id="sign-up" role="tabpanel" aria-labelledby="signup-tab">
                                            <form class="form-sign-in" method="post" novalidate enctype="multipart/form-data">
                                                <div class="form-label-group row">
                                                    <div class="input-group  mb-2">
                                                        <img class="statuse-image img-fluid" id='img-upload' src="img/hqdefault.jpg" />
                                                        <div class="input-group img-imput">
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-default btn-file">
                                                                    Browse Image <input type="file" name="imgImp" id="imgInp" required>
                                                                </span>
                                                            </span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <button class="btn btn-block mr-auto post-image" type="submit">Post</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    
                                    $query3 = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? OR userTwoID = ?) AND status = 1");
                                    $query3->execute(array($pUserID,$pUserID));

                                    $results3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    $friends_array = [];
                                    array_push($friends_array,$pUserID);
                                    foreach($results3 as $row) {
                                        if($row['userOneID'] == $pUserID) {
                                            array_push($friends_array,$row['userTwoID']);
                                        }else{
                                            array_push($friends_array,$row['userOneID']);
                                        }
                                    }
                                    
                                    
                                     $placeholders = str_repeat ('?, ',  count ($friends_array) - 1) . '?';
                                     $query4 = $conn->prepare("SELECT * FROM post WHERE userID IN ($placeholders) ORDER BY postDate DESC");
                                     $query4->execute($friends_array);

                                    $results4 = $query4->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach($results4 as $row) {
                                     
                                        $query6 = $conn->prepare("SELECT * FROM personal_info WHERE userID=? ");
                                        $query6->execute(array($row['userID']));
                                        $row6 = $query6->fetch(PDO::FETCH_BOTH);

                                        $ufName = $row6['userFirstName'];
                                        $ulName = $row6['userLastName'];
                                        $userImage = $row6['userImage'];
                                        
                                        $dt = new DateTime($row['postDate']);
 
                                    ?>
                                <div class="posts">
                                    <div class="post-bar">
                                        <div class="post_topbar">
                                            <div class="meet-dt">
                                                <img src="upload/<?php echo $userImage; ?>" alt="">
                                                <div class="meet-name">
                                                    <h3>
                                                        <?php if(isset($row6['userFirstName'])) {echo $row6['userFirstName']; } if(isset($row6['userLastName'])) {echo ' '.$row6['userLastName']; } ?>
                                                    </h3>
                                                    <span><img src="img/clock.png" alt="">
                                                        <?php echo $dt->format('d-M-Y H:i'); ?></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="post_descp">
                                            <p>
                                                <?php if($row['postType']=='text') {
                                        echo $row['postContent']; 
                                    }
                                        else{
                                            echo "<img class='img-fluid' src='img/".$row['postContent']."' width='400px' height='auto' >";
                                        }
                                                ?>
                                            </p>

                                        </div>


                                        <?php 
                                        
                                         $queryLikes = $conn->prepare("SELECT * FROM post_likes WHERE postID = ?");
                                         $queryLikes->execute(array($row['postID']));

                                         $resultsLike = $queryLikes->fetchAll(PDO::FETCH_ASSOC);
                                        
                                            $liked_array = [];
                                            foreach($resultsLike as $row) {
                                                    array_push($liked_array,$row['likedUserID']);
                                            }
                                        
                                        
                                         $queryComments = $conn->prepare("SELECT * FROM post_comment WHERE postID = ?");
                                         $queryComments->execute(array($row['postID']));

                                         $resultsComments = $queryComments->fetchAll(PDO::FETCH_ASSOC);
                                        
                                            $comment_array = [];
                                            foreach($resultsComments as $row) {
                                                    array_push($comment_array,$row['commentedUserID']);
                                            }
                                        
                                        ?>

                                        <div class="post-status-bar">
                                            <ul class="like-com">
                                                <li>
                                                    <?php if(!in_array($userID,$liked_array))
                                                    {
                                                        echo '<a href="#" class="like-change" data-id='.$row["postID"].' ><i class="far fa-heart"></i> Like</a>';
                                                    }else {
                                            echo '<a href="#" class="colorOrange unlike-change" data-id='.$row["postID"].'><i class="fas fa-heart"></i> Like</a>';
                                        }
                                                ?>


                                                    <img src="img/liked-img.png" alt="">
                                                    <span>
                                                        <?php echo count($liked_array); ?></span>
                                                </li>
                                                <li><i class="far fa-comment-alt"></i> Comments
                                                    <?php echo count($comment_array); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="comment-section">

                                        <?php
                                        
                                        foreach($resultsComments as $row) {
                                              
                                             $queryCmt = $conn->prepare("SELECT * FROM personal_info WHERE 
                                            userID=? ");
                                                $queryCmt->execute(array($row['commentedUserID']));
                                                $rowCmt = $queryCmt->fetch(PDO::FETCH_BOTH);


                                                $dtm = new DateTime($row['commentDate']);
 
                                        
                                        ?>
                                        <div class="comment-sec">
                                            <ul>
                                                <li>
                                                    <div class="comment-list">
                                                        <div class="bg-img">
                                                            <img src="upload/<?php echo $rowCmt['userImage']; ?>" alt="">
                                                        </div>
                                                        <div class="comment">
                                                            <h3>
                                                                <?php if(isset($rowCmt['userFirstName'])) {echo $rowCmt['userFirstName']; } if(isset($rowCmt['userLastName'])) {echo ' '.$rowCmt['userLastName']; } ?>
                                                            </h3>
                                                            <span><img src="img/clock.png" alt="">
                                                                <?php echo $dtm->format('d-M-Y H:i'); ?></span>
                                                            <p>
                                                                <?php echo $row['comment'];?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>


                                        <?php
                                        
                                    }
                                        
                                        ?>
                                        <!--comment-sec end-->
                                        <div class="post-comment">
                                            <div class="cm_img">
                                                <img src="upload/<?php echo $userImage; ?>" alt="">
                                            </div>
                                            <div class="post_comment_box">
                                                <form>
                                                    <input type="text" id="pst-<?php echo $row['postID']; ?>" data-id="<?php echo $row['postID']; ?>" placeholder="Post a comment">
                                                    <button class="btn post-comment-update" data-id="<?php echo $row['postID']; ?>" type="submit">Send</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!--post-comment end-->
                                    </div>

                                </div>
                                <?php
                                          
                                    }
                                        
                                        ?>
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

<script>
    $(document).ready(function() {

        // Update Friend Req
        $('.btn-req').click(function(e) {
            e.preventDefault();

            var req_status = $(this).data('val');

            $.ajax({
                url: 'functions.php',
                data: {
                    'type': 'changeFriendStatus',
                    "req_status": req_status,
                    "userID": <?php echo $userID; ?>,
                    "otherUser": <?php echo $pUserID; ?>
                },
                type: 'post',
                success: function(result) {
                    location.reload();
                }
            });
        });

        // Update Like 
        $('.like-change').click(function(e) {
            e.preventDefault();

            var postID = $(this).data('id');

            $.ajax({
                url: 'functions.php',
                data: {
                    'type': 'like',
                    "postID": postID,
                    "userID": <?php echo $userID; ?>
                },
                type: 'post',
                success: function(result) {
                    location.reload();
                }
            });
        });


        // Update UN Like 
        $('.unlike-change').click(function(e) {
            e.preventDefault();

            var postID = $(this).data('id');

            $.ajax({
                url: 'functions.php',
                data: {
                    'type': 'unlike',
                    "postID": postID,
                    "userID": <?php echo $userID; ?>
                },
                type: 'post',
                success: function(result) {
                    location.reload();
                }
            });
        });


        // Update Post Comment 
        $('.post-comment-update').click(function(e) {
            e.preventDefault();

            var postID = $(this).data('id');
            var inputVal = $("#pst-" + postID).val();
            if (inputVal) {
                $.ajax({
                    url: 'functions.php',
                    data: {
                        'type': 'comment',
                        "postID": postID,
                        "comment": inputVal,
                        "userID": <?php echo $userID; ?>
                    },
                    type: 'post',
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        });


        // Update Post Comment 
        $('.add-post').click(function(e) {
            e.preventDefault();

            var status = $("#inputStatus").val();

            if (status) {
                $.ajax({
                    url: 'functions.php',
                    data: {
                        'type': 'status',
                        "status": status,
                        "userID": <?php echo $userID; ?>
                    },
                    type: 'post',
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        });

        // Update Post Image 
        $('.post-image').click(function(e) {
            e.preventDefault();

            var myFormData = new FormData();
            myFormData.append('pictureFile', $('#imgInp').prop('files')[0]);
            myFormData.append('type', "image-post");
            myFormData.append('userID', <?php echo $userID; ?>);

            if (1 == 1) {
                $.ajax({
                    url: 'functions.php',
                    type: 'post',
                    processData: false, // important
                    contentType: false, // important
                    dataType: 'json',
                    data: myFormData,
                    success: function(result) {
                        location.reload();
                    }
                });
            }
        });


    })

</script>
