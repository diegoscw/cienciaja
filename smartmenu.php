	<div class="mp-pusher" id="mp-pusher">
		<a href="#" id="trigger" class="menu-trigger">Aulas [+]</a>
		<nav id="mp-menu" class="mp-menu">
			<div class="mp-level">
				<h2>Matérias</h2>
				<ul>
				<?php
				$cores=array('04a466','e50101','ffc000');
				$icones=array('icon-leaf','icon-magnet','icon-lab','icon-sigma');
				$sql = "SELECT codigo, descricao FROM materias";
				$resultado = mysql_query($sql, $conexao);
				while ($linha = mysql_fetch_array($resultado)){
				?>
					<li class="icon icon-arrow-left">
                      <a style="font-size:50px; color:#<?=$cores[$linha['codigo']-1]?>" href="index.php?pagina=lisaulas&cod_materia=<?=$linha['codigo'];?>" class="bt-icon <?=$icones[$linha['codigo']-1];?>">
							
						</a>
						<div class="mp-level" style="background:#<?=$cores[$linha['codigo']-1]?>;">
							<h2><?=$linha['descricao'];?></h2>
							<ul>
				<?
						$sqlb = "SELECT codigo, descricao FROM subcategoria where cod_materia=".$linha['codigo'];
						$resultadob = mysql_query($sqlb, $conexao);
						while ($linhab = mysql_fetch_array($resultadob)){
				?>
								<li>
									<a href="index.php?pagina=lisaulas&cod_materia=<?=$linha['codigo'];?>&codigo=<?=$linhab['codigo'];?>"><?=$linhab['descricao']?></a>
									<div class="mp-level">
										<h2><?=$linhab['descricao']?></h2>
										<ul>
				<?
							$sqlc = "SELECT cod_materia, cod_subcategoria, codigo, descricao FROM aulas where cod_materia=".$linha['codigo']." and cod_subcategoria=".$linhab['codigo'];
							$resultadoc = mysql_query($sqlc, $conexao);
							while ($linhac = mysql_fetch_array($resultadoc)){
				?>
											<li><a href="index.php?pagina=detaulas&codigo=<?=$linhac['codigo']?>"  style="color:#<?=$cores[$linha['codigo']-1]?>;"><?=$linhac['descricao']?></a></li>
				<?
							}
							mysql_free_result($resultadoc);
				?>
										</ul>
									</div>
								</li>
				<?		
						}
						mysql_free_result($resultadob);
				?>
							</ul>
						</div>
					</li>
				<?
				}
				mysql_free_result($resultado);
				?>
				</ul>
			</div>
		</nav>
	</div>
	<script src="js/classie.js"></script>
	<script src="js/mlpushmenu.js"></script>
	<script>
		new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );
	</script>