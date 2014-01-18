<style>
#fundo {
	width:960px; 
	height:510px; 
	position:relative;
	background:url(aulas/4/anima/beckerback.png) 577px 220px no-repeat;
}
#becker {
	position:absolute;
	top:230px;
	left:677px;
	width: 284px;
	height: 284px;
	background:url(aulas/4/anima/beckerfront.png);
}
#escala {
	position:absolute;
	bottom:-40px;
	right:50px;
	width: 110px;
	height: 35px;
	background:url(aulas/4/anima/escala.png);
}
#screen {
	position:absolute;
	top:0;
	left:0;
	width: 960px;
	height: 510px;
	cursor: none;
}
#btn_aquecer, #btn_esfriar, #btn_parar{
	position:absolute;
	right:20px;
	diplay:inline-block;
	height:32px;
	width:32px;
	cursor:pointer;
}
#btn_aquecer{
	background:url(aulas/4/anima/fogo.png);
	top:50px;
}
#btn_esfriar{
	background:url(aulas/4/anima/gelo.png);
	top:90px;
}
#btn_parar{
	background:url(aulas/4/anima/stop.png);
	top:130px;
}
</style>
<div id="fundo">
	<div id="escala"></div>
	<canvas id="screen"></canvas>
	<div id="becker"></div>
	<a id="btn_aquecer" onclick="aquecer();"></a>
	<a id="btn_esfriar" onclick="esfriar();"></a>
	<a id="btn_parar" onclick="parar();"></a>
</div>

<script src="aulas/4/anima/ge1doot.js"></script>
<script>
var particulas=100,fase=3;
var obj = [];

