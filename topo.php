			<div class="logo">
				<a class="menu" href="index.php?pagina=home" alt="Ciniciato Solu絥s">
					<img src="images/logo.png" alt="Ciniciato Solu絥s" />
				</a>
			</div>
				   
			<nav class="geral">
				<ul>
				<? 
				include 'pt/menu.php';
				$final=4;
				for ($cont=0;$cont<=$final;$cont++){
					echo "<li><a class=\"menu\" href=\"index.php?pagina=".$url_pagina[$cont]."\">".$desc_pagina[$cont]."</a>";
					if ($cont!=$final) 
						echo "</li>";
					else
						echo "</li>";
				} 
                ?>
				</ul>
			</nav>
			
			<div class="box_busca">
              	<div id="searchfield" class="icon-search">
                	<form><input type="text" placeholder="Procure aqui..." name="currency" class="biginput" id="autocomplete"></form>
             	</div>
              
              <div id="outputbox" style="display:none">
                	<p id="outputcontent"></p>
              	</div>
			</div>
			<span class="clear"></span>