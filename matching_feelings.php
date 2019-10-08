<html lang="en" class="">
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

<head>


    <script src="stopExecutionOnTimeout.js"></script>
    <script src="TweenMax.min.js"></script>
    <script src="pixi.min.js"></script>
    <script src="p2.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Carter+One" rel="stylesheet">
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        
     h1 {
    font-family: 'Carter One', cursive;
    font-size: 40px;
    color:firebrick;
  /*  text-shadow: 2px 2px #ff0066; */
    
 
}
        text {
  font: 24px "Helvetica Neue", Helvetica, Arial, sans-serif;
  text-anchor: middle;
  pointer-events: none;
}
    </style>
    
</head>

<body>
 <center>   <h1>Describe yourself</h1>
    <form action="matchingv2.php" method="POST"> <button type="button" onclick="Passing()" class="btn btn-success">Ready!</button></form></center>
       


    <script>
        var data = [
        {name: "Confused", color: 0x151514, group: "a"},
        {name: "Rejected", color: 0x151514, group: "a"},
        {name: "Helpless", color: 0x151514, group: "a"},
        {name: "Submissive", color: 0x151514, group: "a"},
        {name: "Insecure", color: 0x151514, group: "a"},
        {name: "Anxious", color: 0x151514, group: "a"},
        {name: "Embarrassed", color: 0x151514, group: "a"},
        {name: "Discouraged", color: 0x151514, group: "a"},
        {name: "Overwhelmed", color: 0x151514, group: "a"},
        
        {name: "Excited", color: 0xff2c55, group: "a"},
        {name: "Sensuous",color: 0xff2c55, group: "a"},
        {name: "Energetic", color: 0xff2c55, group: "a"},
        {name: "Cheerful", color: 0xff2c55, group: "a"},
        {name: "Creative",color: 0xff2c55, group: "a"},
        {name: "Hopeful", color: 0xff2c55, group: "a"},
        {name: "Fascinating", color: 0xff2c55, group: "a"},
        {name: "Amused",color: 0xff2c55, group: "a"},
        {name: "Playful", color: 0xff2c55, group: "a"}, 

        {name: "Faithful", color: 0xff2c55, group: "a"},
        {name: "Important", color: 0xff2c55, group: "a"},
        {name: "Appreciated", color: 0xff2c55, group: "a"},
        {name: "Respected", color: 0xff2c55, group: "a"},
        {name: "Proud", color: 0xff2c55, group: "a"},
        {name: "Aware", color: 0xff2c55, group: "a"},
        {name: "Surprised", color: 0xff2c55, group: "a"},
        {name: "Valueable", color: 0xff2c55, group: "a"},
        {name: "Worthwhile", color: 0xff2c55, group: "a"},
            
        {name: "Content",color: 0xff2c55, group: "a"},
        {name: "Thoughtful", color: 0xff2c55, group: "a"},
        {name: "Intimate", color: 0xff2c55, group: "a"},
        {name: "Loving", color: 0xff2c55, group: "a"},
        {name: "Trusting", color: 0xff2c55, group: "a"},
        {name: "Nurturing", color: 0xff2c55, group: "a"},
        {name: "Secure", color: 0xff2c55, group: "a"},
        {name: "Thankful", color: 0xff2c55, group: "a"},
        {name: "Responsive", color: 0xff2c55, group: "a"},
            
        {name: "Guilty", color:0x151514, group: "a"},
        {name: "Ashamed", color:0x151514, group: "a"},
        {name: "Depressed", color:0x151514, group: "a"},
        {name: "Lonely", color:0x151514, group: "a"},
        {name: "Bored", color:0x151514, group: "a"},
        {name: "Tired", color:0x151514, group: "a"},
        {name: "Sleepy", color:0x151514, group: "a"},
        {name: "Stupid", color:0x151514, group: "a"},
        {name: "Inferior", color:0x151514, group: "a"},
            
        {name: "Hurt", color:0x151514, group: "a"},
        {name: "Hostile", color:0x151514, group: "a"},
        {name: "Angry", color:0x151514, group: "a"},
        {name: "Selfish", color:0x151514, group: "a"},
        {name: "Hateful", color:0x151514, group: "a"},
        {name: "Critical", color:0x151514, group: "a"},
        {name: "Irritated", color:0x151514, group: "a"},
        {name: "Jealous", color:0x151514, group: "a"},
        {name: "Frustrated", color: 0xff2c55, group: "a"}
        ];


        var zoom = 75;
        var balls = [];
