<?php
include('config.php');
session_start();
if(isset($_SESSION['userID'])) {
header('location: home.php');
}
?>
<?php $loginCls = "show active";
if(isset($_POST['login']))
   {
    $loginCls = "show active";
    $registerCls = "";
    $user = $_POST['inputLEmail'];
    $pass = $_POST['inputLPassword'];
    $query = $conn->prepare("SELECT userID, userEmail, userPassword FROM user WHERE userEmail=? AND userPassword=? ");
    $query->execute(array($user,$pass));
    $row = $query->fetch(PDO::FETCH_BOTH);
    
    if($query->rowCount() > 0) {
      $_SESSION['userID'] = $row['userID'];
      header('location:home.php');
    } else {
      $message = "Email/Password is wrong";
    }
   }

if(isset($_POST['reset_password']))
   {
    $messageSuccess2 = "Email sent successfully.";
}
if(isset($_POST['register']))
   {
    $registerCls = "show active";
    
    $loginCls = "";
    $user = $_POST['inputEmail'];
    $pass = $_POST['inputPassword'];
    $fName = $_POST['inputFName'];
    $lName = $_POST['inputLName'];
    $bDay = $_POST['bDay'];
    $bMonth = $_POST['bMonth'];
    $bYear = $_POST['bYear'];
    $gender = $_POST['radioGender'];
    
    $birth = $bMonth.'-'.$bDay.'-'.$bYear;
    
     $query = $conn->prepare("SELECT userEmail FROM user WHERE userEmail=?");
    $query->execute(array($user));
    $row = $query->fetch(PDO::FETCH_BOTH);
    
    if($query->rowCount() > 0) {
        
      $messageSingUp = "Email is already registered";
    } else {
        $sql = "INSERT INTO user (userEmail, userPassword) VALUES (?,?)";
    $stmt= $conn->prepare($sql);
    $inserted = $stmt->execute([$user, $pass]);
    
    if($inserted) {
        $lastId = $conn->lastInsertId();
        
        $sql2 = "INSERT INTO personal_info (userID, userFirstName, userLastName, userGender, userBirth) VALUES (?,?,?,?,?)";
        $stmt2= $conn->prepare($sql2);
        $inserted2 = $stmt2->execute([$lastId, $fName, $lName, $gender, $birth]);
        
        if($inserted2) {
            $messageSuccess = "Registered Successfully. Click on login.";
        }
        else{
            $messageSingUp = "Something went wrong.";
        }
    }
    }
   }



?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>CrossWays</title>
</head>

