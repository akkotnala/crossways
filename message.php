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

                  <ul class="user-list">
                    <li><span class="user-name"><a class="userName" data-id="<?php if(isset($row6['userID'])) { echo $row6['userID']; } ?>" href="#">
                      <img src="upload/<?php echo $userImage; ?>" alt="" class="img-circle" style="width: 45px; height: auto;"></a></span>
                          <?php if(isset($row6['userFirstName'])) { echo $row6['userFirstName']; } ?>
                          <?php if(isset($row6['userLastName'])) { echo ' '.$row6['userLastName']; } ?>
                    </li>

                  </ul>






                    <?php

                                    }
                                    
                                   
                                }
                                echo "</ul>";
                                ?>
                </div>
              </div>
              <div class="col-md-8 sign-in-inner">
                <div class="status">

                  <h1 class="timeline-h1 colorOrange">Messages</h1>
                  <p class="start-msg">Click on friend name to start conversation</p>
                  <div class="mesgs">
                    <div class="msg_history">

                    </div>
                  </div>
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
<script>
  (function() {

    $('.status').on('click', '.msg_send_btn', (function(e) {
      e.preventDefault();
      var msg = $('.write_msg').val();
      var receiverID = $(this).attr("data-id");
      if (msg) {

        $.ajax({
          url: 'functions.php',
          data: {
            'type': 'addMessage',
            "receiverID": receiverID,
            "message": msg,
            "userID": <?php echo $userID; ?>
          },
          type: 'post',
          success: function(result) {

            var d = new Date($.now());
            var dt = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

            var tempHTML = '<div class="outgoing_msg"><div class="sent_msg"><p>' + msg + '</p><span class="time_date">' + dt + '</span></div></div>';
            $('.write_msg').val("");
            $(tempHTML).insertBefore($(".type_msg"));
            //                       / location.reload();
          }
        });

      }
    }));


    $.ajax({
      url: 'functions.php',
      data: {
        'type': 'updateMessage',
        "userID": <?php echo $userID; ?>
      },
      type: 'post',
      success: function(result) {}
    });


    $('.userName').click(function(e) {
      e.preventDefault();

      $('.start-msg').hide();
      $('.type_msg').show();
      var oID = $(this).attr('data-id');
      $('.message-users li  a').removeClass("active-msg");
      $(this).addClass("active-msg");
      $.ajax({
        url: "functions.php",
        type: 'post',
        dataType: "json",
        data: {
          otherID: $(this).attr('data-id'),
          type: 'getMessages',
          "userID": <?php echo $userID; ?>
        },
        success: function(data) {
          var html = '';
          data.forEach(function(item) {
            if (item.senderID != <?php echo $userID; ?>) {
              html += '<div class="incoming_msg"><div class="incoming_msg_img"> <img src="' + item.otherImage + '" alt=""> </div><div class="received_msg"><div class="received_withd_msg"><p>' + item.message + '</p><span class="time_date">' + item.sentTime + '</span></div></div></div>';


            } else {
              html += '<div class="outgoing_msg"><div class="sent_msg"><p>' + item.message + '</p><span class="time_date"> ' + item.sentTime + '</span></div></div>';
            }

          });
          html += '<div class="type_msg"><div class="input_msg_write"><input type="text" class="write_msg" placeholder="Type a message" /><button class="msg_send_btn " data-id="' + oID + '" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button> </div></div>';

          $('.msg_history').html(html);
        }
      });
    });

  })();

</script>
