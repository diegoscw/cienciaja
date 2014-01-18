
<script language="javascript" src="aulas/5/anima/javascripts/jquery.hotkeys.js" type="text/javascript"></script>
<script language="javascript" src="aulas/5/anima/javascripts/key_status.js" type="text/javascript"></script>
<script language="javascript" src="aulas/5/anima/javascripts/util.js" type="text/javascript"></script>
<script language="javascript" src="aulas/5/anima/javascripts/sprite.js" type="text/javascript"></script>
<script language="javascript" src="aulas/5/anima/javascripts/sound.js" type="text/javascript"></script>
<style>
#screen{
background:url(aulas/5/anima/fundoa.gif);
}
</style>
<canvas id='screen' width="960" height="510"></canvas>
    <script type='text/javascript'>
      //<![CDATA[
        var CANVAS_WIDTH = 960;
        var CANVAS_HEIGHT = 510;
        var FPS = 30;
        
        var player = {
          color: "#00A",
          x: 900,
          y: 250,
          width: 48,
          height: 42,
          draw: function() {
            canvas.fillStyle = this.color;
            canvas.fillRect(this.x, this.y, this.width, this.height);
          }
        };
        
        var playerBullets = [];
        
        function Bullet(I) {
          I.active = true;
        
          I.xVelocity = -I.speed;
          I.yVelocity = 0;
          I.width = 30;
          I.height = 30;
		  var cores = {};
		  cores[0]='#F00';
		  cores[1]='#0F0';
		  cores[2]='#00F';
          I.color = cores[Math.floor(Math.random()*3)];
        
          I.inBounds = function() {
            return I.x >= 0 && I.x <= CANVAS_WIDTH &&
              I.y >= 0 && I.y <= CANVAS_HEIGHT;
          };
        
          I.draw = function() {
            canvas.fillStyle = this.color;
            canvas.fillRect(this.x, this.y, this.width, this.height);
          };
          
          I.update = function() {
            I.x += I.xVelocity;
            I.y += I.yVelocity;
        
            I.active = I.active && I.inBounds();
          };
        
          I.explode = function() {
            this.active = false;
            // Extra Credit: Add an explosion graphic
          };
        
          return I;
        }
        
        enemies = [];
        
        function Enemy(I) {
          I = I || {};
        
          I.active = true;
          I.age = Math.floor(Math.random() * 128);
          
          I.color = "#A2B";
        
          I.x = 0;
          I.y = CANVAS_HEIGHT / 4 + Math.random() * CANVAS_HEIGHT / 2;
          I.xVelocity = 2;
          I.yVelocity = 1;
        
          I.width = 50;
          I.height = 50;
        
          I.inBounds = function() {
            return I.x >= 0 && I.x <= CANVAS_WIDTH &&
              I.y >= 0 && I.y <= CANVAS_HEIGHT;
          };
		
		  if (I.age>50)
          I.sprite = Sprite("carne");
		  else
          I.sprite = Sprite("pao");
        
          I.draw = function() {
            this.sprite.draw(canvas, this.x, this.y);
          };
        
          I.update = function() {
            I.x += I.xVelocity;
            I.y += I.yVelocity;
        
            I.yVelocity = 3 * Math.sin(I.age * Math.PI / 64);
        
            I.age++;
        
            I.active = I.active && I.inBounds();
          };
        
          I.explode = function() {
            Sound.play("explosion");
        
            this.active = false;
            // Extra Credit: Add an explosion graphic
          };
        
          return I;
        };
        
        var canvasElement = $(document.getElementById("screen"));
        var canvas = canvasElement.get(0).getContext("2d");
        
        setInterval(function() {
          update();
          draw();
        }, 1000/FPS);
        
        function update() {
          if(keydown.space) {
            player.shoot();
          }
        
          if(keydown.left) {
            player.x -= 5;
          }
		  
          if(keydown.up) {
            player.y -= 5;
          }
		  
          if(keydown.down) {
            player.y += 5;
          }
        
          if(keydown.right) {
            player.x += 5;
          }
        
          player.x = player.x.clamp(0, CANVAS_WIDTH - player.width);
          
          playerBullets.forEach(function(bullet) {
            bullet.update();
          });
        
          playerBullets = playerBullets.filter(function(bullet) {
            return bullet.active;
          });
          
          enemies.forEach(function(enemy) {
            enemy.update();
          });
        
          enemies = enemies.filter(function(enemy) {
            return enemy.active;
          });
        
          handleCollisions();
        
          if(Math.random() < 0.1) {
            enemies.push(Enemy());
          }
        }
        
        player.shoot = function() {
          Sound.play("shoot");
        
          var bulletPosition = this.midpoint();
        
          playerBullets.push(Bullet({
            speed: 5,
            x: bulletPosition.x,
            y: bulletPosition.y
          }));
        };
        
        player.midpoint = function() {
          return {
            x: this.x + this.width/2,
            y: this.y + this.height/2
          };
        };
        
        function draw() {
          canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
          player.draw();
          
          playerBullets.forEach(function(bullet) {
            bullet.draw();
          });
        
          enemies.forEach(function(enemy) {
            enemy.draw();
          });
        }
        
        function collides(a, b) {
          return a.x < b.x + b.width &&
            a.x + a.width > b.x &&
            a.y < b.y + b.height &&
            a.y + a.height > b.y;
        }
        
        function handleCollisions() {
          playerBullets.forEach(function(bullet) {
            enemies.forEach(function(enemy) {
              if(collides(bullet, enemy)) {
                enemy.explode();
                bullet.active = false;
              }
            });
          });
        
          enemies.forEach(function(enemy) {
            if(collides(enemy, player)) {
              enemy.explode();
              player.explode();
            }
          });
        }
        
        player.explode = function() {
          this.active = false;
          // Extra Credit: Add an explosion graphic and then end the game
        };
        
        player.sprite = Sprite("player");
        
        player.draw = function() {
          this.sprite.draw(canvas, this.x, this.y);
        };
      //]]>
    </script>