<style>
.list li {
display:inline-block;
margin-right:20px;
}

.list li img {
	border:2px #000 solid;
}

.list li span {
display:block;
}
</style>
<?
if (isset($_REQUEST['cod_materia']))
	$cod_materia=$_REQUEST['cod_materia']; 
else
	$cod_materia='1';
if (isset($_REQUEST['codigo']))
	$cod_subcategoria=$_REQUEST['codigo']; 
else
	$cod_subcategoria='0';
if ($cod_subcategoria>0)
	$sql = "SELECT cod_subcategoria, descricao, codigo, material, lista  FROM aulas WHERE cod_materia=".$cod_materia." and cod_subcategoria=".$cod_subcategoria;
else
	$sql = "SELECT cod_subcategoria, descricao, codigo, material, lista FROM aulas WHERE cod_materia=".$cod_materia;
$resultado = mysql_query($sql, $conexao);
?>
<hgroup>
  <h1>Aulas</h1>
</hgroup>
<ul class="list">
<?
while ($linha = mysql_fetch_array($resultado)){

$codigo = $linha["codigo"];
$cod_subcategoria = $linha["cod_subcategoria"];
$descricao = $linha["descricao"];
?>
	<li>
		<a href="index.php?pagina=detaulas&codigo=<?=$codigo;?>">
			<img src="<?='aulas/'.$codigo.'/thumb.png';?>">
			<span><?=$descricao;?></span>
		</a>
	</li>
<?
}
mysql_free_result($resultado);
?>
</ul>