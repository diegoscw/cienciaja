<?
//$conexao = mysql_connect("localhost","cienciaj_adm","142614aS#");
//$bd = mysql_select_db("cienciaj_at", $conexao);
$conexao = mysql_connect("localhost","root","142614as");
$bd = mysql_select_db("cienciaja", $conexao);
if (isset($_REQUEST['pagina']))
	$url=$_REQUEST['pagina']; 
else
	$url='home';
?>
<!DOCTYPE html>
<html lang="pt-br">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Ciência Já - Pré vestibular e Ciência</title>	
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

		<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" /> 

		<link href='http://fonts.googleapis.com/css?family=Schoolbell' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/icons.css" />

		<script src="js/modernizr-2.6.2.min.js"></script>
		<script src="js/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
      	<script>
          $(function(){
            var aulas = [
              <?
              $sql = "SELECT CONCAT(a.descricao,' - ',sub.descricao)as descricao FROM aulas a LEFT JOIN subcategoria sub ON sub.codigo=a.cod_subcategoria AND sub.cod_materia=a.cod_materia ORDER BY a.descricao";
              $resultado = mysql_query($sql, $conexao);
              while ($linha = mysql_fetch_array($resultado)){
              ?>
              {value: '<?=$linha['descricao']?>', data:''},
              <?
              }
              mysql_free_result($resultado);
              ?>
            ];
            
            $('#autocomplete').autocomplete({
              lookup: aulas,
              onSelect: function (suggestion) {
                var thehtml = ' ' + suggestion.value + '  ' + suggestion.data;
                $('#outputcontent').html(thehtml);
              }
            });
                      
          });     
     </script>
		
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<? include 'smartmenu.php'; ?>
		<header class="geral">
        	<div class="quadro">
				<? include 'topo.php'; ?>
            </div>
		</header>		
		<article class="conteudo">
        	<div class="quadro" id="<?=$url?>">
				<?  include $url.'.php'; ?>
            </div>
		</article>		
		<footer class="geral">
        	<div class="quadro">
				<?  include 'rodape.php'; ?>
            </div>
		</footer>
		<!--script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-42985415-1', 'ciniciato.com.br');
		ga('send', 'pageview');
		</script-->
    </body>
</html>
