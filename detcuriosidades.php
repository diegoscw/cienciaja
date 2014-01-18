<?php
if (isset($_REQUEST['codigo']))
	$codigo=$_REQUEST['codigo']; 
else
	$codigo='1';
$sql = "SELECT titulo,texto FROM curiosidades WHERE codigo=".$codigo;
$resultado = mysql_query($sql, $conexao);
$linha = mysql_fetch_array($resultado);
?>
<h1><?=$linha['titulo'];?></h1>
<?=$linha['texto'];?>
<?
mysql_free_result($resultado);
?>


