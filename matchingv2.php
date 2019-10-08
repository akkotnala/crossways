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

$A = array("Confused","Rejected", "Helpless", "Submissive", "Insecure", "Anxious", "Embarrassed", "Discouraged", "Overwhelmed", "Guilty", "Ashamed", "Depressed", "Lonely", "Bored", "Tired", "Sleepy",  "Stupid", "Inferior", "Hurt", "Hostile",  "Angry",  "Selfish",  "Hateful", "Critical", "Irritated", "Jealous", "Frustrated");
$B = array("Excited", "Sensuous", "Energetic", "Cheerful", "Creative", "Hopeful", "Fascinating", "Amused", "Playful",  "Faithful", "Important", "Appreciated", "Respected",  "Proud", "Aware", "Surprised", "Valueable", "Worthwhile", "Content", "Thoughtful",  "Intimate", "Loving",  "Trusting", "Nurturing", "Secure", "Thankful",  "Responsive"  );


$a = 0; $b = 0; 

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
    
    
}


if ($a > $b) {
  
    
    $match_result = 0;
}

if ($b > $a) {

    
    $match_result = 1;
}




$query_set = $conn->prepare("UPDATE personal_info set matching_feelings = ? WHERE userID =  ?");

$query_set -> execute(array($match_result, $pUserID));


$query3 = $conn->prepare("SELECT userID FROM personal_info WHERE matching_feelings = ? AND userID != ?   ");

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