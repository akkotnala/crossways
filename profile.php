<?php
include("header.php");

?>
<?php 

if(isset($_POST['fullForm']))
   {
    $fName = $_POST['inputFName'];
    $lName = $_POST['inputLName'];
    $bDay = $_POST['bDay'];
    $bMonth = $_POST['bMonth'];
    $bYear = $_POST['bYear'];
    $gender = $_POST['radioGender'];
    
     $birth = $bMonth.'-'.$bDay.'-'.$bYear;
     $queryF = $conn->prepare("UPDATE personal_info set userFirstName=? , userLastName =? , userGender=?, userBirth=? WHERE userID=?");
     $queryF->execute(array($fName, $lName, $gender, $birth, $userID));
         
    
    $inputAddress = $_POST['inputAddress'];
    $inputCity = $_POST['inputCity'];
    $inputState = $_POST['inputState'];
    $inputCountry = $_POST['inputCountry'];
    $addressID = $_POST['addressID'];
    
    if(isset($addressID) && $addressID!="") {
        $queryF = $conn->prepare("UPDATE address set address=? , city =? , state=?, country=? WHERE addressID=?");
        $queryF->execute(array($inputAddress, $inputCity, $inputState, $inputCountry, $addressID));
    } else {
         $sql2 = "INSERT INTO address (address , city , state, country) VALUES (?,?,?,?)";
        $stmt2= $conn->prepare($sql2);
        $inserted2 = $stmt2->execute([$inputAddress, $inputCity, $inputState, $inputCountry]);
        
        $lastId = $conn->lastInsertId();
        
        $queryF = $conn->prepare("UPDATE personal_info set addressID=?  WHERE userID=?");
       $queryF->execute(array($lastId, $userID));
    }
    
}


