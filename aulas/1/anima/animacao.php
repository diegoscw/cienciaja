<style>
@font-face {
  font-family: 'Flat-UI-Icons';
  src: url('fonts/Flat-UI-Icons.eot');
  src: url('fonts/Flat-UI-Icons.eot?#iefix') format('embedded-opentype'), url('fonts/Flat-UI-Icons.woff') format('woff'), url('fonts/Flat-UI-Icons.ttf') format('truetype'), url('fonts/Flat-UI-Icons.svg#Flat-UI-Icons') format('svg');
  font-weight: normal;
  font-style: normal;
}

#fundo {
	width:960px; 
	height:510px; 
	position:relative;
	background:url(aulas/1/anima/fundo.png) 0 0 no-repeat;
	font-family:'Calibri';
}

#jogo{
	position:absolute;
	top:0;
	left:0;
	width:960px; 
	height:513px;
}

#fundo button{
	display:inline-block;
	width:54px;
	height:54px;
	border:0;
	padding:0;
	background:none;
	cursor:pointer;
	position:absolute;
}	
	
#fundo #btn_config{
	background:url(aulas/1/anima/spt_config.png) no-repeat left top;
	-webkit-transition: 0.5s ease all;
	top:40px;
	right:30px;
}

#fundo #btn_config:hover{
	-webkit-animation:btn_config_girar 0.5s steps(5) infinite;
    animation: btn_config_girar 1s steps(5) infinite;
}

@-webkit-keyframes btn_config_girar { 
      0% { background-position:    0px 0; } 
    100% { background-position: -270px 0; }
} 

@keyframes btn_config_girar { 
      0% { background-position:    0px 0; } 
    100% { background-position: -270px 0; }
}

#fundo #btn_playstop{
	top:110px;
	right:90px;
}

#fundo .btn_play{
	background-image:url(aulas/1/anima/btn_playstop.png);
	background-position:0 top;
}

#fundo .btn_stop{
	background-image:url(aulas/1/anima/btn_playstop.png);
	background-position:0 bottom;
}

#fundo #btn_step{
	background-image:url(aulas/1/anima/btn_step.png);
	top:110px;
	right:30px;
}

#fundo #inp_velocidade{
	border:2px solid #1abc9c;
	border-radius:5px;
	padding:10px 15px;
	font-size:30px;
	line-height:30px;
	width:80px;
	position:absolute;
	top:180px;
	right:30px;
	text-align:center;
	background-color: #ffffff;
	color: #1abc9c;
}

#fundo #inp_velocidade::-webkit-input-placeholder {
	color: #819db9;
	font-size:21px;
	line-height:35px;
}

#fundo #inp_velocidade.placeholder {
	color: #819db9;
	font-size:21px;
	line-height:30px;
}

#fundo #inp_velocidade:focus {
	border-color: #1abc9c;
}

#fundo #box_config{
	background:rgba(238,238,238,1);
	display:none;
	position:absolute;
	top:0;
	right:0;
	width:260px;
	padding:30px;
}

#fundo #btn_fechar{
	position:relative;
	background-image:url(aulas/1/anima/btn_fechar.png);
	float:right;
}

#fundo label {
	display: block;
	cursor: pointer;
	position: relative;
	padding-left: 35px;
	font-size: 24px;
	color:#666;
	transition:0.5s ease all;
	color:#bdc3c7;
	margin-bottom:20px;
}

#fundo label:before{
	position:absolute;
	top:0;
	left:0;
}

#fundo label.checked{
	color:#1abc9c;
}

#fundo label.checked:before{	
	content: "\e034";	
	font-family: 'Flat-UI-Icons';
}

#fundo label.unchecked:before{
	content: "\e033";		
	font-family: 'Flat-UI-Icons';
}

#fundo label.unchecked:hover:before{	
	content: "\e034";	
	font-family: 'Flat-UI-Icons';
}

#fundo input[type=range] {
    -webkit-appearance: none;
    background-color: #bdc3c7;
    width: 180px;
    height:20px;
}

#fundo input[type="range"]::-webkit-slider-thumb {
     -webkit-appearance: none;
    background-color: #1abc9c;
    opacity: 1;
    width: 10px;
    height: 26px;
}

