<style>
#fundo {
	background:url(aulas/1/anima/fundo.gif); 
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

#coco{
	height:30px;
	width:30px;
	background:url(aulas/1/anima/coco.png) 0 0 no-repeat;
	position:absolute;
	top:48px;
	left:465px;
}

#homem {
	height:100px;
	width:56px;
	position:absolute;
	left:242px;
	bottom:35px;
	background:url(aulas/1/anima/spt_menino.png) no-repeat left bottom;
}

.homem-andar {
	background:url(aulas/1/anima/spt_menino.png) no-repeat left top;
	-webkit-animation:walk 1s steps(6) infinite;
    animation: walk 1s steps(6) infinite;
}

@-webkit-keyframes  walk { 
      0% { background-position:    0px 0; } 
    100% { background-position: -336px 0; }
} 

@keyframes walk { 
      0% { background-position:    0px 0; } 
    100% { background-position: -336px 0; }
}

#velocidade {
	position:absolute;
	left:240px;
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
    width: 30px;
}

#btn_start{
	position:absolute;
	left:300px;
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
</style>

<script type="text/javascript">
	var hPosicao=242, hVelocidade=10, cPosicao=48, Tempo=0, cVelocidade=10;
	var coco, homem, btnStart;
	var timer;
	
	function mensagem(texto){
		var box=document.getElementById("alerta");
		var msg=document.getElementById("mensagem");
		msg.innerHTML=texto;
		$("#alerta").slideDown();
	}
	
	function setarvalores(){
		hPosicao=242;
		cPosicao=48;
		Tempo=0;
		cVelocidade=10;
		flagFim=0;
		coco = document.getElementById("coco");
		homem = document.getElementById("homem");
		btnStart = document.getElementById("btn_start");
		var boxvelocidade=document.getElementById("velocidade");
		hVelocidade=boxvelocidade.value*10;
		coco.style.display='block';
		coco.style.top=cPosicao+'px'
		homem.style.left=hPosicao+'px'
	}
	
	function start() { 
		$("#alerta").slideUp();
		setarvalores();
		if (hVelocidade<=0)
			mensagem("A velocidade é positiva!");
		else if (hVelocidade>=300)
			mensagem("Velocidade muito alta!");
		else{
			homem.className="homem-andar";
			btnStart.style.display='none';
			timer=setInterval(function(){atualizar()}, 100);
		}
	}
	
	function atualizar() {
		if (hPosicao<650)
			andarhomem();
		else{
			homem.className="";
			btnStart.style.display='block';
			clearInterval(timer);
			if ((hVelocidade<10)||(hVelocidade>11))
				mensagem("Voce passou, mas a velocidade não está correta!");
			else
				mensagem("Parabens, você passou!");
		}
		if (cPosicao<440) 
			caircoco();
		
		if ((hPosicao>409)&&(hPosicao<490)&&(cPosicao>358)){
			homem.className="";
			btnStart.style.display='block';
			clearInterval(timer);
			mensagem("Voce foi atingido");
			}
	
	}
	
	
	function andarhomem() {
		hPosicao+=hVelocidade;
		homem.style.left = hPosicao+"px";
	}
	
	function caircoco() {
		cPosicao+=cVelocidade;
		coco.style.top=cPosicao+"px";
		Tempo++;
		if ((Tempo%10==0)&&(Tempo>10))
			cVelocidade=Tempo;
	}
	
	function resolucao() {
		$("#resolucao").slideDown();
	}
	
	function fecharresolucao() {
		$("#resolucao").slideUp();
	}
</script>

<div id="fundo">
    <div id="homem"></div>
    <div id="coco"></div>
    <input id="velocidade" maxlength="3" type="text" />
    <a id="btn_start" onclick="start();"></a>
    
    <div id="alerta">
        <span id="mensagem"></span>
    </div>
	<div id="resolucao">
		<a id="btn_fechar" onclick="fecharresolucao();"></a>
	</div>
</div>
<a id="btn_app" onclick="resolucao();">Resolução</a>
<p>
Altura do homem=1m<br>
Largura do homem=56cm<br>
Largura do coco=30cm<br>
Distancia horizontal coco-homem=1.70m<br>
Distancia vertical coco-homem=3m<br>
Gravidade=1m/s²<br><br>

3m=1.t².0,5<br>
t=2.4s<br><br>

vm=(1.7+0,3+0,56)/2,4=1.04m/s


</p>
        