if(isset($_GET['userID']))
{
    
      $pUserID = $_GET['userID'];
     $queryF = $conn->prepare("SELECT * FROM relationship WHERE (userOneID = ? AND userTwoID = ? AND status = 3 And actionUserID != ?) OR (userOneID = ? AND userTwoID = ? AND status = 3 AND actionUserID != ?)");
                $queryF->execute(array($pUserID,$userID,$userID,$userID,$pUserID,$userID));
                $rowF = $queryF->fetch(PDO::FETCH_BOTH);

                if($queryF->rowCount() > 0) {
                  $pUserID = $userID;  
                }
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

<style>
  .entry-content {
     border: none;
    padding: 5% 0%;
}
    .header-avatar img {
    height: 150px;
    width: 150px;
}
    header.profile-3 {
    background: linear-gradient(rgba(34, 34, 34, 0.7), rgba(34, 34, 34, 0.7)), url(upload/<?php echo $row['userCover'];?>) no-repeat center center fixed;}
</style>


<!-- ==============================================
	 Header
	 =============================================== -->
<header class="profile-3">
  <div class="container">
    <div class="row">

      <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
        <div class="post-heading">

        </div><!-- /.post-heading -->
        <?php 
                                        
if($pUserID == $userID) {
?>
        <form action='updatepic.php' method='post' enctype="multipart/form-data">
          <input type="file" name="image" />
          <input type="hidden" value="<?php echo $_SESSION['userID'];?>" name="userId" />
          <br />
          <input class="sta2" type='submit' name="submitcover" value="submit" />
        </form>
        <?php
                                        }
    else{
    }
        ?>

      </div><!-- /.col-lg-8 -->

    </div><!-- /.row -->
  </div><!-- /.container -->
</header><!-- /header -->


<!-- ==============================================
	 Header Avatar
	 =============================================== -->
<div class="header-avatar">
  <?php 
                                        
if($pUserID == $userID) {
?>
  <img alt="" src="upload/<?php echo $row['userImage'];?>" class="avatar avatar-200 photo" width="200" height="200">
            <div class="post-heading">

  <form action='updatepic.php' method='post' enctype="multipart/form-data">
    <input type="file" name="image" />
    <input type="hidden" value="<?php echo $_SESSION['userID'];?>" name="userId" />
    <input class="sta2" type='submit' name="submitpic" value="submit" />
  </form>
    </div>
  <?php
                                        }
    else{
        ?>
  <img alt="" src="upload/<?php echo $row['userImage'];?>" class="avatar avatar-200 photo" width="200" height="200">

  <?php
    }
    ?>

  <p>
    <?php if(isset($row['userFirstName'])) {echo $row['userFirstName']; } if(isset($row['userLastName'])) {echo ' '.$row['userLastName']; } ?>
  </p>
</div>

<!-- ==============================================
	 Entry Content
	 =============================================== -->
<section class="entry-content">
  <div class="container">
    <h3 class="title">About me</h3>
    <h5 class="description">An artist of considerable range, Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music, giving it a warm, intimate feel with a solid groove structure. An artist of considerable range.</h5>
  </div><!-- /container -->
</section><!-- /entry-content -->





<!--

<section class="cover-sec">
    <img src="upload/<?php echo $row['userCover'];?>" alt="">
    <form action='updatepic.php' method='post' enctype="multipart/form-data">
        <input type="file" name="image" />
        <input type="hidden" value="<?php echo $_SESSION['userID'];?>" name="userId" />
        <br />
        <input class="sta2" type='submit' name="submitcover" value="submit" />
    </form>
</section>
-->


<main>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-10 col-lg-10 mx-auto">
        <div class="card card-sign-in card-full-profile">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="user-profile user-full-profile text-center">
                  <div class="user-logo text-center">
                    <!--
                                        <div class="image-cropper mx-auto">
                                            <img class="img-fluid profile-image" alt="Responsive image" src="upload/<?php echo $row['userImage'];?>">
                                        </div>
                                        <form action='updatepic.php' method='post' enctype="multipart/form-data">
                                            <input type="file" name="image" />
                                            <input type="hidden" value="<?php echo $_SESSION['userID'];?>" name="userId" />
                                            <input class="sta2" type='submit' name="submitpic" value="submit" />
                                        </form>
-->

                    <?php 
                                        
                                        if($pUserID != $userID) {
                                            
                                            
                                            if($queryF->rowCount() > 0) {
                                                
                                                switch ($rowF['status']) {
                                                    case 0:
                                                        if ($rowF['actionUserID'] == $userID) {
                                                            // Show, "Friend request sent" button. Show options to cancel the friend request.
                                                            ?>

                    <a class=" btn request-button btn-req" data-val=2 href="#">Cancel</a>
                    <a class=" btn request-button btn-req" data-val=3 href="#">Block</a>

                    <?php
                                                        } elseif ($rowF['actionUserID'] == $pUserID) {
                                                            // Show, "Accept Friend request" button. Show options to block and reject friend request.
                                                            ?>

                    <a class=" btn request-button btn-req" data-val=1 href="#">Accept</a>
                    <a class=" btn request-button btn-req" data-val=2 href="#">Reject</a>
                    <a class=" btn request-button  btn-req" data-val=3 href="#">Block</a>


                    <?php
                                                        }
                                                    break;
                                                    case 1:
                                                        // Check and show options to unfriend the user.
                                                        ?>

                    <a class=" btn request-button btn-req" data-val=2 href="#">Unfriend</a>
                    <a class=" btn request-button btn-req" data-val=3 href="#">Block</a>

                    <?php
                                                     break;
                                                    case 2:
                                                        // Check and show options to unfriend the user.
                                                        ?>

                    <a class=" btn request-button btn-req" data-val=0 href="#">Send Request</a>
                    <a class=" btn request-button btn-req" data-val=3 href="#">Block</a>

                    <?php   
                                                    break;
                                                    case 3:
                                                        // Check and show options to unblock. If the other user's visit's this profile show "profile does'nt exists"
                                                        ?>

                    <a class=" btn request-button  btn-req" data-val=2 href="#">Unblock</a>

                    <?php
                                                    break;
                                                    }

                                                } 
                                            else {
                                                ?>
                    <a class=" btn request-button btn-req" data-val=0 href="#">Send Request</a>
                    <a class=" btn request-button btn-req" data-val=3 href="#">Block</a>
                    <?php
                                            }
                                            ?>




                    <?php    
                                        }
                                    
                                        
                                        ?>
                  </div>
                  <hr>
                  <div class="basic-info text-left ml-2">
                    <h3 class="edit-heading">About
                      <?php 
                                            if($userID == $pUserID) {
                                            echo '<a class="edit-button" data-toggle="modal" data-target="#modalRegisterForm">Edit</a>';
                                                
                                               }
                                                
                                                ?>
                    </h3>
                    <div class="basic-info-inner u-info">
                      <p id="gender"><span class="colorOrange"> Gender:</span>
                        <?php if(isset($row['userGender'])) { echo ucfirst($row['userGender']); }?>
                      </p>
                      <p><span class="colorOrange">Birthday:</span>
                        <?php if(isset($row['userBirth'])) { echo $row['userBirth']; }?>
                      </p>
                      <p><span class="colorOrange">Lives In:</span>
                        <?php if(isset($row['city'])) {echo $row['city']; } if(isset($row['state'])) {echo ', '.$row['state']; } if(isset($row['country'])) {echo ', '.$row['country']; } ?>
                      </p>
                    </div>
                  </div>
                  <hr>
                  <div class="basic-info text-left ml-2">
                    <h3>Education</h3>
                    <?php 
                                            foreach($results as $rowE) {
                                            ?>
                    <div class="basic-info-inner u-info">
                      <p><span class="colorOrange"> College Name:</span>
                        <?php if(isset($rowE['collegeName'])) {echo $rowE['collegeName']; } if(isset($rowE['city'])) {echo ', '.$rowE['city']; } if(isset($row['state'])) {echo ', '.$row['state']; } if(isset($rowE['country'])) {echo ', '.$rowE['country']; } ?>
                      </p>
                      <p><span class="colorOrange">Educaton Level:</span>
                        <?php if(isset($rowE['educationLevel'])) {echo $rowE['educationLevel']; } ?>
                      </p>
                      <p><span class="colorOrange">Passing Year:</span>
                        <?php if(isset($rowE['passingYear'])) {echo $rowE['passingYear']; } ?>
                      </p>
                    </div>

                    <br>
                    <?php
                                            } ?>

                  </div>
                </div>
              </div>
              <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold">Update Info</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body mx-3">
                      <form class="form-sign-in" method="post" id="fullDataForm">

                        <h3>Basic Info</h3>
                        <hr>
                        <div class="form-label-group row">
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputFName" name="inputFName" value="<?php if(isset($row['userFirstName'])) {echo $row['userFirstName']; } ?>" class="form-control" placeholder="First Name" required autofocus>
                            <div class="invalid-feedback">
                              Please enter your first name.
                            </div>
                          </div>
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputLName" name="inputLName" value="<?php if(isset($row['userLastName'])) {echo $row['userLastName']; } ?>" class="form-control" placeholder="Last Name" required>
                            <div class="invalid-feedback">
                              Please enter your last name.
                            </div>
                          </div>
                        </div>

                        <div class="form-label-group form-select-dob">
                          <label>Birthday</label><br>
                          <div class="input-group">
                            <select name="bMonth" class="custom-select form-control month-select" required>
                              <option selected value="">Month</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="input-group">
                            <select name="bDay" class="custom-select day-select" required>
                              <option selected value="">Day</option>
                            </select>
                          </div>
                          <div class="input-group">
                            <select name="bYear" class="custom-select year-select" required>
                              <option selected value="">Year</option>
                              <option value="2017">2017</option>
                              <option value="2016">2016</option>
                              <option value="2015">2015</option>
                              <option value="2014">2014</option>
                              <option value="2013">2013</option>
                              <option value="2012">2012</option>
                              <option value="2011">2011</option>
                              <option value="2010">2010</option>
                              <option value="2009">2009</option>
                              <option value="2008">2008</option>
                              <option value="2007">2007</option>
                              <option value="2006">2006</option>
                              <option value="2005">2005</option>
                              <option value="2004">2004</option>
                              <option value="2003">2003</option>
                              <option value="2002">2002</option>
                              <option value="2001">2001</option>
                              <option value="2000">2000</option>
                              <option value="1999">1999</option>
                              <option value="1998">1998</option>
                              <option value="1997">1997</option>
                              <option value="1996">1996</option>
                              <option value="1995">1995</option>
                              <option value="1994">1994</option>
                              <option value="1993" selected="1">1993</option>
                              <option value="1992">1992</option>
                              <option value="1991">1991</option>
                              <option value="1990">1990</option>
                              <option value="1989">1989</option>
                              <option value="1988">1988</option>
                              <option value="1987">1987</option>
                              <option value="1986">1986</option>
                              <option value="1985">1985</option>
                              <option value="1984">1984</option>
                              <option value="1983">1983</option>
                              <option value="1982">1982</option>
                              <option value="1981">1981</option>
                              <option value="1980">1980</option>
                              <option value="1979">1979</option>
                              <option value="1978">1978</option>
                              <option value="1977">1977</option>
                              <option value="1976">1976</option>
                              <option value="1975">1975</option>
                              <option value="1974">1974</option>
                              <option value="1973">1973</option>
                              <option value="1972">1972</option>
                              <option value="1971">1971</option>
                              <option value="1970">1970</option>
                              <option value="1969">1969</option>
                              <option value="1968">1968</option>
                              <option value="1967">1967</option>
                              <option value="1966">1966</option>
                              <option value="1965">1965</option>
                              <option value="1964">1964</option>
                              <option value="1963">1963</option>
                              <option value="1962">1962</option>
                              <option value="1961">1961</option>
                              <option value="1960">1960</option>
                              <option value="1959">1959</option>
                              <option value="1958">1958</option>
                              <option value="1957">1957</option>
                              <option value="1956">1956</option>
                              <option value="1955">1955</option>
                              <option value="1954">1954</option>
                              <option value="1953">1953</option>
                              <option value="1952">1952</option>
                              <option value="1951">1951</option>
                              <option value="1950">1950</option>
                              <option value="1949">1949</option>
                              <option value="1948">1948</option>
                              <option value="1947">1947</option>
                              <option value="1946">1946</option>
                              <option value="1945">1945</option>
                              <option value="1944">1944</option>
                              <option value="1943">1943</option>
                              <option value="1942">1942</option>
                              <option value="1941">1941</option>
                              <option value="1940">1940</option>
                              <option value="1939">1939</option>
                              <option value="1938">1938</option>
                              <option value="1937">1937</option>
                              <option value="1936">1936</option>
                              <option value="1935">1935</option>
                              <option value="1934">1934</option>
                              <option value="1933">1933</option>
                              <option value="1932">1932</option>
                              <option value="1931">1931</option>
                              <option value="1930">1930</option>
                              <option value="1929">1929</option>
                              <option value="1928">1928</option>
                              <option value="1927">1927</option>
                              <option value="1926">1926</option>
                              <option value="1925">1925</option>
                              <option value="1924">1924</option>
                              <option value="1923">1923</option>
                              <option value="1922">1922</option>
                              <option value="1921">1921</option>
                              <option value="1920">1920</option>
                              <option value="1919">1919</option>
                              <option value="1918">1918</option>
                              <option value="1917">1917</option>
                              <option value="1916">1916</option>
                              <option value="1915">1915</option>
                              <option value="1914">1914</option>
                              <option value="1913">1913</option>
                              <option value="1912">1912</option>
                              <option value="1911">1911</option>
                              <option value="1910">1910</option>
                              <option value="1909">1909</option>
                              <option value="1908">1908</option>
                              <option value="1907">1907</option>
                              <option value="1906">1906</option>
                              <option value="1905">1905</option>
                            </select>
                          </div>
                        </div>


                        <div class="form-label-group form-select-dob">
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" <?php if(isset($row[ 'userGender' ]) && $row[ 'userGender' ]=='male' ) {echo 'checked' ; }?> id="radioGenderMale" value="male" name="radioGender" class="custom-control-input" required>
                            <label class="custom-control-label" for="radioGenderMale">Male</label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" <?php if(isset($row[ 'userGender' ]) && $row[ 'userGender' ]=='female' ) {echo 'checked' ; }?> id="radioGenderFemale" value="female" name="radioGender" class="custom-control-input" required>
                            <label class="custom-control-label" for="radioGenderFemale">Female</label>
                          </div>

                        </div>

                        <h3>Address Info</h3>
                        <hr>
                        <div class="form-label-group row">
                          <input type="hidden" name="addressID" value="<?php if(isset($row['addressID'])) {echo $row['addressID']; } ?>">
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputAddress" value="<?php if(isset($row['address'])) {echo $row['address']; } ?>" name="inputAddress" class="form-control" placeholder="Address">
                            <div class="invalid-feedback">
                              Please enter your address.
                            </div>
                          </div>
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputCity" value="<?php if(isset($row['city'])) {echo $row['city']; } ?>" name="inputCity" class="form-control" placeholder="City">
                            <div class="invalid-feedback">
                              Please enter your city name.
                            </div>
                          </div>
                        </div>
                        <div class="form-label-group row">
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputState" value="<?php if(isset($row['state'])) {echo $row['state']; } ?>" name="inputState" class="form-control" placeholder="Province">
                            <div class="invalid-feedback">
                              Please enter your state.
                            </div>
                          </div>
                          <div class="input-group mb-2 col-md-6">
                            <input type="text" id="inputCountry" value="<?php if(isset($row['country'])) {echo $row['country']; } ?>" name="inputCountry" class="form-control" placeholder="Country">
                            <div class="invalid-feedback">
                              Please enter your country name.
                            </div>
                          </div>
                        </div>
                        <button class="btn btn-block mr-auto update-full-info" name="fullForm" type="submit">Update Info</button>
                      </form>

                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-8 sign-in-inner timeline">


                <h1 class="timeline-h1 colorOrange">Timeline</h1>

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
                                     $query4 = $conn->prepare("SELECT * FROM post WHERE userID =  $pUserID ORDER BY postDate DESC");
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

                      <?php 
                                        
if($pUserID == $userID) {
?>
                      <button data-post-id="<?php echo $row['postID']; ?>" data-user-id="<?php echo $row['userID']; ?>" style="float:right;" onClick="deletePost(this)"><i class="fa fa-times" aria-hidden="true"></i></button>

                      <script type="text/javascript">
                        function reply_click(clicked_id) {
                          alert(clicked_id);
                        }

                        function deletePost(input) {
                          let postID = $(input).attr('data-post-id');
                          let userID = $(input).attr('data-user-id');

                          $.get('delete_post.php', {
                              post_id: postID,
                              user_id: userID
                            },
                            function(data, status) {
                              if (status == "success") {
                                if (data.isError == false) {
                                  alert('Deleted!');
                                  location.reload();
                                }
                              }
                            }, "json"
                          );
                        }

                      </script>

                      <?php
                        }
                                      else {
                                        
                                      }
                                          ?>
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
                              <img src="<?php echo $rowCmt['userImage']; ?>" alt="">
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
                        <img src="<?php echo $userImage; ?>" alt="">
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
  });