(function () {
	var scr, ctx, pointer, grid, npart, pdiam, gw, gh, ax = 0, ay = 0, gx, gy, g, flag=0;
	/* ==== construtor particula ==== */
	var Particle = function () {
		if (Math.floor(Math.random() * 10)>5)
			this.x = Math.floor(Math.random() * 600);
		else
			this.x=Math.floor(Math.random() * 200)+750;
		this.y = Math.floor(Math.random() * scr.height);
		this.vx = 0;
		this.vy = 0;
		this.dx = 0;
		this.dy = 0;
		this.temperatura=1;//1-50solido 51-100liquido 101-150gas
	}
	/* ==== move particle ==== */
	Particle.prototype.move = function () {
		if (this.temperatura>99){
			if ((this.dx==0)&&(Math.floor(Math.random()*10)>8))
				if (Math.floor(Math.random()*10)>5)
					this.dx=Math.floor(Math.random()*2)+1;
				else
					this.dx=-Math.floor(Math.random()*2)-1;
			if ((this.dy==0)&&(Math.floor(Math.random()*10)>8))
				if (Math.floor(Math.random()*10)>3)
					this.dy=Math.floor(Math.random()*2)+1;
				else
					this.dy=-Math.floor(Math.random()*2)-1;
		}
		this.x+=this.dx;
		this.vx+=this.dx;
		this.y  += this.dy;
		this.vy += this.dy;
		this.dx  = 0;
		this.dy  = 0;
		/* ---- desenha particula ---- */
		ctx.beginPath();
		ctx.arc(this.x, this.y, 10, 0, 2 * Math.PI, false);
		ctx.fillStyle = 'hsl(' + -((this.temperatura*1.6)-240) + ', ' + (50) + '%, 50%)';
		ctx.fill();
	}
	/* ==== simulacao particula ==== */
	Particle.prototype.physics = function () {
		/* ---- mouse ---- */
		flag=0;
		if (pointer.isDown) {
			var dx = this.x - pointer.X;
			var dy = this.y - pointer.Y;
			var d = Math.sqrt(dx * dx + dy * dy);
			if (d < Math.min(scr.width, scr.height) / 2) {
				this.dx += dx / d * 2;
				this.dy += dy / d * 2;
			}
		}
		/* ---- gravidade and aceleracao ---- */
		this.vy += ay;//*this.peso;
		if (this.temperatura<50)
			this.vy +=0.3;
		else if (this.temperatura<100)
			this.vy +=0.1;
		else
			this.vy -=0.2;
		this.x+=this.vx;
		this.y += this.vy;
		/* ---- limites tela ---- */
		if (this.x < pdiam * .5) 
			this.dx += (pdiam * .5 - this.x);
		else if (this.x > scr.width - pdiam * .5) 
			this.dx -= (this.x - scr.width + pdiam * .5);
		else if ((this.x > 600 - pdiam * .5)&&(this.x < 650 - pdiam * .5)&&(this.y > 200 - pdiam * .5)){
			this.dx -= (this.x - 600 + pdiam * .5);
			flag++;
		}
		else if ((this.x > 649 - pdiam * .5)&&(this.x < 700 - pdiam * .5)&&(this.y > 200 - pdiam * .5)){
			this.dx += (-pdiam * .5 -this.x+700);
			flag++;
		}
		if (this.y < pdiam * .5) 
			this.dy += (pdiam * .5 - this.y);
		else if (this.y > scr.height - pdiam * .5) 
			this.dy -= (this.y - scr.height + pdiam * .5);
		else if ((flag==0)&&(this.x > 600 - pdiam * .5)&&(this.x < 700 - pdiam * .5)&&(this.y > 200 - pdiam * .5))
			this.dy -= (this.y - 200 + pdiam * .5);
		/* ---- grid coordinates ---- */
		gx=Math.round(this.x / (pdiam * 4));
		gy=Math.round(this.y / (pdiam * 4));
		/* ---- variacao temperatura ---- */
		if (fase<2)
			if ((pointer.X>this.x-100)&&(pointer.X<this.x+100)&&(pointer.Y<this.y+100)&&(pointer.Y>this.y-100)){
				if ((fase==1)&&(this.temperatura<149))
					this.temperatura++;
				else if ((fase==0)&&(this.temperatura>1))
					this.temperatura--;
			}
		/* ---- colisao particulas ---- */
		for (var ix = gx - 1; ix <= gx + 1; ix++) {  
			for (var iy = gy - 1; iy <= gy + 1; iy++) {
				var g = grid[iy * gw + ix] || [];
				for (var j = 0, l = g.length; j < l; j++) {
					var that = g[j];
					var dx = that.x - this.x;
					var dy = that.y - this.y;
					var temp=((this.temperatura+that.temperatura)/2);
					var d = Math.sqrt(dx * dx + dy * dy);
					if (d < pdiam+(temp/5)) {
						dx = Math.round((dx / d) * (pdiam+(temp/5) - d) * .25);
						dy = Math.round((dy / d) * (pdiam+(temp/5) - d) * .25);
						this.temperatura=temp;
						that.temperatura=temp;
						this.dx -= dx+this.temperatura*0.006;
						this.dy -= dy+this.temperatura*0.006;
						that.dx += dx+that.temperatura*0.006;
						that.dy += dy+that.temperatura*0.006;
					} 
				}
			}
		}		
		/* ---- update neighbors list ---- */
		if (!grid[gy * gw + gx]) 
			grid[gy * gw + gx] = [this];
		else 
			grid[gy * gw + gx].push(this);
	}
	/* ==== loop principal ==== */
	var run = function () {
		// ---- limpa a tela ----
		ctx.clearRect(0, 0, scr.width, scr.height);
		grid = new Array(gw * gh);
		// ---- cursor mouse ----
		ctx.beginPath();
		ctx.arc(pointer.X, pointer.Y, 100, 0, 2 * Math.PI, false);
		if (fase==1)
			ctx.fillStyle =  "rgba(255, 111, 5, 0.1)";
		else if (fase==0)
			ctx.fillStyle =  "rgba(0, 100, 255, 0.1)";
		else
			ctx.fillStyle =  "rgba(0, 0, 0, 0.1)";
		ctx.fill();
		for(var i = 0; i < npart; i++){ 
			obj[i].move(); 
			obj[i].physics();
		}
		// ---- proximo frame ----
		requestAnimFrame(run);
	}
	/* ==== inicializacao ==== */
	var init = function (p) {
		pdiam = 20;
		// ---- canvas ----
		scr = new ge1doot.Screen({
			container: "screen",
			resize: function () {
				gw = Math.round(scr.width  / (pdiam * 4));
				gh = Math.round(scr.height / (pdiam * 4));
			}
		});
		ctx = scr.ctx;
		scr.resize();
		// ---- pointer ----
		pointer = new ge1doot.Pointer({});
		// ---- criar particulas ----
		npart =particulas;
		for (var i = 0; i < npart; i++) {
			obj[i] = new Particle();
		}
		ay = 0.1;
		run();
	}
	return {
		// ---- launch script -----
		load : function (p) {
			window.addEventListener('load', function () {
				init(p);
			}, false);
		}  
	}
})().load({
});

function parar(){
	fase=3;
}

function aquecer(){
	fase=1;
}

function esfriar(){
	fase=0;
}
</script>