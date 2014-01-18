<style>
#fundo {
	width:960px; 
	height:510px; 
	position:relative;
}
#screen {
	position:absolute;
	top:0;
	left:0;
	cursor: none;
}
</style>
<div id="fundo">
	<canvas id="screen"	width="960"	height="510"></canvas>
</div>

<script src="aulas/4/anima/ge1doot.js"></script>
<script>
var particulas=2, gravidade=0.2, atrito=0.001, pontuacao=0;
var largura=960, altura=510, imagemcaixaf,imagemcaixab,tempo=0;
var obj = [], box, qtdobj=[];
var scr, ctx, pointer, grid, pdiam=50;

var tema=0, temas=[], opcs=[], opcsb=[], cores=[];
cores[0]="09b8ae";
cores[1]="09b83e";
cores[2]="b84209";
cores[3]="b809ae";
temas[0]="Proteína";
temas[1]="Carboidrato";
temas[2]="Lípideo";
temas[3]="Acido Nucleico";
opcs[0]="Carne";
opcsb[0]=0;
opcs[1]="Pao";
opcsb[1]=1;
opcs[2]="Azeite";
opcsb[2]=2;
opcs[3]="Aminoacidos";
opcsb[3]=0;
opcs[4]="Acidos Graxos";
opcsb[4]=2;
opcs[5]="Glicidios";
opcsb[5]=1;
opcs[6]="Adenina";
opcsb[6]=3;
opcs[7]="Timina";
opcsb[7]=3;
opcs[8]="Guanina";
opcsb[8]=3;
opcs[9]="Citosina";
opcsb[9]=3;



/* ==== construtor particula ==== */
var Particula = function () {
	this.x = Math.floor(Math.random() * largura);//posicao X
	this.y =50 * .5;//Math.floor(Math.random() * scr.height);//Posicao Y
	this.ind=0;
	this.tipo=0;
};

var Caixa = function(){
	this.x=(largura-150)/2;
	this.y=altura-150;
	this.altura=147; 
	this.largura=150;
};

(function () {

	Caixa.prototype.move = function() {
	//
	}

	/* ==== move particula ==== */
	Particula.prototype.move = function () {
		/* ---- desenha particula ---- */
		//ctx.beginPath();
		//ctx.arc(this.x, this.y, pdiam/2, 0, Math.PI*2, false);
		//ctx.fillStyle = 'blue';
		//ctx.fill();
		
		ctx.fillStyle = cores[opcsb[this.tipo]];
		ctx.font = "bold 26px Arial";
		ctx.fillText(opcs[this.tipo], this.x, this.y);
	//	ctx.beginPath();
     // ctx.rect(this.x, this.y, opcs[this.tipo].length*15, 10);
     // ctx.fillStyle = 'yellow';
      //ctx.fill();
		
		//this.y += this.vy;
		this.y+=5;
		
		if ((this.y<(altura-box.altura)+45)&&(this.y>(altura-box.altura)+25)&&(this.x>box.x)&&(this.x<box.x+box.largura))
			{
			if (tema==opcsb[this.tipo])
				pontuacao++;
			else
				pontuacao--;
			qtdobj[this.ind]=0;
			delete obj[this.ind];
			}
			
		else if (this.y>510)
			{
			qtdobj[this.ind]=0;
			delete obj[this.ind];
			}
			
		}

	/* ==== loop principal ==== */
	var run = function () {
		// ---- limpa a tela ----
		ctx.clearRect(0, 0, scr.width, scr.height);
				box.x=pointer.X;
				ctx.drawImage(imagemcaixab, box.x, altura-box.altura);
			for(var i = 0; i < particulas; i++){ 
				if  (qtdobj[i]==1)
					obj[i].move(); 
			}
		
				ctx.drawImage(imagemcaixaf, box.x, altura-box.altura);
		ctx.fillStyle = "blue";
		ctx.font = "bold 20px Arial";
		ctx.fillText("Pontuacao:"+pontuacao, 100, 35);
		ctx.fillStyle = cores[tema];
		ctx.font = "bold 26px Arial";
		ctx.fillText(temas[tema], 450, 35);
		if (tempo==700){
			tema=Math.floor(Math.random()*4);
			tempo=0;
		}
		tempo++;

		if (Math.floor(Math.random()*100)>95){
			obj[particulas] = new Particula();
			obj[particulas].ind=particulas;
			obj[particulas].tipo=Math.floor(Math.random()*9);
			//if (qtdobj[particulas-1]==1){
			//	obj[particulas].x = Math.floor(Math.random() * largura);//posicao X
			//	while (obj[particulas].x>obj[particulas-1].x)&&(obj[particulas].x<obj[particulas-1].x+opcs[obj[particulas-1].tipo].length*15)
			//		obj[particulas].x = Math.floor(Math.random() * largura);
			//} else
			obj[particulas] = Math.floor(Math.random() * largura);
			qtdobj[particulas]=1;
			particulas++;
		}
		
		// ---- proximo frame ----
		requestAnimFrame(run);
	}
	/* ==== inicializacao ==== */
	var init = function (p) {
		// ---- canvas ----
		scr = new ge1doot.Screen({
			container: "screen",
			resize: function () {
			}
		});
		ctx = scr.ctx;
		scr.resize();
		imagemcaixaf = new Image();
		imagemcaixaf.src = p.particleImgf;
		imagemcaixab = new Image();
		imagemcaixab.src = p.particleImgb;
		// ---- pointer ----
		pointer = new ge1doot.Pointer({});
		// ---- criar particulas ----
		for (var i = 0; i < particulas; i++) {
			obj[i] = new Particula();
			qtdobj[i]=1;
			obj[i].ind=i;
			obj[i].tipo=Math.floor(Math.random()*9);
		}
		box=new Caixa();
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
	particleImgf: "aulas/15/anima/caixaf.png",
	particleImgb: "aulas/15/anima/caixab.png"
});

function parar(){
			obj[particulas] = new Particula();
			obj[particulas].cor=Math.floor(Math.random()*100);
			obj[particulas].kelastica=Math.floor(Math.random()*10)/10;
			particulas++;
}

</script>