<style>
#fundo {
	width:960px; 
	height:513px; 
	position:relative;
}

#resolucao {
	background:url(aulas/1/anima/resolucao.gif); 
	width:960px; 
	height:513px; 
	position:absolute;
	display:none;
}

#btn_fechar{
	background:url(aulas/1/anima/btn_fechar.png); 
	display:inline-block;
	position:absolute;
	height:55px;
	width:45px;
	bottom:30px;
	right:55px;
}

#velocidade {
	position:absolute;
	left:790px;
	top:330px;
	padding:0 10px;
    border-radius: 3px;
    border: none;
    box-shadow: 0 1px 2px rgba(0,0,0,0.2) inset, 0 -1px 0 rgba(0,0,0,0.05) inset;
    transition: all 0.2s linear;
    font-family: "Helvetica Neue", sans-serif;
    font-size: 20px;
    color: #222222;
    height: 36px;
    width: 50px;
}

#btn_start{
	position:absolute;
	left:870px;
	top:320px;
    height: 54px;
    width: 34px;
	background:url(aulas/1/anima/btn_start.png) 0 0 no-repeat;

}


#alerta {
	padding: 19px 0;
	text-align:center;
	color: #fefefe;
	position: absolute;
	font: 14px/20px Museo300Regular, Helvetica, Arial, sans-serif;
	display:none;
	bottom:0;
	width:100%;
	background:rgba(50,50,50,0.8);
}

#alerta #mensagem { padding: 0 20px 0 40px; font-size:18px; color:#fff;}

#jogo{
}
</style>

<div id="fundo">
	<canvas id="jogo" width="960" height="510"></canvas>
    <input id="velocidade"  type="text" />
    <a id="btn_start" onclick="start();"></a>
    
    <div id="alerta">
        <span id="mensagem"></span>
    </div>
	<div id="resolucao">
		<a id="btn_fechar" onclick="fecharresolucao();"></a>
	</div>
</div>
<a id="btn_app" onclick="upda();">atualizar</a>

<script type="text/javascript">
	var Tempo=0, btnStart, timer;
		
	var CANVAS_WIDTH = 960;
	var CANVAS_HEIGHT = 510;
	var FPS = 30;
	
	var canvasElement = document.getElementById("jogo");
	var canvas = canvasElement.getContext("2d");
	
	var gravidade=0;
	
	var jogador = {
		color: "#0A0",
		width: 50,
		height: 100,
		x: 0,
		y: CANVAS_HEIGHT-100,
		velocidade: 0,
		hit:0,
		tempo:0,
		desenhar: function() {
			canvas.fillStyle = this.color;
			canvas.fillRect(this.x, this.y, this.width, this.height);
		},
		mover: function() {
			if ((colisao()==0)&&(this.x+this.width<CANVAS_WIDTH))
				this.x+=this.velocidade;
			else 
				this.hit++;
			this.tempo=Tempo;
		}
    };
	
	var pedra = {
		color: "#00A",
		x: 500,
		y: (CANVAS_HEIGHT%100),
		yi:0,
		width: 50,
		height: 50,
		velocidade: 0,
		hit:0,
		tempo:0,
		desenhar: function() {
			canvas.fillStyle = this.color;
			canvas.fillRect(this.x, this.y, this.width, this.height);
		},
		mover: function() {
			this.velocidade=(this.velocidade+gravidade);
			if ((colisao()==0)&&(this.y<CANVAS_HEIGHT-this.height))
				this.y+=this.velocidade;
			else
				this.hit++;
			this.tempo=Tempo;
		}
    };
	
	function colisao(){
		if ((pedra.x<(jogador.x+jogador.width)) && ((pedra.x+pedra.width)>jogador.x) && (pedra.y<(jogador.y+jogador.height)) && ((pedra.y+pedra.height)>		jogador.y)) 
			return 1;
		else
			return 0;
	}
	
	function desenhardados(){
		canvas.fillStyle = "blue";
		canvas.font = "bold 26px Arial";
		canvas.fillText((Tempo/100).toFixed(2)+"s", CANVAS_WIDTH-160, 35);
		canvas.fillText((gravidade*100).toFixed(1)+"m/s²", CANVAS_WIDTH-160, 70);
		canvas.fillText("X="+pedra.x/100+"m", CANVAS_WIDTH-160, 105);
		canvas.fillText("Y="+(-(pedra.y-CANVAS_HEIGHT)-pedra.height)/100+"m", CANVAS_WIDTH-160, 140);
		canvas.fillText("V="+((((pedra.x+50)/100)/((Math.sqrt((-(pedra.yi-CANVAS_HEIGHT)-150)*2*0.01/gravidade)/10)))+0.01).toFixed(2)+"m/s", CANVAS_WIDTH-160, 170);
	}
	
	function desenhargrid() {
		var espaco=100, linhas=(CANVAS_HEIGHT/espaco), colunas=(CANVAS_WIDTH/espaco);
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
		for (i=0; i<=Math.floor(jogador.tempo/10); i++){
			canvas.fillStyle = "hsl("+i*20+",50%,50%)";
			canvas.fillRect(jogador.velocidade*i*10, jogador.y, jogador.width, jogador.height);
		}
		for (i=0; i<=Math.floor(pedra.tempo/10); i++){
			canvas.fillStyle = "hsl("+i*20+",50%,50%)";
			canvas.fillRect(pedra.x, pedra.yi+0.5*gravidade*i*i*100, pedra.width, pedra.height);
		}
	}	
		
	function desenhar() {
		canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
		desenhargrid();
		jogador.desenhar();
		pedra.desenhar();
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
		flagFim=0;
		gravidade=.001+(+Math.floor(Math.random()*10))/1000;
		pedra.x=Math.floor(Math.random()*(CANVAS_WIDTH-400)/10)*10+200;
		pedra.yi=pedra.y=Math.floor(Math.random()*20)*10;
		btnStart = document.getElementById("btn_start");
	}
	
	function start() { 
		$("#alerta").slideUp();
		if (Tempo>0)
			setarvalores();
		var boxvelocidade=document.getElementById("velocidade");
		jogador.velocidade=Math.abs(boxvelocidade.value);
		setInterval(function(){
			if ((pedra.hit==0)||(jogador.hit==0)){
				atualizar();
				Tempo++;
				desenhar();
			}
		}, 1);	
	}
	
	function atualizar() {
		if (jogador.hit==0)
			jogador.mover();
		if (pedra.hit==0)
			pedra.mover();
	}
	
	function upda() {
		var boxvelocidade=document.getElementById("velocidade");
		jogador.velocidade=Math.abs(boxvelocidade.value);
		atualizar();
		Tempo++;
		desenhar();
	}
		
	function resolucao() {
		$("#resolucao").slideDown();
	}
	
	function fecharresolucao() {
		$("#resolucao").slideUp();
	}
	
	window.onload=function(){ setarvalores(); desenhar()};
</script>

        


