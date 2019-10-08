<?php

include("header.php");

include('config.php');

function numhash($n) {
return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n)>> 16));
    }

if(isset($_GET['userID']))
{
   
    
      $pUserID = $_GET['userID'];
}

   $match = $_GET['match'];
// echo $match;

$matching_values = explode(', ', $match);

// print_r($matching_values);

$A = array("Sports", "Travel");
$B = array("Geeky", "Science", "IT");
$C = array("Music", "Creation", "Reading", "Movies");
$D = array("Games", "Cooking");
$E = array("Acting", "Business", "Clothing");

$a = 0; $b = 0; $c = 0; $d = 0; $e = 0;

foreach($matching_values as $match_value) {
    foreach($A as $a_value){
        
        if ($match_value == $a_value) {
            $a++;
        }
    }
    
    foreach($B as $b_value){
         if ($match_value ==$b_value) {
            $b++;
        }
    }
    
    foreach($C as $c_value){
         if ($match_value == $c_value) {
            $c++;
        }
    }
    
    
    foreach($D as $d_value){
         if ($match_value == $d_value) {
            $d++;
        }
    }
    
    
    foreach($E as $e_value){
         if ($match_value == $e_value) {
            $e++;
        }
    }
    
    
}


if (($a > $b)&&($a > $c)&&($a > $d)&&($a > $e)) {
   // echo "Congratulations, you are Active kind! ";
    
    $match_result = "Active";
}

if (($b > $a)&&($b > $c)&&($b > $d)&&($b > $e)) {
   // echo "Congratulations, you are Tech kind! ";
    
    $match_result = "Tech";
}

if (($c > $b)&&($c > $a)&&($c > $d)&&($c > $e)) {
  //  echo "Congratulations, you are Creative kind! ";
    $match_result = "Creative";
}


if (($d > $b)&&($d > $c)&&($d > $a)&&($d > $e)) {
   // echo "Congratulations, you are  Crafting kind! ";
    $match_result = "Crafting";
}


if (($e > $b)&&($e > $c)&&($e > $d)&&($e > $a)) {
  //  echo "Congratulations, you are Acting kind! ";
    $match_result = "Acting";
}

else {
  // echo "Oh wow multiple types!";
    $match_result = "Multiple";
}



$query_set = $conn->prepare("UPDATE personal_info set matching_results = ? WHERE userID =  ?");

$query_set -> execute(array($match_result, $pUserID));


$query3 = $conn->prepare("SELECT userID FROM personal_info WHERE matching_results = ? AND userID != ?   ");

$query3->execute(array($match_result, $pUserID));

$results3 = $query3->fetchAll(PDO::FETCH_ASSOC);
                                    



if (empty($results3)){
    echo "<center><h1>Oops, you're the only one!</h1></center>";
}

else {
    
    $key= array_rand($results3, 1);

$match = $results3[$key]["userID"];

$query2 = $conn->prepare("SELECT * FROM personal_info WHERE userID = ?   ");

$query2->execute(array($match));

$results = $query2->fetchAll(PDO::FETCH_ASSOC);
    
echo "<form action='' method='POST'>
<center><a href='profile.php?userID=$match'><button type='button'  id='finish' class='btn btn-success'>Go to my match " . $results[0]['userFirstName']  . " " . $results[0]['userLastName'] . "!</button></a></center>
</form>";




}


//$match = json_encode($match);

?>
<style>
body {
  margin: auto;
    
  background-image: linear-gradient(to bottom, aqua, pink);
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 100%;


}

    btn {
        margin-top: 100px;
    }

</style>



<?php 
?>