<body id="login-body">
    <!--The body element contains the full visible content of the web page-->
    <header>
        <!--The header typically includes your logo, tagline, and may contain a nav element-->
        <nav>
            <!--The nav element isn't used for every single link but for navigational menus-->
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-md-10 col-lg-10 mx-auto">
                    <div class="card card-sign-in my-5">
                        <div class="card-body">
                            <div class="row card-divider">
                                <div class="d-none d-md-block col-md-6">
                                    <div class="web-info">
                                        <div class="web-logo text-center">
                                            <p>CrossWays is a network of peopel. Where you can connect to different people.</p>
                                        </div>
                                        <img class="mx-auto d-block m-5 img-w-70" class="img-fluid" alt="Responsive image" src="img/networking.png">
                                    </div>
                                </div>
                                <div class="col-md-6 sign-in-inner">
                                    <ul class="nav nav-tabs mt-2 text-center custom-log-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link <?php if(isset($loginCls) && !empty($loginCls)) {echo 'active'; }?>" id="singin-tab" data-toggle="tab" href="#sign-in" role="tab" aria-controls="signin" aria-selected="true">SignIn</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php if(isset($registerCls) && !empty($registerCls)) {echo $registerCls; }?>" id="singup-tab" data-toggle="tab" href="#sign-up" role="tab" aria-controls="signup" aria-selected="true">SignUp</a>
                                        </li>
                                    </ul>
                                    <hr>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade <?php if(isset($loginCls) && !empty($loginCls)) {echo $loginCls; }?>" id="sign-in" role="tabpanel" aria-labelledby="signin-tab">
                                            <?php 
                                            if(isset($message)) {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $message; ?>
                                            </div>
                                            <?php
                                            }
                                            ?>

                                            <?php 
                                            if(isset($messageSuccess2)) {
                                            ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $messageSuccess2; ?>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <form class="form-sign-in" method="post" novalidate>
                                                <div class="form-label-group">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                                        </div>
                                                        <input type="email" id="inputLEmail" name="inputLEmail" class="form-control" placeholder="Email" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Please enter your email.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-label-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                        </div>
                                                        <input type="password" id="inputLPassword" name="inputLPassword" class="form-control" placeholder="Password" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your password.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-label-group">
                                                    <div class="input-group">
                                                        <p><a class="forgot" href="">Forgot Password?</a></p>
                                                    </div>
                                                </div>
                                                <button class="btn btn-block mr-auto" type="submit" name="login">Sign In</button>
                                            </form>
                                        </div>


                                        <div class=" tab-pane fade <?php if(isset($registerCls)  && !empty($registerCls)) {echo $registerCls; }?>" id="sign-up" role="tabpanel" aria-labelledby="signup-tab">
                                            <?php 
                                            if(isset($messageSingUp)) {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $messageSingUp; ?>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <?php 
                                            if(isset($messageSuccess)) {
                                            ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $messageSuccess; ?>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <form class="form-sign-in" method="post" novalidate>
                                                <div class="form-label-group row">
                                                    <div class="input-group mb-2 col-md-6">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                                                        </div>
                                                        <input type="text" id="inputFName" name="inputFName" class="form-control" placeholder="First Name" required autofocus>
                                                        <div class="invalid-feedback">
                                                            Please enter your first name.
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-2 col-md-6">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-user"></i></div>
                                                        </div>
                                                        <input type="text" id="inputLName" name="inputLName" class="form-control" placeholder="Last Name" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your last name.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-label-group">
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                                        </div>
                                                        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your email.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-label-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                        </div>
                                                        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your password.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-label-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                                                        </div>
                                                        <input type="password" id="inputCPassword" name="inputCPassword" class="form-control" placeholder=" ConfirmPassword" required>
                                                        <div class="invalid-feedback">
                                                            Please enter your confirmation password.
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
                                                        <input type="radio" id="radioGenderMale" name="radioGender" value="male" class="custom-control-input" required>
                                                        <label class="custom-control-label" for="radioGenderMale">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="radioGenderFemale" name="radioGender" value="female" class="custom-control-input" required>
                                                        <label class="custom-control-label" for="radioGenderFemale">Female</label>
                                                    </div>

                                                </div>
                                                <button class="btn btn-block mr-auto" type="submit" name="register">Sign Up</button>
                                            </form>
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
    <footer>
        <!--The footer typically contains links to things like About Us, Privacy Policy, Contact Us and so forth. It may also contain a nav, address, section, or aside element.--> <address>
            <!--Put an address element in the footer and you're indicating that the contact info within the element is for the owner of the website rather than the author of the article.--> </address> </footer>

    <!-- jQuery, Popper, Bootstrap.min JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- Custom JS -->
    <script src="js/validation.js"></script>

    <!-- Birthdate Select -->
    <script>
        $(document).ready(function() {



            $(".forgot").click(function(e) {

                e.preventDefault();
                $(this).unbind('click');
                $('#sign-in').append('<form method="post" class="forgot-password"><div class="form-label-group"><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-envelope"></i></div></div><input type="email" id="inputFEmail" name="inputFEmail" class="form-control" placeholder="Email" required autofocus><div class="invalid-feedback">Please enter your email.</div></div> </div><button class="btn btn-block mr-auto" type="submit" name="reset_password">Reset Password</button></form>');
            });
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
</body>

</html>
