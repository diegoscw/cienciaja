			<? 
			include $idioma.'/contato.php'; 
			if (isset($_REQUEST['enviado']))
				$enviado=$_REQUEST['enviado']; 
			else
				$enviado='N';
			?>
			<hgroup>
                <h1>Fale Conosco</h1>
			</hgroup>
			<section class="lateral">
				<? 
				include $idioma.'/'.$texto.'.php';
				if ($enviado=='S')
					echo '<strong>'.$txt_envio.'</strong>';
				else if ($enviado=='E')
					echo '<strong>'.$txt_erroenvio.'</strong>';
				else{ 
				?>
              <p>Gostou da gente? Tem alguma dúvida? Quer nos apoiar? Entre em contato:</p>
					<form method="post" action="enviaremail.php?idioma=<?=$idioma?>">
						<label>Nome</label>
						<input type="text" name="nome" autofocus="autofocus" required />
						<label>Email</label>
						<input type="email" name="email"  required />
						<label>Mensagem</label>
						<textarea required name="mensagem"></textarea>
						<button>Enviar</button>
					</form>
				<?
				}
				?>
			</section>
             
             <aside>
				<a href="#" class="a-btn">
					<span class="a-btn-icon-left"><span class="ico-mail"></span></span>
					<span class="a-btn-slide-text">contato@ciniciato.com.br</span>
				</a>
				<a href="#" class="a-btn">
					<span class="a-btn-icon-left"><span class=" ico-fone"></span></span>
					<span class="a-btn-slide-text">(18) 8171 - 1580</span>
				</a>
				<a href="#" class="a-btn">
					<span class="a-btn-icon-left"><span class="ico-home"></span></span>
					<span class="a-btn-slide-text">Assis/SP</span>
				</a>
             </aside>
			 <span class="clear"></span>