var match ="";
        var renderer = PIXI.autoDetectRenderer(window.innerWidth, window.innerHeight, {
            transparent: true,
            antialias: true
        });

        document.body.appendChild(renderer.view);


        var world = new p2.World({
            gravity: [0, 0]
        });
        var stage = new PIXI.Container();
        stage.position.x = renderer.width / 2; // center at origin
        stage.position.y = renderer.height / 2;
        stage.scale.x = zoom; // zoom in
        stage.scale.y = -zoom; // Note: we flip the y axis to make "up" the physics "up"


        //floor
        planeShape = new p2.Plane();
        planeBody = new p2.Body({
            position: [0, -1]
        });
        planeBody.addShape(planeShape);
        world.addBody(planeBody);


        var Ball = function(t, c, r, x) {

            this.init = function() {
                this.el = new PIXI.Container();
                this.baseRadius = this.radius = r;

                this.circle = new PIXI.Graphics();
                this.circle.beginFill(c);
                this.circle.drawCircle(0, 0, 0.99);
                this.circle.endFill();
                this.circle.interactive = true;
                this.circle.hitArea = new PIXI.Circle(0, 0, 1);
                this.circle.scale.x = this.circle.scale.y = this.radius;
                this.el.addChild(this.circle);

                stage.addChild(this.el);

                let text = new PIXI.Text(t, {
                    fontFamily: 'Arial',
                    fontSize: 18,
                    fill: 0xffffff,
                    align: 'center',
                    wordWrap: true
                });

                text.anchor.x = 0.5;
                text.anchor.y = 0.5;
                text.position.x = 0;
                text.scale.x = 0.01;
                text.scale.y = -0.01;
                this.el.addChild(text);
                this.ballText = this.el.addChild(text)._text;
                this.shape = new p2.Circle({
                    radius: this.radius
                });

                let startX = x % 2 === 0 ? 2 + r : -2 - r;
                let startY = r - Math.random() * (r * 2);
                this.body = new p2.Body({
                    mass: 0.001,
                    position: [startX, startY],
                    angularVelocity: 0,
                    fixedRotation: true
                });

                this.body.addShape(this.shape);
                world.addBody(this.body);
            };

            this.update = function() {
                this.body.applyForce([-this.body.position[0] / 100, -this.body.position[1] / 100]);

                this.el.position.x = this.body.position[0];
                this.el.position.y = this.body.position[1];
                this.el.rotation = this.body.angle;
            };

            this.mouseover = function() {

            };

            this.mouseout = function() {

            };

            this.click = function() {
                this.radius = this.baseRadius + 0.3;
                console.log(this.ballText);
                match += ", " + this.ballText;
                                console.log(match);

                TweenMax.to(this.circle.scale, 0.2, {
                    x: this.radius,
                    y: this.radius,
                    onUpdate: this.updateRadius.bind(this),
                    onComplete: this.updateRadius.bind(this)
                });

            };

            this.updateRadius = function() {
                this.shape.radius = this.circle.scale.x;
                this.body.updateBoundingRadius();
            };

            this.init.call(this);
            this.circle.mouseover = this.mouseover.bind(this);
            this.circle.mouseout = this.mouseout.bind(this);
            this.circle.click = this.click.bind(this);
        };


        for (var i = 0; i < data.length; i++) {
            var ball = new Ball(data[i].name, data[i].color, 0.5, i);
            this.balls.push(ball);
                     //  .attr("id", data[i].name );
        }
        
        

        function animate() {

            world.step(1 / 60);

            for (var i = 0; i < this.balls.length; i++) {
                balls[i].update();
            }

            renderer.render(stage);

            requestAnimationFrame(animate);
        }

        animate();
        
        function Passing() {
    
   // var data = {match: match};
    //$.post("matchingv2.php", data);
    
   /* $.ajax({
        type:'GET',
        url:'matching.php',
        data: { match: match },
        success: function(data) {
        console.log("yes!", data);
    }
    }); */
    
     window.location.href = "matchingv2.php?match=" + match + "&userID=<?php echo $encoded?>";

   
   
}

    </script>

    <canvas style= "height:50px;touch-action: none; cursor: inherit;"></canvas>
</body>

</html>
