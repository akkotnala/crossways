<?php
include('config.php');
session_start();
if(!isset($_SESSION['userID'])) {
 header('location: index.php');
}

$userID = $_SESSION['userID'];

$query = $conn->prepare("SELECT * FROM personal_info WHERE userID=? ");
    $query->execute(array($userID));
    $row = $query->fetch(PDO::FETCH_BOTH);
    
$fName = $row['userFirstName'];
$lName = $row['userLastName'];
$userImage = $row['userImage'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="css/app.css" rel="stylesheet">
    <link>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Crossways</title>
</head>

<body id="">
    <!--The body element contains the full visible content of the web page-->
    <header>

        <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark meet-navbar">
            <div class="container">
                <a class="navbar-brand" href="home.php"><span class="colorOrange">Cross</span><span class="colorOrange">Ways</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="home.php">
                                <i class="fa fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="friends.php">
                                Friends
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link message-link" href="message.php">
                                <span class="badge badge-notify">3</span>
                                Messages
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="second-icon dropdown menu-icon">
                                <span role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <a class="nav-link message-link">Notifications <span class="badge badge-notify1">3</span></a>
                                </span>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownNotification">
                                    <li class="new-not">
                                        <a href="#" title="User name comment"><img src="img/user2.jpg" alt="User name" class="img-circle img-user-mini"> User comments your post</a>
                                    </li>
                                    <li class="new-not">
                                        <a href="#" title="User name comment"><img src="img/user3.jpg" alt="User name" class="img-circle img-user-mini"> User comments your post</a>
                                    </li>
                                    <li>
                                        <a href="#" title="User name comment"><img src="img/user4.jpg" alt="User name" class="img-circle img-user-mini"> User comments your post</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="notification.php" title="All notifications">All Notifications</a></li>
                                </ul>
                            </div>
                        </li>
                        <ul class="nav navbar-nav navbar-user">
                            <!-- User -->
                            <li class="dropdown open">
                                <a href="#" class="dropdown-toggle nav-link message-link" data-toggle="dropdown" aria-expanded="true">
                                    <?php echo $row['userFirstName'];?><span class="caret"></span> 
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a style="color :black;" class="nav-link" href="profile.php">Profile</a></li>
                                    <li><a style="color :black;" class="nav-link" href="settings.php">Settings</a></li>
                                    <li><a style="color :black;" class="nav-link" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>

                    </ul>
                    <form class="form-inline my-2 my-lg-0 form-search">
                        <input class="form-control mr-sm-2" type="text" id="autocomplete" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-orange my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
