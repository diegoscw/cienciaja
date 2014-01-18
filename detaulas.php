<?php
if (isset($_REQUEST['codigo']))
	$codigo=$_REQUEST['codigo']; 
else
	$codigo='1';
$sql = "SELECT descricao, video, material, lista, cod_materia FROM aulas WHERE codigo=".$codigo;
$resultado = mysql_query($sql, $conexao);
$linha = mysql_fetch_array($resultado);
$descricao = $linha["descricao"];
$video = $linha["video"];
$material = $linha["material"];
$lista = $linha["lista"];
$cores=array('04a466','e50101','ffc000');
$cor=$cores[$linha['cod_materia']-1];
mysql_free_result($resultado);
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=172667022903441";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="tabContainer">
    <div class="tabs">
        <ul id="menu_aula">
            <li id="tabHeader_1"><a style="background:url(images/btn/btn_aula.png) 15px center no-repeat;">Aula</a></li>
            <li id="tabHeader_2"><a style="background:url(images/btn/btn_exercicio.png) 15px center no-repeat;">Exerc�os</a></li>
            <li id="tabHeader_3"><a style="background:url(images/btn/btn_extra.png) 15px center no-repeat;">Extras</a></li>
        </ul>
    </div>
	<h1 class="titulo" style="color:#<?=$cor;?>;"><?=$descricao;?></h1>
    <span class="clear"></span>
    <div class="tabscontent">
		<div class="tabpage" id="tabpage_1">
			<article class="box_lft">
				<div id="player"></div>
                <script>      // 2. This code loads the IFrame Player API code asynchronously.
                      var tag = document.createElement('script');
                      tag.src = "http://www.youtube.com/player_api";
                      var firstScriptTag = document.getElementsByTagName('script')[0];
                      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                
                      // 3. This function creates an <iframe> (and YouTube player)
                      //    after the API code downloads.
                      var player;
                      function onYouTubePlayerAPIReady() {
                        player = new YT.Player('player', {
                          playerVars: { 'autoplay': 0, 'controls': 1,'autohide':0,'wmode':'opaque' },
                          height: '400',
          				  width: '660',
                          videoId: '<?=$video;?>',
                          events: {
                            'onReady': onPlayerReady}
                        });
                      }
                
                      // 4. The API will call this function when the video player is ready.
                      function onPlayerReady(event) {
                        //event.target.mute();
                      }
                </script>
              
              
              
              <a id="btn_app" onclick="player.seekTo(3,1);">dsadsadasd</a>
              <a id="btn_app"  href="<?=$material;?>" target="_blank">Material Escrito</a>
			</article>
			<aside>
				<div class="fb-comments" data-href="http://www.cienciaja.com.br/index.php?pagina=detaulas&codigo=<?=$codigo;?>" data-width="280" data-numposts="3" data-colorscheme="light">
				</div>
			</aside>
		</div>
		<div class="tabpage" id="tabpage_2">
			<article class="box_lft">
			<?
			$sql = "SELECT descricao, video FROM exercicios WHERE cod_aulas=".$codigo;
			$resultado = mysql_query($sql, $conexao);
			$cont=0;
			while ($linha = mysql_fetch_array($resultado)){
				$cont++;
				$descricao = $linha["descricao"];
				$video = $linha["video"];
			?>
				<div class="subtabpage" id="subtabpage_<?=$cont;?>">
					<iframe width="660" height="400" src="//www.youtube.com/embed/<?=$video;?>" frameborder="0" allowfullscreen></iframe>
					<p>
						<?=$descricao;?>
					</p>
					<a id="btn_app">Resolu磯</a>
				</div>
			<?
			}
			?>
            </article>
			<aside>
				<div class="subtabs">
					<ul>
						<?
						$i=1;
						while ($i<=$cont){
						?>
							<li id="subtabHeader_<?=$i;?>"><a>Exerc�o <?=$i;?></a></li>
						<?
						$i++;
						}
						?>
					</ul>
				</div>
				<a id="btn_app" href="<?=$lista;?>" target="_blank">[+] Listas</a>
			</aside>
		</div>	
		<div class="tabpage" id="tabpage_3">
			<? include 'aulas/'.$codigo.'/anima/animacao.php'?>
		</div>
	</div>
</div>
<span class="clear"></span>
<script type="text/javascript">
function selecionarabas() {
	var container = document.getElementById("tabContainer");
	var navitem = container.querySelector(".tabs ul li");
	var subnavitem = container.querySelector(".subtabs ul li");
	var ident = navitem.id.split("_")[1];
	var subident = subnavitem.id.split("_")[1];
	navitem.parentNode.setAttribute("data-current",ident);
	subnavitem.parentNode.setAttribute("data-current",subident);
	navitem.setAttribute("class","tabActiveHeader");
	subnavitem.setAttribute("class","subtabActiveHeader");

	var pages = container.querySelectorAll(".tabpage");
	for (var i = 1; i < pages.length; i++) {
		pages[i].style.display="none";
	}
	var subpages = container.querySelectorAll(".subtabpage");
	for (var i = 1; i < subpages.length; i++) {
		subpages[i].style.display="none";
	}
	
	var tabs = container.querySelectorAll(".tabs ul li");
	for (var i = 0; i < tabs.length; i++) {
		tabs[i].onclick=displayPage;
	}
	var subtabs = container.querySelectorAll(".subtabs ul li");
	for (var i = 0; i < subtabs.length; i++) {
		subtabs[i].onclick=displaysubPage;
	}
}

// on click of one of tabs
function displayPage() {
	var current = this.parentNode.getAttribute("data-current");
	document.getElementById("tabHeader_" + current).removeAttribute("class");
	document.getElementById("tabpage_" + current).style.display="none";

	var ident = this.id.split("_")[1];
	this.setAttribute("class","tabActiveHeader");
	document.getElementById("tabpage_" + ident).style.display="block";
	this.parentNode.setAttribute("data-current",ident);
}
function displaysubPage() {
	var current = this.parentNode.getAttribute("data-current");
	document.getElementById("subtabHeader_" + current).removeAttribute("class");
	document.getElementById("subtabpage_" + current).style.display="none";

	var ident = this.id.split("_")[1];
	this.setAttribute("class","subtabActiveHeader");
	document.getElementById("subtabpage_" + ident).style.display="block";
	this.parentNode.setAttribute("data-current",ident);
}

if ((document.getElementById || document.all) && document.images) {
	window.onload = windowOnload;
}
function windowOnload()
{
   selecionarabas();
}
</script>