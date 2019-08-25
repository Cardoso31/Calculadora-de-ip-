<!DOCTYPE html>
<html>

<head>
	<title>Calculadora de ip</title>

	<link rel="stylesheet" type="text/css" href="css/class.css">
</head>


<body>
	<nav>
		<p class="desenvolvedores">Aline Soster<br>Mateus M. Cardoso <br> 3info3</p>
	<div class='tituloCalculadora'>
		<h1>Calculadora de ip da classe C</h1>
	</div>
	
	<div class='formEnvioIp'>
		<form  method="post" action="index.php?acao=calcularIp">

		<div>
			<label for='ip'>Insira o Ip</label>
			<input type="text" name="ip" maxlength="15" placeholder="Ex : xxx.xxx.xxx.xxx" required>
			
		</div>

		<div>
			<label for='mascara'>Insira a máscara</label>
			<input type="text" name="mascara" maxlength="15" placeholder="Ex : xxx.xxx.xxx.xxx ou /xx"  required>
		</div>

		<input type="submit" name="" class="botaoEnvio">
		</form>	

	</div>
	</nav>




