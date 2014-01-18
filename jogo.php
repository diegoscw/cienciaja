<?
if (isset($_REQUEST['jogo']))
	$jogo=$_REQUEST['jogo']; 
else
	$jogo='1';
?>
<!DOCTYPE html>
<html lang="pt-br">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="ISO-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Ciência Já! - Pré-vestibular e Ciência</title>	
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<script src="js/jquery.min.js" type="text/javascript"></script>

		
    </head>
    <body>
		<? include 'aulas/'.$jogo.'/anima/animacao.php'; ?>
    </body>
</html>
