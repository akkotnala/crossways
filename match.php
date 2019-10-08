<?php

include("header.php");

include('config.php');

function numhash($n) {
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
<link href="https://fonts.googleapis.com/css?family=Carter+One" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
 <script src="http://malsup.github.com/jquery.form.js"></script> 
<h1><center>MATCHING TIME!</center></h1>
<center>
<form action="matching.php" method="POST">
<button type="button" onclick="Passing()" id="finish" class="btn btn-success">Ready!</button>
</form></center>



<form action="my-account.php" method="post" enctype="multipart/form-data">
 
</form>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

var bleed = 100,
    width = 960,
    height = 760;
var match = "";

var pack = d3.layout.pack()
    .sort(null)
    .size([width, height + bleed * 2])
    .padding(2);

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(0," + -bleed + ")");

d3.json("README.json", function(error, json) {
  if (error) throw error;

  var node = svg.selectAll(".node")
      .data(pack.nodes(flatten(json))
        .filter(function(d) { return !d.children; }))
    .enter().append("g")
      .attr("class", "node")
      .attr("id", function(d) {return d.name;})
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  node.append("circle")
      .attr("r", function(d) { return d.r; })
      .style("stroke", "black");

  node.append("text")
      .text(function(d) { return d.name; })
      .style("font-size", function(d) { return Math.min(2 * d.r, (2 * d.r - 8) / this.getComputedTextLength() * 24) + "px"; })
      .attr("dy", ".35em");
  node.on("click", function(){
      console.log(1);
      console.log(d3.select(this).attr('id'));
      match += ", " + d3.select(this).attr('id');
      console.log(match);
  })
});


function flatten(root) {
  var nodes = [];

  function recurse(node) {
    if (node.children) node.children.forEach(recurse);
    else nodes.push({name: node.name, value: node.size});
  }

  recurse(root);
  return {children: nodes};
}
 
function Passing() {
    
   // var data = {match: match};
    //$.post("matching.php", data);
    
   /* $.ajax({
        type:'GET',
        url:'matching.php',
        data: { match: match },
        success: function(data) {
        console.log("yes!", data);
    }
    }); */
    
     window.location.href = "matching.php?match=" + match + "&userID=<?php echo $encoded?>";

   
   
}
     

</script>
<style>
body {
  margin:0;
  /*background-image: linear-gradient(to bottom, aqua, pink);*/
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 100%;


}

h1 {
    font-family: 'Carter One', cursive;
    font-size: 40px;
    color:firebrick;
  /*  text-shadow: 2px 2px #ff0066; */
    
 
}


circle {
  fill: white;
}

.node:hover circle {
  fill: red;
    }
    
    svg, btn {
        display: block;
        margin: auto;
    }

text {
  font: 26px "Helvetica Neue", Helvetica, Arial, sans-serif;
  text-anchor: middle;
  pointer-events: none;
  color: white  !important;
}
    
</style>