#fundo .range{
	margin-bottom:20px;
	font-size:24px;
	color:#1abc9c;
}
</style>

<div id="fundo">
	<canvas id="jogo" width="960" height="510"></canvas>
	<button id="btn_playstop" class="btn_play" onclick="start();"></button>
	<button id="btn_config" onclick="mostraboxconfig();"></button>
	<button id="btn_step" onclick="step();"></button>
	<input id="inp_velocidade" type="text" value="" placeholder="Vm(m/s)" >
	<div id="box_config">
		<button id="btn_fechar" onclick="fecharboxconfig();"></button>
		<span style="display:block; clear:both; height:15px;"></span>
		<label id="chk_grid" class="unchecked" onClick="grid.mostrar();">
			Grid
		</label>
		<form class="range" onsubmit="return false" oninput="o.value = parseInt(slider.value)">
			<input id="slider" type="range" name="slider" value="100"  min="10" max="100" step="10" onchange="grid.alterar();">
			<output name="o">100</output>cm
		</form>
		<label id="chk_rastro" class="unchecked" onClick="mostrargrid();">
			Rastro
		</label>
		<label id="chk_dadosextras" class="unchecked" onClick="dados.mostrar();">
			Dados Fixos
		</label>
	</div>
</div>

<script src="aulas/1/anima/ge1doot.js"></script>
<script type="text/javascript">
	function mostraboxconfig(){
		$("#box_config").slideDown();
	}
	
	function fecharboxconfig(){
		$("#box_config").slideUp();
	}

	var Tempo=0, timer, hit=0;
		
	var CANVAS_WIDTH = 960;
	var CANVAS_HEIGHT = 510;
	
	var canvasElement = document.getElementById("jogo");
	var canvas = canvasElement.getContext("2d");
		
	var gravidade=0.098;
	
	var configs = {
		execucao:0
	};
	
	var dados ={
		visivel:0,
		desenhar: function(objeto) {
			var pnome=[], pvalor=[], qtd=0, largura=0, altura=0;
			if (objeto.height!=0){
				pnome[qtd]='h'
				pvalor[qtd]=(objeto.height/100).toFixed(2)+"m";
				qtd++;
			}
			if (objeto.width!=0){
				pnome[qtd]='l'
				pvalor[qtd]=(objeto.width/100).toFixed(2)+"m";
				qtd++;
			}
			if (objeto.x!=0){
				pnome[qtd]='x'
				pvalor[qtd]=(objeto.x/100).toFixed(2)+"m";
				qtd++;
			}
			if ((CANVAS_HEIGHT-objeto.y-chao-objeto.height)!=0){
				pnome[qtd]='y'
				pvalor[qtd]=((CANVAS_HEIGHT-objeto.y-chao.height-objeto.height)/100).toFixed(2)+"m";
				qtd++;
			}
			if (objeto.ay!=0){
				pnome[qtd]='ay'
				pvalor[qtd]=(-objeto.ay*100).toFixed(2)+"m/s²";
				qtd++;
			}
			if (objeto.vx!=0){
				pnome[qtd]='vx'
				pvalor[qtd]=(objeto.vx).toFixed(2)+"m/s";
				qtd++;
			}
			canvas.font = "bold 16px Arial";
			var i=0;
			while (i<qtd){
				if (largura<canvas.measureText(pnome[i]+"="+pvalor[i]).width)
					largura=canvas.measureText(pnome[i]+"="+pvalor[i]).width;
				altura+=18;
				i++;
			}
			canvas.fillStyle = "white";
			for (i=0; i<qtd; i++){
				canvas.fillText(pnome[i]+"="+pvalor[i], objeto.x+objeto.width+10, 16+objeto.y+(objeto.height-altura)/2+i*18);
			}
		},
		mostrar: function(){
			this.visivel=Math.abs(this.visivel-1);
			if (this.visivel==1)
				document.getElementById("chk_dadosextras").className="checked";
			else
				document.getElementById("chk_dadosextras").className="unchecked";
			desenhar();
		}
	}
	
	var espaco=100;
	
	var grid ={
		espacamento:100,
		visivel:0,
		ay:0,
		vy:0,
		vx:0,
		mostrar: function() {
			this.visivel=Math.abs(this.visivel-1);
			if (this.visivel==1)
				document.getElementById("chk_grid").className="checked";
			else
				document.getElementById("chk_grid").className="unchecked";
			desenhar();
		},
		alterar: function() {
			espaco=document.getElementById('slider').value;
			desenhar();
		},
		desenhar: function() {
			var linhas=(CANVAS_HEIGHT/espaco), colunas=(CANVAS_WIDTH/espaco);
			for (var i=0; i<linhas+1; i++){
				canvas.beginPath();
				canvas.moveTo(0, -((i*espaco)-CANVAS_HEIGHT));
				canvas.lineTo(CANVAS_WIDTH, -((i*espaco)-CANVAS_HEIGHT));
				canvas.closePath();
				canvas.stroke();
				}
			for (i=0; i<colunas+1; i++){
				canvas.beginPath();
				canvas.moveTo((i*espaco), 0);
				canvas.lineTo((i*espaco), CANVAS_HEIGHT);
				canvas.closePath();
				canvas.stroke();
				}
		}
	};
	
	
	var sprite = function (){
		frames:0;
		path:'';
		tempo:0;
	};
	
	var chao = {
		color: "#A00",
		width: CANVAS_WIDTH,
		height: 35,
		x: 0,
		y: CANVAS_HEIGHT-35,
		vy:0,
		ay:0,
		vx:0,
		desenhar: function() {
			//canvas.fillStyle = this.color;
			//canvas.fillRect(this.x, this.y, this.width, this.height);
		}
    };
	
	var explosao = {
		width: 129,
		height: 114,
		x: 0,
		y: 0,
		tempo:0,
		img:[],
		obj:[],
		visivel:0,
		desenhar: function() {
			//canvas.fillStyle = this.color;
			//canvas.fillRect(this.x, this.y, this.width, this.height);
			if (Tempo-this.tempo<10*this.img.frames){
				canvas.globalAlpha=(explosao.img.frames-20)/(Tempo-this.tempo);
				this.obj[0].desenhar();
				this.obj[1].desenhar();
				canvas.globalAlpha=1;
				canvas.drawImage(this.img.path, Math.floor(((Tempo-this.tempo)/this.img.tempo)%this.img.frames)*this.width, 0, this.width, this.height, this.x, this.y, this.width, this.height);
			}else{
				this.visivel=0;
				delete this.obj[0];
				delete this.obj[1];
				configs.execucao=0;
				clearInterval(timer);
				setarvariaveis();
				start();
			}
		},
		explodir: function(objA, objB) {
			this.visivel=1;
			this.obj[0]=objA;
			this.obj[1]=objB;
			objA.vx=0;
			objB.vx=0;
			objA.visivel=0;
			objB.visivel=0;
			if (objA.x+objA.width>objB.x)
				this.x=((objA.x+objA.width+objB.x)/2)-this.width/2;
			else
				this.x=((objB.x+objB.width+objA.x)/2)-this.width/2;
			this.y=(objA.y+objA.height+objB.y+objB.height)/2-this.height;
			this.tempo=Tempo;
		}
    };
		
	var jogador = {
		color: "#0A0",
		width: 56,
		height: 33,
		x: 0,
		y: CANVAS_HEIGHT-33-chao.height,
		vx: 0,
		ay: 0,
		vy:0,
		tempo:0,
		visivel:1,
		img:[],
		desenhar: function() {
			//canvas.fillStyle = this.color;
			//canvas.fillRect(this.x, this.y, this.width, this.height);
			canvas.drawImage(this.img.path, Math.floor((this.tempo/this.img.tempo)%this.img.frames)*this.width, 0, this.width, this.height, this.x, this.y, this.width, this.height);
		},
		mover: function() {
			this.x+=this.vx;
			this.tempo=Tempo;
		}
    };
	
	var pedra = {
		color: "#00A",
		x: 500,
		y:0,
		yi:0,
		width: 40,
		height: 30,
		vy: 0,
		vx: 0,
		ay:0,
		ax:0,
		tempo:0,
		drag:0,
		visivel:1,
		img:[],
		desenhar: function() {
			//canvas.fillStyle = this.color;
			//canvas.fillRect(this.x, this.y, this.width, this.height);
			canvas.drawImage(this.img.path, Math.floor((this.tempo/this.img.tempo)%this.img.frames)*this.width, 0, this.width, this.height, this.x, this.y, this.width, this.height);
		},
		mover: function() {
			this.vy+=this.ay;
			this.y=this.y+this.vy;
			this.vx+=this.ax;
			this.x+=this.vx;
			this.tempo++;
		}
    };
	
	function colisao(objA, objB, explodir){
		if ((objA.x<(objB.x+objB.width)) && ((objA.x+objA.width)>objB.x) && (objA.y<(objB.y+objB.height)) && ((objA.y+pedra.height)>objB.y)) {
			if ((objB.vx>0)&&(objA.x>objB.x+objB.width/2)){
				objA.x=objB.x+objB.width;
				objA.vx=objB.vx;
				if (explodir==1)
					explosao.explodir(objA, objB);
			}
			return 1;
		}
		else
			return 0;
	}
	
	function colisaosup(objA, objB, margemX, margemY){
		if ((objA.x-objB.x>-margemX)&&(objA.x-objB.x<objB.width-objA.width+margemX)&&(objB.y-objA.y-objA.height<0)&&(objB.y-objA.y-objA.height>-margemY)){
			objB.color="#0A0";
			objA.vy=objB.vy;
			objA.ay=objB.ay;
			objA.vx=objB.vx;
			objA.y=objB.y-objA.height;
			return 1;
			}
		else
			return 0;
	}
	
	function colisaocanvas(obj){
		if (obj.x+obj.width>CANVAS_WIDTH)
			return 1;
		else
			return 0;
	}
	
	function verificarcolisoes(){
		if (colisaosup(pedra, jogador, 10, 30)==1){
		}else if (colisao(pedra, jogador, 1)==1){ 
		}
		colisaosup(pedra, chao, 50, 100);
		if (colisaocanvas(jogador)==1){
			configs.execucao=0;
			clearInterval(timer);
			setarvariaveis();
			start();
		}
			
	}
	
	function desenhardados(){
		canvas.fillStyle = "white";
		canvas.font = "bold 26px Arial";
		canvas.fillText("t:"+(Tempo/100).toFixed(1)+"s", 30, CANVAS_HEIGHT-10);
	}
			
	function desenharrastro() {
		for (i=0; i<=Math.floor(jogador.tempo/20); i++){
			canvas.globalAlpha=i/Math.floor(jogador.tempo/20);
			canvas.drawImage(jogador.img.path, Math.floor(i%jogador.img.frames)*56, 0, jogador.width, jogador.height, jogador.vx*i*10, jogador.y, jogador.width, jogador.height);
			canvas.globalAlpha=1;
			//canvas.fillStyle = "hsl("+i*20+",50%,50%)";
			//canvas.fillRect(jogador.velocidade*i*10, jogador.y, jogador.width, jogador.height);
		}
		for (i=0; i<=Math.floor(pedra.tempo/10); i++){
			canvas.globalAlpha=i/Math.floor(pedra.tempo/10);
			canvas.drawImage(pedra.img.path, Math.floor(i%jogador.img.frames)*40, 0, pedra.width, pedra.height, pedra.x,  pedra.yi+0.5*gravidade*i*i*100, pedra.width, pedra.height);
			canvas.globalAlpha=1;
			//canvas.fillStyle = "hsl("+i*20+",50%,50%)";
			//canvas.fillRect(pedra.x, pedra.yi+0.5*gravidade*i*i*100, pedra.width, pedra.height);
		}
	}
		
	function desenhar() {
		canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
		if (grid.visivel==1)
			grid.desenhar();
		//desenharrastro();
		chao.desenhar();
		if (jogador.visivel==1)
			jogador.desenhar();
		if (pedra.visivel==1)
			pedra.desenhar();
		if (dados.visivel==1){
			dados.desenhar(pedra);
			dados.desenhar(jogador);
		}
		if (explosao.visivel==1)
			explosao.desenhar();
		desenhardados();
	}
	
	function mensagem(texto){
		var box=document.getElementById("alerta");
		var msg=document.getElementById("mensagem");
		msg.innerHTML=texto;
		$("#alerta").slideDown();
	}
	
	function setarvalores(){
		Tempo=0;
		pedra.x=Math.floor((CANVAS_WIDTH+pedra.width)/2);
		pedra.yi=pedra.y=pedra.height;
		pedra.ay=gravidade;
	}
	
	function setarvariaveis(){
		Tempo=0;
		pedra.tempo=0;
		pedra.y=pedra.yi;
		pedra.ay=gravidade;
		pedra.vx=0;
		pedra.visivel=1;
		jogador.tempo=0;
		jogador.x=0;
		jogador.visivel=1;
		explosao.tempo=0;
	}
	
	function start() { 
		var btn=document.getElementById("btn_playstop");
		if (btn.className=="btn_stop"){
			btn.className="btn_play";
			clearTimeout(timer);
		}else{
			btn.className="btn_stop";
			if (configs.execucao==0){
				if (document.getElementById("inp_velocidade").value)
					jogador.vx=parseFloat(document.getElementById("inp_velocidade").value);
				else
					jogador.vx=0;
				configs.execucao++;
			}
			timer=setInterval(function(){
					atualizar();
					verificarcolisoes();
					Tempo++;
					if (Tempo%2==0)
						desenhar();
				}, 1);	
		}
		
	}
	
	function step() { 
		if (configs.execucao==0){
			if (document.getElementById("inp_velocidade").value)
				jogador.vx=parseFloat(document.getElementById("inp_velocidade").value);
			else
				jogador.vx=0;
			configs.execucao++;
		}
		for (var ka=0;ka<10;ka++)
			{
				atualizar();
				Tempo++;
				desenhar();
				verificarcolisoes();
			}
	}
	
	function atualizar() {
		if (hit!=1){
			jogador.mover();
			pedra.mover();
		}else
			explosao.mover();
	}
	
	canvasElement.addEventListener("mousedown", mousedown, false);
	function mousedown(event) {
		if (pedra.drag>0)
			pedra.drag=0;
		if ((pointer.X>pedra.x)&&(pointer.X<pedra.x+pedra.width)&&(pointer.Y>pedra.y)&&(pointer.Y<pedra.y+pedra.height))
			pedra.drag++;
	} 
	
	canvasElement.addEventListener("mousemove", mousemove, false);
	function mousemove(event) {
		if (pedra.drag>0){
			pedra.x=pointer.X;
			pedra.yi=pedra.y=pointer.Y;
			}
		desenhar();
		if ((pointer.X>=pedra.x)&&(pointer.X<=pedra.x+pedra.width)&&(pointer.Y>=pedra.y)&&(pointer.Y<=pedra.y+pedra.height)){
			dados.desenhar(pedra);
		}
		if ((pointer.X>=jogador.x)&&(pointer.X<=jogador.x+jogador.width)&&(pointer.Y>=jogador.y)&&(pointer.Y<=jogador.y+jogador.height)){
			dados.desenhar(jogador);
		}
	} 

	
(function () {	
	scr = new ge1doot.Screen({
		container: "jogo",
		resize: function () {
				var gw = Math.round(960);
				var gh = Math.round(510);
			}
	});
	
	canvas = scr.ctx;
	scr.resize();
		
	jogador.img = new sprite();
	jogador.img.path = new Image();
	jogador.img.path.src = "aulas/1/anima/carro.png";
	jogador.img.frames=4;
	jogador.img.tempo=10;
	
	
	explosao.img = new sprite();
	explosao.img.path = new Image();
	explosao.img.path.src = "aulas/1/anima/explosao.gif";
	explosao.img.frames=33;
	explosao.img.tempo=10;
	
	pedra.img = new sprite();
	pedra.img.path = new Image();
	pedra.img.path.src = "aulas/1/anima/caixa.png";
	pedra.img.frames=8;
	pedra.img.tempo=80;
	
	pointer = new ge1doot.Pointer({});
	setarvalores(); 
	desenhar();
	})().load({
});
</script>

        


