<section id="slideshow">
	<?
	$cont=1;
	$sql = "SELECT codigo, descricao, link FROM slides";
	$resultado = mysql_query($sql, $conexao);	
	while ($linha = mysql_fetch_array($resultado)){
	?>
		<div id="sld_<?=$cont;?>" class="<? if ($cont<=3) echo "pos".$cont;?>">
			<a href="<?=$linha['link']?>" <? if (strpos($linha['link'],"www")) echo "target=\"_blank\"";?>>
				<img src="slider/<?=$linha['codigo']?>.png" />
				<span><?=$linha['descricao'];?></span>
			</a>
		</div>
	<?
		$cont++;
	}
	mysql_free_result($resultado);
	?>
</section>
<script>
var box=document.getElementById('slideshow');
var cont=2;
function play(){
	var slides=5;
	if (cont==1)
		document.getElementById("sld_"+slides).className="";
	if (cont>1)
		document.getElementById("sld_"+(cont-1)).className="";
		
	document.getElementById("sld_"+cont).className="pos1";
	
	if ((cont+1)>slides)
		document.getElementById("sld_1").className="pos2";
	else
		document.getElementById("sld_"+(cont+1)).className="pos2";
		
	if ((cont+1)>slides)
		document.getElementById("sld_2").className="pos3";
	else if ((cont+2)>slides)
		document.getElementById("sld_1").className="pos3";
	else
		document.getElementById("sld_"+(cont+2)).className="pos3";
	cont++;
	if (cont>slides)
		cont=1;
}
var timer=setInterval(function(){play()}, 5000);
</script>

<div class="box_ultimos">
<h3>Recentes</h3>
<div>
	<h4>Curiosidades</h4>
	<ul>
	<?
	$sql = "SELECT codigo, titulo, DATE_FORMAT(data,'%d/%m/%Y')as data FROM curiosidades ORDER BY data LIMIT 0, 5";
	$resultado = mysql_query($sql, $conexao);
	while ($linha = mysql_fetch_array($resultado)){      
	?>
		<li>
			<a href="index.php?pagina=detcuriosidades&codigo=<?=$linha['codigo'];?>">
				<span><?=$linha['titulo'];?></span>
				<time><?=$linha['data'];?></time>
			</a>
		</li>
	<?
	}
	mysql_free_result($resultado);
	?>
	</ul>
	<a id="btn_app">Veja mais[+]</a>
</div>
<div>
	<h4>Posts</h4>
		<ul>
		<?
		function loadFB($fbID){
			$myFBToken="480133685432452|o42Y09kJTlYu66ewrsf6M4RPWro";
			$url="https://graph.facebook.com/".$fbID."/feed?access_token=".$myFBToken."&limit=20";
			//https://graph.facebook.com/367806420023156/feed?access_token=480133685432452|o42Y09kJTlYu66ewrsf6M4RPWro&limit=20
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);		
			$page = json_decode(curl_exec($c));
			curl_close($c);
			return $page->data;
		}
		$fbID="367806420023156";
		$fbLimit=5;
		$fbCount=0;
		$myPosts=loadFB($fbID);	
		date_default_timezone_set("America/Chicago");
		foreach($myPosts as $dPost){
			if(($dPost->from->id==$fbID)&&(isset($dPost->message))){
				$dTime = strtotime($dPost->created_time);
				$myTime=date("M d Y h:ia", $dTime);
				if ($pos=strpos($dPost->message,'http')){
					$link=substr($dPost->message,$pos,strlen($dPost->message));
                  	$dPost->message=substr($dPost->message,0,$pos);
				}else
					$link=$dPost->link;
		?>
			<li><a href="<?=$link?>" target="_blank"><?=substr(($dPost->message),0,100).'...';?> <time datetime="<?=date("d/m/y H:i",$dTime);?>"><?=date("d/m/y H:i",$dTime);?></time></a></li>
		<?
				if($fbCount>$fbLimit) break;
              	$fbCount+=$fbCount+1;
			}
		}
		?>
	</ul>
</div>
<div id="box_aulas">
	<h4>Aulas</h4>
	<ul>
	<?
	$icones=array('icon-leaf','icon-magnet','icon-lab','icon-sigma');
	$cores=array('04a466','e50101','ffc000');
	$sql = "SELECT cod_materia, codigo, descricao FROM aulas ORDER BY data DESC LIMIT 0,5";
	$resultado = mysql_query($sql, $conexao);
	while ($linha = mysql_fetch_array($resultado)){
	?>
		<li>
			<a href="index.php?pagina=detaulas&codigo=<?=$linha['codigo'];?>" style="color:#<?=$cores[$linha['cod_materia']-1]?>;" class="bt-icon <?=$icones[$linha['cod_materia']-1]?>">
				<span><?=$linha['descricao'];?></span>
			</a>
		</li>
	<?
	}
	mysql_free_result($resultado);
	?>
	</ul>
	<a id="btn_app">Veja mais[+]</a>
</div>
</div>
			
<span class="clear"></span> 