</script>


<!-- Birthdate Select -->
<script>
  $(document).ready(function() {

    // Birth Date
    let isLeap = (year) => new Date(year, 1, 29).getDate() === 29;

    var monthSelect = $(".month-select");
    var daySelect = $(".day-select");
    var yearSelect = $(".year-select");

    var months31 = ["1", "3", "5", "7", "8", "10", "12"];
    var months30 = ["4", "6", "9", "11"];
    var monthsLeap = ["2"];

    monthSelect.change(function() {
      var selectedMonth = this.value;
      var selectedYear = +this.value;
      var dayHTML = "<option value='' selected>Day</option>";
      if (jQuery.inArray(selectedMonth, months31) !== -1) {
        for (var i = 1; i <= 31; i++) {
          dayHTML += `<option value="${i}">${i}</option>`;
        }
      } else if (jQuery.inArray(selectedMonth, months30) !== -1) {
        for (var i = 1; i <= 30; i++) {
          dayHTML += `<option value="${i}">${i}</option>`;
        }
      } else if (monthSelect.val() === "2" && isLeap(selectedYear)) {
        for (var i = 1; i <= 29; i++) {
          dayHTML += `<option value="${i}">${i}</option>`;
        }
      } else {
        for (var i = 1; i <= 28; i++) {
          dayHTML += `<option value="${i}">${i}</option>`;
        }
      }

      daySelect.html(dayHTML);
    });


    yearSelect.change(function() {
      var selectedYear = +this.value;
      var dayHTML = "<option value='' selected>Day</option>";
      if (isLeap(selectedYear) && monthSelect.val() === "2") {
        for (var i = 1; i <= 29; i++) {
          dayHTML += `<option value="${i}">${i}</option>`;
        }
      }
      daySelect.html(dayHTML);
    });
  });

</script>
